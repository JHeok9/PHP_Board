<?php
session_start();
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 게시글 데이터 필터
$filtered = array(
    'title' => mysqli_real_escape_string($conn, $_POST['title']),
    'content' => mysqli_real_escape_string($conn, $_POST['content']),
    'create_user_id' => mysqli_real_escape_string($conn, $_POST['create_user_id'])
);

// 게시글 등록
try{
    $sql = "insert into board(title, content, created, create_user_id) 
            values('{$filtered['title']}','{$filtered['content']}', NOW(), '{$filtered['create_user_id']}')";
    // 게시글 등록 시도
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        throw new Exception('등록에 실패했습니다: ' . mysqli_error($conn));
    }

    // 등록 성공
    header("Location: home.php");
} catch(Exception $e){
    // 등록 실패
    echo '등록 실패: ' . $e->getMessage();
    error_log($e->getMessage());
}
?>