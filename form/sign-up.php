<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="/form/sign-up/sign-up.js"></script>
    <script>
        function validateform() {
            var returnval = true;

            // Get the input values
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var password = document.getElementById("pass").value;
            var cnfpass = document.getElementById("cnfpass").value;

            // Get the error span elements
            var usernameError = document.getElementById("usernameError");
            var emailError = document.getElementById("emailError");
            var phoneError = document.getElementById("phone-error");
            var passwordError = document.getElementById("passwordError");
            var cnfpassError = document.getElementById("cnfpassError");

            // Clear previous error messages
            usernameError.textContent = "";
            emailError.textContent = "";
            phoneError.textContent = "";
            passwordError.textContent = "";
            cnfpassError.textContent = "";

            // Validate username
            if (username.trim() === "") {
                usernameError.textContent = "Username is required";
                returnval = false;
            }

            // Validate email
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (email.trim() === "") {
                emailError.textContent = "Email is required";
                returnval = false;
            } else if (!emailPattern.test(email)) {
                emailError.textContent = "Invalid email format";
                returnval = false;
            }

            // Validate phone
            var phonePattern = /^\d{10}$/; 
            if (phone.trim() === "") {
                phoneError.textContent = "Phone number is required";
                returnval = false;
            } else if (!phonePattern.test(phone)) {
                phoneError.textContent = "Invalid phone number or give 10 digit phone number";
                returnval = false;
            }

            // Validate password
            if (password.trim() === "") {
                passwordError.textContent = "Password is required";
                returnval = false;
            }

            // Validate confirm password
            if (cnfpass.trim() === "") {
                cnfpassError.textContent = "Confirm password is required";
                returnval = false;
            } else if (password !== cnfpass) {
                cnfpassError.textContent = "Passwords do not match";
                returnval = false;
            }

            return returnval;
        }
    </script>
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container {
    background-color: #a7233a;
    display: flex;
    height: 133vh;
}

.left-side {
    flex: 1;
    background-image: url(../allpics/log.png);
    background-size: cover;
    background-position: center bottom 2%;
    box-shadow: 0 0 90px black;
    background-size: 220%;

    height: 133vh;
}

.right-side {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.form-container {
    max-width: 400px;
    width: 100%;
    background-color: #a7233a;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-container h1,
.form-container h4 {
    color: white;
    text-align: center;
    margin-bottom: 20px;
}

.form-container label {
    color: white;
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    margin-left: 20px;
}

.form-container input {
    width: calc(100% - 40px);
    margin-bottom: 10px;
    padding: 10px;
    box-sizing: border-box;
    background-color: black;
    color: white;
    margin-left: 20px;
}

.form-container .user label,
.form-container .no label,
.form-container .mail label,
.form-container .pass label,
.form-container .conf-pass label {
    margin-left: 20px;
}

.form-container button {
    width: calc(100% - 40px);
    margin-top: 20px;
    padding: 10px;
    background-color: white;
    color: black;
    border: none;
    cursor: pointer;
    font-weight: bold;
    margin-left: 20px;
}

.form-container p {
    margin-top: 15px;
    text-align: center;
}

.form-container p a {
    color: black;
    text-decoration: none;
}

</style>
<body>
    <form action="/processsignup.php" onsubmit=" return validateform()" method="post">

        <div class="container">
            <div class="left-side"></div>
        <div class="right-side">
            <div class="form-container">
                <h1>Create new Account</h1>
            <h4>Already Registered? <a href="login.php">Log in</a> here</h4>
        <form action="processsignup.php" method="POST" onsubmit="return validate()">
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
            <div class="phone">
                <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your number"> 
        <span class="error-message" id="phone-error"></span>
    </div>
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
</form>
</body>

</html>
