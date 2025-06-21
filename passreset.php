<?php
include("config.php");
session_start();

// GET 파라미터 유효성 확인
if (!isset($_GET['token']) || !isset($_GET['user'])) {
    echo "<h2>Invalid request.</h2>";
    exit();
}

$token = $_GET['token'];
$user = $_GET['user'];

// 토큰으로 이메일 조회
$stmt = $db->prepare("SELECT email FROM reset WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    echo "<h2>Invalid reset link.</h2>";
    exit();
}

$checkmail = $row['email'];

// 이메일로 사용자 확인
$stmt = $db->prepare("SELECT username FROM register WHERE email = ?");
$stmt->bind_param("s", $checkmail);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc() || $row['username'] !== $user) {
    echo "<h2>Invalid reset link.</h2>";
    exit();
}

// 새 비밀번호 생성 및 해싱
$new_password_plain = bin2hex(random_bytes(4));  // 예: 8자리 랜덤
$new_password_hashed = password_hash($new_password_plain, PASSWORD_DEFAULT);

// 비밀번호 업데이트
$stmt = $db->prepare("UPDATE register SET password = ? WHERE username = ? AND email = ?");
$stmt->bind_param("sss", $new_password_hashed, $user, $checkmail);
if ($stmt->execute()) {
    // 토큰 삭제
    $del = $db->prepare("DELETE FROM reset WHERE token = ?");
    $del->bind_param("s", $token);
    $del->execute();

    // 실제 서비스에서는 메일로 새 비밀번호 발송
    echo "<h2>Your password has been reset. New password: " . htmlspecialchars($new_password_plain) . "</h2>";
} else {
    echo "<h2>Failed to reset password. Please try again.</h2>";
}
?>
