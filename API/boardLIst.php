<?php
header("Access-Control-Allow-Origin: *"); // 외부 도메인 접근 허용
header('Content-Type: application/json'); // 응답 헤더를 JSON 형식으로 설정

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");
$sql = "select b.*, u.nickname from board b left join user u on b.write_user_id = u.id";

$result = mysqli_query($conn, $sql);

// 넘겨줄 게시글 리스트 선언
$board_list = array();

while($row = mysqli_fetch_assoc($result)){
    $board = array(
        'id' => htmlspecialchars($row['id']),
        'title' => htmlspecialchars($row['title']),
        'board_created' => htmlspecialchars($row['board_created']),
        'views' => htmlspecialchars($row['views']),
        'nickname' => htmlspecialchars($row['nickname'])
    );
    $board_list[] = $board; // 리스트에 게시글 추가
}

echo json_encode($board_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // JSON 응답 반환

?>