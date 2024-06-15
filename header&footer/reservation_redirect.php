<?php
session_start();


if(isset($_SESSION['username'])) {
    
    header("Location: ../loginhome/bookingtble.php");
} else {
    
    header("Location: ../form/login.php");
}
exit();
?>
