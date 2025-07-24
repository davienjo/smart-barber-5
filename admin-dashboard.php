<?php
session_start();
include('partials/connect.php');

// Protect the page
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Get today's bookings
$today = date('Y-m-d');
$booking_sql = "SELECT COUNT(*) AS total FROM bookings WHERE date = '$today'";
$booking_result = mysqli_query($conn, $booking_sql);
$booking_data = mysqli_fetch_assoc($booking_result);
$todays_bookings = $booking_data['total'] ?? 0;

// Get this week's revenue
$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));
$revenue_sql = "SELECT SUM(price) AS revenue FROM bookings WHERE date BETWEEN '$week_start' AND '$week_end'";
$revenue_result = mysqli_query($conn, $revenue_sql);
$revenue_data = mysqli_fetch_assoc($revenue_result);
$weekly_revenue = $revenue_data['revenue'] ?? 0;

// Get total customers
$customer_sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'customer'";
$customer_result = mysqli_query($conn, $customer_sql);
$customer_data = mysqli_fetch_assoc($customer_result);
$total_customers = $customer_data['total'] ?? 0;
?>

<?php
include('partials/header.php');
?>
<h1 class="admin-dashboard-wrapper-heading">Admin Dashboard</h1>
  <div class="admin-dashboard-wrapper">
    <h2>Welcome, <?php echo $_SESSION['admin_name']; ?> 👋</h2>
    <p>You are logged in as an <strong>admin</strong>.</p>

    <div class="admin-card-grid">
      <div class="admin-card">
        <h3>📅 Bookings Today</h3>
        <p><?php echo $todays_bookings; ?></p>
      </div>
      <div class="admin-card">
       <h3>💰 Weekly Revenue</h3>
       <p>$<?php echo number_format($weekly_revenue, 2); ?></p>
      </div>
      <div class="admin-card">
        <h3>👥 Total Customers</h3>
        <p><?php echo $total_customers; ?></p>
      </div>
    </div>

    <nav class="admin-nav">
      <a href="manage-bookings.php" class="admin-nav-link">Manage Bookings</a>
      <a href="manage-services.php" class="admin-nav-link">Manage Services</a>
      <a href="view-customers.php" class="admin-nav-link">View Customers</a>
      <a href="analytics.php" class="admin-nav-link">Analytics</a>
      <a href="logout.php" class="admin-nav-link admin-logout-link">Logout</a>
      <a href="view-messages.php" class="admin-nav-link">New Messages</a>
    </nav>
  </div>

</body>
</html>


<?php
include('partials/footer.php');
?>