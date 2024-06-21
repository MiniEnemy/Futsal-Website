<?php
session_start();

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

// Prepare and execute user data query
$stmtUser = $conn->prepare("SELECT ID, Email, Phone, Username FROM user WHERE Username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $userData = $resultUser->fetch_assoc();
} else {
    echo "No user data found.";
    exit();
}

// Prepare and execute booking data query
$stmtBooking = $conn->prepare("SELECT ID, Booking_Date, Time FROM booking WHERE Username = ?");
$stmtBooking->bind_param("s", $username);
$stmtBooking->execute();
$resultBooking = $stmtBooking->get_result();

if ($resultBooking->num_rows > 0) {
    $userBookings = $resultBooking->fetch_all(MYSQLI_ASSOC);
}

// Function to check for overlap
function checkOverlap($conn, $booking_id, $new_start_time, $new_end_time, $booking_date) {
    // Convert new time range to DateTime objects for comparison
    $new_start = new DateTime($booking_date . ' ' . $new_start_time);
    $new_end = new DateTime($booking_date . ' ' . $new_end_time);

    // Prepare query to check for overlapping bookings
    $stmtOverlap = $conn->prepare("SELECT ID FROM booking WHERE ID <> ? AND Booking_Date = ? AND ((Time >= ? AND Time < ?) OR (Time <= ? AND ? < Time))");
    $stmtOverlap->bind_param("isssss", $booking_id, $booking_date, $new_start_time, $new_end_time, $new_start_time, $new_end_time);
    $stmtOverlap->execute();
    $resultOverlap = $stmtOverlap->get_result();

    if ($resultOverlap->num_rows > 0) {
        return true; // Overlap found
    } else {
        return false; // No overlap
    }
}

// Function to log admin activity with booking times
function log_admin_activity($admin_id, $action, $details, $old_time_range = null, $new_time_range = null) {
    $log_file = 'admin_activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "$timestamp | Admin ID: $admin_id | $action | Details: $details";
    
    // Append old and new time ranges if provided
    if ($old_time_range !== null && $new_time_range !== null) {
        $log_entry .= " | Old Time: $old_time_range | New Time: $new_time_range";
    }
    
    $log_entry .= PHP_EOL;
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

// Handle form submission
if (isset($_POST['update'])) {
    $new_start_time = $_POST['start_time'];
    $new_end_time = $_POST['end_time'];
    $booking_date = $userBookings[0]['Booking_Date']; // Assuming booking date is fetched and stored

    if (!empty($userBookings)) {
        $booking_id = $userBookings[0]['ID'];
        $existingTimeRange = $userBookings[0]['Time']; // Existing time range

        // Check for overlap
        if (checkOverlap($conn, $booking_id, $new_start_time, $new_end_time, $booking_date)) {
            $error_message = "Error: The selected time range overlaps with an existing booking.";
        } else {
            // Update the booking
            $stmtUpdateBooking = $conn->prepare("UPDATE `booking` SET Time = ? WHERE ID = ?");
            $new_time_range = $new_start_time . '-' . $new_end_time;
            $stmtUpdateBooking->bind_param("si", $new_time_range, $booking_id);

            if ($stmtUpdateBooking->execute()) {
                // Log admin activity with old and new time ranges
                $admin_id = $_SESSION['Admin_ID']; // Replace with actual admin ID retrieval method
                $action = "Update Booking";
                $details = "Booking ID: $booking_id";
                log_admin_activity($admin_id, $action, $details, $existingTimeRange, $new_time_range);

                header("Location: Booking(admin).php");
                exit();
            } else {
                $error_message = "Error updating booking details: " . $conn->error;
            }
        }
    } else {
        header("Location: Booking(admin).php");
        exit();
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
    <title>Edit Booking Details</title>
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
        .form-group input[disabled] {
            background-color: #f5f5f5; /* Gray out disabled fields */
        }
        .form-group button, #danger {
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
        .text-danger {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Booking Details</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($userData['Username']) ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($userData['Email']) ?>" disabled>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($userData['Phone']) ?>" disabled>
            </div>
            <?php if (!empty($userBookings)): ?>
                <div class="form-group">
                    <label for="booking_date">Booking Date</label>
                    <input type="date" id="booking_date" name="booking_date" value="<?= htmlspecialchars($userBookings[0]['Booking_Date']) ?>" disabled>
                </div>
                <?php 
                    // Splitting existing time range to show start and end time
                    $existingTimeRange = explode('-', $userBookings[0]['Time']);
                    $existingStartTime = $existingTimeRange[0];
                    $existingEndTime = $existingTimeRange[1];
                ?>
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <select name="start_time" id="start_time" required>
                        <?php
                        // Generate options for start time from 8:00 AM to 4:45 PM in 15-minute intervals
                        $start = new DateTime("08:00");
                        $end = new DateTime("17:00");
                        while ($start <= $end) {
                            $time = $start->format("H:i");
                            echo '<option value="' . $time . '" ' . ($existingStartTime == $time ? 'selected' : '') . '>' . $time . '</option>';
                            $start->modify("+15 minutes");
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <select name="end_time" id="end_time" required>
                        <?php
                        // Generate options for end time from 8:15 AM to 5:00 PM in 15-minute intervals
                        $start = new DateTime("08:15");
                        $end = new DateTime("17:00");
                        while ($start <= $end) {
                            $time = $start->format("H:i");
                            echo '<option value="' . $time . '" ' . ($existingEndTime == $time ? 'selected' : '') . '>' . $time . '</option>';
                            $start->modify("+15 minutes");
                        }
                        ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <?php if (isset($error_message)): ?>
                    <p class="text-danger"><?= $error_message ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group actions">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="Booking(admin).php" id="danger" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
