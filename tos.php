<?php
// 안전한 파일 목록 정의
$allowed = [
    "tos" => "tos.html",
    "privacy" => "privacy.html",
    "help" => "help.html"
];

// 사용자가 요청한 파일 키
$fileKey = $_GET['file'] ?? 'tos';  // 기본값 설정

// 화이트리스트 검증
if (array_key_exists($fileKey, $allowed)) {
    include($allowed[$fileKey]);
} else {
    echo "<h2>Invalid file access.</h2>";
    // 또는 404로 처리 가능
    // http_response_code(404);
}
?>
