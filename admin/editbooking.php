<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$row = [];

if (isset($_GET['editid'])) {
    $id = $_GET['editid'];
    $sql = "SELECT * FROM `booking` WHERE ID = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); 
    } else {
        echo "No booking found with ID: $id"; 
        exit(); 
    }
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $booking_date = $_POST['booking_date'];
    $time = $_POST['time'];

    $update_sql = "UPDATE `booking` SET Username='$username', Email='$email', Phone='$phone', Booking_Date='$booking_date', Time='$time' WHERE ID=$id";

    if (mysqli_query($conn, $update_sql)) {
        echo "Record updated successfully";
        header("Location: Booking(admin).php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
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
        .form-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
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
        <h2>Edit Booking</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= isset($row['Username']) ? $row['Username'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= isset($row['Email']) ? $row['Email'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= isset($row['Phone']) ? $row['Phone'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="booking_date">Booking Date</label>
                <input type="date" id="booking_date" name="booking_date" value="<?= isset($row['Booking_Date']) ? $row['Booking_Date'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <select name="time" id="time" required>
                    <option value="">Select a time</option>
                    <option value="08:00-09:00" <?= (isset($row['Time']) && $row['Time'] == '08:00-09:00') ? 'selected' : '' ?>>08:00 AM - 09:00 AM</option>
                    <option value="09:00-10:00" <?= (isset($row['Time']) && $row['Time'] == '09:00-10:00') ? 'selected' : '' ?>>09:00 AM - 10:00 AM</option>
                    <option value="10:00-11:00" <?= (isset($row['Time']) && $row['Time'] == '10:00-11:00') ? 'selected' : '' ?>>10:00 AM - 11:00 AM</option>
                    <option value="11:00-12:00" <?= (isset($row['Time']) && $row['Time'] == '11:00-12:00') ? 'selected' : '' ?>>11:00 AM - 12:00 PM</option>
                    <option value="12:00-13:00" <?= (isset($row['Time']) && $row['Time'] == '12:00-13:00') ? 'selected' : '' ?>>12:00 PM - 01:00 PM</option>
                    <option value="13:00-14:00" <?= (isset($row['Time']) && $row['Time'] == '13:00-14:00') ? 'selected' : '' ?>>01:00 PM - 02:00 PM</option>
                    <option value="14:00-15:00" <?= (isset($row['Time']) && $row['Time'] == '14:00-15:00') ? 'selected' : '' ?>>02:00 PM - 03:00 PM</option>
                    <option value="15:00-16:00" <?= (isset($row['Time']) && $row['Time'] == '15:00-16:00') ? 'selected' : '' ?>>03:00 PM - 04:00 PM</option>
                    <option value="16:00-17:00" <?= (isset($row['Time']) && $row['Time'] == '16:00-17:00') ? 'selected' : '' ?>>04:00 PM - 05:00 PM</option>
                </select>
            </div>
            <div class="form-group actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="Booking(admin).php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
