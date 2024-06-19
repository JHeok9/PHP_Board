<?php
// 일별 접속자 현황
$sql = "SELECT DATE_FORMAT(d.date_range, '%Y-%m-%d') AS log_date,
COALESCE(COUNT(a.id), 0) AS total_logins
FROM (
 SELECT CURDATE() - INTERVAL (n.n) DAY AS date_range
 FROM (
     SELECT 0 as n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
     UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
     ) n
 ) d
LEFT JOIN access_log a ON DATE(a.log_time) = d.date_range
GROUP BY d.date_range
ORDER BY d.date_range";

$result = mysqli_query($conn, $sql);
$logs = array();

while($row = mysqli_fetch_assoc($result)) {
$logs[] = $row;
}
?>