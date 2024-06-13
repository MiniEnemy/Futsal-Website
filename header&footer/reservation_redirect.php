<?php
session_start();


if(isset($_SESSION['username'])) {
    
    header("Location: ../loginhome/booking.php");
} else {
    
    header("Location: ../form/login.php");
}
exit();
?>
