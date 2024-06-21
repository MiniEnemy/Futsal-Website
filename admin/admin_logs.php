<?php
// Function to display logs
function display_logs() {
    $log_file = 'admin_activity.log';
    
    if (file_exists($log_file)) {
        $logs = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        echo '<table border="1">';
        echo '<tr><th>Timestamp</th><th>Admin ID</th><th>Action</th><th>Details</th></tr>';
        
        foreach ($logs as $log) {
            // Explode the log entry into components
            $log_parts = explode(' | ', $log);
            
            // Extract basic details
            $timestamp = htmlspecialchars($log_parts[0]);
            $admin_id = htmlspecialchars($log_parts[1]);
            $action = htmlspecialchars($log_parts[2]);
            $details = htmlspecialchars($log_parts[3]);
            
            // Additional details, if present (e.g., old and new booking times)
            $extra_details = '';
            if (isset($log_parts[4]) && strpos($log_parts[4], 'Old Time') !== false && strpos($log_parts[5], 'New Time') !== false) {
                $old_time = htmlspecialchars($log_parts[4]);
                $new_time = htmlspecialchars($log_parts[5]);
                $extra_details = "<br>($old_time, $new_time)";
            }
            
            // Display table row
            echo '<tr>';
            echo '<td>' . $timestamp . '</td>';
            echo '<td>' . $admin_id . '</td>';
            echo '<td>' . $action . '</td>';
            echo '<td>' . $details . $extra_details . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo 'No logs available.';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Activity Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            text-align: center;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
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
    
    <?php
    // Handle clearing logs
    if (isset($_POST['clear_logs'])) {
        clear_logs();
        echo '<p>Logs have been cleared.</p>';
        // Optionally, you can redirect or refresh the page after clearing logs
        // header("Refresh:0"); // Uncomment this line to refresh the page after clearing logs
    }
    ?>
</body>
</html>
