<?php
session_start();

// 로그인 아닐시 로그인페이지로 이동
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page !== 'index.php' && $current_page !== 'create_user.php' && empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>board</title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- CSS -->
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body class="text-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo '<a class="navbar-brand" href="home.php">Board</a>';
                        echo '<a class="nav-link" href="user/logout_process.php">로그아웃</a>';
                    }
                ?>
                
            </div>
        </nav>