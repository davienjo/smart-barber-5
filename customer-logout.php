<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Set logout message using session (must restart session)
session_start();
$_SESSION['message'] = "You have been logged out.";

// Redirect to login page
header("Location: customer-login.php");
exit;
