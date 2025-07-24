<?php
session_start();
include('partials/connect.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please log in to view your bookings.";
    header("Location: customer-login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
include('partials/header.php');
?>

<section class="bookings-container">
    <h2>📋 My Bookings</h2>
    <a href="customer-dashboard.php" class="btn btn-primary">⬅ Back</a>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<p class="message">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }

    // Fetch bookings for this user
    $sql = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY date DESC, time DESC";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0): ?>
        <table class="bookings-table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Barber</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['service']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['time']); ?></td>
                        <td><?php echo htmlspecialchars($row['barber'] ?: 'Any'); ?></td>
                        <td><?php echo '$' . number_format($row['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-bookings">You haven’t booked any appointments yet.</p>
    <?php endif; ?>
</section>

<?php include('partials/footer.php'); ?>
