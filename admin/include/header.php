<?php
session_start();
if ($_SESSION['user_id'] != 1) {
    header("Location: ../home.php");
}
?>
<!doctype html>
<html lang="ko">

<head>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Basic Style -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <!-- Basic Js -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">DashBoard</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user_list.php">유저목록</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="access_log.php">접속로그</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login_log.php">로그인로그</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="event_log.php">이벤트로그</a>
                    </li>
                </ul>
            </div>
            <a class="nav-link" href="../home.php">돌아가기</a>
        </div>
    </nav>