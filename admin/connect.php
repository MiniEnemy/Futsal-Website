<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM `user`";


if (isset($_GET['date']) && $_GET['date'] != '') {
    $sql .= " WHERE Booking_Date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_GET['date']);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

if (!$result) {
    die("Error: " . $conn->error);
}


if (isset($stmt)) {
    $stmt->close();
}
?>
