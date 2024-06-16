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

$username = $email = $phone = $password = "";
$user_id = 0;

if (isset($_SESSION['username'])) {
    $sessionUsername = $_SESSION['username'];
    
    $sql = "SELECT * FROM user WHERE Username = '$sessionUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['ID'];
        $username = $row['Username'];
        $email = $row['Email'];
        $phone = $row['Phone'];
        $password = $row['Password']; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];
    $newPassword = $_POST['password'];

    $hashedPassword = $password;

    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    $checkSql = "SELECT * FROM user WHERE (Email = '$newEmail' OR Username = '$newUsername') AND ID != '$user_id'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $error_message = "Username or Email already exists.";
    } else {
        $sql = "UPDATE user SET Username='$newUsername', Email='$newEmail', Phone='$newPhone', Password='$hashedPassword' WHERE ID='$user_id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $newUsername;
            $_SESSION['userEmail'] = $newEmail;
            $_SESSION['userPhone'] = $newPhone;

            header("Location: ../loginhome/loggedin.php");
            exit();
        } else {
            $error_message = "Error updating record: " . $conn->error;
        }
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
    <link rel="stylesheet" href="../css/update.css">
</head>
<body>
    <div class="container">
        <h2>Update User Information</h2>
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <div class="error" id="error-message"></div>
        <form id="updateForm" action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password if you want to change it">

            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("updateForm");
        const errorMessage = document.getElementById("error-message");

        form.addEventListener("submit", (e) => {
            const newUsername = document.getElementById("username").value;
            const newEmail = document.getElementById("email").value;
            const newPhone = document.getElementById("phone").value;
            const newPassword = document.getElementById("password").value;

            errorMessage.textContent = "";

            if (!validateUsername(newUsername)) {
                e.preventDefault();
                errorMessage.textContent = "Username must be alphanumeric and between 3 and 20 characters.";
            } else if (!validateEmail(newEmail)) {
                e.preventDefault();
                errorMessage.textContent = "Please enter a valid email address.";
            } else if (!validatePhone(newPhone)) {
                e.preventDefault();
                errorMessage.textContent = "Please enter a valid phone number.";
            } else if (newPassword !== "" && !validatePassword(newPassword)) {
                e.preventDefault();
                errorMessage.textContent = "Password must be at least 8 characters long.";
            }
        });

        function validateUsername(username) {
            const re = /^[a-zA-Z0-9]{3,20}$/;
            return re.test(username);
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            return re.test(String(email).toLowerCase());
        }

        function validatePhone(phone) {
            const re = /^[0-9]{10,15}$/;
            return re.test(phone);
        }

        function validatePassword(password) {
            return password.length >= 8;
        }
    });
    </script>
</body>
</html>
