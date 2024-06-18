<?php
require_once "dbconn.php";

require '../lib/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// URL 파라미터 가져오기
$type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';
$table = isset($_GET['table']) ? mysqli_real_escape_string($conn, $_GET['table']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';

// WHERE 조건 조합
$where_conditions = [];

if (!empty($search)) {
    $where_conditions[] = "u.nickname LIKE '%$search%'";
}

if (!empty($start_date)) {
    $where_conditions[] = "log_time >= '$start_date'";
}

if (!empty($end_date)) {
    $where_conditions[] = "log_time <= '$end_date'";
}

$where_sql = "";
if (count($where_conditions) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where_conditions);
}

// 엑셀 다운로드 함수 호출
if($type == 'all'){
    all_excel_download($table, $where_sql);
}else if($type == ''){

}

// 전체페이지 엑셀 다운로드
function all_excel_download($table, $where_sql){
    global $conn;

    // 출력할 쿼리문
    $list_sql = "SELECT t.*, u.name, u.nickname FROM $table t LEFT JOIN user u ON t.user_id = u.id $where_sql ORDER BY log_time DESC";

    $result = mysqli_query($conn, $list_sql);

    // 첫 번째 행에서 컬럼 이름 목록 추출
    if ($first_row = mysqli_fetch_assoc($result)) {
        $columns = array_keys($first_row); // 컬럼명 배열
        $num_columns = count($columns); // 컬럼 수
    }

    
    // 스프레드시트 객체 생성
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 헤더 행 작성
    // 행번호 초기화
    $column = 'A';
    for ($col = 0; $col < $num_columns; $col++) {
        $sheet->setCellValue($column . "1", $columns[$col]);
        $column++;
    }

    // 데이터 행 작성
    $row = 2; // 데이터는 두 번째 행부터 시작합니다.
    mysqli_data_seek($result, 0); // 결과셋 포인터를 처음으로 되돌립니다.
    while ($data = mysqli_fetch_assoc($result)) {
        $column = 'A';
        for ($col = 0; $col < $num_columns; $col++) {
            $sheet->setCellValue($column . $row, $data[$columns[$col]]);
            $column++;
        }
        $row++;
    }


    // 엑셀 파일 생성
    $writer = new Xlsx($spreadsheet);

    // 파일을 직접 다운로드하도록 설정
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$table.'.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit();
}

?>