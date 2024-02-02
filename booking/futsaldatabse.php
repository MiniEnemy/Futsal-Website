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
    $name = $_POST['visitor_name'];
    $email = $_POST['visitor_email'];
    $phone = $_POST['visitor_phone'];
    $booking_date = $_POST['booking_date'];
    $time = $_POST['time'];

    // Check if the selected time is already booked
    $checkSql = "SELECT * FROM booking WHERE Booking_Date = '$booking_date' AND Time = '$time'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Selected time is already booked. Please choose another time.";
        header("Location: booking.php"); // Replace with the actual URL of your form page
        exit();
    } else {
        // Insert Query for SQL
        $sql = "INSERT INTO booking(Username, Email, Phone, Booking_Date, Time) VALUES ('$name', '$email', '$phone', '$booking_date', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "<br/><br/><span>Data Inserted successfully...!!</span>";
        } else {
            echo "<p>Insertion Failed <br/>" . $conn->error . "</p>";
        }
    }
}

$conn->close();
?>
