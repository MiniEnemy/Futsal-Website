<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      /* Resetting default styles and setting global styles */

/* Styling for the navigation bar */
* {
    border: 0;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    font-size: 22px;
    letter-spacing: 2px;
}
nav {
    background-color: white; /* Dark background color */
    padding: 10px 20px; /* Padding for the navigation bar */
    display: flex; /* Flex container to align items horizontally */
    align-items: center;
     /* Align items vertically in the center */
     border-bottom: 2px black solid ;
    
}

nav p {
    margin-left: 34px;
    font-size: 45px;
    font-weight: bold;
    font-family: 'Times New Roman', Times, serif;
    cursor: pointer;
    width: 252px;
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
    margin-left: 280px;
    margin-top: 10px;
}

menu a {
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

    </style>
</head>
<body>
<nav>
    <img src="../Logo/Futsal.png" alt="fusal logo" class="logo1">
    <p>Elite Strike </p>
    <menu>
      <!-- Navigation bar ends here -->
      <a href="index.php">Home</a>
      <a href="about.php">About-Us</a>
      <a href="booking.php">Reservations</a>
      <a href="">Gallery</a>
      <i class="fa-solid fa-right-to-bracket" onclick="alert('hello nigs')"></i>

    </menu>
  </nav>
</body>
</html>