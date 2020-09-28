<?php
include_once('./_common.php');
include_once('../comm/Dao.php');
include "../lib/PHPExcel.php";

$fc_val = $_GET["fc"];

$d = new Dao();
$fc_list = $d->getAllFc_list();

error_reporting(E_ALL);
ini_set("display_errors",1);

//db
$d = new Dao();
$arrCustomers = $d->getAllCustomers();

// 보더 스타일 지정
$right_border = [ 'borders' => [ 'right' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ] ] ];
$all_border = [ 'borders' => [ 'allborders' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ] ] ];

// excel
$objPHPExcel = new PHPExcel();
if($fc_val == "on"){
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A1", "FC_ID")
        ->setCellValue("B1", "FC 성명")
        ->setCellValue("C1", "연락처 1")
        ->setCellValue("D1", "연락처 2")
        ->setCellValue("E1", "캠페인명")
//        ->setCellValue("F1", str_replace("<br>" , "<br style='mso-data-placement:same-cell;'>","신청일\n형식 : 2020-01-01"))
        ->setCellValue("F1", "신청일 예)2020-01-01")
        ->setCellValue("G1", "고객이름")
        ->setCellValue("H1", "생년월일 예)2020-01-01")
        ->setCellValue("I1", "성별 (남자/여자)")
        ->setCellValue("J1", "연락처 (-포함)")
        ->setCellValue("K1", "지역")
        ->setCellValue("L1", "방문요청일 예)2020-01-01")
        ->setCellValue("M1", "공급가격")
        ->setCellValue("N1", "포인트 차감 금액");;

    $count = 1;
    //row data insert
    foreach ($fc_list as $key => $value) {
        $num = 2 + $key;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(sprintf("A%s", $num) , $value['mb_id'])
            ->setCellValue(sprintf("B%s", $num) , $value['mb_name'])
            ->setCellValue(sprintf("C%s", $num) , $value['mb_tel'])
            ->setCellValue(sprintf("D%s", $num) , $value['mb_hp']);
        $count++;
    }

    $objPHPExcel -> getActiveSheet() -> getStyle("A1:N1") -> getFont() -> setBold(true);
    $objPHPExcel -> getActiveSheet() -> getStyle("A1:N1") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID)-> getStartColor() -> setRGB("CECBCA");

    $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($all_border);
    $objPHPExcel->getActiveSheet()->getStyle(sprintf("D1:D%s", $count))->applyFromArray($right_border);

    foreach(range('A','N') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setWidth(14);
    }

//    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setVisible(false);
    $objPHPExcel->getActiveSheet()->getStyle("A1:M1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(21);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(27);
//    $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setAutoSize(true);
    $filename="FC 업로드 양식.xls";  //파일명

}else{
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A1", "캠페인명")
        ->setCellValue("B1", "신청일 예)2020-01-01")
        ->setCellValue("C1", "고객이름")
        ->setCellValue("D1", "생년월일 예)2020-01-01")
        ->setCellValue("E1", "성별 (남자/여자)")
        ->setCellValue("F1", "연락처 (-포함)")
        ->setCellValue("G1", "지역")
        ->setCellValue("H1", "방문요청일 예)2020-01-01")
        ->setCellValue("I1", "공급가격");

    $objPHPExcel -> getActiveSheet() -> getStyle("A1:I1") -> getFont() -> setBold(true);
    $objPHPExcel -> getActiveSheet() -> getStyle("A1:I1") -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID)-> getStartColor() -> setRGB("CECBCA");

    $objPHPExcel ->getActiveSheet() ->getStyle('A1:I1')->applyFromArray($all_border);
    foreach(range('A','I') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setWidth(14);
    }

    $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

    $filename="미배정 업로드 양식.xls";  //파일명
}

// 시트 네임
$objPHPExcel -> getActiveSheet() -> setTitle("업로드 양식");

// 첫번째 시트(Sheet)로 열리게 설정
$objPHPExcel -> setActiveSheetIndex(0);

// 파일이름 파일 이름 깨짐 방지 EUCKR
// $filename = iconv("UTF-8", "EUC-KR", "dbtrade_yyMmdd");

header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition: attachment;filename={$filename}");
header("Cache-Control:max-age=0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
$objWriter -> save("php://output");

?>