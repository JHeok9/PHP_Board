<?php
require_once "head.php";
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

$action_url = 'create_board_process.php';

if(isset($_GET['id'])){
    $action_url = "update_board_process.php";

    settype($_POST['id'], 'integer');
    $filtered_id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = "select * from board where id = {$filtered_id}";

    $result = mysqli_query($conn, $sql);

}
?>

<div>
    <form action=<?=$action_url?> method="post">
        <table>
            <tr>
                <td>
                    <input type="text" name="title" placeholder="제목">
                </td>
            </tr>
            <tr>
                <td>
                    <textarea name="content" placeholder="내용"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="create_user_id" value="<?=$_SESSION['user_id']?>">
                    <input type="submit" value="게시">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
require_once "footer.php";
?>