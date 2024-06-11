<?php
session_start();
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 게시글 데이터 필터
$filtered = array(
    'id' => mysqli_real_escape_string($conn, $_POST['id']),
    'title' => mysqli_real_escape_string($conn, $_POST['title']),
    'content' => mysqli_real_escape_string($conn, $_POST['content']),
);

// 게시글 수정
try{
    $sql = "update board set title = '{$filtered['title']}', content = '{$filtered['content']}' where id = {$filtered['id']}";
    // 게시글 수정 시도
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        throw new Exception('수정에 실패했습니다: ' . mysqli_error($conn));
    }

    // 수정 성공
    header("Location: board.php?id={$filtered['id']}");
} catch(Exception $e){
    // 등록 실패
    echo '등록 실패: ' . $e->getMessage();
    error_log($e->getMessage());
}
?>