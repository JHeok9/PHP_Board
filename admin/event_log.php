<?php
require_once "include/header.php";
require_once "include/dbconn.php";
require_once "include/pagination.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$page = isset($_GET['page']) ? mysqli_real_escape_string($conn, $_GET['page']) : '';

$result = pagination("event_log", $search, $page, "event_time");

$html = '';
while($row = mysqli_fetch_assoc($result['content_list'])) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['user_id']}</td>";
    $html .= "<td>{$row['name']}</td>";
    $html .= "<td>{$row['nickname']}</td>";
    $html .= "<td>{$row['event_ip']}</td>";
    $html .= "<td>{$row['event_content']}</td>";
    $html .= "<td>{$row['event_time']}</td>";
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
                <caption>이벤트 로그</caption>
                <!-- 검색 -->
                <form action="login_log.php">
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
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>유저 번호</th>
                            <th>유저 ID</th>
                            <th>닉네임</th>
                            <th>유저 IP</th>
                            <th>작업 내용</th>
                            <th>작업 시간</th>
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