<?php
require_once "head.php";
?>

<div>
    <form action="login_process.php" method="post">
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
                    <input type="submit" value="로그인">
                </td>
            </tr>
            <tr>
                <td><a href="create_user.php">회원가입</a></td>
            </tr>
        </table>
    </form>
</div>

<?php
require_once "footer.php";
?>