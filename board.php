<?php
require_once "head.php";
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

$board = array(
    'title' => '',
    'content' => '',
    'write_user_id' =>  '',
    'board_created' =>  '',
    'views' =>  ''
);

$button = '';

// 게시글 가져오기
if(isset($_GET['id'])){
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 게시글 조회수증가
    $sql = "update board set views = views + 1 where id = {$filtered_id}";
    mysqli_query($conn, $sql);

    $sql = "select b.*, u.nickname from board b left join user u on b.write_user_id = u.id where b.id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);
    $board['title'] = htmlspecialchars($row['title']);
    $board['content'] = htmlspecialchars($row['content']);
    $board['nickname'] = htmlspecialchars($row['nickname']);
    $board['board_created'] = htmlspecialchars($row['board_created']);
    $board['views'] = htmlspecialchars($row['views']);

    if($row['write_user_id'] == $_SESSION['user_id']){
        $button = "<a href='write_board.php?id={$filtered_id}' class='btn btn-outline-secondary'>modify</a>";
        $button .= "<a href='delete_board_process.php?id={$filtered_id}' class='btn btn-outline-secondary' onclick='return confirm(\"삭제하시겠습니까?\")'>delete</a>";
        // $button .= '<form action="delete_board_process.php" method="post"><input type="hidden" name="id" value="'.$row['id'].'"><input type="submit" class="btn btn-outline-secondary" value="delete"></form>';
    }
}

// 업로드 파일 가져오기
$board_file = array();
$sql = "select * from board_file where board_id = {$filtered_id}";
$result = mysqli_query($conn, $sql);
if ($result !== false && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $board_file['id'] = htmlspecialchars($row['id']);
    $board_file['uuid'] = htmlspecialchars($row['uuid']);
    $board_file['file_name'] = htmlspecialchars($row['file_name']);
} else {
    // 파일이 없을 때 처리
    $board_file['id'] = null;
    $board_file['uuid'] = null;
    $board_file['file_name'] = null;
}

$reply = '';
// 댓글 가져오기
$sql = "select r.*, u.nickname 
          from reply r left join board b 
            on r.board_id = b.id 
               left join user u 
            on r.reply_user_id = u.id 
          where b.id = {$filtered_id}";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    $reply .= "<tr>";
    $reply .= "<td>{$row['content']}</td>";
    $reply .= "<td class = 'table-secondary'>{$row['nickname']}</td>";
    $reply .= "</tr>";
}

?>

<div>
    <h2><a href="home.php">board</a></h2>
    <table class="table">
        <tr>
            <td>제목</td>
            <td><?=$board['title']?></td>
        </tr>
        <tr>
            <td>작성자</td>
            <td><?=$board['nickname']?></td>
        </tr>
        <tr>
            <td>게시일</td>
            <td><?=$board['board_created']?></td>
        </tr>
        <tr>
            <td>조회수</td>
            <td><?=$board['views']?></td>
        </tr>
        <tr>
            <td>내용</td>
            <td><?=$board['content']?></td>
        </tr>
        <tr>
            <td>첨부파일</td>
            <td><a href="file_download.php?uuid=<?=$board_file['uuid']?>&file_name=<?=$board_file['file_name']?>"><?=$board_file['file_name']?></a></td>
        </tr>
    </table>
    <br><br>

    <tr>
        <form action="create_board_reply_process.php" method="post">
                <table class="table">
                    <div class="mb-3">
                        <textarea class="form-control" name="content" placeholder="댓글을 작성해주세요."></textarea>
                        <input type="hidden" name="board_id" value="<?=$_GET['id']?>">
                        <input type="hidden" name="reply_user_id" value="<?=$_SESSION['user_id']?>">
                        <input class="btn btn-primary btn-xs" type="submit" value="작성">
                    </div>
                </table>
            </form>
        </tr>
        <div>
            <table class="table table-light">
                <?=$reply?>
            </table>
        </div>

    <a href="home.php" class="btn btn-outline-secondary">list</a><?=$button?>
</div>

<?php
require_once "footer.php";
?>