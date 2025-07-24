<?php
session_start();
include('partials/connect.php');
include('partials/header.php');


if(!isset($_SESSION['admin_name'])){
    header("location: login.php");

}

if (isset($_GET['id'])){
    $booking_id = $_GET['id'];

$sql = "UPDATE bookings SET status ='Cancelled' WHERE id = $booking_id";
$result = mysqli_query($conn, $sql);

if ($result){
    $_SESSION['message'] ="Cancelled succesfully";
    header("location: manage-bookings.php");
    exit;
}else{
    $_SESSION['message'] ="Failed to cancel";
    header("location: manage-bookings.php");
    exit;
}
header("location:manage-bookings.php");
exit;
}



?>
<?php
include('partials/footer.php');
?>