<?php
header('Content-Type: application/json'); // 응답 헤더를 JSON 형식으로 설정

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 반환할 게시글 상세정보 선언
$board = array();

if(isset($_GET['id'])){
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "select b.*, u.nickname from board b left join user u on b.write_user_id = u.id where b.id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $board = array(
            'id' => htmlspecialchars($row['id']),
            'title' => htmlspecialchars($row['title']),
            'content' => htmlspecialchars($row['content']),
            'board_created' => htmlspecialchars($row['board_created']),
            'views' => htmlspecialchars($row['views']),
            'write_user_id' => htmlspecialchars($row['write_user_id']),
            'nickname' => htmlspecialchars($row['nickname'])
        );
    }
}

echo json_encode($board, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // JSON 응답 반환

?>