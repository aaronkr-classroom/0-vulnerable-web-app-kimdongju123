<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Register Page</title>
  <meta http-equiv="X-Frame-Options" content="DENY">
</head>
<body>

<?php
include("config.php");
session_start(); // CSRF 토큰을 사용하는 경우 필요

// POST 파라미터 확인
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    empty($_POST['username']) || empty($_POST['passwd']) ||
    empty($_POST['email']) || empty($_POST['gender'])) {
    echo "<h2>Invalid form submission.</h2>";
    exit();
}

$a = $_POST['username'];
$b = password_hash($_POST['passwd'], PASSWORD_DEFAULT); // 비밀번호 해싱
$c = $_POST['email'];
$d = $_POST['gender'];

// 입력값 유효성 검증 (기본 예시)
if (!filter_var($c, FILTER_VALIDATE_EMAIL)) {
    echo "<h2>Invalid email format.</h2>";
    exit();
}
$allowed_genders = ['male', 'female'];
if (!in_array(strtolower($d), $allowed_genders)) {
    echo "<h2>Invalid gender.</h2>";
    exit();
}

// Prepared Statement 사용 (컬럼 지정이 안전)
$stmt = $db->prepare("INSERT INTO register (username, password, email, gender) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $a, $b, $c, $d);

// 실행
if ($stmt->execute()) {
    echo "<h2>Successfully registered as " . htmlspecialchars($a) . "</h2><br />";
} else {
    echo "<h2>Username is taken or registration error.</h2>";
}

$stmt->close();
$db->close();
?>

<br>
<a href="/index.php">Go back</a>

</body>
</html>
