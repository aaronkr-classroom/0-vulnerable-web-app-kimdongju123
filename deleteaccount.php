<?php
require_once("config.php");
session_start();

// 클릭재킹 방지
header("X-Frame-Options: DENY");

// 세션 로그인 확인
if (!isset($_SESSION['login_user'])) {
    header("Location: /index.php");
    exit();
}

$check = $_SESSION['login_user'];

// POST 값 체크
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    empty($_POST['username']) || empty($_POST['oldpasswd']) || empty($_POST['csrf_token'])) {
    header("Location: /settings.php");
    exit();
}

$user = $_POST['username'];
$old = $_POST['oldpasswd'];
$csrf = $_POST['csrf_token'];

// CSRF 검증
if (!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $csrf) {
    echo "<h2>CSRF detected... Get out of here!</h2>";
    exit();
}

// 사용자 일치 확인
if ($check !== $user) {
    echo "<h2>You are not authorized</h2>";
    exit();
}

// DB에서 사용자 확인 및 비밀번호 검증
$stmt = $db->prepare("SELECT password FROM register WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "<h2>User not found</h2>";
    exit();
}

$stmt->bind_result($hashed_pw);
$stmt->fetch();

if (!password_verify($old, $hashed_pw)) {
    echo "<h2>Incorrect password</h2>";
    exit();
}

// 사용자 삭제
$delete_stmt = $db->prepare("DELETE FROM register WHERE username = ?");
$delete_stmt->bind_param("s", $user);
$delete_stmt->execute();

if ($delete_stmt->affected_rows > 0) {
    session_destroy();
    echo "<h2>Account deleted successfully</h2>";
} else {
    echo "<h2>Deletion failed. Please try again later.</h2>";
}

$delete_stmt->close();
$stmt->close();
$db->close();
?>

<html>
<body>
<br>
<a href="/index.html"><h3>Login page</h3></a>
</body>
</html>
