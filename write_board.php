<?php
require_once "head.php";
// DB연결
$conn = mysqli_connect("localhost", "testlink", "12345", "test1");

// 게시,수정에 따른 form태그 변경사항
$action_url = 'board/create_board_process.php';
$submit_value = '게시';

$board = array(
    'id' => '',
    'title' => '',
    'content' => '',
    'write_user_id' => ''
);

// 수정접근시 board_id
if(isset($_GET['id'])){
    settype($_GET['id'], 'integer');
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "select * from board where id = {$filtered_id}";

    $result = mysqli_query($conn, $sql);
    $row =  mysqli_fetch_array($result);

    if($row['write_user_id'] == $_SESSION['user_id']){
        $action_url = "board/update_board_process.php";
        $submit_value = '수정';
    
        $board['id'] = htmlspecialchars($row['id']);
        $board['title'] = htmlspecialchars($row['title']);
        $board['content'] = htmlspecialchars($row['content']);
        $board['write_user_id'] = htmlspecialchars($row['write_user_id']);
    }
}
?>

<div>
    <form action=<?=$action_url?> method="post" enctype="multipart/form-data">
        <table>
            <div class="mb-3">
                <input class="form-control" type="text" name="title" placeholder="제목" value="<?=$board['title']?>">
            </div>
            <div class="mb-3">
                <textarea class="form-control" name="content" placeholder="내용"><?=$board['content']?></textarea>
            </div>
            <div class="mb-3">
                <input class="form-control" type="file" name="upload_file">
            </div>
            <div class="mb-3">
                <input type="hidden" name="id" value="<?=$board['id']?>">
                <input type="hidden" name="write_user_id" value="<?=$_SESSION['user_id']?>">
                <input type="submit" class="btn btn-primary btn-xs" value=<?=$submit_value?>>
            </div>
        </table>
    </form>
</div>

<?php
require_once "footer.php";
?>