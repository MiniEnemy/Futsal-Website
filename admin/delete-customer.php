<?php
include 'connect.php';

if(isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Step 1: Fetch the username of the user to be deleted
    $fetch_user_sql = "SELECT username FROM `user` WHERE id = $id";
    $fetch_user_result = mysqli_query($conn, $fetch_user_sql);
    
    if(mysqli_num_rows($fetch_user_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_user_result);
        $username = $row['username'];

        // Step 2: Delete from the booking table where username matches
        $delete_booking_sql = "DELETE FROM `booking` WHERE username = '$username'";
        $delete_booking_result = mysqli_query($conn, $delete_booking_sql);

        // Step 3: Delete from the user table
        $delete_user_sql = "DELETE FROM `user` WHERE id = $id";
        $delete_user_result = mysqli_query($conn, $delete_user_sql);

        if($delete_user_result && $delete_booking_result) {
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
