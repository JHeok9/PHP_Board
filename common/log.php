<?php
require "dbconn.php";

// 접속 로그
function access(){
    global $conn;
    // 접속 정보 수집
    $access_ip = $_SERVER['REMOTE_ADDR'];
    $access_browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
    $access_route = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct';

    // 운영체제 정보 추출 (간단한 방법)
    $os_array = [
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    ];

    $access_os = 'Unknown';
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $access_browser)) {
            $access_os = $value;
            break;
        }
    }

    // 데이터 필터링
    $filtered = array(
        'access_ip' => mysqli_real_escape_string($conn, $access_ip),
        'access_browser' => mysqli_real_escape_string($conn, $access_browser),
        'access_os' => mysqli_real_escape_string($conn, $access_os),
        'access_route' => mysqli_real_escape_string($conn, $access_route)
    );

    // 접속 로그 DB에 저장
    try {
        $sql = "INSERT INTO access_log (access_ip, access_time, access_browser, access_os, access_route) 
                VALUES ('{$filtered['access_ip']}', NOW(), '{$filtered['access_browser']}', '{$filtered['access_os']}', '{$filtered['access_route']}')";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            throw new Exception('접속 로그 저장에 실패했습니다: ' . mysqli_error($conn));
        }
    } catch(Exception $e) {
        echo '오류: ' . $e->getMessage();
        error_log($e->getMessage());
    }
    // DB 연결 종료
    mysqli_close($conn);
}

// 로그인 로그
function login_log($id){
    global $conn;

    $login_id = $id;
    $login_ip = $_SERVER['REMOTE_ADDR'];

    try{
        $sql = "insert into login_log(login_id, login_ip, login_time) values({$login_id}, '{$login_ip}', NOW())";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            throw new Exception('접속 로그 저장에 실패했습니다: ' . mysqli_error($conn));
        }
    } catch(Exception $e){
        echo '오류: ' . $e->getMessage();
        error_log($e->getMessage());
    }
    // DB 연결 종료
    mysqli_close($conn);
}

// 게시글 로그
function create_board_log($log_type, $board_id, $user_id){
    global $conn;

    $event_ip = $_SERVER['REMOTE_ADDR'];
    $event_content = "$log_type : $board_id";

    try{
        $sql = "insert into event_log (user_id, event_ip, event_content, event_time)
            values({$user_id}, '{$event_ip}', '{$event_content}', NOW())";
        $result = mysqli_query($conn, $sql);
        if($result === false){
            throw new Exception('접속 로그 저장에 실패했습니다: ' . mysqli_errno($conn));
        }
    }catch(Exception $e){
        echo '오류: ' . $e->getMessage();
        error_log($e->getMessage());
    }
    // DB 연결 종료
    mysqli_close($conn);
}

?>