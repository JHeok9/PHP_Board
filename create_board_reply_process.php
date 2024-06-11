<?php
session_start();
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 댓글 데이터 필터
$filtered = array(
    'reply_content' => mysqli_real_escape_string($conn, $_POST['reply_content']),
    'board_id' => mysqli_real_escape_string($conn, $_POST['board_id']),
    'user_id' => mysqli_real_escape_string($conn, $_POST['user_id'])
);

// 게시글 등록
try{
    $sql = "insert into reply(reply_content, created, board_id, user_id) 
            values('{$filtered['reply_content']}', NOW(), '{$filtered['board_id']}', '{$filtered['user_id']}')";
    // 게시글 등록 시도
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        throw new Exception('등록에 실패했습니다: ' . mysqli_error($conn));
    }

    // 등록 성공
    header("Location: board.php?id={$filtered['board_id']}");
} catch(Exception $e){
    // 등록 실패
    echo '등록 실패: ' . $e->getMessage();
    error_log($e->getMessage());
}
?>