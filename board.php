<?php
require_once "head.php";
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

$board = array(
    'title' => '',
    'content' => '',
    'create_user_id' =>  '',
    'created' =>  ''
);

$button = '';

// 게시글 가져오기
if(isset($_GET['id'])){
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "select b.*, u.name from board b left join user u on b.create_user_id = u.id where b.id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);
    $board['title'] = htmlspecialchars($row['title']);
    $board['content'] = htmlspecialchars($row['content']);
    $board['name'] = htmlspecialchars($row['name']);
    $board['created'] = htmlspecialchars($row['created']);

    if($row['create_user_id'] == $_SESSION['user_id']){
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
            on r.user_id = u.id 
          where b.id = {$filtered_id}";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    $reply .= "<tr>";
    $reply .= "<td>{$row['reply_content']}</td>";
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
            <td>작성자</td><td><?=$board['name']?></td>
        </tr>
        <tr>
            <td>게시일</td><td><?=$board['created']?></td>
        </tr>
        <tr>
            <td>내용</td><td><?=$board['content']?></td>
        </tr>
    </table>
    <br><br>

    <table border="1">
        <tr>
            <form action="create_board_reply_process.php" method="post">
                <td><textarea name="reply_content" placeholder="댓글을 작성해주세요."></textarea></td>
                <input type="hidden" name="board_id" value="<?=$_GET['id']?>">
                <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">
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