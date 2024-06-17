<?php
require_once "include/header.php";
require_once "include/dbconn.php";

$sql = "select * from user";

$result = mysqli_query($conn, $sql);

$html = '';
while($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['name']}</td>";
    $html .= "<td>{$row['nickname']}</td>";
    $html .= "<td>{$row['user_created']}</td>";
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
                <caption>유저 정보</caption>
                <table class="table table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>회원번호</th>
                            <th>회원ID</th>
                            <th>회원이름</th>
                            <th>가입일</th>
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