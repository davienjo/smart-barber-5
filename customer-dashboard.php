<?php
session_start();
include('partials/connect.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please log in to access your dashboard.";
    header("Location: customer-login.php");
    exit;
}

// Get customer name from session or database
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'] ?? 'Customer'; // Use stored name if available

// Optional: Fetch user's name from database if not in session
if (!isset($_SESSION['name'])) {
    $query = "SELECT name FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $_SESSION['name'] = $name;
    }
}

include('partials/header.php');
?>

<section class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <div class="dashboard-actions">
        <a href="view-my-bookings.php" class="btn-form">📅 View My Bookings</a>
        <a href="book.php" class="btn-form">➕ Book An Appointment</a>
        <a href="logout.php" class="btn-form logout">🚪 Logout</a>
    </div>
</section>

<?php include('partials/footer.php'); ?>
