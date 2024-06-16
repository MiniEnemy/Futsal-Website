<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$userData = [];
$userBookings = [];

$stmtUser = $conn->prepare("SELECT ID, Email, Phone, Username FROM user WHERE Username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $userData = $resultUser->fetch_assoc();
}

$stmtBooking = $conn->prepare("SELECT ID, Booking_Date, Time FROM booking WHERE Username = ?");
$stmtBooking->bind_param("s", $username);
$stmtBooking->execute();
$resultBooking = $stmtBooking->get_result();

if ($resultBooking->num_rows > 0) {
    $userBookings = $resultBooking->fetch_all(MYSQLI_ASSOC);
}

if (isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE `user` SET Username='$new_username', Email='$email', Phone='$phone' WHERE Username='$username'";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['username'] = $new_username;
        echo "User details updated successfully";

        $booking_id = $userBookings[0]['ID'];
        $booking_date = $_POST['booking_date'];
        $time = $_POST['time'];

        $update_booking_sql = "UPDATE `booking` SET Booking_Date='$booking_date', Time='$time' WHERE ID=$booking_id";

        if (!$conn->query($update_booking_sql)) {
            echo "Error updating booking details: " . $conn->error;
        }

        header("Location: bookingtble.php");
        exit();
    } else {
        echo "Error updating user details: " . $conn->error;
    }
}

$stmtUser->close();
$stmtBooking->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 50px;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-group button,#danger {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .actions {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User Details</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($userData['Username']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($userData['Email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($userData['Phone']) ?>" required>
            </div>
            <?php if (!empty($userBookings)): ?>
            <div class="form-group">
                <label for="booking_date">Booking Date</label>
                <input type="date" id="booking_date" name="booking_date" value="<?= htmlspecialchars($userBookings[0]['Booking_Date']) ?>" required>
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <select name="time" id="time" required>
                    <option value="08:00-09:00" <?= ($userBookings[0]['Time'] == '08:00-09:00') ? 'selected' : '' ?>>08:00 AM - 09:00 AM</option>
                    <option value="09:00-10:00" <?= ($userBookings[0]['Time'] == '09:00-10:00') ? 'selected' : '' ?>>09:00 AM - 10:00 AM</option>
                    <option value="10:00-11:00" <?= ($userBookings[0]['Time'] == '10:00-11:00') ? 'selected' : '' ?>>10:00 AM - 11:00 AM</option>
                    <option value="11:00-12:00" <?= ($userBookings[0]['Time'] == '11:00-12:00') ? 'selected' : '' ?>>11:00 AM - 12:00 PM</option>
                    <option value="12:00-13:00" <?= ($userBookings[0]['Time'] == '12:00-13:00') ? 'selected' : '' ?>>12:00 PM - 01:00 PM</option>
                    <option value="13:00-14:00" <?= ($userBookings[0]['Time'] == '13:00-14:00') ? 'selected' : '' ?>>01:00 PM - 02:00 PM</option>
                    <option value="14:00-15:00" <?= ($userBookings[0]['Time'] == '14:00-15:00') ? 'selected' : '' ?>>02:00 PM - 03:00 PM</option>
                    <option value="15:00-16:00" <?= ($userBookings[0]['Time'] == '15:00-16:00') ? 'selected' : '' ?>>03:00 PM - 04:00 PM</option>
                    <option value="16:00-17:00" <?= ($userBookings[0]['Time'] == '16:00-17:00') ? 'selected' : '' ?>>04:00 PM - 05:00 PM</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="form-group actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="user_details.php" id="danger" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
