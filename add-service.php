<?php
session_start();
include('partials/connect.php');
include('partials/header.php');

// Protect the page
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);

    // Basic validation
    if (empty($name) || empty($price) || !is_numeric($price)) {
        $error = "Please enter a valid service name and numeric price.";
    } else {
        $stmt = $conn->prepare("INSERT INTO services (name, price) VALUES (?, ?)");
        $stmt->bind_param("sd", $name, $price);
        if ($stmt->execute()) {
            $success = "Service added successfully!";
        } else {
            $error = "Failed to add service. Try again.";
        }
    }
}
?>

<div class="dashboard-container">
  <h2>Add New Service</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post" class="form">
    <label>Service Name:</label>
    <input type="text" name="name" required>

    <label>Price (USD):</label>
    <input type="number" step="0.01" name="price" required>

    <button type="submit" class="btn btn-primary">Add Service</button>
    <a href="manage-services.php" class="btn btn-secondary">Back</a>
  </form>
</div>

<?php include('partials/footer.php'); ?>
