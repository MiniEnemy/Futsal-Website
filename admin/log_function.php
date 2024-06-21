<?php
function log_admin_activity($admin_id, $action, $details) {
    $log_file = 'admin_activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "$timestamp | Admin ID: $admin_id | Action: $action | Details: $details" . PHP_EOL;
    
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}
?>
