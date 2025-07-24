<?php
session_start();
include('partials/connect.php');
include('partials/header.php');

// Protect the page (admin only)
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Get user ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-danger'>Invalid customer ID.</p>";
    exit;
}

$user_id = $_GET['id'];

// Get customer info
$user_sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
$user_result = mysqli_query($conn, $user_sql);

if (mysqli_num_rows($user_result) != 1) {
    echo "<p class='text-danger'>Customer not found.</p>";
    exit;
}

$user = mysqli_fetch_assoc($user_result);

// Get booking history
$sql = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY date DESC, time DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container my-5">
  <h2 class="mb-4">Booking History for <span class="text-primary"><?php echo htmlspecialchars($user['name']); ?></span></h2>

  <div class="table-responsive mb-4">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>SN</th>
          <th>Service</th>
          <th>Barber</th>
          <th>Price</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $sn = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $sn++ . "</td>";
                echo "<td>" . htmlspecialchars($row['service']) . "</td>";
                echo "<td>" . htmlspecialchars($row['barber']) . "</td>";
                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>No bookings found for this customer.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <a href="view-customers.php" class="btn btn-secondary">← Back to Customers</a>
</div>

<?php include('partials/footer.php'); ?>
