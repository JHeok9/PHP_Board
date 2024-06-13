<?php
require_once "include/header.php";

$conn = mysqli_connect("localhost", "testlink", "12345", "test1");
$sql = "select * from login_log order by login_time desc";

$result = mysqli_query($conn, $sql);
$logs = array();

$html = '';
while($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>";
    $html .= "<td>{$row['login_id']}</td>";
    $html .= "<td>{$row['login_ip']}</td>";
    $html .= "<td>{$row['login_time']}</td>";
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
                <caption>로그인 정보</caption>
                <table class="table table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>로그인id</th>
                            <th>로그인IP</th>
                            <th>로그인시간</th>
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