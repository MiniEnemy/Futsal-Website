<?php
// Assuming you have a database connection established
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

// Fetch user details from the "signup" table
$sql = "SELECT username, email, phone FROM signup WHERE id = 5"; // Assuming you have a user_id, you need to replace it with the actual user ID or use some mechanism to identify the current user
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();
    $userName = $row["username"];
    $userEmail = $row["email"];
    $userPhone = $row["phone"];
} else {
    // Handle if user details are not found
    $userName = "";
    $userEmail = "";
    $userPhone = "";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="booking.css">
</head>

<body>
    <form action="futsaldatabse.php" method="post" id="bookingForm" onsubmit="return validateForm()">
        <div class="elem-group">
            <label for="name">Username</label>
            <input type="text" id="name" name="visitor_name" value="<?php echo $userName; ?>" disabled>
            <span class="error-message" id="name-error"></span>
        </div>

        <div class="elem-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="visitor_email" value="<?php echo $userEmail; ?>" disabled>
            <span class="error-message" id="email-error"></span>
        </div>

        <div class="elem-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="visitor_phone" value="<?php echo $userPhone; ?>" disabled>
            <span class="error-message" id="phone-error"></span>
        </div>

        <div class="elem-group">
            <label for="booking-date">Booking Date</label>
            <input type="date" id="booking-date" name="booking_date">
            <span class="error-message" id="date-error"></span>
        </div>
        <div class="elem-group">
            <label for="time">Time Selection</label>
            <select name="time" id="time">
                <option value="">Select a time</option>
                <option value="08:00-09:00">08:00AM TO 09:00AM</option>
                <option value="09:00-10:00">09:00AM TO 10:00AM</option>
                <option value="10:00-11:00">10:00AM TO 11:00AM</option>
                <option value="11:00-12:00">11:00AM TO 12:00PM</option>
                <option value="12:00-13:00">12:00PM TO 01:00PM</option>
                <option value="13:00-14:00">01:00PM TO 02:00PM</option>
                <option value="14:00-15:00">02:00PM TO 03:00PM</option>
                <option value="15:00-16:00">03:00PM TO 04:00PM</option>
                <option value="16:00-17:00">04:00PM TO 05:00PM</option>
                <!-- Add unique values for other options -->
            </select>
            <span class="error-message" id="time-error">
                <?php
                session_start();
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']); // Clear the session variable
                }
                ?>
            </span>
        </div>
        <button type="submit" name="submit" onclick="validateForm()">Submit</button>
    </form>

    <script>
        function validateForm() {
            // Reset previous error messages
            resetErrorMessages();

            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var date = document.getElementById("booking-date").value;
            var time = document.getElementById("time").value;

            // Validate username
            if (!name.trim()) {
                document.getElementById("name-error").textContent = "Username is required";
            } else if (!/^[A-Za-z\s]{3,20}$/.test(name)) {
                document.getElementById("name-error").textContent = "Invalid username format";
            }

            // Validate email
            if (!email.trim()) {
                document.getElementById("email-error").textContent = "Email is required";
                
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                document.getElementById("email-error").textContent = "Invalid email format";
            }

            // Validate phone
            if (!phone.trim()) {
                document.getElementById("phone-error").textContent = "Phone number is required";
            } else if (!/(\d{3})-?\s?(\d{3})-?\s?(\d{4})/.test(phone)) {
                document.getElementById("phone-error").textContent = "Invalid phone number format";
            }

            // Validate booking date
            if (!date.trim()) {
                document.getElementById("date-error").textContent = "Booking date is required";
            }

            // Validate time
            if (!time.trim()) {
                document.getElementById("time-error").textContent = "Time selection is required";
            }
            return !(name === '' || email === '' || phone === '' || date === '' || time === '');

            // Add additional validation for booking date, from time, and to time if needed
        }

        function resetErrorMessages() {
            var errorElements = document.getElementsByClassName("error-message");
            for (var i = 0; i < errorElements.length; i++) {
                errorElements[i].textContent = "";
            }
        }

        var currentDateTime = new Date();
        var year = currentDateTime.getFullYear();
        var month = (currentDateTime.getMonth() + 1);
        var date = currentDateTime.getDate();

        if (date < 10) {
            date = '0' + date;
        }
        if (month < 10) {
            month = '0' + month;
        }

        var currentDate = year + "-" + month + "-" + date;
        var bookingElem = document.querySelector("#booking-date");

        bookingElem.setAttribute("min", currentDate);
    </script>
</body>

</html>