<?php 
$sub_menu = "200800";

include_once('./_common.php');
include_once('../comm/Dao.php');
include "/var/www/html/lib/PHPExcel.php";

$objPHPExcel = new PHPExcel();

$d = new Dao();
$arrCustomers = $d->getAllCustomers();
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1", "고객번호")
            ->setCellValue("B1", "캠페인명")
            ->setCellValue("C1", "신청일")
            ->setCellValue("D1", "고객이름")
            ->setCellValue("E1", "생년월일")
            ->setCellValue("F1", "연락처")
            ->setCellValue("G1", "지역")
            ->setCellValue("H1", "방문요청일")
            ->setCellValue("I1", "요청사항")
            ->setCellValue("J1", "공급가격")
            ->setCellValue("K1", "상태");

$count = 1;

//row data insert
foreach ($arrCustomers as $key => $value) { 
    $num = 2 + $key;
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(sprintf("A%s", $num) , $value['id'])
                ->setCellValue(sprintf("B%s", $num) , $value['campaign'])
                ->setCellValue(sprintf("C%s", $num) , substr($value['req_date'],0,-9))
                ->setCellValue(sprintf("D%s", $num) , $value['name'].($value['sex'] == 0 ? "(여)" : "(남)"))
                ->setCellValue(sprintf("E%s", $num) , $value['birth'])
                ->setCellValue(sprintf("F%s", $num) , $value['contact'])
                ->setCellValue(sprintf("G%s", $num) , $value['location'])
                ->setCellValue(sprintf("H%s", $num) , substr($value['req_visit_date'],0,-9))
                ->setCellValue(sprintf("I%s", $num) , $value['consult'])
                ->setCellValue(sprintf("J%s", $num) , number_format($value['price']))
                ->setCellValue(sprintf("K%s", $num) , $value['status'] == 1 ? "배정완료" : "배정대기");
                $count++;
}

$objPHPExcel -> getActiveSheet() -> getStyle("A1:K1") -> getFont() -> setBold(true);
$objPHPExcel -> getActiveSheet() -> getStyle("A1:K1") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID)

-> getStartColor() -> setRGB("CECBCA");

$objPHPExcel -> getActiveSheet() -> getStyle(sprintf("A1:K%s", $count)) -> getBorders() -> getAllBorders()
-> setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

// 시트 네임
$objPHPExcel -> getActiveSheet() -> setTitle("dbtrade");

// 첫번째 시트(Sheet)로 열리게 설정
$objPHPExcel -> setActiveSheetIndex(0);

// 파일이름 파일 이름 깨짐 방지 EUCKR 
// $filename = iconv("UTF-8", "EUC-KR", "dbtrade_yyMmdd");

$filename="dbtrade_".date('Y-m-d').".xls";  //파일명 

header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition: attachment;filename={$filename}");
header("Cache-Control:max-age=0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
$objWriter -> save("php://output");
?>