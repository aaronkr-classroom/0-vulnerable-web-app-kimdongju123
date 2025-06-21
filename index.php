<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vulnerable Web Application</title>
  <meta http-equiv="X-Frame-Options" content="DENY"> <!-- 클릭재킹 방지 -->
</head>

<body>
  <script>
    // 프레임 안에서 열렸을 경우 강제로 벗어남
    if (top !== window) {
      top.location = window.location;
    }
  </script>

  <center>
    <h1>WEB Application Security</h1>
    <h2>Secure WEB Application</h2>

    <h3>Registration Form</h3>
    <form action="register.php" method="POST">
      Username: <input type="text" name="username" required><br>
      Password: <input type="password" name="passwd" required><br>
      Email: <input type="email" name="email" required><br>
      Gender:
      <input type="radio" name="gender" value="male" required> Male
      <input type="radio" name="gender" value="female" required> Female
      <br><br>

      <!-- CSRF Token -->
      <?php
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
      ?>
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

      <input type="submit" name="register" value="Register">
    </form>

    <h3>Login Form</h3>
    <form action="login.php" method="POST">
      Username: <input type="text" name="username" required><br>
      Password: <input type="password" name="passwd" required><br>
      
      <!-- CSRF Token -->
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

      <input type="submit" name="login" value="Login">
    </form>

    <br>
    <a href="forgotpassword.html">Forgot Password</a>
  </center>
</body>
</html>
