<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Strike Sign-Up</title>
    <link rel="stylesheet" href="/form/sign-up/sign-up.css">
    <script src="/form/sign-up/sign-up.js" defer></script>
</head>

<body>
    <div>
        <h1>Welcome to Elite Strike</h1>
        <form onsubmit="return validate()" action="processsignup.php" method="post">
            <div class="sign-up">
                <div class="fname">
                    <label for="fname">First name</label><br>
                    <input type="text" name="fname"   placeholder="Enter your First Name" id="fname">
                </div>
                <br><br>
                <div class="lname">
                    <label for="lname">Enter your Last name</label><br>
                    <input type="text" name="lname" placeholder="Enter your last name" id="lname">
                </div>
                <br><br>
                <div class="mail">
                    <label for="email">Enter your E-mail</label><br>
                    <input type="email" name="email" placeholder="Enter your Email" id="email" onblur="checkEmail()">
                    <span id="emailError" class="error"></span>
                </div>
                <br><br>
                <div class="pn">
                    <label for="no">Enter your phone number</label><br>
                    <input type="tel" name="no" placeholder="Enter your phone no." id="no">
                </div>
                <br><br>
                <div class="username">
                    <label for="user">Enter your username</label><br>
                    <input type="text" name="user" id="user" placeholder="Enter your username">
                </div>
                <br><br>
                <div class="pass">
                    <label for="pass">Enter your password</label><br>
                    <input type="password" name="pass" id="pass" onblur="checkPassword()" placeholder="Enter your password">
                    <span id="passwordError" class="error"></span>
                </div>
                <br><br>
                <button type="submit">Submit</button>
                <br><br>
                <div class="noacc">
                    <p>Already signed in? <a href="../log-in/login.html">Log-in</a> here</p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
