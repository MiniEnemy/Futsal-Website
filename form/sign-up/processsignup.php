<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['no'];
$username = $_POST['user'];
$password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

$sql = "INSERT INTO `signup`(`Firstname`, `Lastname`, `Email`, `Phone`, `Username`, `Password`) VALUES ('$fname', '$lname', '$email', '$phone', '$username', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Location:../log-in/login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
