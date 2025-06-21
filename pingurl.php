<?php
include("config.php");
session_start();

header("X-Frame-Options: DENY"); // 클릭재킹 방지

// 로그인 확인
if (!isset($_SESSION['login_user'])) {
    header("Location: /index.php");
    exit();
}

// 입력값 확인
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    empty($_POST['url']) || empty($_POST['csrf_token'])) {
    header("Location: /vulnerable/settings.php");
    exit();
}

$url = $_POST['url'];
$csrf = $_POST['csrf_token'];

// CSRF 검증
if (!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $csrf) {
    echo "<h2>CSRF detected... Get out of here!</h2>";
    exit();
}

// URL/IP 주소 유효성 검증 (ping 허용 기준)
if (!filter_var($url, FILTER_VALIDATE_IP) && !filter_var("http://$url", FILTER_VALIDATE_URL)) {
    echo "<h2>Invalid URL or IP address.</h2>";
    exit();
}

// ping 실행
$escaped = escapeshellarg($url); // ✅ 단일 인자 escape
echo "<h1>Result from Vulnerable server</h1>";
echo "<pre>" . shell_exec("ping -c 3 $escaped") . "</pre>";
?>
