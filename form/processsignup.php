<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$phone = (string)$_POST['phone'];
$username = $_POST['username'];
$password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

$checkSql = "SELECT * FROM user WHERE Email = '$email' OR Username = '$username'";
$checkResult = $conn->query($checkSql);

$checkAdminSql = "SELECT * FROM admin WHERE Email = '$email' OR Username = '$username'";
$checkAdminResult = $conn->query($checkAdminSql);

if ($checkResult->num_rows > 0 || $checkAdminResult->num_rows > 0) {

    echo "<script>alert('Email or username already exists.');</script>";
    echo "<script>window.location.href = './sign-up.php';</script>";
    exit();
}
    else{
    $sql = "INSERT INTO user ( Email, Phone, Username, Password)
            VALUES ('$email', '$phone', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location:./login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    }

$conn->close();

?>
