<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect user to index.php
header("Location:../mainpage/index.php");

?>
