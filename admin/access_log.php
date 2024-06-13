<?php
require_once "include/header.php";

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");
$sql = "select * from access_log";

$result = mysqli_query($conn, $sql);
$logs = array();

$html = '';
while($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['access_ip']}</td>";
    $html .= "<td>{$row['access_time']}</td>";
    $html .= "<td>{$row['access_browser']}</td>";
    $html .= "<td>{$row['access_os']}</td>";
    $html .= "<td>{$row['access_route']}</td>";
    $html .= "</tr>";
}

?>

<!-- Wrap -->
<div id="wrap">
    <!-- Container -->
    <main id="container">
        <div class="main_content">
            <!--Content-->
            <div class="tb_row td_center">
                <caption>회원 유형별 접속 현황</caption>
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
            <!--//Content-->

        </div>


    </main>
    <!--//Container-->
</div>


</body>

</html>