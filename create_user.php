<?php
require_once "head.php";
?>

<div>
    <form action="create_user_process.php" method="post">
        <table>
            <tr>
                <td>
                    <input type="text" name="name" placeholder="아이디">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="password" placeholder="비밀번호">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="nickname" placeholder="닉네임">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="회원가입">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
require_once "footer.php";
?>