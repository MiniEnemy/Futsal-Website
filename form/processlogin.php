<?php
if (!session_id()) {
    session_start();
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin credentials
    $sqlAdmin = "SELECT * FROM admin WHERE Username = ?";
    $stmtAdmin = $conn->prepare($sqlAdmin);
    $stmtAdmin->bind_param("s", $username);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    if ($resultAdmin->num_rows > 0) {
        $rowAdmin = $resultAdmin->fetch_assoc();
        if ($password == $rowAdmin['Password']) {
            // Admin login successful
            $_SESSION['username'] = $username;
            $_SESSION['userEmail'] = $rowAdmin['Email'];
            $_SESSION['userPhone'] = $rowAdmin['Phone'];
            header("Location: ../admin/admin.php");
            exit();
        }
    }

    // Check user credentials
    $sqlUser = "SELECT * FROM user WHERE Username = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("s", $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        if (password_verify($password, $rowUser['Password'])) {
            // User login successful
            $_SESSION['username'] = $username;
            $_SESSION['userEmail'] = $rowUser['Email'];
            $_SESSION['userPhone'] = $rowUser['Phone'];
            header("Location: ../loginhome/loggedin.php");
            exit();
        }
    }

    // If no successful login attempt, set an error message
    $_SESSION['error_message'] = "Invalid username or password. Please try again.";

    header("Location: ./login.php");
    exit();
}

$conn->close();
?>
