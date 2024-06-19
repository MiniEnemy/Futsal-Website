<!DOCTYPE html>
<html>
<head>
    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"
            integrity="sha512-DUC8yqWf7ez3JD1jszxCWSVB0DMP78eOyBpMa5aJki1bIRARykviOuImIczkxlj1KhVSyS16w2FSQetkD4UU2w=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <!-- Bootstrap CSS CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          rel="stylesheet"/>
    <!-- Bootstrap JS CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Moment.js CDN -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js">
    </script>

    <!-- Bootstrap Datetimepicker CSS CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet"/>
    <!-- Bootstrap datetimepicker JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Basic internal styling -->
    <style>
        body {
            text-align: center;
        }

        p {
            font-size: 25px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="color:green; font-weight:bold">
        GeeksforGeeks
    </h1>
    <p>jQuery - Set datetimepicker on textbox click</p>
    <div class="container col-xs-4 col-xs-offset-4">
        <div style="position:relative">
            <form id="bookingForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="start-time">Start Time:</label>
                    <input class="form-control"
                           type="text"
                           id="start-time"
                           name="startTime" />
                </div>
                <div class="form-group">
                    <label for="end-time">End Time:</label>
                    <input class="form-control"
                           type="text"
                           id="end-time"
                           name="endTime" />
                </div>
                <button type="submit" class="btn btn-primary">Book Now</button>
            </form>
        </div>
    </div>

    <?php
    // PHP script to handle form submission and store in database

    // Function to fetch booked datetimes from database
    function getBookedTimes() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=booking', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SELECT booking_datetime FROM bookings");
            $bookedTimes = $stmt->fetchAll(PDO::FETCH_COLUMN);

            return $bookedTimes;
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
            return array(); // Return empty array on error
        }
    }

    // Get booked times from database
    $bookedTimes = getBookedTimes();
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            var bookedTimes = <?php echo json_encode($bookedTimes); ?>;

            // Initialize datetime picker for start time
            $('#start-time').datetimepicker({
                format: 'YYYY-MM-DD HH:mm', // Format for date and time
                stepping: 15, // Interval between times (e.g., 15 minutes)
                minDate: moment(), // Start from current moment
                useCurrent: false
            });

            // Initialize datetime picker for end time
            $('#end-time').datetimepicker({
                format: 'YYYY-MM-DD HH:mm', // Format for date and time
                stepping: 15, // Interval between times (e.g., 15 minutes)
                minDate: moment(), // Start from current moment
                useCurrent: false
            });

            // Disable booked times
            function disableBookedTimes(picker) {
                picker.on('dp.show', function () {
                    var datesToDisable = [];
                    for (var i = 0; i < bookedTimes.length; i++) {
                        datesToDisable.push(moment(bookedTimes[i], 'YYYY-MM-DD HH:mm'));
                    }
                    picker.data("DateTimePicker").disabledDates(datesToDisable);
                });
            }

            disableBookedTimes($('#start-time'));
            disableBookedTimes($('#end-time'));

            // Update end time based on start time selection
            $('#start-time').on('dp.change', function (e) {
                $('#end-time').data('DateTimePicker').minDate(e.date); // Set minDate for end time picker
            });

            $('#bookingForm').submit(function (event) {
                var startTime = $('#start-time').val();
                var endTime = $('#end-time').val();

                if (!startTime || !endTime) {
                    alert('Please select both start and end times');
                    event.preventDefault();
                } else if (moment(startTime, 'YYYY-MM-DD HH:mm').isSameOrAfter(moment(endTime, 'YYYY-MM-DD HH:mm'))) {
                    alert('End time must be after start time');
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
