<?php
include 'connect.php';

$id = $_GET['editid'] ?? 0; 
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$old_name = $row['Username'] ?? '';
$old_email = $row['Email'] ?? '';
$old_phone = $row['Phone'] ?? '';

$name = $old_name;
$email = $old_email;
$phone = $old_phone;

if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $conn->begin_transaction();
    try {
        // Update user table
        $sql = "UPDATE user SET Username=?, Email=?, Phone=? WHERE ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
        $stmt->execute();

        // Update booking table
        $sql = "UPDATE booking SET Username=?, Email=?, Phone=? WHERE Username=? AND Email=? AND Phone=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $email, $phone, $old_name, $old_email, $old_phone);
        $stmt->execute();

        $conn->commit();

        header("Location: customer.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
            margin: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
    <script>
        function validateForm() {
            let username = document.getElementById("username").value;
            let email = document.getElementById("email").value;
            let phone = document.getElementById("phone").value;

            let usernameError = document.getElementById("username-error");
            let emailError = document.getElementById("email-error");
            let phoneError = document.getElementById("phone-error");

            usernameError.textContent = "";
            emailError.textContent = "";
            phoneError.textContent = "";

            let valid = true;

            if (!validateUsername(username)) {
                usernameError.textContent = "Username must be alphanumeric and between 3 and 20 characters.";
                valid = false;
            } 
            if (!validateEmail(email)) {
                emailError.textContent = "Please enter a valid email address.";
                valid = false;
            } 
            if (!validatePhone(phone)) {
                phoneError.textContent = "Please enter a valid phone number.";
                valid = false;
            }

            return valid;
        }

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
    </script>
</head>
<body>
    <div class="container">
        <h2>Edit Account</h2>
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($name); ?>">
                <div class="error" id="username-error"></div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <div class="error" id="email-error"></div>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                <div class="error" id="phone-error"></div>
            </div>
            <input type="submit" name="submit" value="Update">
        </form>
    </div>
</body>
</html>
