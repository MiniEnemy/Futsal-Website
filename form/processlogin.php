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


    if ($username === 'owner' && $password === 'owner') {

        header("Location: ../admin/admin.php");
        exit();
    }

 
    $sql = "SELECT * FROM user WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['Password'])) {
            
            $_SESSION['username'] = $username;
            $_SESSION['userEmail'] = $row['Email'];
            $_SESSION['userPhone'] = $row['Phone'];

      
            header("Location: ../loginhome/loggedin.php");
            exit();
        } else {
            
            echo "<script>
                    alert('Invalid username or password.');
                    window.location.href = './login.php';
                  </script>";
        }
    } else {
        
        echo "<script>
                alert('Invalid username or password.');
                window.location.href = './login.php';
              </script>";
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
