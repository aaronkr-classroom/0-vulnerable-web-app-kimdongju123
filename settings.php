<?php
include("config.php");
session_start();

// 클릭재킹 방지
header("X-Frame-Options: DENY");

// 로그인 확인
if (!isset($_SESSION['login_user'])) {
    header("Location: /index.php");
    exit();
}

// CSRF 토큰 생성
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$check = $_SESSION['login_user'];

// 사용자 정보 조회
$stmt = $db->prepare("SELECT username, email, gender FROM register WHERE username = ?");
$stmt->bind_param("s", $check);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    echo "<h2>User not found.</h2>";
    exit();
}

$a = $row['username'];
$email = htmlspecialchars($row['email']);
$gender = strtolower($row['gender']);

$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Settings</title>
  <meta http-equiv="X-Frame-Options" content="DENY">
</head>
<body>
  <h1>Welcome <?php echo htmlspecialchars($a); ?></h1>

  <center>
    <h2>Profile Setting</h2>
    <form action="Profileupdate.php" method="POST">
      Username: <input type="text" name="username" disabled value="<?php echo htmlspecialchars($a); ?>"><br>
      Email: <input type="email" name="email" value="<?php echo $email; ?>" required><br>
      Gender:
      <input type="radio" name="gender" value="male" <?php if ($gender === 'male') echo 'checked'; ?>> Male
      <input type="radio" name="gender" value="female" <?php if ($gender === 'female') echo 'checked'; ?>> Female<br>

      <!-- CSRF Token -->
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf']; ?>"><br>
      <input type="submit" name="update" value="Update">
    </form>

    <br><h2>Change Password</h2>
    <form action="changepasswd.php" method="POST">
      Old Password: <input type="password" name="oldpasswd" required><br>
      New Password: <input type="password" name="newpasswd" required><br>
      <input type="hidden" name="username" value="<?php echo htmlspecialchars($a); ?>">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf']; ?>"><br>
      <input type="submit" value="Change Password">
    </form>

    <br><h2>Delete Account</h2>
    <form action="deleteaccount.php" method="POST">
      Password: <input type="password" name="oldpasswd" required><br>
      <input type="hidden" name="username" value="<?php echo htmlspecialchars($a); ?>">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf']; ?>"><br>
      <input type="submit" value="Delete Account">
    </form>

    <br><h2>Ping Website</h2>
    <form action="pingurl.php" method="POST">
      Enter URL or IP: <input type="text" name="url" required><br>
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf']; ?>"><br>
      <input type="submit" value="Ping">
    </form>

    <br><h2>Terms of Service</h2>
    <a href="tos.php?file=service">Click here</a>

    <br><br><br>
    <a href="logout.php">Logout</a>
  </center>
</body>
</html>
