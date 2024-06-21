<?php
include 'logger.php';

$logs = readLogs();
?>

<h1>Change Logs</h1>
<pre><?php echo $logs; ?></pre>
