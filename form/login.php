<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/login2.css">
  <script>
    // Function to validate the form
    function validateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      // Check if username and password are "owner"
      if (username.trim() === "owner" && password.trim() === "owner") {
        window.location.href = "../admin/admin.php"; // Redirect to admin.php
        return false; // Prevent default form submission
      }

      // Check if username is empty
      if (username.trim() === "") {
        alert("Please enter your username");
        return false;
      }

      // Check if password is empty
      if (password.trim() === "") {
        alert("Please enter your password");
        return false;
      }

      // Form is valid, proceed with default form submission
      return true;
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="left-side"></div>
    <div class="right-side">
      <div class="form-container">
        <h2>Login</h2>
        <h4>sign in to continue</h4>
        <form action="./processlogin.php" method="POST" onsubmit="return validateForm()">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username"><br><br>
          <label for="password">Password</label>
          <input type="password" id="password" name="password"><br><br>
          <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="sign-up.php">Sign up here</a></p>
      </div>
    </div>
  </div>
</body>

</html>
