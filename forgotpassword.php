<!DOCTYPE html>
<html>
  <head> 
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- 클릭재킹 방지 -->
    <meta http-equiv="X-Frame-Options" content="DENY">
  </head>
  <body>
    <center>
      <h1>Enter your email</h1>

      <?php
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // ✅ 올바른 함수
        }
      ?>

      <form action="sendmail/index.php" method="POST">
        <input type="email" name="email" placeholder="your@email.com" required><br><br>

        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <input type="submit" value="Submit">
      </form>
    </center>
  </body>
</html>
