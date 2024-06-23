<?php
// Start session to use session variables
session_start();

// Include your database connection file
include 'connect.php';

// Function to log admin activity
function log_admin_activity($admin_id, $action, $details) {
    $log_file = 'admin_activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "$timestamp | $admin_id | $action | $details" . PHP_EOL;

    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

// Check if deleteid is set in the query string
if(isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Step 1: Fetch the username of the user to be deleted
    $fetch_user_sql = "SELECT username FROM user WHERE id = $id";
    $fetch_user_result = mysqli_query($conn, $fetch_user_sql);

    if(mysqli_num_rows($fetch_user_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_user_result);
        $username = $row['username'];

        // Step 2: Delete from the booking table where username matches
        $delete_booking_sql = "DELETE FROM booking WHERE username = '$username'";
        $delete_booking_result = mysqli_query($conn, $delete_booking_sql);

        // Step 3: Delete from the user table
        $delete_user_sql = "DELETE FROM user WHERE id = $id";
        $delete_user_result = mysqli_query($conn, $delete_user_sql);

        if($delete_user_result && $delete_booking_result) {
            // Log admin activity
            $admin_id = $_SESSION['Admin_ID'] ?? ''; // Replace with actual admin ID retrieval method
            $action = "Delete User";
            $details = "Deleted user with ID: $id and username: $username";
            log_admin_activity($admin_id, $action, $details);

            header("Location: customer.php");
            exit; // Stop execution after redirect
        } else {
            die(mysqli_error($conn));
        }
    } else {
        die("User not found.");
    }
}
?>
