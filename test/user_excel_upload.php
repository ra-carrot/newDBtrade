<?php
include_once('./_common.php');
include_once('../comm/Dao.php');
header("Content-Type:text/html;charset=utf-8");

$d = new Dao();

$error = $_FILES['excel_upload']['error'];
include "../lib/PHPExcel.php";

//error_reporting(E_ALL);
//ini_set("display_errors",1);

if ($error == UPLOAD_ERR_OK){

    $file_name = $_FILES['excel_upload']['name'];
    $tmp_file = $_FILES['excel_upload']['tmp_name'];
    $file_path = '../go/'.$file_name;

    if(move_uploaded_file($tmp_file, $file_path)){
        try{
            $objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
            $objReader->setReadDataOnly(true);
            $objExcel = $objReader->load($file_path);

            // 첫번째 시트를 선택
            $objExcel->setActiveSheetIndex(0);
            $objWorksheet = $objExcel->getActiveSheet();
            $rowIterator = $objWorksheet->getRowIterator();

            foreach ($rowIterator as $row) { // 모든 행에 대해서
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
            }

            $maxRow = $objWorksheet->getHighestRow();

            $check_fc1 = $objWorksheet->getCell('A' . 1)->getValue();
            $check_fc2 = $objWorksheet->getCell('B' . 1)->getValue();
            $msg = "";
            $cnt = 0;
            if($check_fc1 == "FC_ID" && $check_fc2 == "FC 성명"){
                for ($i = 2 ; $i <= $maxRow ; $i++) {

                    $allocate_fc_id = $objWorksheet->getCell('A' . $i)->getValue();

                    $campaign = $objWorksheet->getCell('E' . $i)->getValue();

                    $req_date = PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCell('F' . $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); // 신청일
                    $name = $objWorksheet->getCell('G' . $i)->getValue(); // 고객성명
                    $birth =  PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCell('H' . $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); // 생일
                    $sex =  $objWorksheet->getCell('I' . $i)->getValue();
                    if($sex == "남자"){
                        $sex = 0;
                    }else if($sex == "여자"){
                        $sex = 1;
                    }
                    $contact =  $objWorksheet->getCell('J' . $i)->getValue(); // 연락처
                    $location =  $objWorksheet->getCell('K' . $i)->getValue();
                    $req_visit_date = PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCell('L' . $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); // 방문요청일
                    $price = $objWorksheet->getCell('M' . $i)->getValue(); // 가격

                    // 중복검사
                    if(!$d->is_customer($name , $sex , $contact, $req_date , $campaign)){
                        if($allocate_fc_id == ""){
                            // fc 빈칸 업로드
                            $d->setUserFC($allocate_fc_id, $campaign, $req_date, $name, $birth, $sex, $contact, $location, $req_visit_date, $price, 0);
                            $cnt++;
                        }else{
                            // fc_id 체크 후 업로드 유효한 것만 업로드
                            if($d->is_member($allocate_fc_id)){
                                $d->setUserFC($allocate_fc_id, $campaign, $req_date, $name, $birth, $sex, $contact, $location, $req_visit_date, $price, 1);
                                $cnt++;
                            }else{
                                $msg = $msg.$i."열 존재하지 않는 FC 이름입니다.<br>";
                            }
                        }
                    }else{
                        $msg = $msg.$i."열 이미 업로드 되어있는 정보입니다.<br>";
                    }
                }

            }else{
                echo "업로드 양식이 다릅니다";
                return false;
//                미배정 양식 업로드 주석
//                for ($i = 2 ; $i <= $maxRow ; $i++) {
//                    $allocate_fc_id = null;
//                    $campaign = $objWorksheet->getCell('A' . $i)->getValue(); // 캠페인명
//                    $req_date = PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCell('B' . $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); // 신청일
//                    $name = $objWorksheet->getCell('C' . $i)->getValue(); // 고객성명
//                    $birth =  PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCell('D' . $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); // 생일
//                    $sex =  $objWorksheet->getCell('E' . $i)->getValue();
//                    if($sex == "남자"){
//                        $sex = 0;
//                    }else if($sex == "여자"){
//                        $sex = 1;
//                    }
//                    $contact =  $objWorksheet->getCell('F' . $i)->getValue(); // 연락처
//                    $location =  $objWorksheet->getCell('G' . $i)->getValue();
//                    $req_visit_date = PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCell('H' . $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); // 방문요청일
//                    $price = $objWorksheet->getCell('I' . $i)->getValue(); // 가격
//
//                    $d->setUserFC($allocate_fc_id, $campaign, $req_date, $name, $birth, $sex, $contact, $location, $req_visit_date, $price, 0);
//                }
            }
            echo $msg."제외 ".$cnt."개 업로드 완료";
        }catch (ErrorException $E){
            echo "업로드 실패";
        }
    }else{

    }
}
?>