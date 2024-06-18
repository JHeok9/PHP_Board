<?php
require_once "include/header.php";
require_once "include/dbconn.php";
require_once "include/pagination.php";

$result = pagination("login_log", $search, $page, $start_date, $end_date);

$html = '';
while($row = mysqli_fetch_assoc($result['content_list'])) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['user_id']}</td>";
    $html .= "<td>{$row['name']}</td>";
    $html .= "<td>{$row['nickname']}</td>";
    $html .= "<td>{$row['login_ip']}</td>";
    $html .= "<td>{$row['log_time']}</td>";
    $html .= "</tr>";
}

$page_links = $result['page_list'];
?>

<!-- Wrap -->
<div id="wrap">
    <!-- Container -->
    <main id="container">
        <div class="main_content">
            <!--Content-->
            <div class="tb_row td_center">
                <caption>로그인 정보</caption>
                <!-- 검색 -->
                <form action="login_log.php">
                    <input type="date" name="start_date">
                    <span> ~ </span>
                    <input type="date" name="end_date">
                    <br>
                    <input type="text" name="search" placeholder="유저ID">
                    <input type="submit" value="검색">
                </form>
                <table class="table table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>유저 번호</th>
                            <th>유저 ID</th>
                            <th>닉네임</th>
                            <th>로그인IP</th>
                            <th>로그인시간</th>
                        </tr>
                    </thead>
                    <tbody id="log_list">
                        <?=$html?>
                    </tbody>
                </table>
            </div>
            <!-- 페이지 링크 -->
            <div>
                <?=$page_links?>
            </div>
            <!--//Content-->

        </div>


    </main>
    <!--//Container-->
</div>


</body>

</html>