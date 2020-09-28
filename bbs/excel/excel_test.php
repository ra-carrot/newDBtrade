<?php
require_once('/var/www/html/lib/PHPExcel/IOFactory.php');
$file = './teble.xls';
try {
    $inputFileType = PHPExcel_IOFactory::identify($file);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($file);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($file, PATHINFO_BASENAME).'" : '.$e->getMessage());
}
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
print_r($sheetData);




//id	allocate_fc_id	name	status	birth	sex	contact	req_visit_date	consult	req_date	allocate_date	allocate_price	price
	public function setCustomer($allocate_fc_id, $name, $status, $birth, $sex, $contact, $req_visit_date, $consult, $req_date, $allocate_date, $allocate_price, $price)
    {

	  $maxId = $this->dao->select(' max(id) ')->from('customer')->where('1=1');

	  $maxId = $maxId + 1;

	  $this->dao->insert('customer',
			[	'id','i', $maxId,
				'allocate_fc_id', 's', $allocate_fc_id,
				'name', 's', $name,
				'status', 'i', $status,
				'birth', 's', $birth,
				'sex', 'i', $sex,
				'contact', 's', $contact,
				'req_visit_date', 's', $req_visit_date,
				'consult', 's', $consult,
				'req_date', 's', $req_date,
				'allocate_date', 's', $allocate_date,
				'allocate_price', 'i', $allocate_price,
				'price', 'i', $price
			]
		);
	}