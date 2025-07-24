<?php
session_start();
include('partials/connect.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please log in to book an appointment.";
    header("Location: customer-login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $barber = mysqli_real_escape_string($conn, $_POST['barber']);
    $user_id = $_SESSION['user_id'];
    $status = "Pending";

    // Set price based on service
    switch ($service) {
        case "Haircut": $price = 15.00; break;
        case "Beard Trim": $price = 10.00; break;
        case "Shave": $price = 12.00; break;
        case "Hair + Beard Combo": $price = 22.00; break;
        case "Kids Haircut": $price = 3.50; break;
        case "Color Treatment": $price = 10.00; break;
        default: $price = 30.00;
    }

    // Insert booking into database
    $sql = "INSERT INTO bookings (user_id, service, date, time, barber, price, status)
            VALUES ('$user_id', '$service', '$date', '$time', '$barber', '$price', '$status')";

    if (mysqli_query($conn, $sql)) {
        // Fetch user email and name
        $user_sql = "SELECT name, email FROM users WHERE id = '$user_id' LIMIT 1";
        $user_result = mysqli_query($conn, $user_sql);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
            $customer_name = $user_data['name'];
            $customer_email = $user_data['email'];

            // Compose email
            $to = $customer_email;
            $subject = "Smart Barbershop Appointment Confirmation";
            $message = "Hi $customer_name,\n\nYour appointment for '$service' with $barber on $date at $time has been successfully booked.\n\nPrice: Ksh $price\n\nThank you for choosing us!\nSmart Barbershop.";
            $headers = "From: no-reply@smartbarbershop.com";

            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['message'] = "Appointment booked and confirmation email sent!";
            } else {
                $_SESSION['message'] = "Appointment booked, but email failed to send.";
            }
        } else {
            $_SESSION['message'] = "Appointment booked, but user email not found.";
        }

        header("Location: customer-dashboard.php");
        exit;
    } else {
        $_SESSION['message'] = "Booking failed. Please try again.";
        header("Location: book.php");
        exit;
    }
}

include('partials/header.php');
?>

<section class="form-book">
    <h1 class="form-h2">Book an Appointment</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<p class="message">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    ?>

    <form action="book.php" method="POST">
        <!-- Service -->
        <label for="service">Choose a Service</label>
        <select name="service" id="service" required>
            <option value="">Select Service</option>
            <option value="Haircut">Haircut</option>
            <option value="Beard Trim">Beard Trim</option>
            <option value="Shave">Shave</option>
            <option value="Hair + Beard Combo">Hair + Beard Combo</option>
            <option value="Kids Haircut">Kids Haircut</option>
            <option value="Color Treatment">Color Treatment</option>
        </select>

        <!-- Date & Time -->
        <label for="date">Date</label>
        <input type="date" name="date" id="date" required>

        <label for="time">Time</label>
        <input type="time" name="time" id="time" required>

        <!-- Optional Barber -->
        <label for="barber">Choose a Barber</label>
        <select name="barber" id="barber">
            <option value="">No Preference</option>
            <option value="Martin Lawrence">Martin Lawrence</option>
            <option value="John Smith">John Smith</option>
            <option value="James Brown">James Brown</option>
            <option value="Kelvin Squidward">Kelvin Squidward</option>
        </select>

        <input type="submit" class="btn-form" value="Book Appointment">
    </form>
</section>

<?php include('partials/footer.php'); ?>
