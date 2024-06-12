<?php
$upload_dir = "boardFile/"; // 업로드 경로

// 파일명 검증 및 정리
if (!isset($_GET['uuid']) || !isset($_GET['file_name'])) {
    die("파일 정보가 제공되지 않았습니다.");
}

$file_uuid = basename($_GET['uuid']); // UUID의 경로 조작 방지
$file_name = basename($_GET['file_name']); // 원본 파일명

$file_path = $upload_dir . $file_uuid;

if (!file_exists($file_path)) {
    die("파일이 존재하지 않습니다.");
}

$file_size = filesize($file_path);
$file_info = pathinfo($file_path);

// 파일 확장자 확인 (필요시 확장자 목록에 추가)
$allowed_extensions = ["jpg", "jpeg", "png", "gif", "txt", "pdf", "zip"];
if (!in_array(strtolower($file_info['extension']), $allowed_extensions)) {
    die("허용되지 않는 파일 형식입니다.");
}

// 파일 다운로드
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $file_name . "\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $file_size);
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: public");
header("Expires: 0");

$fp = fopen($file_path, "rb");
if ($fp !== false) {
    while (!feof($fp)) {
        echo fread($fp, 8192); // 8KB씩 읽기
        flush(); // 출력을 강제
    }
    fclose($fp);
} else {
    die("파일을 열 수 없습니다.");
}
?>
