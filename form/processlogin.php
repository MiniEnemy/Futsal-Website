<?php
if (!session_id()) {
    session_start();
}

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = $email = $phone = $password = "";
$user_id = 0;

if (isset($_SESSION['username'])) {
    $sessionUsername = $_SESSION['username'];
    // Fetch user data based on session username
    $sql = "SELECT * FROM signup WHERE Username = '$sessionUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['ID'];
        $username = $row['Username'];
        $email = $row['Email'];
        $phone = $row['Phone'];
        $password = $row['Password']; // Store current password
    }
}

// Update user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];
    $newPassword = $_POST['password'];

    // Check if password is updated
    if (!empty($newPassword)) {
        $password = $newPassword; // Use new password
    }

    $sql = "UPDATE signup SET Username='$newUsername', Email='$newEmail', Phone='$newPhone', Password='$password' WHERE ID='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Update session variables
        $_SESSION['username'] = $newUsername;
        $_SESSION['userEmail'] = $newEmail;
        $_SESSION['userPhone'] = $newPhone;

        // Redirect to loggedin.php after successful update
        header("Location: ../loginhome/loggedin.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
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
        <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>
        
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter new password if you want to change it"><br>
        
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
