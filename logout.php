<?php
include("config.php");
session_start();

header("X-Frame-Options: DENY"); // 클릭재킹 방지

// 세션 완전 파기
$_SESSION = []; // 모든 세션 변수 제거
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy(); // ✅ 정확한 함수 이름

// 리디렉션
header("Location: /index.html");
exit();
?>
