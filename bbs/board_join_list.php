<?php
include_once('./_common.php');
?>
<!doctype html>
<html lang="en">

<head>
<title>보험가입내역 조회신청관리</title>
<?php
		include_once(G5_THEME_PATH.'/head.php');

		$pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1" ; 
		$filter = $_GET["filter"]!= NULL ? $_GET["filter"] : "" ;
		$search = $_GET["search"]!= NULL ? $_GET["search"] : "" ;

		$postvars = array('pass'=>'kiosk', 'req'=>'my_insurance', 'memberId'=>$member['mb_id'],'id'=>$member['mb_id'], 'insureId'=>$member['INSUREID'], 'level'=>$member['mb_level'], 'requestPageNo'=>$pageNum, 'filter'=>$filter, 'search'=>$search	);

		$header = array();
		$header[] = 'Content-Type: Application/json';

		$url = 'https://kiosk.tsellitech.com/member_index.php';
		$http = curl_init();
		curl_setopt($http, CURLOPT_URL, $url);
		curl_setopt($http, CURLOPT_POST, 1);
        curl_setopt($http, CURLOPT_POSTFIELDS, $postvars);


		curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);

		
		$responseJson = curl_exec($http);
		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
		$requestList = json_decode($responseJson);
		//$maxNum = json_decode($responseJson)->pageNoLimit;
		echo "<script>console.log('$responseJson');</script>";
		
		$s_page = 1;
		$e_page = 10;
		//var_dump($responseJson);
		//var_dump($requestList);
		//var_dump($requestList);
		curl_close($http);
		
?>

<h2 id="container_title"><span title="청구완료 리스트">청구완료 리스트</span></h2>
<style>
HTML CSSResult
EDIT ON
table.type09 {
    border-collapse: collapse;
    text-align: left;
    line-height: 1.5;

}
table.type09 thead th {
    padding: 10px;
    font-weight: bold;
    vertical-align: top;
    color: #369;
    border-bottom: 3px solid #036;
}
table.type09 tbody th {
    width: 150px;
    padding: 10px;
    font-weight: bold;
    vertical-align: top;
    border-bottom: 1px solid #ccc;
    background: #f3f6f7;
}
table.type09 td {
    width: 350px;
    padding: 10px;
    vertical-align: top;
    border-bottom: 1px solid #ccc;
}


.btn{
      text-decoration: none;
      font-size:2rem;
      color:white;
      padding:10px 20px 10px 20px;
      margin:20px;
      display:inline-block;
      border-radius: 10px;
      transition:all 0.1s;
      text-shadow: 0px -2px rgba(0, 0, 0, 0.44);
      font-family: 'Lobster', cursive;
    }
    .btn:active{
      transform: translateY(3px);
    }
    .btn.blue{
      background-color: #1f75d9;
      border-bottom:5px solid #165195;
    }
    .btn.blue:active{
      border-bottom:2px solid #165195;
    }
    .btn.red{
      background-color: #ff521e;
      border-bottom:5px solid #c1370e;
    }
    .btn.red:active{
      border-bottom:2px solid #c1370e;
    }
</style>
</head>

<body>
<div>
	<form>
		<select name="filter">
			<option value="" <?php if($filter == "") echo "SELECTED";?>>검색조건선택</option>
			<option value="신청기기" <?php if($filter == "신청기기") echo "SELECTED";?>>신청기기</option>
			<option value="병원" <?php if($filter == "병원") echo "SELECTED";?>>병원</option>
			<option value="성명" <?php if($filter == "성명") echo "SELECTED";?>>성명</option>
		</select>
		<input name="search" type="text" value="<?=$search?>">
		<input type="submit" value="검색">
	</form>
</div>
<div>
<table class="type09">
    <thead>
    <tr>
        <th scope="cols">NO</th>
        <th scope="cols">신청기기</th>
		<th scope="cols">신청병원</th>
        <th scope="cols">성명</th>
		<th scope="cols">나이</th>
        <th scope="cols">연락처</th>
		<th scope="cols">등록일</th>
    </tr>
    </thead>
    <tbody>
	<?php
	foreach($requestList as $reqArr){

	?>
		<tr>
			<td><?= $reqArr->no ?></td>
			<td><?= $reqArr->신청기기 ?></td>
			<td><?= $reqArr->신청병원 ?></td>
			<td><?= $reqArr->성명 ?></td>
			<td><?= $reqArr->나이 ?></td>
			<td><?= $reqArr->연락처 ?></td>
			<td><?= $reqArr->등록일 ?></td>
		</tr>
	<?php
	}
	?>

    </tbody>
</table>
</div>
<div style="text-align:center">
<?php
for ($p=$s_page; $p<=$e_page; $p++) {
	//<a class="btn blue" href="http://digdag1985.cafe24.com/easyone/bbs/board_sell_list.php?page=<?=$p"><?=$p</a>
?>

    

<?php
}
?>



</div>
</body>

</html>


<?php
include_once(G5_THEME_PATH.'/tail.php');

?>
