<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsal-booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve entered username and password from the form
$enteredUsername = $_POST['username'];
$enteredPassword = $_POST['password'];

// Prepare SQL query to fetch user details based on entered username
$sql = "SELECT * FROM signup WHERE Username='$enteredUsername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User with the entered username exists
    $row = $result->fetch_assoc();
    
    // Verify the entered password with the hashed password stored in the database
    if (password_verify($enteredPassword, $row['Password'])) {
        // Passwords match, set session variables and redirect to logged-in page
        $_SESSION['username'] = $enteredUsername;
        $_SESSION['userEmail'] = $row['Email'];
        $_SESSION['userPhone'] = $row['Phone'];
        
        header("Location: ../../loginhome/loggedin.html");
        exit();
    } else {
        // Passwords do not match, redirect back to login page with an error message
        $_SESSION['error_message'] = "Invalid password. Please try again.";
        header("Location: login.html");
        exit();
    }
} else {
    // No user found with the entered username, redirect back to login page with an error message
    $_SESSION['error_message'] = "Invalid username. Please try again.";
    header("Location: login.html");
    exit();
}
?>
