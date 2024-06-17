<?php
session_start();
require_once "../common/dbconn.php";
require_once "../common/log.php";

// 댓글 데이터 필터
$filtered = array(
    'reply_user_id' => mysqli_real_escape_string($conn, $_POST['reply_user_id']),
    'board_id' => mysqli_real_escape_string($conn, $_POST['board_id']),
    'content' => mysqli_real_escape_string($conn, $_POST['content'])
);

// 댓글 등록
try{
    $sql = "insert into reply(reply_user_id, board_id, content, reply_created) 
            values('{$filtered['reply_user_id']}','{$filtered['board_id']}', '{$filtered['content']}', NOW())";
    // 댓글 등록 시도
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        throw new Exception('등록에 실패했습니다: ' . mysqli_error($conn));
    }

    // 등록 성공
    header("Location: ../board.php?id={$filtered['board_id']}");
} catch(Exception $e){
    // 등록 실패
    echo '등록 실패: ' . $e->getMessage();
    error_log($e->getMessage());
}
?>