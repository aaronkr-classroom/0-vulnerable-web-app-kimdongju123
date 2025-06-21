<?php
// 보안 설정 로드 (.env 또는 설정 파일 포함)
require_once __DIR__ . '/config-ver.php';  // ✅ 공백과 세미콜론 위치 수정

// 데이터베이스 연결
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 연결 오류 처리
if (!$db) {
    // 서버 에러 로그에 기록 (사용자에게는 노출하지 않음)
    error_log("DB connection failed: " . mysqli_connect_error());

    // 사용자에게는 일반적인 메시지만 표시
    die("내부 서버 오류입니다. 잠시 후 다시 시도해 주세요.");
}
?>
