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

    // Redirect back to login on failure without an error message
    header("Location: ./login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Information</title>
</head>
<body>
    <h2>Update User Information</h2>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo isset($username) ? $username : ''; ?>"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"><br>
        
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter new password if you want to change it"><br>
        
        <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
