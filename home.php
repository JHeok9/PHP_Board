<?php
require_once "head.php";

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");
$sql = "select * from board";
$result = mysqli_query($conn, $sql);

$board_list = '';
while($row = mysqli_fetch_array($result)){
    $title = htmlspecialchars($row['title']);
    $board_list .= "<li><a href='board?id={$row['id']}>{$title}</a></li>";
}
?>
<div>
    <h2>board</h2>
    <ol>
        <?=$board_list?>
    </ol>
    <a href="create_board.php">글작성</a>
</div>
<?php
require_once "footer.php";
?>