<?php
session_start();

$userEmail = $_SESSION['userEmail'] ?? "";
$userPhone = $_SESSION['userPhone'] ?? "";
$userName = $_SESSION['username'] ?? "";
$availableStartTimes = [];
$availableEndTimes = [];
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

        // Filter out times that are already booked for start times
        $availableStartTimes = filterAvailableStartTimes($allTimes, $bookedTimes);
        // For end times, consider all times (only filtering based on selected start time later)
        $availableEndTimes = $allTimes;

        $conn->close();

        // If no available start times, set an error message
        if (empty($availableStartTimes)) {
            $_SESSION['error_message'] = "All time slots are fulfilled. Please choose another date.";
        }
    }
}

function filterAvailableStartTimes($allTimes, $bookedTimes)
{
    $availableTimes = [];

    foreach ($allTimes as $time) {
        $isAvailable = true;
        $currentTime = new DateTime($time);

        foreach ($bookedTimes as $bookedTime) {
            list($bookedStartTime, $bookedEndTime) = explode('-', $bookedTime);
            $start = new DateTime($bookedStartTime);
            $end = new DateTime($bookedEndTime);

            if ($currentTime >= $start && $currentTime < $end) {
                $isAvailable = false;
                break;
            }
        }

        if ($isAvailable) {
            $availableTimes[] = $time;
        }
    }

    return $availableTimes;
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

        $start = new DateTime($start_time);
        $end = new DateTime($end_time);

        $checkSql = "SELECT * FROM booking WHERE Booking_Date = '$booking_date'";
        $result = $conn->query($checkSql);

        while ($row = $result->fetch_assoc()) {
            $bookedTimeRange = $row['Time'];
            list($bookedStartTime, $bookedEndTime) = explode('-', $bookedTimeRange);
            $bookedStart = new DateTime($bookedStartTime);
            $bookedEnd = new DateTime($bookedEndTime);

            if (($start >= $bookedStart && $start < $bookedEnd) || ($end > $bookedStart && $end < $bookedEnd) || ($start <= $bookedStart && $end >= $bookedEnd)) {
                $_SESSION['error_message'] = "Selected time range is already booked. Please choose another time.";
                header("Location: booking.php");
                exit();
            }
        }

        $timeRange = $start_time . '-' . $end_time;
        $sql = "INSERT INTO booking (Username, Email, Phone, Booking_Date, Time) VALUES ('$userName', '$userEmail', '$userPhone', '$booking_date', '$timeRange')";

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
    <?php include ("../header&footer/header.php"); ?>
    <form action="booking.php" method="post" id="bookingForm">
        <div class="elem-group">
            <label for="name">Username</label>
            <input type="text" id="name" name="visitor_name" value="<?php echo htmlspecialchars($userName); ?>"
                disabled>
            <span class="error-message" id="name-error"></span>
        </div>

        <div class="elem-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="visitor_email" value="<?php echo htmlspecialchars($userEmail); ?>"
                disabled>
            <span class="error-message" id="email-error"></span>
        </div>

        <div class="elem-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="visitor_phone" value="<?php echo htmlspecialchars($userPhone); ?>"
                disabled>
            <span class="error-message" id="phone-error"></span>
        </div>

        <div class="elem-group">
            <label for="booking-date">Booking Date</label>
            <input type="date" id="booking-date" name="booking_date"
                value="<?php echo htmlspecialchars($selectedDate); ?>" min="<?php echo date('Y-m-d'); ?>">
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

        <?php if (!empty($availableStartTimes)): ?>
            <div class="elem-group">
                <label for="start-time">Start Time</label>
                <select name="start_time" id="start-time">
                    <option value="">Select a start time</option>
                    <?php foreach ($availableStartTimes as $time): ?>
                        <option value="<?php echo htmlspecialchars($time); ?>"><?php echo htmlspecialchars($time); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="error-message" id="start-time-error"></span>
            </div>

            <div class="elem-group" id="end-time-group" style="display: none;">
                <label for="end-time">End Time</label>
                <select name="end_time" id="end-time">
                    <option value="">Select an end time</option>
                </select>
                <span class="error-message" id="end-time-error"></span>
            </div>

            <button type="submit" name="submit" id="submit" class="submit">Submit</button>
        <?php endif; ?>
    </form>

    <?php include ("../header&footer/footer.php"); ?>

    <script>
        document.getElementById("submit").addEventListener("click", function (event) {
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

        window.addEventListener("load", function () {
            var startTimeElem = document.getElementById("start-time");
            var endTimeElem = document.getElementById("end-time");
            var endTimeGroupElem = document.getElementById("end-time-group");

            startTimeElem.addEventListener("change", function () {
                var selectedStartTime = this.value;
                if (selectedStartTime) {
                    endTimeGroupElem.style.display = "block";
                    populateEndTimes(selectedStartTime);
                } else {
                    endTimeGroupElem.style.display = "none";
                }
            });

            function populateEndTimes(selectedStartTime) {
                // Clear previous end time options
                endTimeElem.innerHTML = '<option value="">Select an end time</option>';

                if (!selectedStartTime) return;

                var availableEndTimes = <?php echo json_encode($availableEndTimes); ?>;
                var bookedTimes = <?php echo json_encode($bookedTimes); ?>;

                // Find the index of the selected start time
                var startTimeIndex = availableEndTimes.indexOf(selectedStartTime);

                // Loop through available times starting from the index of selected start time
                for (var i = startTimeIndex + 1; i < availableEndTimes.length; i++) {
                    var endTime = availableEndTimes[i];
                    var endTimeIsValid = true;

                    // Check if end time is at least one hour after the selected start time
                    var startDateTime = new Date("2000-01-01 " + selectedStartTime);
                    var endDateTime = new Date("2000-01-01 " + endTime);
                    var diffInMinutes = (endDateTime - startDateTime) / (1000 * 60);

                    if (diffInMinutes < 60) {
                        continue; // Skip times less than one hour after start time
                    }

                    // Check if endTime is before or between booked times
                    for (var j = 0; j < bookedTimes.length; j++) {
                        var bookedTime = bookedTimes[j];
                        var [bookedStartTime, bookedEndTime] = bookedTime.split('-');

                        if (selectedStartTime < bookedStartTime && endTime > bookedStartTime) {
                            endTimeIsValid = false;
                            break;
                        }

                        if (endTime > bookedStartTime && endTime < bookedEndTime) {
                            endTimeIsValid = false;
                            break;
                        }
                    }

                    if (endTimeIsValid) {
                        var option = document.createElement("option");
                        option.value = endTime;
                        option.textContent = endTime;
                        endTimeElem.appendChild(option);
                    }
                }
            }

            // Populate the end time dropdown on page load if a start time is already selected
            if (startTimeElem.value) {
                endTimeGroupElem.style.display = "block";
                populateEndTimes(startTimeElem.value);
            }
        });
    </script>
</body>

</html>


