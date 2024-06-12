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
        $button = "<a href='write_board.php?id={$filtered_id}'><button>수정</button></a>";
        $button .= '<form action="delete_board_process.php" method="post"><input type="hidden" name="id" value="'.$row['id'].'"><input type="submit" value="삭제"></form>';
    }
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
    $reply .= "<td>{$row['nickname']}</td>";
    $reply .= "</tr>";
}

?>

<div>
    <table border="1">
        <tr>
            <td>제목</td><td><?=$board['title']?></td>
        </tr>
        <tr>
            <td>작성자</td><td><?=$board['nickname']?></td>
        </tr>
        <tr>
            <td>게시일</td><td><?=$board['board_created']?></td>
        </tr>
        <tr>
            <td>조회수</td><td><?=$board['views']?></td>
        </tr>
        <tr>
            <td>내용</td><td><?=$board['content']?></td>
        </tr>
    </table>
    <br><br>

    <table border="1">
        <tr>
            <form action="create_board_reply_process.php" method="post">
                <td><textarea name="content" placeholder="댓글을 작성해주세요."></textarea></td>
                <input type="hidden" name="board_id" value="<?=$_GET['id']?>">
                <input type="hidden" name="reply_user_id" value="<?=$_SESSION['user_id']?>">
                <td><input type="submit" value="작성"></td>
            </form>
        </tr>
        <?=$reply?>
    </table>

    <br><br>
    <a href="home.php"><button>목록</button></a><br>
    <?=$button?>
</div>

<?php
require_once "footer.php";
?>