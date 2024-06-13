<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
   
    $userName = $_SESSION['username'] ?? "";
    $userEmail = $_SESSION['userEmail'] ?? "";
    $userPhone = $_SESSION['userPhone'] ?? "";

 
    $booking_date = $_POST['booking_date'] ?? "";
    $time = $_POST['time'] ?? "";

   
    $checkSql = "SELECT * FROM booking WHERE Booking_Date = '$booking_date' AND Time = '$time'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Selected time is already booked. Please choose another time.";
        header("Location: booking.php");
        exit();
    } else {
        
        $sql = "INSERT INTO booking (Username, Email, Phone, Booking_Date, Time) VALUES ('$userName', '$userEmail', '$userPhone', '$booking_date', '$time')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Booking successful! Redirecting...";
            header("Location: success.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Insertion failed: " . $conn->error;
            header("Location: booking.php");
            exit();
        }
    }
}

$conn->close();
?>
