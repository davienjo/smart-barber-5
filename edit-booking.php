<?php
session_start();
include('partials/connect.php');

// Redirect if not admin
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Get booking ID from URL
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "Booking not specified.";
    header("Location: manage-bookings.php");
    exit;
}

$booking_id = $_GET['id'];

// Fetch booking info
$sql = "SELECT * FROM bookings WHERE id = $booking_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    $_SESSION['message'] = "Booking not found.";
    header("Location: manage-bookings.php");
    exit;
}

$booking = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $barber = $_POST['barber'];
    $status = $_POST['status'];

    $update = "UPDATE bookings SET 
                date = '$date', 
                time = '$time', 
                barber = '$barber', 
                status = '$status'
               WHERE id = $booking_id";

    if (mysqli_query($conn, $update)) {
        $_SESSION['message'] = "Booking updated successfully!";
        header("Location: manage-bookings.php");
        exit;
    } else {
        $error = "Update failed. Please try again.";
    }
}

include('partials/header.php');
?>

<div class="dashboard-container">
    <h2>Edit Booking</h2>
    <a href="manage-bookings.php" class="btn btn-primary back-btn">⬅ Back</a>

    <?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>

    <form action="" method="POST" class="form-box">
        <label>Date</label>
        <input type="date" name="date" value="<?= $booking['date'] ?>" required autocomplete="off">

        <label>Time</label>
        <input type="time" name="time" value="<?= $booking['time'] ?>" required autocomplete="off">

        <label>Barber</label>
        <select name="barber">
            <option value="Martin Lawrence" <?= $booking['barber'] == "Martin Lawrence" ? 'selected' : '' ?>>Martin Lawrence</option>
            <option value="John Smith" <?= $booking['barber'] == "John Smith" ? 'selected' : '' ?>>John Smith</option>
            <option value="James Brown" <?= $booking['barber'] == "James Brown" ? 'selected' : '' ?>>James Brown</option>
            <option value="Kelvin Squidward" <?= $booking['barber'] == "Kelvin Squidward" ? 'selected' : '' ?>>Kelvin Squidward</option>
        </select>

        <label>Status</label>
        <select name="status">
            <option value="Pending" <?= $booking['status'] == "Pending" ? 'selected' : '' ?>>Pending</option>
            <option value="Confirmed" <?= $booking['status'] == "Confirmed" ? 'selected' : '' ?>>Confirmed</option>
            <option value="Completed" <?= $booking['status'] == "Completed" ? 'selected' : '' ?>>Completed</option>
            <option value="Cancelled" <?= $booking['status'] == "Cancelled" ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <input type="submit" value="Update Booking" class="btn btn-warning mt-3">
    </form>
</div>

<?php include('partials/footer.php'); ?>
