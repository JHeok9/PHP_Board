<?php
require_once "head.php";
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

$board = array(
    'title' => 'hi',
    'content' => 'hi',
    'create_user_id' =>  'hi'
);

$button = '';

if(isset($_GET['id'])){
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "select * from board b left join user u on b.create_user_id = u.id where b.id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);
    $board['title'] = htmlspecialchars($row['title']);
    $board['content'] = htmlspecialchars($row['content']);
    $board['name'] = htmlspecialchars($row['name']);

    if($row['create_user_id'] == $_SESSION['user_id']){
        $button = "<a href='write_board.php?id={$filtered_id}'><button>수정</button></a>";
        $button .= '<form action="delete_board_process.php" method="post"><input type="hidden" name="id" value="'.$row['id'].'"><input type="submit" value="삭제"></form>';
    }
}
?>

<div>
    <table border="1">
        <tr>
            <td>제목</td><td><?=$board['title']?></td>
        </tr>
        <tr>
            <td>내용</td><td><?=$board['content']?></td>
        </tr>
        <tr>
            <td>작성자</td><td><?=$board['name']?></td>
        </tr>
    </table>
    <a href="home.php"><button>목록</button></a>
    <?=$button?>
</div>

<?php
require_once "footer.php";
?>