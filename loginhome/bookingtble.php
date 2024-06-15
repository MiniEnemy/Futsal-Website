<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsalbooking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve logged-in user's username from session
$username = $_SESSION['username'];

// Initialize variables to store user data and bookings
$userData = [];
$userBookings = [];

// Prepare SQL query to fetch user data based on username
$stmtUser = $conn->prepare("SELECT ID, Email, Phone, Username FROM user WHERE Username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

// Fetch user data
if ($resultUser->num_rows > 0) {
    $userData = $resultUser->fetch_assoc();
}

// Prepare SQL query to fetch bookings for the user
$stmtBooking = $conn->prepare("SELECT ID, Booking_Date, Time FROM booking WHERE Username = ?");
$stmtBooking->bind_param("s", $username);
$stmtBooking->execute();
$resultBooking = $stmtBooking->get_result();

// Fetch user bookings
if ($resultBooking->num_rows > 0) {
    while ($row = $resultBooking->fetch_assoc()) {
        $userBookings[] = $row;
    }
}

// Close prepared statements and database connection
$stmtUser->close();
$stmtBooking->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details and Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 70%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            text-align: center;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            color: #333;
            border-radius: 4px;
            display: inline-block;
        }
        .actions a:hover {
            background-color: #e0e0e0;
        }
        .book-now {
            margin-bottom: 20px;
        }
        .book-now a {
            text-decoration: none;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }
        .book-now a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="book-now">
    <h2>Book Now</h2>
    <p>If you haven't made any bookings yet, you can book here:</p>
    <a href="booking.php">Book Here</a>
</div>

<div>
    <?php if (!empty($userData)): ?>
        <h2>User Details and Bookings</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Username</th>
                <th>Booking Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            <?php foreach ($userBookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($userData['ID']); ?></td>
                    <td><?php echo htmlspecialchars($userData['Email']); ?></td>
                    <td><?php echo htmlspecialchars($userData['Phone']); ?></td>
                    <td><?php echo htmlspecialchars($userData['Username']); ?></td>
                    <td><?php echo htmlspecialchars($booking['Booking_Date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['Time']); ?></td>
                    <td class="actions">
                        <a href="deletebook.php?id=<?php echo $booking['ID']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>User data not found.</p>
    <?php endif; ?>
</div>

</body>
</html>
