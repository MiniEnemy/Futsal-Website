<?php
session_start(); // Start the session

// Retrieve user details from session
$userEmail = $_SESSION['userEmail'] ?? "";
$userPhone = $_SESSION['userPhone'] ?? "";
$userName = $_SESSION['username'] ?? ""; // Retrieve the username from the session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <form action="futsaldatabse.php" method="post" id="bookingForm" onsubmit="return validateForm()">
        <div class="elem-group">
            <label for="name">Username</label>
            <input type="text" id="name" name="visitor_name" value="<?php echo $userName; ?>" >
            <span class="error-message" id="name-error"></span>
        </div>

        <div class="elem-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="visitor_email" value="<?php echo $userEmail; ?>" >
            <span class="error-message" id="email-error"></span>
        </div>

        <div class="elem-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="visitor_phone" value="<?php echo $userPhone; ?>" >
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

        var date = document.getElementById("booking-date").value;
        var time = document.getElementById("time").value;

        // Validate booking date
        if (!date.trim()) {
            document.getElementById("date-error").textContent = "Booking date is required";
        }

        // Validate time
        if (!time.trim()) {
            document.getElementById("time-error").textContent = "Time selection is required";
        }

        // If any error messages are present, prevent form submission
        var errorMessages = document.querySelectorAll(".error-message");
        for (var i = 0; i < errorMessages.length; i++) {
            if (errorMessages[i].textContent !== "") {
                return false; // Prevent form submission
            }
        }

        return true; // Allow form submission if no errors
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
