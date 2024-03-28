<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="sign-up2.css">
    <script src="/form/sign-up/sign-up.js"></script>
</head>

<body>
    
    <div class="container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="form-container">
                <h1>Create new Account</h1>
                <h4>Already Registered? <a href="/form/log-in/login.html">Log in</a> here</h4>
                <form action="processsignup.php" method="POST" onsubmit="return validate()">
                    <div class="name">
                        <label for="fname">First Name</label><br>
                        <input type="text" placeholder="Enter your first name" id="fname" name="fname">
                        <span id="fnameError" class="error"></span>
                    </div>
                    <br><br>
                    <div class="name">
                        <label for="lname">Last Name</label><br>
                        <input type="text" placeholder="Enter your last name" id="lname" name="lname">
                        <span id="lnameError" class="error"></span>
                    </div>
                    <br><br>
                    <div class="user">
                        <label for="username">Username</label><br>
                        <input type="text" placeholder="Enter your username" id="username" name="username">
                        <span id="usernameError" class="error"></span>
                    </div>
                    <br><br>
                    <div class="mail">
                        <label for="email">Email</label><br>
                        <input type="email" placeholder="Enter your email" id="email" name="email">
                        <span id="emailError" class="error"></span>
                    </div>
                    <br><br>
                    <div class="pass">
                        <label>Password</label><br>
                        <input type="password" placeholder="Enter your password" id="pass" name="pass">
                        <span id="passwordError" class="error"></span>
                    </div>
                    <br><br>
                    <div class="conf-pass">
                        <label>Confirm Password</label><br>
                        <input type="password" placeholder="Confirm your password" id="cnfpass" name="cnfpass">
                        <span id="cnfpassError" class="error"></span>
                    </div>
                    <br><br>
                    <button class="log" type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
