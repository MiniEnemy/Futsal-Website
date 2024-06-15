<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if booking ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Booking ID is missing.");
}

$bookingID = $_GET['id'];

// Delete booking from database
$deleteStmt = $conn->prepare("DELETE FROM booking WHERE ID = ?");
$deleteStmt->bind_param("i", $bookingID);

if ($deleteStmt->execute()) {
    // Redirect to booking page after successful deletion
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting booking: " . $conn->error;
}

$deleteStmt->close();

// Close database connection
$conn->close();
?>
