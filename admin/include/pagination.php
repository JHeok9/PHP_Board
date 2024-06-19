<?php
require_once "dbconn.php";

// 로그인,이벤트 로그
function pagination($table, $search, $page, $start_date, $end_date){
    global $conn;

    $list_num = 10; // 한 페이지에 보여줄 게시글 수
    $page_num = 5; // 페이지 번호를 몇 개까지 보여줄지 설정
    $page = !empty($page) ? $page : 1;
    $start = ($page - 1) * $list_num;

   // WHERE 조건 조합
   $where_conditions = [];

   if (!empty($search)) {
       $where_conditions[] = "u.nickname LIKE '%$search%'";
   }

   if (!empty($start_date)) {
       $where_conditions[] = "log_time >= '$start_date'";
   }

   if (!empty($end_date)) {
       $end_date .= ' 23:59:59';
       $where_conditions[] = "log_time <= '$end_date'";
   }

   $where_sql = "";
   if (count($where_conditions) > 0) {
       $where_sql = "WHERE " . implode(" AND ", $where_conditions);
   }

   // SQL 쿼리 작성
   $count_sql = "SELECT COUNT(*) AS count FROM $table t LEFT JOIN user u ON t.user_id = u.id $where_sql";
   $list_sql = "SELECT t.*, u.name, u.nickname FROM $table t LEFT JOIN user u ON t.user_id = u.id $where_sql ORDER BY log_time DESC LIMIT $start, $list_num";

    
    $count = mysqli_query($conn, $count_sql);
    $board_count = mysqli_fetch_array($count)['count'];
    
    // 전체 페이지 수 계산
    $total_page = ceil($board_count / $list_num);

    // 페이지 번호 링크 생성
    $page_list = '';
    $page_start = max(1, $page - floor($page_num / 2)); // 시작 페이지 번호
    $page_end = min($total_page, $page_start + $page_num - 1); // 끝 페이지 번호

    // 검색어 파라미터
    $search_param = !empty($search) ? "&search={$search}" : "";
    $date_param = (!empty($start_date) ? "&start_date={$start_date}" : "") . (!empty($end_date) ? "&end_date={$end_date}" : "");

    if ($page_start > 1) {
        $page_list .= "<a href='?page=1{$search_param}{$date_param}'>처음</a> ";
    }

    for ($i = $page_start; $i <= $page_end; $i++) {
        if ($i == $page) {
            $page_list .= "<strong>$i</strong> ";
        } else {
            $page_list .= "<a href='?page=$i{$search_param}{$date_param}'>$i</a> ";
        }
    }

    if ($page_end < $total_page) {
        $page_list .= "<a href='?page=$total_page{$search_param}{$date_param}'>끝</a>";
    }
    
    $content_list = mysqli_query($conn, $list_sql);

    return [
            'content_list' => $content_list,
            'page_list' => $page_list
           ];
}

// 접속 로그
function pagination2($table, $search, $page, $start_date, $end_date){
    global $conn;

    $list_num = 10; // 한 페이지에 보여줄 게시글 수
    $page_num = 5; // 페이지 번호를 몇 개까지 보여줄지 설정
    $page = !empty($page) ? $page : 1;
    $start = ($page - 1) * $list_num;

    // WHERE 조건 조합
   $where_conditions = [];

   if (!empty($start_date)) {
       $where_conditions[] = "log_time >= '$start_date'";
   }

   if (!empty($end_date)) {
       $where_conditions[] = "log_time <= '$end_date'";
   }

   $where_sql = "";
   if (count($where_conditions) > 0) {
       $where_sql = "WHERE " . implode(" AND ", $where_conditions);
   }

 
    $count_sql = "select count(*) as count from $table $where_sql";
    $list_sql = "select t.* from $table t $where_sql order by log_time desc limit $start, $list_num";

    
    $count = mysqli_query($conn, $count_sql);
    $board_count = mysqli_fetch_array($count)['count'];
    
    // 전체 페이지 수 계산
    $total_page = ceil($board_count / $list_num);

    // 페이지 번호 링크 생성
    $page_list = '';
    $page_start = max(1, $page - floor($page_num / 2)); // 시작 페이지 번호
    $page_end = min($total_page, $page_start + $page_num - 1); // 끝 페이지 번호

     // 검색어 파라미터
     $search_param = !empty($search) ? "&search={$search}" : "";
     $date_param = (!empty($start_date) ? "&start_date={$start_date}" : "") . (!empty($end_date) ? "&end_date={$end_date}" : "");
 
    if ($page_start > 1) {
        $page_list .= "<a href='?page=1{$search_param}{$date_param}'>처음</a> ";
    }

    for ($i = $page_start; $i <= $page_end; $i++) {
        if ($i == $page) {
            $page_list .= "<strong>$i</strong> ";
        } else {
            $page_list .= "<a href='?page=$i{$search_param}{$date_param}'>$i</a> ";
        }
    }

    if ($page_end < $total_page) {
        $page_list .= "<a href='?page=$total_page{$search_param}{$date_param}'>끝</a>";
    }
    
    $content_list = mysqli_query($conn, $list_sql);

    return [
            'content_list' => $content_list,
            'page_list' => $page_list
           ];
}
?>