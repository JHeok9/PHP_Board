<?php
require_once "../common/dbconn.php";

// 회원가입 데이터 필터
$filtered = array(
    'name' => mysqli_real_escape_string($conn, $_POST['name']),
    'password' => mysqli_real_escape_string($conn, $_POST['password']),
    'nickname' => mysqli_real_escape_string($conn, $_POST['nickname'])
);

// 회원가입
try{
    $sql = "insert into user(name, password, nickname, user_created) 
            values('{$filtered['name']}','{$filtered['password']}','{$filtered['nickname']}', NOW())";
    // 회원가입 시도
    $result = mysqli_query($conn, $sql);
    
    if ($result === false) {
        throw new Exception('회원가입에 실패했습니다: ' . mysqli_error($conn));
    }

    // 회원가입 성공
    echo '회원가입 성공 <a href="../index.php">돌아가기</a>';
} catch(Exception $e){
    // 회원가입 실패
    echo '회원가입 실패: ' . $e->getMessage();
    error_log($e->getMessage());
}

?>