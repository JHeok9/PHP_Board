<?php
require_once "head.php";

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");
$filtered_search = '';

// 페이징처리
if(isset($_GET['category']) && !empty($_GET['search'])){ // 검색시 게시글 카운트
    $filtered_search = mysqli_real_escape_string($conn, $_GET['search']);
    if($_GET['category'] == 'title'){
        $sql = "select count(*) as count from board where title like '%$filtered_search%'";
    }else{
        
        $sql = "select count(*) as count from board b left join user u on b.write_user_id = u.id where u.nickname like '%$$filtered_search%'";
    }
}else{ // 전체게시글 카운트
    $sql = "select count(*) as count from board";
}

$result = mysqli_query($conn, $sql);
$board_count = mysqli_fetch_array($result)['count'];

$list_num = 5; // 한 페이지에 보여줄 게시글 수
$page_num = 5; // 페이지 번호를 몇 개까지 보여줄지 설정
$page = isset($_GET['page']) ? mysqli_real_escape_string($conn, $_GET['page']) : 1;
$start = ($page - 1) * $list_num;

// 전체 페이지 수 계산
$total_page = ceil($board_count / $list_num);

// 게시글 리스트 가져오기
if(isset($_GET['category']) && !empty($_GET['search'])){ // 검색시
    if($_GET['category'] == 'title'){
        $sql = "select b.*, u.nickname 
                  from board b left join user u 
                    on b.write_user_id = u.id 
                 where title like '%$filtered_search%'
                order by board_created desc 
                 limit $start, $list_num";
    }else{
        $sql = "select b.*, u.nickname 
                  from board b left join user u 
                    on b.write_user_id = u.id 
                 where u.nickname like '%$filtered_search%'
                order by board_created desc 
                 limit $start, $list_num";
    }
}else{ 
    $sql = "select b.*, u.nickname from board b left join user u on b.write_user_id = u.id order by board_created desc limit $start, $list_num";
}

$result = mysqli_query($conn, $sql);

// 페이지 번호 링크 생성
$page_list = '';
$page_start = max(1, $page - floor($page_num / 2)); // 시작 페이지 번호
$page_end = min($total_page, $page_start + $page_num - 1); // 끝 페이지 번호

if ($page_start > 1) {
    $page_list .= "<a href='?page=1'>처음</a> ";
}

for ($i = $page_start; $i <= $page_end; $i++) {
    if ($i == $page) {
        $page_list .= "<strong>$i</strong> ";
    } else {
        $page_list .= "<a href='?page=$i'>$i</a> ";
    }
}

if ($page_end < $total_page) {
    $page_list .= "<a href='?page=$total_page'>끝</a>";
}

$board_list = '';
while($row = mysqli_fetch_array($result)){
    $board = array(
        'id' => htmlspecialchars($row['id']),
        'nickname' => htmlspecialchars($row['nickname']),
        'title' => htmlspecialchars($row['title']),
        'board_created' => htmlspecialchars($row['board_created']),
        'views' => htmlspecialchars($row['views'])
    );

    $board_list .= "<tr>";
    $board_list .= "<td>{$board['id']}</td>";
    $board_list .= "<td>{$board['nickname']}</td>";
    $board_list .= "<td><a href='board.php?id={$board['id']}'>{$board['title']}</a></td>";
    $board_list .= "<td>{$board['board_created']}</td>";
    $board_list .= "<td>{$board['views']}</td>";
    $board_list .= "</tr>";
}
?>

<div>
    <h2><a href="home.php">board</a></h2>

     <!-- 검색 -->
    <form action="home.php">
        <div class="input-group">
            <div class="form-outline">
                <select name="category">
                    <option value="title">제목</option>
                    <option value="nickname">작성자</option>
                </select>
                <input type="text" name="search">
            </div>
            <button type="submit" class="btn btn-primary">검색</button>
        </div>
    </form>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">작성자</th>
                <th scope="col">제목</th>
                <th scope="col">게시일</th>
                <th scope="col">조회수</th>
            </tr>
        </thead>
        <tbody>
            <?=$board_list?>
        </tbody>
    </table>

    <div>
        <?=$page_list?>
    </div>

    <a href="write_board.php"><button class="btn btn-primary">글작성</button></a>
</div>
<?php
require_once "footer.php";
?>