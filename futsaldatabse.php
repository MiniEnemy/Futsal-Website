<?php
session_start();



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsal-booking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Retrieve user details from session
    $userName =$_POST['visitor_name'];
    $userEmail = $_POST['visitor_email'];
    $userPhone = $_POST['visitor_phone'] ?? "";

    // Retrieve form data
    $booking_date = $_POST['booking_date'] ?? "";
    $time = $_POST['time'] ?? "";

    // Check if the selected time is already booked
    $checkSql = "SELECT * FROM booking WHERE Booking_Date = '$booking_date' AND Time = '$time'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Selected time is already booked. Please choose another time.";
        header("Location: booking.php"); // Redirect back to booking page
        exit();
    } else {
        // Insert the data into the database
        $sql = "INSERT INTO booking (Username, Email, Phone, Booking_Date, Time) VALUES ('$userName', '$userEmail', '$userPhone', '$booking_date', '$time')";

        if ($conn->query($sql) === TRUE) {
            header("Location:index.php");
        } else {
            echo "<p>Insertion Failed <br/>" . $conn->error . "</p>";
        }
    }
}

$conn->close();
?>
