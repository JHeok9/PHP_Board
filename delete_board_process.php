<?php
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

settype($_POST['id'], 'integer');
$filtered_id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "delete from board where id = {$filtered_id}";
$result = mysqli_query($conn, $sql);

if($result === false){
    echo '삭제 에러';
    error_log(mysqli_error($conn));
} else {
    header("Location: home.php");
}

?>