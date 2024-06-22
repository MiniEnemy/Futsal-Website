<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/login2.css">
  <!-- Include Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <script>
    function validateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      if (username.trim() === "") {
        alert("Please enter your username");
        return false;
      }

      if (password.trim() === "") {
        alert("Please enter your password");
        return false;
      }

      return true;
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="left-side"></div>
    <div class="right-side">
      <div class="form-container">
        <button id="closeBtn" onclick="redirectToIndex()"><i class="fas fa-times"></i></button>
        <h2>Login</h2>
        <h4>Log in to continue</h4>
        
        <!-- Display error message if it exists -->
        <?php
        session_start();
        if (isset($_SESSION['error_message'])) {
          echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
          unset($_SESSION['error_message']); // Clear the error message after displaying
        }
        ?>
        
        <form action="processlogin.php" method="POST" onsubmit="return validateForm()">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username"><br><br>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password"><br><br>
          <button type="submit">Login</button>
        </form>
        
        <p>Don't have an account? <a href="sign-up.php">Sign up here</a></p>
      </div>
    </div>
  </div>

  <script>
    function redirectToIndex() {
      window.location.href = "../mainpage/index.php";
    }
  </script>

</body>
</html>
