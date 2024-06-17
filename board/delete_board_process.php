<?php
session_start();
require_once "../common/dbconn.php";
require_once "../common/log.php";

$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "delete from board where id = {$filtered_id}";
$result = mysqli_query($conn, $sql);

// 로그
create_board_log("글삭제", $filtered_id, $_SESSION['user_id']);

if($result === false){
    echo '삭제 에러';
    error_log(mysqli_error($conn));
} else {
    header("Location: ../home.php");
}

?>