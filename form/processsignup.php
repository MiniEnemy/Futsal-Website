<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsal-booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$phone = (string)$_POST['phone']; // Cast phone number to string
$username = $_POST['username'];
$password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

// Check if email or username already exists
$checkSql = "SELECT * FROM signup WHERE Email = '$email' OR Username = '$username'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    // Email or username already exists
    echo "<script>alert('Email or username already exists.');</script>";
    echo "<script>window.location.href = '../sign-up/sign-up.php';</script>";
    exit();
} else {
    // Insert new record
    $sql = "INSERT INTO signup ( Email, Phone, Username, Password)
            VALUES ('$email', '$phone', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location:../log-in/login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>