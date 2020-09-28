<?php

include_once('./_common.php');

if(!$is_admin) {
    exit;
}

$g5['title'] = $group['gr_subject'];
include_once('./_head.php');


if($is_admin) {

} elseif($is_member) {
    Header("Location:/bbs/login.php");
} else{
    Header("Location:/bbs/login.php");
}

?>

<head>
    <title>포인트충전</title>
    <h2 id="container_title"><span title="포인트충전">포인트충전</span></h2>
	
</head>
<style>
.table_txt03 {
	font-family: Malgun Gothic,'맑은 고딕','돋움','dotum',sans-serif;	
	font-size:13px;
	font-style:normal;
	color:#353535;
	padding: 5px 0px;
	text-decoration:none;
}

</style>


    <form id="req_deposit" action="https://www.globaldbtrade.co.kr/trade/deposit.php" method="post" enctype="multipart/form-data">
		<div class="tbl_head01 tbl_wrap">
			<table class="text-center">
				<thead>
				<tr class="tbl_head_tr">
					<th scope="cols">버튼</th>
					<th scope="cols">결제금액</th>
					<th scope="cols">충전포인트</th>
					<th scope="cols">장문문자(LMS) 사용기준</th>
					<th scope="cols">멀티문자(MMS) 사용기준</th>
					<th scope="cols">팩스 사용기준</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td><input name="pointPolicy" type="radio" value="2"><input name="pointPrice" type="hidden" value="9900"><input name="pointTotalPrice" type="hidden" value="10890"></td>
						<td>9,900</td>
						<td>10,000</td>
						<td>약 250건</td>
						<td>약 105건</td>
						<td class="c-fax">약 200장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" checked="" value="4"><input name="pointPrice" type="hidden" value="19900"><input name="pointTotalPrice" type="hidden" value="21890"></td>
						<td>19,900</td>
						<td>20,000</td>
						<td>약 500건</td>
						<td>약 211건</td>
						<td class="c-fax">약 400장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" value="5"><input name="pointPrice" type="hidden" value="29900"><input name="pointTotalPrice" type="hidden" value="32890"></td>
						<td>29,900</td>
						<td>30,000</td>
						<td>약 750건</td>
						<td>약 316건</td>
						<td class="c-fax">약 600장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" value="6"><input name="pointPrice" type="hidden" value="49900"><input name="pointTotalPrice" type="hidden" value="54890"></td>
						<td>49,900</td>
						<td>50,000</td>
						<td>약 1,250건</td>
						<td>약 526건</td>
						<td class="c-fax">약 1,000장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" value="7"><input name="pointPrice" type="hidden" value="99900"><input name="pointTotalPrice" type="hidden" value="109890"></td>
						<td>99,900</td>
						<td>100,000</td>
						<td>약 2,500건</td>
						<td>약 1,053건</td>
						<td class="c-fax">약 2,000장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" value="8"><input name="pointPrice" type="hidden" value="149900"><input name="pointTotalPrice" type="hidden" value="164890"></td>
						<td>149,900</td>
						<td>150,000</td>
						<td>약 3,750건</td>
						<td>약 1,579건</td>
						<td class="c-fax">약 3,000장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" value="9"><input name="pointPrice" type="hidden" value="199900"><input name="pointTotalPrice" type="hidden" value="219890"></td>
						<td>199,900</td>
						<td>200,000</td>
						<td>약 5,000건</td>
						<td>약 2,105건</td>
						<td class="c-fax">약 4,000장</td>
					</tr>
				
					<tr>
						<td><input name="pointPolicy" type="radio" value="10"><input name="pointPrice" type="hidden" value="249900"><input name="pointTotalPrice" type="hidden" value="274890"></td>
						<td>249,900</td>
						<td>250,000</td>
						<td>약 6,250건</td>
						<td>약 2,632건</td>
						<td class="c-fax">약 5,000장</td>
					</tr>
				</tbody>
			</table>
			<p class="text-right" style="margin-bottom: 20px;">결제금액 : <span id="totalPrice">9,900</span>원 <span id="totalVatPrice" style="color: red;">(부과세 포함 10,890원)</span></p>
			
			<div class="tbl_head01 tbl_wrap">
				<table>						
					<colgroup>
						<col width="160">
						<col>
						<col width="200">
					</colgroup>
					<tbody>
						<tr>
							<td class="text-center" style="font-size: 15px;"><strong>결제방법 선택</strong></td>
							<td>
								<label><input name="paymentType" type="radio" value="MTD0002"> 신용카드&nbsp;&nbsp;</label>
								<label><input name="paymentType" type="radio" value="MTD0003"> 실시간 계좌이체&nbsp;&nbsp;</label>
								<label><input name="paymentType" type="radio" value="MTD0004"> 휴대폰 결제&nbsp;&nbsp;</label>
								<label><input name="paymentType" type="radio" value="MTD0006"> 가상계좌 &nbsp;&nbsp;</label>
								
							</td>
							<td class="pd-0">
								<button class="btn btn-big green-filled btn-border-none" style="width: 300px; height: 60px;" onclick="payment();" type="button">결제하기</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
    </form>
    <script type='text/javascript'>
 
    </script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>