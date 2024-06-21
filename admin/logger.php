<?php

function log_admin_activity($admin_id, $action, $details) {
    $logFile = 'admin_activity.log';

    $logMessage = "[" . date('Y-m-d H:i:s') . "] Admin ID: {$admin_id} - Action: {$action} - Details: {$details}" . PHP_EOL;

    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>
