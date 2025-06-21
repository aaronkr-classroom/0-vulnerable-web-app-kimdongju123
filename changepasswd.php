<?php
include("config.php");
session_start();

// 클릭재킹 방지
header("X-Frame-Options: DENY");

// 세션 사용자 확인
if (!isset($_SESSION['login_user'])) {
    header("Location: /index.php");
    exit();
}

$session_user = $_SESSION['login_user'];

// POST 파라미터 유효성 검사
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    empty($_POST['username']) || empty($_POST['oldpasswd']) || empty($_POST['newpasswd']) || empty($_POST['csrf_token'])) {
    header("Location: /settings.php");
    exit();
}

$user = $_POST['username'];
$old = $_POST['oldpasswd'];
$new = $_POST['newpasswd'];
$csrf = $_POST['csrf_token'];

// CSRF 토큰 검증
if (!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $csrf) {
    echo "<h2>CSRF detected! Get out!</h2>";
    exit();
}

// 사용자 불일치 차단
if ($session_user !== $user) {
    echo "<h2>You are not authorized to change other user's passwords</h2>";
    exit();
}

// 데이터베이스에서 현재 비밀번호 해시 확인
$stmt = $db->prepare("SELECT password FROM register WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "<h2>User not found.</h2>";
    exit();
}

$stmt->bind_result($hashed_pw);
$stmt->fetch();

// 기존 비밀번호 검증
if (!password_verify($old, $hashed_pw)) {
    echo "<h2>Incorrect password.</h2>";
    exit();
}

// 새 비밀번호 해시
$new_hashed = password_hash($new, PASSWORD_DEFAULT);

// 비밀번호 업데이트
$update_stmt = $db->prepare("UPDATE register SET password = ? WHERE username = ?");
$update_stmt->bind_param("ss", $new_hashed, $user);
$update_stmt->execute();

if ($update_stmt->affected_rows > 0) {
    echo "<h2>Password updated successfully</h2>";
} else {
    echo "<h2>Password update failed. Try again later.</h2>";
}

$update_stmt->close();
$stmt->close();
$db->close();
?>

<html>
<body>
<br>
<a href="/settings.php"><h3>Go back</h3></a>
</body>
</html>
