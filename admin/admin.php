<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Strike Admin Panel</title>
    <link rel="stylesheet" href="../admin.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .topnav {
            display: flex;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        .logo {
            width: 100px;
            margin-right: 20px;
        }
        .logo img {
            width: 100%;
        }
        .topnav-right h1 {
            font-size: 36px;
            margin: 0;
        }
        .lineh {
            width: 100%;
            height: 1px;
            background-color: #ddd;
        }
        .linev {
            border-left: 1px solid #ddd;
            height: 100vh;
            position: absolute;
            left: 172px;
            top: 0;
        }
        .lftcolumn {
            width: 172px;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 50px;
        }
        .lftcolumn h4 {
            font-size: 16px;
            margin: 0;
            padding: 10px 20px;
            cursor: pointer;
        }
        .lftcolumn h4:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="lineh"></div>
    <div class="linev"></div>
    <div class="topnav">
        <div class="logo">
            <img src="../img/login.png" alt="logo">
        </div>
        <div class="topnav-right">
            <h1>Elite Strike Admin Panel</h1>
        </div>
    </div>
    <div class="lftcolumn">
        <h4>Dashboard</h4>
        <h4>Customers</h4>
        <h4>Bookings</h4>
    </div>
</body>
</html>
