<?php
// Start session to use session variables
session_start();

// Function to display logs
function display_logs() {
    $log_file = 'admin_activity.log';
    
    if (file_exists($log_file)) {
        $logs = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        echo '<table class="log-table">';
        echo '<tr><th>Timestamp</th><th>Admin ID</th><th>Action</th><th>Details</th></tr>';
        
        foreach ($logs as $log) {
            // Explode the log entry into components
            $log_parts = explode(' | ', $log);

            // Extract basic details with checks
            $timestamp = htmlspecialchars($log_parts[0] ?? '');
            $admin_id = htmlspecialchars($log_parts[1] ?? '');
            $action = htmlspecialchars($log_parts[2] ?? '');
            $details = htmlspecialchars($log_parts[3] ?? '');
            
            // Display table row
            echo '<tr>';
            echo '<td>' . $timestamp . '</td>';
            echo '<td>' . $admin_id . '</td>';
            echo '<td>' . $action . '</td>';
            echo '<td>' . $details . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<div class="no-logs">No logs available.</div>';
    }
}

// Function to clear logs
function clear_logs() {
    $log_file = 'admin_activity.log';
    
    // Check if log file exists and delete it
    if (file_exists($log_file)) {
        unlink($log_file);
    }
}

// Check if clear logs action is triggered
if (isset($_POST['clear_logs'])) {
    clear_logs();
    $_SESSION['logs_cleared'] = true; // Set session variable to indicate logs have been cleared
    header("Location: {$_SERVER['PHP_SELF']}"); // Redirect to clear POST data
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Activity Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: #4b49ac;
        }
        
        .log-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            min-width: 400px;
        }
        
        .log-table th, .log-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .log-table th {
            background-color: #4b49ac;
            color: #ffffff;
        }
        
        .log-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .log-table tr:hover {
            background-color: #e9e9e9;
        }
        
        .no-logs {
            text-align: center;
            color: #777;
            font-size: 18px;
            margin-top: 20px;
        }
        
        .popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            display: none; /* Hide initially */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        
        form {
            text-align: center;
            margin: 20px 0;
        }
        
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Admin Activity Logs</h1>
    
    <!-- Display logs table -->
    <?php display_logs(); ?>
    
    <!-- Form to clear logs -->
    <form action="" method="post">
        <button type="submit" name="clear_logs">Clear Logs</button>
    </form>
    
    <!-- Popup message for logs cleared -->
    <?php
    if (isset($_SESSION['logs_cleared']) && $_SESSION['logs_cleared'] === true) {
        echo '<div class="popup">';
        echo 'Logs have been cleared.';
        echo '</div>';
        unset($_SESSION['logs_cleared']); // Clear the session variable after displaying the message
    }
    ?>
    
    <script>
    // JavaScript to show popup for a few seconds and then hide it
    window.onload = function() {
        var popup = document.querySelector('.popup');
        if (popup) {
            popup.style.display = 'block';
            setTimeout(function() {
                popup.style.display = 'none';
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    };
    </script>
</body>
</html>
