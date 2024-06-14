<?php
require_once "include/header.php";

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");
$sql = "select * from event_log";

$result = mysqli_query($conn, $sql);

$html = '';
while($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['user_id']}</td>";
    $html .= "<td>{$row['event_ip']}</td>";
    $html .= "<td>{$row['event_content']}</td>";
    $html .= "<td>{$row['event_time']}</td>";
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
                <caption>이벤트 로그</caption>
                <table class="table table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>유저 번호</th>
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
            <!--//Content-->

        </div>


    </main>
    <!--//Container-->
</div>


</body>

</html>