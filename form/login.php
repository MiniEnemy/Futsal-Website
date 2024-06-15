<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/login2.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


  <script>
    // Function to validate the form
    function validateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      // Check if username and password are "owner"
      if (username.trim() === "owner" && password.trim() === "owner") {
        window.location.href = "../admin/admin.php"; 
        return false; 
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
      <button id="closeBtn" onclick="redirectToIndex()"><i class="fa-solid fa-xmark"></i></button>
        <h2>Login</h2>
        <h4>log in to continue</h4>
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
