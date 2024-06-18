<?php
require_once "include/header.php";
require_once "include/dbconn.php";
require_once "include/pagination.php";

$result = pagination2("access_log", $search, $page, $start_date, $end_date);

$html = '';
while($row = mysqli_fetch_assoc($result['content_list'])) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['access_ip']}</td>";
    $html .= "<td>{$row['log_time']}</td>";
    $html .= "<td>{$row['access_browser']}</td>";
    $html .= "<td>{$row['access_os']}</td>";
    $html .= "<td>{$row['access_route']}</td>";
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
                <caption>접속 정보</caption>
                <!-- 검색 -->
                <form action="access_log.php">
                    <input type="date" name="start_date">
                    <span> ~ </span>
                    <input type="date" name="end_date">
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
                            <th>접속IP</th>
                            <th>접속일</th>
                            <th>브라우저</th>
                            <th>운영체제</th>
                            <th>접근 경로</th>
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