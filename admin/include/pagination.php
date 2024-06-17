<?php
require_once "dbconn.php";


function pagination($table, $search, $page){
    global $conn;

    $list_num = 10; // 한 페이지에 보여줄 게시글 수
    $page_num = 5; // 페이지 번호를 몇 개까지 보여줄지 설정
    $page = !empty($page) ? $page : 1;
    $start = ($page - 1) * $list_num;

    if(!empty($search)){
        $count_sql = "select count(*) as count from $table t left join user u on t.user_id = u.id where u.nickname like '%$search%'";
        $list_sql = "select t.*, u.name, u.nickname from $table t left join user u on t.user_id = u.id where u.nickname like '%$search%' limit $start, $list_num";
    } else {
        $count_sql = "select count(*) as count from $table";
        $list_sql = "select t.*, u.name, u.nickname from $table t left join user u on t.user_id = u.id limit $start, $list_num";
    }
    
    $count = mysqli_query($conn, $count_sql);
    $board_count = mysqli_fetch_array($count)['count'];
    
    // 전체 페이지 수 계산
    $total_page = ceil($board_count / $list_num);

    // 페이지 번호 링크 생성
    $page_list = '';
    $page_start = max(1, $page - floor($page_num / 2)); // 시작 페이지 번호
    $page_end = min($total_page, $page_start + $page_num - 1); // 끝 페이지 번호

    $search_param = !empty($search) ? "&search={$search}" : "";
    if ($page_start > 1) {
        $page_list .= "<a href='?page=1{$search_param}'>처음</a> ";
    }

    for ($i = $page_start; $i <= $page_end; $i++) {
        if ($i == $page) {
            $page_list .= "<strong>$i</strong> ";
        } else {
            $page_list .= "<a href='?page=$i{$search_param}'>$i</a> ";
        }
    }

    if ($page_end < $total_page) {
        $page_list .= "<a href='?page=$total_page{$search_param}'>끝</a>";
    }
    
    $content_list = mysqli_query($conn, $list_sql);

    return ['content_list' => $content_list, 'page_list' => $page_list];
}
?>