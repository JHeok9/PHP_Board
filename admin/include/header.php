<?php
session_start();
require_once "dbconn.php";

if ($_SESSION['user_id'] != 1) {
    header("Location: ../home.php");
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$page = isset($_GET['page']) ? mysqli_real_escape_string($conn, $_GET['page']) : '';
$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';

$down_load_param = "";
if(!empty($search)){
    $down_load_param .= "&search=$search";
}
if(!empty($start_date)){
    $down_load_param .= "&start_date=$start_date";
}
if(!empty($end_date)){
    $down_load_param .= "&end_date=$end_date";
}

?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>admin</title>

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