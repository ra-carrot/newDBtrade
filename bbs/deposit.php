<?php

include_once('./_common.php');

if(!$is_member) {
    exit;
}

$g5['title'] = $group['gr_subject'];
include_once('./_head.php');

require_once '/var/www/html/comm/Dao.php';
require_once '/var/www/html/common.php';


$dao = new Dao();


$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$today = date("Y-m-d");
//if($is_admin) {
//
//} elseif($is_member) {
//    Header("Location:/bbs/login.php");
//} else{
//    Header("Location:/bbs/login.php");
//}

?>

<head>
	<link rel="StyleSheet" href="../css/bootstrap-datepicker.css?ver=<?php echo G5_CSS_VER ?>" type="text/css" />
	<script src="../js/bootstrap-datepicker.js?ver=<?php echo G5_JS_VER ?>"></script>
	<script src="../js/bootstrap-datepicker.kr.js?ver=<?php echo G5_JS_VER ?>"></script>	
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


    <form id="req_deposit" action="../trade/deposit.php" method="post" enctype="multipart/form-data">
		<div class="tbl_head01 tbl_wrap">
			<table class="text-center">
				<thead>
				<tr class="tbl_head_tr">
					<th scope="cols">아이디</th>
					<th scope="cols">입금자명</th>
					<th scope="cols">입금액</th>
					<th scope="cols">입금방식</th>
					<th scope="cols">입금등록</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" value="<?=$member['mb_id']?>" id="mb_id" name="mb_id" readonly></td>
						<td><input type="text" value="" name="deposit_name" id="deposit_name"></td>
						<td><input type="text" value="" name="deposit_amount" id="deposit_amount"></td>
						<td><input type="radio" value="현금" name="deposit_type" checked>현금<input type="radio" value="급여공제" name="deposit_type">급여공제</td>
						<td><input class="attribution" type="submit" value="입금등록" name="submit"></td>
					</tr>
					<tr>
						<td class="textRight">안내사항</td>
						<td class="textLeft" colspan="3"> · 입금 계좌 :  00은행 000-0000-00000   예금주 : 0 0 0<br></td>
														  <!--· 결번, 중복, 거절 등의 AS비용을 미리 넣어, <span class="txt_red">입금액의 120%를 포인트 충전해드립니다.</span><br> 
														  · 환불 시 남은 금액에서 20%를 제외한 금액을 환불해 드립니다.-->
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-12 textBox">추후에 신용카드 결제도 업데이트 예정입니다.</div>
    </form>

    <div id="result" class="tbl_head01 tbl_wrap">
		<table class= "text-center">
			<tbody>
				<tr>
					<td align="right" colspan="2">
						총입금금액: <b><?=($dao->getTotalInputDeposit($member['mb_id']))?> 원</b> | 총충전금액: <b><?=($dao->getTotalCheckedDeposit($member['mb_id']))?> 원</b> | 잔액 : <b><?php echo number_format($dao->getPoint($member['mb_id']));?> 원</b>
					</td>
				</tr>
				<tr>
					<td ><button class="btn01" onclick="location.href='?type=;'">충전내역</button></td>
					<td ><button class="btn02" onclick="location.href='?type=use;'">사용내역</button></td> 
				</tr>
				<tr>
					<td align="left" colspan="4">
						<form name="fsearch" action="" method="get">
						<input name="type" type="hidden" value="">

						<input name="start_date" class="hasDatepicker" id="start_date" type="text" value="<?=isset($start_date) ? $start_date : $today?>">~
						<input name="end_date" class="hasDatepicker" id="end_date" type="text" value="<?=isset($end_date) ? $end_date : $today?>">
						<input class="btn_cancel" type="submit" value="검색">
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="text-center">
			<tbody>
				<?php

				$req_list = $dao->reqDepositList($member['mb_id']);
						echo '
				<tr>
					<td width="250" align="center" class="">요청날짜</td>
					<td width="250" align="center" class="">요청금액(원)</td>
					<td width="250" align="center" class="">충전금액(원)</td>
					<td width="250" align="center" class="">타입</td>
					<td width="250" align="center" class="">상태</td>
				</tr>';
				if(isset($req_list)){
					foreach($req_list as $req){
						echo '<tr>';
						echo '<td>'.$req['req_time'].'</td>';
						echo '<td>'.number_format($req['req_amount']).'원</td>';

						if(isset($req['check_amount'])){
							echo '<td>'.number_format($req['check_amount']).'원</td>';
							echo '<td>'.$req['deposit_type'].'</td>';
							echo '<td>'.'확인완료</td>';
						}else{
							echo '<td>입금 확인중</td>';
							echo '<td>'.$req['deposit_type'].'</td>';
							echo '<td>'.'입금 확인중</td>';

						}
						echo '</tr>';
					}
				}else {
					?>
					<?php
					echo '<tr><td class="empty_list" colspan="4">자료가 없습니다.</td></tr>';
				}
				?>

					<tr>
						<td align="center" style=" padding: 0 0px 40px 0px;" colspan="4">
							<div style="position:relative;">
								<span style="text-align:left;"></span>
							</div>
						</td>
					</tr>
			</tbody>
		</table>
	</div>

		

    <script type='text/javascript'>
		$('.hasDatepicker').datepicker({
			 format: "yyyy-mm-dd",	//데이터 포맷 형식(yyyy : 년 mm : 월 dd : 일 )
		    startDate: '',	//달력에서 선택 할 수 있는 가장 빠른 날짜. 이전으로는 선택 불가능 ( d : 일 m : 달 y : 년 w : 주)
		    endDate: '',	//달력에서 선택 할 수 있는 가장 느린 날짜. 이후로 선택 불가 ( d : 일 m : 달 y : 년 w : 주)
		    autoclose : true,	//사용자가 날짜를 클릭하면 자동 캘린더가 닫히는 옵션
		    calendarWeeks : false, //캘린더 옆에 몇 주차인지 보여주는 옵션 기본값 false 보여주려면 true
		    clearBtn : false, //날짜 선택한 값 초기화 해주는 버튼 보여주는 옵션 기본값 false 보여주려면 true
		    datesDisabled : [],//선택 불가능한 일 설정 하는 배열 위에 있는 format 과 형식이 같아야함.
		    daysOfWeekDisabled : [],	//선택 불가능한 요일 설정 0 : 일요일 ~ 6 : 토요일
		    daysOfWeekHighlighted : [], //강조 되어야 하는 요일 설정
		    disableTouchKeyboard : false,	//모바일에서 플러그인 작동 여부 기본값 false 가 작동 true가 작동 안함.
		    immediateUpdates: false,	//사용자가 보는 화면으로 바로바로 날짜를 변경할지 여부 기본값 :false 
		    multidate : false, //여러 날짜 선택할 수 있게 하는 옵션 기본값 :false 
		    multidateSeparator :",", //여러 날짜를 선택했을 때 사이에 나타나는 글짜 2019-05-01,2019-06-01
		    templates : {
		        leftArrow: '&laquo;',
		        rightArrow: '&raquo;'
		    }, //다음달 이전달로 넘어가는 화살표 모양 커스텀 마이징 
		    showWeekDays : true ,// 위에 요일 보여주는 옵션 기본값 : true
		    title: '',	//캘린더 상단에 보여주는 타이틀
		    todayHighlight : true ,	//오늘 날짜에 하이라이팅 기능 기본값 :false 
		    toggleActive : false,	//이미 선택된 날짜 선택하면 기본값 : false인경우 그대로 유지 true인 경우 날짜 삭제
		    weekStart : 0 ,//달력 시작 요일 선택하는 것 기본값은 0인 일요일 
		    language : "kr"	//달력의 언어 선택, 그에 맞는 js로 교체해줘야한다
		}).on("changeDate", function(e){
			$(this).attr("value",$(this).val());
		});


        /* attach a submit handler to the form */
        $("#req_deposit").submit(function(event) {

            /* stop form from submitting normally */
            event.preventDefault();

            /* get the action attribute from the <form action=""> element */
            var $form = $( this ),
                url = $form.attr( 'action' );

            console.log($('#deposit_name').val());
            /* Send the data using post with element id name and name2*/
            var posting = $.post( url, { mb_id: $('#mb_id').val(), deposit_amount: $('#deposit_amount').val().replace(/,/gi,""), deposit_name: $('#deposit_name').val(), deposit_type: $('input[name="deposit_type"]:checked').val()} );

            /* Alerts the results */
            posting.done(function( data ) {
				console.log(data);
				alert(data);
				
				if(data == "정상 신청되었습니다.") window.location.reload();
				//$('#result').html(data);

            });
        });
		$('#deposit_amount').on("keyup", function(){
			var nTemp  = $(this).val();
			nTemp = nTemp.replace(/,/gi,"");
			nTemp = nTemp.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$(this).val(nTemp)
		});
    </script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>