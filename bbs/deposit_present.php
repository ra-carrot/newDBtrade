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
					<th scope="cols">아이디</th>
					<th scope="cols">입금자명</th>
					<th scope="cols">입금액</th>
					<th scope="cols">입금등록</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" value="<?=$member['mb_id']?>" id="mb_id" name="mb_id" readonly></td>
						<td><input type="text" value="" name="deposit_name" id="deposit_name"></td>
						<td><input type="text" value="" name="deposit_amount" id="deposit_amount"></td>
						<td><input class="attribution" type="submit" value="입금등록" name="submit"></td>
					</tr>
					<tr>
						<td colspan="4">*충전 : 입금액의 120%를 충전해 드립니다.(결번,중복,거절 등의 AS비용을 미리 넣어 드립니다.)<br>*환불 : 남은 금액에서 20%를 제외한 금액을 환불해 드립니다.<br>oo은행 000-0000-00000  </td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-12 textBox">추후에 신용카드 결제도 업데이트 예정입니다.</div>
    </form>

    <div id="result" class="tbl_head01 tbl_wrap">
		<table>
			<tbody>
				<tr>
					<td align="center" style="padding-top:35px;">
						<table width="1100" border="0" cellspacing="0" cellpadding="0">
						  <tbody><tr> 
							<td class="tap_box"><input class="tap_on" onclick="location.href='?type=';" type="button" value="충전내역"></td>
							<td class="tap_box_r"><input class="tap_off" onclick="location.href='?type=use';" type="button" value="사용내역"></td> 
							<td align="right" style="border-bottom:1px solid #999;">
								<table border="0" cellspacing="0" cellpadding="0">
								  <tbody><tr>
									<td class="table_txt03">총입금금액:<b>0원</b></td>
									<td class="table_txt03">ㅣ</td>
									<td class="table_txt03">총충전금액:<b>0원</b></td>
									<td class="table_txt03">ㅣ</td>
									<td class="table_txt03">총환불금액:<b>0원</b></td>
									<td class="table_txt03">ㅣ</td>
									<td class="table_txt03">잔액:<b>0원</b></td>
								  </tr>
								</tbody></table>
							</td>
						  </tr>
						</tbody></table>
					</td>
				</tr>
				<tr>
					<td align="center" style="padding-top:30px;">
						<table width="1100" border="0" cellspacing="0" cellpadding="0">
							<tbody><tr>
								<td align="left" colspan="9">
									<form name="fsearch" action="" method="get">
									<input name="type" type="hidden" value="">
									<table border="0" cellspacing="0" cellpadding="0">
									<tbody><tr>
										<td align="left" colspan="2">
											<table border="0" cellspacing="0" cellpadding="0">
												<tbody><tr>
													<td class="table_txt03"><input name="start_date" class="frm_calendar input_day hasDatepicker" id="start_date" style="text-align:left;width:85px;padding:2px 0 3px 5px;" type="text" value="2020-05-01">~
													<input name="end_date" class="frm_calendar input_day hasDatepicker" id="end_date" style="text-align:left;width:85px;padding:2px 0 3px 5px;" type="text" value="2020-05-01">
													<input class="button06" type="submit" value="검색"></td>
												</tr>
											</tbody></table>
										</td>
									  </tr>
									</tbody></table>
									</form>
								</td>
							</tr>
							<tr>
								<td width="250" align="center" class="table_txt01">날짜</td>
								<td width="250" align="center" class="table_txt01">입금금액(원)</td>
								<td width="250" align="center" class="table_txt01">충전금액(원)</td>
								<td width="250" align="center" class="table_txt01">상태</td>
							</tr>
							<tr><td class="empty_list" colspan="4">자료가 없습니다.</td></tr>                <tr>
								<td align="center" style=" padding: 0 0px 40px 0px;" colspan="4">
									<div style="position:relative;">
										<span style="text-align:left;"></span>
									</div>
								</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

		

    <script type='text/javascript'>
        /* attach a submit handler to the form */
        $("#req_deposit").submit(function(event) {

            /* stop form from submitting normally */
            event.preventDefault();

            /* get the action attribute from the <form action=""> element */
            var $form = $( this ),
                url = $form.attr( 'action' );

            console.log($('#deposit_name').val());
            /* Send the data using post with element id name and name2*/
            var posting = $.post( url, { mb_id: $('#mb_id').val(), deposit_amount: $('#deposit_amount').val(), deposit_name: $('#deposit_name').val() } );

            /* Alerts the results */
            posting.done(function( data ) {
                $('#result').html(data);

            });
        });
    </script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>