<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="sign-up2.css">
    <script src="/form/sign-up/sign-up.js"></script>
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
    background-image: url(../../allpics/log.png);
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
    margin-left: 20px; /* Adjusted margin for better alignment */
}

.form-container input {
    width: calc(100% - 40px); /* Adjusted input width */
    margin-bottom: 10px;
    padding: 10px;
    box-sizing: border-box;
    background-color: black;
    color: white;
    margin-left: 20px; /* Adjusted margin for better alignment */
}

.form-container .user label,
.form-container .no label,
.form-container .mail label,
.form-container .pass label,
.form-container .conf-pass label { /* Added class for confirm password label */
    margin-left: 20px; /* Adjusted margin for better alignment */
}

.form-container button {
    width: calc(100% - 40px); /* Adjusted button width */
    margin-top: 20px; /* Adjusted margin for better spacing */
    padding: 10px;
    background-color: white;
    color: black;
    border: none;
    cursor: pointer;
    font-weight: bold;
    margin-left: 20px; /* Adjusted margin for better alignment */
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
    
    <div class="container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="form-container">
                <h1>Create new Account</h1>
                <h4>Already Registered? <a href="../form/log-in/login.php">Log in</a> here</h4>
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
</body>

</html>
