<?php
session_start();

// Include your database connection file
include 'connect.php';
// Include your logging function file
include 'log_function.php';

// Function to get current admin ID (replace with your actual implementation)
function get_current_admin_id() {
    // Example implementation, replace with your actual method of getting admin ID
    return $_SESSION['admin_id'] ?? 0; // Assuming admin_id is stored in session
}

// Check if editid is set in URL
$id = $_GET['editid'] ?? 0;

// Fetch existing user details from the database
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Store old values for logging purposes
$old_name = $row['Username'] ?? '';
$old_email = $row['Email'] ?? '';
$old_phone = $row['Phone'] ?? '';

// Initialize variables for form values
$name = $old_name;
$email = $old_email;
$phone = $old_phone;

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update user table
        $sql = "UPDATE user SET Username=?, Email=?, Phone=? WHERE ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
        $stmt->execute();

        // Log admin activity
        $admin_id = get_current_admin_id();
        $action = "Update User";
        $details = "User ID: $id, Original: Name=$old_name, Email=$old_email, Phone=$old_phone; Updated: Name=$name, Email=$email, Phone=$phone";
        log_admin_activity($admin_id, $action, $details);

        // Commit transaction
        $conn->commit();

        // Redirect after successful update
        header("Location: customer.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

$stmt->close();
$conn->close();
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
