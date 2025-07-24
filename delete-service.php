<?php
session_start();
include('partials/connect.php');

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Check if service ID is set and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage-services.php");
    exit;
}

$service_id = $_GET['id'];

// Optional: Check if service exists
$check_sql = "SELECT * FROM services WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $service_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows != 1) {
    header("Location: manage-services.php");
    exit;
}

// Delete the service
$delete_sql = "DELETE FROM services WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $service_id);

if ($delete_stmt->execute()) {
    $_SESSION['success'] = "Service deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete service.";
}

header("Location: manage-services.php");
exit;
?>
