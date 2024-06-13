<?php
if (!session_id()) {
    session_start(); 
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
            background-color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            border-bottom: 2px black solid ;
            font: 'TourneyFont';
        }
        nav p {
            margin-left: 34px;
            font-size: 45px;
            font-weight: bold;
            font-family: 'tourney', 'Helvetica Neue', Helvetica, Arial;
            cursor: pointer;
            width: 304px;
            
        }
       
        .logo1 {
            width: 100px;
            height: auto;
        }
       
        menu {
            display: flex;
            align-items: center;
            margin-left: 260px;
            margin-top: 10px;
        }
        menu a {
            font-family:'merriweather';
            font-weight: 550;
           
            text-decoration: none;
            margin-left: 29px;
            font-size: 26px;
            margin-bottom: 2px;
        }
        menu i {
            font-weight: 400;
           
            font-size: 36px;
            cursor: pointer;
            margin-left: 50px;
            vertical-align: middle;
            margin-bottom: 2px;
        }
        menu a:hover {
            text-decoration: underline;
        }
       
        .dropdown {
            position: relative;
            display: inline-block;
        }

       
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding-right: 20px;
        }

       
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 20px;
        }

       
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

       
        .dropdown:hover .dropdown-content {
            display: block;
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
        
        <a href="../mainpage/index.php">Home</a>
        <a href="../mainpage/about.php">About-Us</a>
        <a href="../header&footer/reservation_redirect.php">Reservations</a>
        <a href="../mainpage/gallary.php">Gallery</a>
        <?php if (isset($_SESSION['username'])) { ?>
            <div class="dropdown">
                <a href="#" class="user-icon"><i class="fa-solid fa-user"></i></a>
                
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
