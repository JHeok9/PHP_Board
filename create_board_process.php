<?php
session_start();
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 게시글 데이터 필터
$filtered = array(
    'title' => mysqli_real_escape_string($conn, $_POST['title']),
    'content' => mysqli_real_escape_string($conn, $_POST['content']),
    'write_user_id' => mysqli_real_escape_string($conn, $_POST['write_user_id'])
);

// 게시글 등록
try{
    $sql = "insert into board(title, content, board_created, write_user_id, views) 
            values('{$filtered['title']}','{$filtered['content']}', NOW(), '{$filtered['write_user_id']}', 0)";
    // 게시글 등록 시도
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        throw new Exception('등록에 실패했습니다: ' . mysqli_error($conn));
    }

    // 등록된 게시글의 ID 가져오기
    $board_id = mysqli_insert_id($conn);


    // 파일 업로드 처리
    if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == UPLOAD_ERR_OK) {
        $upload_dir = "boardFile/"; // 업로드 경로
        $max_file_size = 5 * 1024 * 1024; // 5MB

        // 업로드된 파일 정보 가져오기
        $file_name = $_FILES["upload_file"]["name"];
        $file_tmp_name = $_FILES["upload_file"]["tmp_name"];
        $file_size = $_FILES["upload_file"]["size"];

        // 파일 확장자 체크
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "txt"];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) { // 확장자 체크
            // 파일 크기 체크
            if ($file_size <= $max_file_size) {
                // 새로운 파일 이름을 생성합니다.
                $new_file_name = uniqid() . "." . $file_extension;
                $upload_path = $upload_dir . $new_file_name;

                // 파일을 이동시킵니다.
                if (move_uploaded_file($file_tmp_name, $upload_path)) {
                    // 파일 권한 설정
                    chmod($upload_path, 0777);

                    // 파일 정보 DB에 저장
                    $sql = "insert into board_file (uuid, board_id, file_name, file_created) 
                            values ('{$new_file_name}', {$board_id}, '{$file_name}', NOW())";
                    $result = mysqli_query($conn, $sql);
                    if ($result === false) {
                        throw new Exception('파일 정보 저장에 실패했습니다: ' . mysqli_error($conn));
                    }

                    // 트랜잭션 커밋
                    mysqli_commit($conn);

                    // 등록 성공
                    header("Location: home.php");
                    exit();
                } else {
                    throw new Exception("파일 업로드 실패.");
                }
            } else {
                throw new Exception("파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($max_file_size / (1024 * 1024)) . "MB입니다.");
            }
        } else {
            throw new Exception("지원하지 않는 파일 형식입니다. jpg, jpeg, png, gif 파일만 허용됩니다.");
        }
    }
    header("Location: home.php");
} catch(Exception $e){
     // 트랜잭션 롤백
     mysqli_rollback($conn);

    // 등록 실패
    echo '등록 실패: ' . $e->getMessage();
    error_log($e->getMessage());
}
?>