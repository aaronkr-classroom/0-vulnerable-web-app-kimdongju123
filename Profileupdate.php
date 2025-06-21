<?php
include("config.php");
session_start();

header("X-Frame-Options: DENY"); // 클릭재킹 방지

// 세션 확인
if (!isset($_SESSION['login_user'])) {
    header("Location: /index.php");
    exit();
}

// POST 방식 확인
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /settings.php");
    exit();
}

$user = $_SESSION['login_user'];
$em = $_POST['email'];
$gen = $_POST['gender'];
$csrf = $_POST['csrf_token'];

// 입력값 유효성 검증
if (empty($em) || empty($gen)) {
    header("Location: /settings.php");
    exit();
}

if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
    echo "<h2>Invalid email format.</h2>";
    exit();
}

$allowed_genders = ['male', 'female'];
if (!in_array(strtolower($gen), $allowed_genders)) {
    echo "<h2>Invalid gender value.</h2>";
    exit();
}

// CSRF 검증
if (!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $csrf) {
    echo "<h2>CSRF detected... Get out of here!</h2>";
    exit();
}

// DB 업데이트
$stmt = $db->prepare("UPDATE register SET email = ?, gender = ? WHERE username = ?");
$stmt->bind_param("sss", $em, $gen, $user);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<h2>Account updated successfully</h2>";
} else {
    echo "<h2>No modification done to profile</h2>";
}

$stmt->close();
$db->close();
?>

<html>
<body>
<br>
<a href="/settings.php"><h3>Go back</h3></a>
</body>
</html>
