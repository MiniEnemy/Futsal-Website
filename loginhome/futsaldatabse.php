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
    // Retrieve user details from session
    $userName = $_SESSION['username'] ?? "";
    $userEmail = $_SESSION['userEmail'] ?? "";
    $userPhone = $_SESSION['userPhone'] ?? "";

    // Retrieve form data
    $booking_date = $_POST['booking_date'] ?? "";
    $time = $_POST['time'] ?? "";

    // Check if the selected time is already booked
    $checkSql = "SELECT * FROM booking WHERE Booking_Date = '$booking_date' AND Time = '$time'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Selected time is already booked. Please choose another time.";
        header("Location: booking.php");
        exit();
    } else {
        // Insert the data into the database
        $sql = "INSERT INTO booking (Username, Email, Phone, Booking_Date, Time) VALUES ('$userName', '$userEmail', '$userPhone', '$booking_date', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "<br/><br/><span>Data Inserted successfully...!!</span>";
            header("Location:../index.php");
            exit();
        } else {
            echo "<p>Insertion Failed <br/>" . $conn->error . "</p>";
        }
    }
}

$conn->close();
?>
