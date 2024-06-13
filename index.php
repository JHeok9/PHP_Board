<?php
require_once "head.php";
?>

<!--  html 전체 영역을 지정하는 container -->
<div id="container">
    <!--  login 폼 영역을 : loginBox -->
    <div id="loginBox">
        <form action="login_process.php" method="post">
            <!-- 로그인 페이지 타이틀 -->
            <div id="loginBoxTitle">Login</div>
            <!-- 아이디, 비번, 버튼 박스 -->
                <div id="inputBox">
                    <div class="input-form-box"><span>아이디 </span><input type="text" name="name" class="form-control"></div>
                    <div class="input-form-box"><span>비밀번호 </span><input type="password" name="password" class="form-control"></div>
                    <div class="button-login-box" >
                    <button type="submit" class="btn btn-primary btn-xs" style="width:100%">로그인</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require_once "footer.php";
?>