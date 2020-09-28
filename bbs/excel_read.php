<?php
include_once('./_common.php');
include "/var/www/html/lib/PHPExcel.php";
 
//-- 읽을 범위 필터 설정
$rangeArr = range('A','L');
class MyReadFilter implements PHPExcel_Reader_IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
        global $rangeArr;
        // Read rows 1 to 7 and columns A to E only
        if (in_array($column,$rangeArr)) {
            return true;
        }
        return false;
    }
}
$filterSubset = new MyReadFilter();
 
$filename = $_FILES['uploadFile']['tmp_name'];
$upfile_path = $_FILES['uploadFile']['name'];
$path = pathinfo($upfile_path);
$UpFileExt = strtolower($path['extension']);
$inputFileType = '';

 //파일 타입 설정 (확자자에 따른 구분)
if($UpFileExt == "xls") {
    $inputFileType = 'Excel5';    
}elseif( $UpFileExt == 'xlsx' ){
    $inputFileType = 'Excel2007';
}
   


if( file_exists ($filename) && $inputFileType ) {
 
 
    //엑셀리더 초기화
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    //데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
    $objReader->setReadDataOnly(false);    
 
    //범위 지정(위에 작성한 범위필터 적용)
    $objReader->setReadFilter($filterSubset);
    //업로드된 엑셀 파일 읽기
    $objPHPExcel = $objReader->load($filename);
	
    //첫번째 시트로 고정
    $objPHPExcel->setActiveSheetIndex(0);
 
    //고정된 시트 로드
    $objWorksheet = $objPHPExcel->getActiveSheet();
 
    //시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    $total_rows = count($sheetData);
 
//echo "<pre>";print_r($sheetData);echo "</pre>\n";
	$d = new Dao();
		
		


    $kk = 0;
    
    foreach($sheetData as $rows) {
		
        if( $kk ==0 ){
          
        }else{
			
			
			echo (" <br /> ");
			
			$id = '';
			$allocate_fc_id = $rows["A"];
			$name = $rows["B"];
			$status = $rows["C"];
			$birth = $rows["D"];
			$sex = $rows["E"];
			$contact = $rows["F"];
			$req_visit_date = $rows["G"];
			$consult = $rows["H"];
			$req_date = $rows["I"];
			$allocate_date = $rows["J"];
			$allocate_price = $rows["K"];
			$price = $rows["L"];
			echo ($allocate_fc_id." ".$name." ".$status." ".$birth." ".$sex." ".$contact." ".$req_visit_date." ".$consult." ".$req_date." ".$allocate_date." ".$allocate_price." ".$price);


			$page_per = $d->setCustomer($allocate_fc_id, $name, $status, $birth, $sex, $contact, $req_visit_date, $consult, $req_date, $allocate_date, $allocate_price, $price);
			
			var_dump(page_per);
        }
 
 		$kk++;
		sleep(1);
    }//end foreach
   
 
}else{
    echo 'Error!!';
}
 
?>