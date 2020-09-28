<?php
include_once('./_common.php');
include "/var/www/html/lib/PHPExcel.php";



$objPHPExcel = new PHPExcel();




$d = new Dao();
$arrCustomers = $d->getAllCustomers();

$objPHPExcel -> setActiveSheetIndex(0)

-> setCellValue("A1", "ID")

-> setCellValue("B1", "배정받은 FC")

-> setCellValue("C1", "고객이름")

-> setCellValue("D1", "상태")

-> setCellValue("E1", "주소")

-> setCellValue("F1", "고객생일")

-> setCellValue("G1", "고객성별")

-> setCellValue("H1", "고객 연락처")

-> setCellValue("I1", "방문 요청 날짜")

-> setCellValue("J1", "상담내용")

-> setCellValue("K1", "요청날짜")

-> setCellValue("L1", "배정일")

-> setCellValue("M1", "최종배정금액")

-> setCellValue("N1", "최초금액")

-> setCellValue("O1", "캠페인");


$count = 1;

foreach($arrCustomers as $key => $val) {

	$num = 2 + $key;

	$objPHPExcel -> setActiveSheetIndex(0)

	-> setCellValue(sprintf("A%s", $num), $val['id'])

	-> setCellValue(sprintf("B%s", $num), $val['allocate_fc_id'])

	-> setCellValue(sprintf("C%s", $num), $val['name'])

	-> setCellValue(sprintf("D%s", $num), $val['status'])

	-> setCellValue(sprintf("E%s", $num), $val['location'])

	-> setCellValue(sprintf("F%s", $num), $val['birth'])

	-> setCellValue(sprintf("G%s", $num), $val['sex'])

	-> setCellValue(sprintf("H%s", $num), $val['contact'])

	-> setCellValue(sprintf("I%s", $num), $val['req_visit_date'])

	-> setCellValue(sprintf("J%s", $num), $val['consult'])

	-> setCellValue(sprintf("K%s", $num), $val['req_date'])

	-> setCellValue(sprintf("L%s", $num), $val['allocate_date'])

	-> setCellValue(sprintf("M%s", $num), $val['allocate_price'])

	-> setCellValue(sprintf("N%s", $num), $val['price'])

	-> setCellValue(sprintf("O%s", $num), $val['campaign']);



	$count++;

}




// 타이틀 부분

$objPHPExcel -> getActiveSheet() -> getStyle("A1:O1") -> getFont() -> setBold(true);

$objPHPExcel -> getActiveSheet() -> getStyle("A1:O1") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID)

-> getStartColor() -> setRGB("CECBCA");



// 내용 지정

$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A2:O%s", $count)) -> getFill()

-> setFillType(PHPExcel_Style_Fill::FILL_SOLID) -> getStartColor() -> setRGB("F4F4F4");



// 시트 네임

$objPHPExcel -> getActiveSheet() -> setTitle("Customers");



// 첫번째 시트(Sheet)로 열리게 설정

$objPHPExcel -> setActiveSheetIndex(0);



// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.





// 브라우저로 엑셀파일을 리다이렉션

header("Content-Type:application/vnd.ms-excel");

header("Content-Disposition: attachment;filename=customer.xls");

header("Cache-Control:max-age=0");



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");

$objWriter -> save("php://output");




?>