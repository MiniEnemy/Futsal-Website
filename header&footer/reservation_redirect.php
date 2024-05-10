<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // User is logged in, redirect to booking page
    header("Location: ../loginhome/booking.php");
} else {
    // User is not logged in, redirect to login page
    header("Location: ../form/login.php");
}
exit();
?>
