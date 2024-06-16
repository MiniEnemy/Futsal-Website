<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Booking ID is missing.");
}

$bookingID = $_GET['id'];


$deleteStmt = $conn->prepare("DELETE FROM booking WHERE ID = ?");
$deleteStmt->bind_param("i", $bookingID);

if ($deleteStmt->execute()) {

    header("Location: bookingtbl.php");
    exit();
} else {
    echo "Error deleting booking: " . $conn->error;
}

$deleteStmt->close();


$conn->close();
?>
