<?php
require_once "head.php";
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 게시,수정에 따른 form태그 변경사항
$action_url = 'create_board_process.php';
$submit_value = '게시';

$board = array(
    'title' => '',
    'content' => '',
    'create_user_id' => ''
);

if(isset($_GET['id']) && $_GET['id'] == $_SESSION['user_id']){
    $action_url = "update_board_process.php";
    $submit_value = '수정';

    settype($_GET['id'], 'integer');
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "select * from board where id = {$filtered_id}";

    $result = mysqli_query($conn, $sql);

    $row =  mysqli_fetch_array($result);
    $board['title'] = htmlspecialchars($row['title']);
    $board['content'] = htmlspecialchars($row['content']);
    $board['create_user_id'] = htmlspecialchars($row['create_user_id']);

}
?>

<div>
    <form action=<?=$action_url?> method="post">
        <table>
            <tr>
                <td>
                    <input type="text" name="title" placeholder="제목" value="<?=$board['title']?>">
                </td>
            </tr>
            <tr>
                <td>
                    <textarea name="content" placeholder="내용"><?=$board['content']?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="create_user_id" value="<?=$_SESSION['user_id']?>">
                    <input type="submit" value=<?=$submit_value?>>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
require_once "footer.php";
?>