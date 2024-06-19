<?php
session_start();

$userEmail = $_SESSION['userEmail'] ?? "";
$userPhone = $_SESSION['userPhone'] ?? "";
$userName = $_SESSION['username'] ?? "";
$availableTimes = [];
$selectedDate = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_availability'])) {
    $selectedDate = $_POST['booking_date'] ?? "";
    if (empty($selectedDate)) {
        $_SESSION['error_message'] = "Please select a booking date first.";
    } else {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "futsalbooking";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch existing bookings for the selected date
        $sql = "SELECT Time FROM booking WHERE Booking_Date = '$selectedDate'";
        $result = $conn->query($sql);

        $bookedTimes = [];
        while ($row = $result->fetch_assoc()) {
            $bookedTimes[] = $row['Time'];
        }

        // Generate all possible times in 15-minute intervals
        $allTimes = [];
        $start = new DateTime("08:00");
        $end = new DateTime("17:00");

        while ($start <= $end) {
            $allTimes[] = $start->format("H:i");
            $start->modify("+15 minutes");
        }

        // Find the latest end time among the booked times
        $latestEndTime = "08:00"; // Initialize with the start time or earliest time
        foreach ($bookedTimes as $bookedTime) {
            list($bookedStartTime, $bookedEndTime) = explode('-', $bookedTime);
            if ($bookedEndTime > $latestEndTime) {
                $latestEndTime = $bookedEndTime;
            }
        }

        // Filter out times before the latest end time
        $filteredTimes = [];
        foreach ($allTimes as $time) {
            if ($time >= $latestEndTime) {
                $filteredTimes[] = $time;
            }
        }

        $availableTimes = $filteredTimes;

        $conn->close();

        // If no available times, set an error message
        if (empty($availableTimes)) {
            $_SESSION['error_message'] = "All time slots are fulfilled. Please choose another date.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $userName = $_SESSION['username'] ?? "";
    $userEmail = $_SESSION['userEmail'] ?? "";
    $userPhone = $_SESSION['userPhone'] ?? "";

    $booking_date = $_POST['booking_date'] ?? "";
    $start_time = $_POST['start_time'] ?? "";
    $end_time = $_POST['end_time'] ?? "";

    if ($booking_date && $start_time && $end_time) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "futsalbooking";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Convert times to DateTime objects for easier manipulation
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);

        // Check for overlapping bookings
        $checkSql = "SELECT * FROM booking WHERE Booking_Date = '$booking_date'";
        $result = $conn->query($checkSql);

        while ($row = $result->fetch_assoc()) {
            $bookedTimeRange = $row['Time'];
            list($bookedStartTime, $bookedEndTime) = explode('-', $bookedTimeRange);
            $bookedStart = new DateTime($bookedStartTime);
            $bookedEnd = new DateTime($bookedEndTime);

            // Check for any overlap
            if (($start >= $bookedStart && $start < $bookedEnd) || ($end > $bookedStart && $end <= $bookedEnd) || ($start <= $bookedStart && $end >= $bookedEnd)) {
                $_SESSION['error_message'] = "Selected time range is already booked. Please choose another time.";
                header("Location: booking.php");
                exit();
            }
        }

        // Insert the booking with start and end times as a single range
        $timeRange = $start_time . '-' . $end_time;
        $sql = "INSERT INTO booking (Username, Email, Phone, Booking_Date, Time) 
                VALUES ('$userName', '$userEmail', '$userPhone', '$booking_date', '$timeRange')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Booking successful! Redirecting...";
            header("Location: bookingtble.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Insertion failed: " . $conn->error;
            header("Location: booking.php");
            exit();
        }

        $conn->close();
    } else {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: booking.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="../css/booking.css">
</head>
<body>
    <?php include("../header&footer/header.php"); ?>
    <form action="booking.php" method="post" id="bookingForm">
        <div class="elem-group">
            <label for="name">Username</label>
            <input type="text" id="name" name="visitor_name" value="<?php echo htmlspecialchars($userName); ?>" disabled>
            <span class="error-message" id="name-error"></span>
        </div>

        <div class="elem-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="visitor_email" value="<?php echo htmlspecialchars($userEmail); ?>" disabled>
            <span class="error-message" id="email-error"></span>
        </div>

        <div class="elem-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="visitor_phone" value="<?php echo htmlspecialchars($userPhone); ?>" disabled>
            <span class="error-message" id="phone-error"></span>
        </div>

        <div class="elem-group">
            <label for="booking-date">Booking Date</label>
            <input type="date" id="booking-date" name="booking_date" value="<?php echo htmlspecialchars($selectedDate); ?>" min="<?php echo date('Y-m-d'); ?>">
            <span class="error-message" id="date-error">
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
                ?>
            </span>
        </div>

        <button type="submit" name="check_availability" id="check" class="submit">Check Availability</button>

        <?php if (!empty($availableTimes)): ?>
            <div class="elem-group">
                <label for="start-time">Start Time</label>
                <select name="start_time" id="start-time">
                    <option value="">Select a start time</option>
                    <?php foreach ($availableTimes as $time): ?>
                        <option value="<?php echo htmlspecialchars($time); ?>"><?php echo htmlspecialchars($time); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="error-message" id="start-time-error"></span>
            </div>

            <div class="elem-group">
                <label for="end-time">End Time</label>
                <select name="end_time" id="end-time">
                    <option value="">Select an end time</option>
                    <?php foreach ($availableTimes as $time): ?>
                        <option value="<?php echo htmlspecialchars($time); ?>"><?php echo htmlspecialchars($time); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="error-message" id="end-time-error"></span>
            </div>

            <button type="submit" name="submit" id="submit" class="submit">Submit</button>
        <?php endif; ?>
    </form>

    <?php include("../header&footer/footer.php"); ?>

    <script>
    document.getElementById("submit").addEventListener("click", function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    function validateForm() {
        resetErrorMessages();

        var date = document.getElementById("booking-date").value;
        var startTime = document.getElementById("start-time").value;
        var endTime = document.getElementById("end-time").value;

        var hasError = false;

        if (!date.trim()) {
            document.getElementById("date-error").textContent = "Booking date is required";
            hasError = true;
        }

        if (!startTime.trim()) {
            document.getElementById("start-time-error").textContent = "Start time is required";
            hasError = true;
        }

        if (!endTime.trim()) {
            document.getElementById("end-time-error").textContent = "End time is required";
            hasError = true;
        } else if (startTime >= endTime) {
            document.getElementById("end-time-error").textContent = "End time must be after start time";
            hasError = true;
        } 

        return !hasError;
    }

    function resetErrorMessages() {
        var errorElements = document.getElementsByClassName("error-message");
        for (var i = 0; i < errorElements.length; i++) {
            errorElements[i].textContent = "";
        }
    }

    window.addEventListener("load", function() {
        var bookingDateElem = document.getElementById("booking-date");
        var startTimeElem = document.getElementById("start-time");
        var endTimeElem = document.getElementById("end-time");

        bookingDateElem.addEventListener("change", function() {
            resetEndTimeOptions();
        });

        startTimeElem.addEventListener("change", function() {
            resetEndTimeOptions();
        });

        function resetEndTimeOptions() {
            var selectedStartTime = startTimeElem.value;
            var endOptions = endTimeElem.options;

            // Clear existing options
            endOptions.length = 0;
            endOptions[0] = new Option("Select an end time", "");

            // Calculate the minimum end time (45 minutes after the selected start time)
            if (selectedStartTime) {
                var minEndTime = new Date("1970-01-01T" + selectedStartTime + ":00Z");
                minEndTime.setMinutes(minEndTime.getMinutes() + 60);
                var minEndTimeString = minEndTime.toISOString().substr(11, 5);

                // Filter and add valid end times
                <?php foreach ($availableTimes as $time): ?>
                    if ("<?php echo $time; ?>" >= minEndTimeString) {
                        endOptions[endOptions.length] = new Option("<?php echo $time; ?>", "<?php echo $time; ?>");
                    }
                <?php endforeach; ?>
            }
        }
    });
</script>

</body>
</html>
make it so that the option shown are of only that are not in database for time            
