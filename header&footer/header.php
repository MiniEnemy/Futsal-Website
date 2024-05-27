<?php
if (!session_id()) {
    session_start(); // Start the session if it's not already started
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking system</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&family=Tourney:ital,wght@1,900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&family=Tourney:wght@900&display=swap" rel="stylesheet">

    <style>
        /* Resetting default styles and setting global styles */
        * {
            border: 0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 22px;
            letter-spacing: 0px;
        }
        nav {
            background-color: white; /* Dark background color */
            padding: 10px 20px; /* Padding for the navigation bar */
            display: flex; /* Flex container to align items horizontally */
            align-items: center; /* Align items vertically in the center */
            border-bottom: 2px black solid ;
        }
        nav p {
            margin-left: 34px;
            font-size: 45px;
            font-weight: bold;
            font-family: 'tourney', 'Helvetica Neue', Helvetica, Arial;
            cursor: pointer;
            width: 304px;
        }
        /* Logo styles */
        .logo1 {
            width: 100px; /* Adjust width as needed */
            height: auto; /* Maintain aspect ratio */
        }
        /* Menu styles */
        menu {
            display: flex;
            align-items: center;
            margin-left: 260px;
            margin-top: 10px;
        }
        menu a {
            font-family:'merriweather';
            font-weight: 550;
            color: black;
            text-decoration: none;
            margin-left: 29px;
            font-size: 26px;
            margin-bottom: 2px;
        }
        menu i {
            font-weight: 400;
            color: black;
            font-size: 36px;
            cursor: pointer;
            margin-left: 50px;
            vertical-align: middle;
            margin-bottom: 2px;
        }
        menu a:hover {
            text-decoration: underline; /* Underline on hover */
        }
        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding-right: 20px;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 20px;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }
        p #lname{
            font: 'TourneyFont';
        }
        .log-img{
            margin-left: 43px;
            width: 57px;
        }
    </style>
</head>
<body>
<nav>
    <img src="../Logo/Futsal.png" alt="fusal logo" class="logo1">
    <p id="lname" >Elite Strike </p>
    <menu>
        <!-- Navigation bar ends here -->
        <a href="../mainpage/index.php">Home</a>
        <a href="../mainpage/about.php">About-Us</a>
        <a href="../header&footer/reservation_redirect.php">Reservations</a>
        <a href="../mainpage/gallary.php">Gallery</a>
        <?php if (isset($_SESSION['username'])) { ?>
            <div class="dropdown">
                <a href="#" class="user-icon"><i class="fa-solid fa-user"></i></a>
                <!-- Dropdown content -->
                <div class="dropdown-content">
                    <a href="../form/user.php"><?php echo $_SESSION['username']; ?></a>
                    <a href="../header&footer/logout.php">Logout</a>
                </div>
            </div>
        <?php } else { ?>
            <a href="../form/login.php"><img src="../img/login.png" class="log-img" alt=""></a>
        <?php } ?>
    </menu>
</nav>
</body>
</html>
