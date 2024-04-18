<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `signup` ";

if(isset($_GET['date']) && $_GET['date'] != '') {
    $sql .= "WHERE Booking_Date = '" . $_GET['date'] . "'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

?>