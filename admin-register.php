<?php
session_start();
include('partials/header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
</head>
<body>
<h2 class="register-h2">Register Admin</h2>
<p>
<?php
if(isset($_SESSION['success'])){
   echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
   unset($_SESSION['success']);
}
if(isset($_SESSION['fail'])){
   echo "<div class='alert alert-fail'>{$_SESSION['fail']}</div>";
   unset($_SESSION['fail']);
}
if(isset($_SESSION['match'])){
   echo "<div class='alert alert-match'>{$_SESSION['match']}</div>";
   unset($_SESSION['match']);
}
if(isset($_SESSION['exists'])){
   echo "<div class='alert alert-exists'>{$_SESSION['exists']}</div>";
   unset($_SESSION['exists']);
}
?>

</p>

<div class="register-form">
  <form method="POST" action="admin-register.php">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" required autocomplete="off">

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required autocomplete="off">

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required autocomplete="off">

    <label for="cpassword">Confirm Password:</label>
    <input type="password" name="cpassword" id="cpassword" required autocomplete="off">

    <button type="submit" name="signup">Sign Up</button><br><br>
    
    Already have an account? <a class="cust-signup-link" href="login.php">Login here</a>
  </form>
  
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  include('partials/connect.php');

  if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $role = 'admin';

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql); 

    if (mysqli_num_rows($result) > 0) {
       $_SESSION['exists'] = "User already exists";
        header("location: admin-register.php");
    } else {
      if ($password === $cpassword) {
        $sql_insert = "INSERT INTO users (name, email, password, role) 
                VALUES('$name', '$email', '$password', '$role')"; 
        $result = mysqli_query($conn, $sql_insert);

        if ($result) {
          
        $_SESSION['success'] = "Signed up successfully";
        header("location: login.php");

        } else {
        $_SESSION['fail'] = "Failed to sign up";
        header("location: admin-register.php"); 
        }

      } else {
        $_SESSION['match'] = "Passwords do not match";
        header("location: admin-register.php");


       
      }
    }
  }
}
?>


<?php include('partials/footer.php'); ?>