<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "futsalbooking";

// Create a new database connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user ID from session securely
$username = $_SESSION['username'];

// Escaping the username to prevent SQL injection
$username = $conn->real_escape_string($username);

// Query to get user ID
$sql = "SELECT ID FROM signup WHERE Username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userID = $row['ID'];

    // Escaping the user ID to prevent SQL injection
    $userID = $conn->real_escape_string($userID);

    // Query to fetch booking data for the user
    $bookingSql = "SELECT * FROM booking WHERE ID = '$userID'";
    $bookingResult = $conn->query($bookingSql);

    // Display bookings in a table
    echo "<h2>Your Booked Tables</h2>";
    if ($bookingResult->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Date</th><th>Time</th></tr>";
        while ($bookingRow = $bookingResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($bookingRow['Booking_Date']) . "</td>";
            echo "<td>" . htmlspecialchars($bookingRow['Time']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No bookings found.";
    }
} else {
    echo "User not found.";
}

$conn->close();
?>
