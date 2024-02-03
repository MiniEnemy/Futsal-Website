<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$enteredUsername = $_POST['username'];
$enteredPassword = $_POST['pass'];

$sql = "SELECT * FROM `signup` WHERE `Username`='$enteredUsername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verify the password
    if (password_verify($enteredPassword, $row['Password'])) {
        // Username and password match
        $_SESSION['username'] = $username;
        header("Location:../../booking/booking.php");

        exit();
    } else {
        // Password does not match
        echo "<script>alert('Invalid password. Please try again.');</script>";
        echo "<script>window.location.href='./login.html';</script>";
    }
} else {
    // Username not found
    echo "<script>alert('Invalid username. Please try again.');</script>";
    echo "<script>window.location.href='./login.html';</script>";
}

$conn->close();
?>
