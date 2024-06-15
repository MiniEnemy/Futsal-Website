<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "futsalbooking";


$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$username = $_SESSION['username'];


$username = $conn->real_escape_string($username);

$sql = "SELECT ID FROM user WHERE Username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userID = $row['ID'];

    $userID = $conn->real_escape_string($userID);

    $bookingSql = "SELECT * FROM booking WHERE ID = '$userID'";
    $bookingResult = $conn->query($bookingSql);


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
