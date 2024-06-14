<?php
header("Access-Control-Allow-Origin: *"); // 외부 도메인 접근 허용
header('Content-Type: application/json'); // 응답 헤더를 JSON 형식으로 설정

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 반환할 게시글 상세정보 선언
$res = array();

if(isset($_GET['id'])){
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "select * from user where id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $res = array(
            'id' => htmlspecialchars($row['id']),
            'name' => htmlspecialchars($row['name']),
            'password' => htmlspecialchars($row['password']),
            'nickname' => htmlspecialchars($row['nickname']),
            'user_created' => htmlspecialchars($row['user_created'])
        );
    }
}

echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // JSON 응답 반환

?>