<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsal-booking";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connection was established: ";
}
$sql = "SELECT * FROM `booking` ";
$result = mysqli_query($conn, $sql);
echo "<br>";
// $num = mysqli_num_rows($result);

// while ($row = mysqli_fetch_assoc($result)) {
//     echo $row["Username"] . " " . $row["Email"] . " " . $row["Phone"];
//     echo "<br>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Records</title>
    <style>
        table {
            border-collapse: collapse;
            align-item:center;
            width: 40%;
            margin-bottom: 20px; /* Add margin below the table */
        }
        th, td {
            border: 2px solid black; /* 2px black border for all table cells */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2; /* Light gray background for header row */
        }
    </style>
</head>
<body>
    <h2>Booking Records</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Booking Date</th>
            <th>Time</th>
        </tr>
        <?php
        // Display data in table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Username"] . "</td>";
            $bookingDate = date("d-m-Y", strtotime($row["Booking_Date"]));
            echo "<td>" . $bookingDate . "</td>"; // Display formatted booking date
            echo "<td>" . $row["Time"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
