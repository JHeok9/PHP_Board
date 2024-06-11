<?php
require_once "head.php";
?>

<div>
    <form action="create_board_process.php" method="post">
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
                    <input type="submit" value="게시">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
require_once "footer.php";
?>