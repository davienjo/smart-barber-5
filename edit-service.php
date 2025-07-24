<?php
session_start();
include('partials/connect.php');
include('partials/header.php');

// Redirect if not logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Check if service ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage-services.php");
    exit;
}

$service_id = $_GET['id'];
$success = $error = "";

// Get current service details
$sql = "SELECT * FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: manage-services.php");
    exit;
}

$service = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);

    if (empty($name) || empty($price) || !is_numeric($price)) {
        $error = "Please enter valid service details.";
    } else {
        $update_sql = "UPDATE services SET name = ?, price = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sdi", $name, $price, $service_id);

        if ($update_stmt->execute()) {
            $success = "Service updated successfully.";
            $service['name'] = $name;
            $service['price'] = $price;
        } else {
            $error = "Failed to update service.";
        }
    }
}
?>

<div class="dashboard-container">
  <h2>Edit Service</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post" class="form">
    <label>Service Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required>

    <label>Price (USD):</label>
    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($service['price']); ?>" required>

    <button type="submit" class="btn btn-primary">Update Service</button>
    <a href="manage-services.php" class="btn btn-secondary">Back</a>
  </form>
</div>

<?php include('partials/footer.php'); ?>
