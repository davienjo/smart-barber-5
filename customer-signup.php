<?php
session_start();
include('partials/connect.php');

// Handle signup logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['message'] = "Email already registered. Try logging in.";
    } else {
        $role = 'customer';
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Registration successful! You can now log in.";
            header("Location: customer-login.php");
            exit;
        } else {
            $_SESSION['message'] = "Signup failed. Please try again.";
        }
    }
}
?>

<?php include('partials/header.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm custom-signup-card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Customer Sign Up</h3>

                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-warning"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                    <?php endif; ?>

                    <form action="customer-signup.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Sign Up</button>
                    </form>

                    <p class="mt-3 text-center">
                        Already have an account? <a href="customer-login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>
