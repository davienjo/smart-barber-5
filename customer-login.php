<?php
session_start();
include('partials/connect.php');

// Handle login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);
     
        if (password_verify($password, $user['password'])) {
    if ($user['role'] === 'customer') {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['message'] = "Welcome back, " . $user['name'] . "!";
        header("Location: customer-dashboard.php");
        exit;
    } else {
        $_SESSION['message'] = "Access denied. Not a customer account.";
    }
}

        else {
            $_SESSION['message'] = "Incorrect password.";
        }
    } else {
        $_SESSION['message'] = "Email not found.";
    }
}
?>

<?php include('partials/header.php'); ?>

<div class="cust-login-wrapper">
  <div class="cust-login-box">
    <h2 class="cust-login-title">Customer Login</h2>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="cust-msg"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <form action="customer-login.php" method="POST" class="cust-login-form">
      <div class="cust-form-group">
        <label for="email">Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="cust-form-group">
        <label for="password">Password</label>
        <input type="password" name="password" required>
      </div>

      <button type="submit" class="cust-login-btn">Login</button>

      <p class="cust-signup-link">Don't have an account? <a href="customer-signup.php">Sign Up</a></p>
    </form>
  </div>
</div>

<?php include('partials/footer.php'); ?>
