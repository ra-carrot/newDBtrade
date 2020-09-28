<?php
include_once('./_common.php');
if ($is_member == false) {
    Header("Location:/bbs/login.php");
    exit;
}

//echo $start_date;

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$assign = $_GET['assign'];
$sex = $_GET['sex'];
$orderby = $_GET['orderby'];
$sido = $_GET['sido'];
$filter = $_GET['filter'];
$today = date("Y-m-d");
$page = $_GET['page'];

include_once(G5_THEME_PATH . '/head.php');

//$pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1" ;
//		$filter = $_GET["filter"]!= NULL ? $_GET["filter"] : "" ;
//		$search = $_GET["search"]!= NULL ? $_GET["search"] : "" ;
//
//		$postvars = array('pass'=>'kiosk', 'req'=>'ins_req_list', 'memberId'=>$member['mb_id'],'id'=>$member['mb_id'], 'insureId'=>$member['INSUREID'], 'level'=>$member['mb_level'], 'requestPageNo'=>$pageNum, 'filter'=>$filter, 'search'=>$search	);
//
//		$header = array();
//		$header[] = 'Content-Type: Application/json';
//
//		$url = 'https://kiosk.tsellitech.com/member_index.php';
//		$http = curl_init();
//		curl_setopt($http, CURLOPT_URL, $url);
//		curl_setopt($http, CURLOPT_POST, 1);
//        curl_setopt($http, CURLOPT_POSTFIELDS, $postvars);
//
//
//		curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
//
//
//		$responseJson = curl_exec($http);
//		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
//		$requestList = json_decode($responseJson);
//		//$maxNum = json_decode($responseJson)->pageNoLimit;
//		echo "<script>console.log('$responseJson');</script>";
//
//		$s_page = 1;
//		$e_page = 10;
//		//var_dump($responseJson);
//		//var_dump($requestList);
//		//var_dump($requestList);
//		curl_close($http);

?>

<h2 id="container_title"><span title="DB공급현황">DB공급현황</span></h2>
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


	.btn {
		text-decoration: none;
		font-size: 2rem;
		color: white;
		padding: 10px 20px 10px 20px;
		margin: 20px;
		display: inline-block;
		border-radius: 10px;
		transition: all 0.1s;
		text-shadow: 0px -2px rgba(0, 0, 0, 0.44);
		font-family: 'Lobster', cursive;
	}

	.btn:active {
		transform: translateY(3px);
	}

	.btn.blue {
		background-color: #1f75d9;
		border-bottom: 5px solid #165195;
	}

	.btn.blue:active {
		border-bottom: 2px solid #165195;
	}

	.btn.red {
		background-color: #ff521e;
		border-bottom: 5px solid #c1370e;
	}

	.btn.red:active {
		border-bottom: 2px solid #c1370e;
	}

	.text-center {
		text-align: center;
	}
</style>
<div>
	<form id="sortForm">
        <select name="filter" onchange="this.form.submit();">
            <option value="" <?php if ($filter == "") echo "SELECTED"; ?>>캠페인명</option>
            <option value="기계약-퍼미션" <?php if ($filter == "기계약-퍼미션") echo "SELECTED"; ?>>기계약 퍼미션</option>
            <option value="산모교실-퍼미션" <?php if ($filter == "산모교실-퍼미션") echo "SELECTED"; ?>>산모교실 퍼미션</option>
            <option value="SNS재무-상담" <?php if ($filter == "SNS재무-상담") echo "SELECTED"; ?>>SNS재무 상담</option>
			<option value="보험금청구" <?php if ($filter == "보험금청구") echo "SELECTED"; ?>>보험금청구</option>
        </select>
		<span style="float:right;">
			<span class="">
				<input name="assign" type="radio" onchange="this.form.submit();" value="" <?php if ($assign == "") echo "checked"; ?>>전체</input>
				<input name="assign" type="radio" onchange="this.form.submit();" value="배정"  <?php if ($assign == "배정") echo "checked"; ?>>배정</input>
				<input name="assign" type="radio" onchange="this.form.submit();" value="미배정" <?php if ($assign == "미배정") echo "checked"; ?>>미배정</input>
			</span>
			<select name="sido">
				<option value="" <?php if ($sido == "") echo "SELECTED"; ?>>시/도</option>
				<option value="강원도" <?php if ($sido == "강원도") echo "SELECTED"; ?>>강원도</option>
				<option value="경기도" <?php if ($sido == "경기도") echo "SELECTED"; ?>>경기도</option>
				<option value="경상남도" <?php if ($sido == "경상남도") echo "SELECTED"; ?>>경상남도</option>
				<option value="경상북도" <?php if ($sido == "경상북도") echo "SELECTED"; ?>>경상북도</option>
				<option value="광주광역시" <?php if ($sido == "광주광역시") echo "SELECTED"; ?>>광주광역시</option>
				<option value="대구광역시" <?php if ($sido == "대구광역시") echo "SELECTED"; ?>>대구광역시</option>
				<option value="대전광역시" <?php if ($sido == "대전광역시") echo "SELECTED"; ?>>대전광역시</option>
				<option value="부산광역시" <?php if ($sido == "부산광역시") echo "SELECTED"; ?>>부산광역시</option>
				<option value="서울특별시" <?php if ($sido == "서울특별시") echo "SELECTED"; ?>>서울특별시</option>
				<option value="세종특별자치시" <?php if ($sido == "세종특별자치시") echo "SELECTED"; ?>>세종특별자치시</option>
				<option value="울산광역시" <?php if ($sido == "울산광역시") echo "SELECTED"; ?>>울산광역시</option>
				<option value="인천광역시" <?php if ($sido == "인천광역시") echo "SELECTED"; ?>>인천광역시</option>
				<option value="전라남도" <?php if ($sido == "전라남도") echo "SELECTED"; ?>>전라남도</option>
				<option value="전라북도" <?php if ($sido == "전라북도") echo "SELECTED"; ?>>전라북도</option>
				<option value="제주특별자치도" <?php if ($sido == "제주특별자치도") echo "SELECTED"; ?>>제주특별자치도</option>
				<option value="충청남도" <?php if ($sido == "충청남도") echo "SELECTED"; ?>>충청남도</option>
				<option value="충청북도" <?php if ($sido == "충청북도") echo "SELECTED"; ?>>충청북도</option>
			</select>
			
			<span class="">
				<input name="sex"type="radio" value="남자" <?php if ($sex == "남자") echo "checked"; ?>>남자</input>
				<input name="sex"type="radio" value="여자" <?php if ($sex == "여자") echo "checked"; ?>>여자</input>
			</span>
			방문요청일
			<input name="start_date" class="hasDatepicker" id="start_date" type="text" value="<?=isset($start_date) ? $start_date : ""?>">~
			<input name="end_date" class="hasDatepicker" id="end_date" type="text" value="<?=isset($end_date) ? $end_date : ""?>">
			<input id="orderby" name="orderby" type="hidden" value="<?=isset($orderby) ? $orderby : ""?>">
			
			<input class="btn_cancel" type="submit" value="검색">
		</span>
	</form>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tbl_head01 tbl_wrap">
    <table class="text-center">
        <thead>
        <tr class="tbl_head_tr">
            <th scope="cols">고객 번호</th>
			<th scope="cols">캠페인명</th>
			<th scope="cols"><span onClick="sortFormSubmit(this)" class="sortList">신청일</span></th>
            <th scope="cols">고객이름(성별)</th>
            <th scope="cols"><span onClick="sortFormSubmit(this)" class="sortList">생년월일</span></th>
            <th scope="cols">연락처</th>
			<th scope="cols">지역</th>
            <th scope="cols"><span onClick="sortFormSubmit(this)" class="sortList">방문요청일</span></th>
            <!--<th scope="cols">요청사항</th>-->
            <th scope="cols"><span onClick="sortFormSubmit(this)" class="sortList">공급가격</span></th>
            <th scope="cols">상태</th>
			<?php
            echo '<th scope="cols">배정받기</th>';
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $d = new Dao();
		$page_per = $d->getCustomersTotalPage();
		$data = $d->getCustomers();
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i % 2 === 0)
                echo '<tr>';
            else
                echo '<tr bgcolor="#f2f2f2">';

            $i = $i + 1;

			$pTime = strtotime(date("Y-m-d")) - strtotime($value['req_date']);
								
			$value['price'] = $value['price'] - ( 1000 * ceil($pTime/ (60*60*24))) ;
			$value['price'] = $value['price'] <= 1000 ? 1000 : $value['price'];

            if($member["mb_id"] != $value['allocate_fc_id'])
            {
                $value['birth'] = substr($value['birth'], 2, 2)."****";
                $value['contact'] = substr($value['contact'], 0, 6)."**-****";
            }

            if($value['allocate_fc_id'] != null && $value['allocate_fc_id'] != "" ){
                $value['price'] = $value['allocate_price'];
            }


            echo '<td>' . ((($page == null ? 1 : $page)-1)*20 + $i) . '</td>';
			echo '<td>' .  $value['campaign']. '</td>';
			echo '<td>' . (substr($value['req_date'], 0, -9)) . '</td>';
            echo '<td>' . ($value['name']).($value['sex'] == 0 ? "(여)" : "(남)"). '</td>';
            echo '<td>' . ($value['birth']) . '</td>';
            echo '<td>' . ($value['contact']) . '</td>';
            echo '<td>' . ($value['location']) . '</td>';
            echo '<td>' . (substr($value['req_visit_date'],0,-9)) . '</td>';
            //echo '<td>' . ($value['consult']) . '</td>';
            if ($is_admin && $value['status'] != 1) {
                echo '<td><input class="listInput" id="price' . $key . '" value="' . ($value['price']) . '"></td>';
            } else {
                echo '<td>' . (number_format($value['price'])) . '</td>';
            }
			echo '<td>' . '<div id="result' . $key . '">' . ($value['status'] == 1 ? "배정완료" : "배정대기") . '</div></td>';
            if ($value['status'] == 1) {
                echo '<td>' . $value['allocate_fc_id'] . '</td>';
            } else {
                echo '<td>';
                echo '<form id="req_deposit_' . $key . '" action="https://www.globaldbtrade.co.kr/trade/allocate.php" method="post" enctype="multipart/form-data">';
                echo '<input id="btn_allocate_' . $key . '" type="submit" class="attribution" value=" 배정받기 "/>';
                echo '</form>';
                if ($is_admin) {
                    echo '<form id="req_price_edit_' . $key . '" action="https://www.globaldbtrade.co.kr/trade/manage_price.php" method="post" enctype="multipart/form-data">';
                    echo '<input id="btn_price_edit_' . $key . '" type="submit" class="attriBlueButton" value=" 가격수정 "/>';
                    echo '</form>';
                }
                echo '</td>';
            }
            echo '</tr>';
            echo '<tr>';
            echo '</tr>';
            ?>
            <script type='text/javascript'>
				function sortFormSubmit(_this){
					$("#sortForm").find("#orderby").val($(_this).html());
					$("#sortForm").submit();
				}
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
                $("#req_price_edit_<?=$key?>").submit(function (event) {
                    console.log('price change <?=$key?>');
                    console.log('new price:  ' + $("#price<?=$key?>").val());
                    event.preventDefault();
                    /* get the action attribute from the <form action=""> element */
					
					
					var $form = $(this),
					url = $form.attr('action');
					// console.log($('#mb_id').val());
					/* Send the data using post with element id name and name2*/
					var posting = $.post(url, {
						customer_id: '<?=$value["id"]?>',
						mb_id: '<?=$member["mb_id"]?>',
						price: $("#price<?=$key?>").val()


					});
					$('#btn_price_edit_<?=$key?>').css("display", "none");

					/* Alerts the results */
					try {
						posting.done(function (data) {

							console.log(data);
							var result = JSON.parse(data);
							console.log(result.error);
							console.log(result.message);
							$('#btn_price_edit_<?=$key?>').css("display", "");
							if (result.error === 200) {//정상
								console.log('error 200');
								$('#price<?=$key?>').html(result.message);
							} else {
								//업데이트 실패
								$('#price<?=$key?>').html(<?=$value['price']?>);
							}
						});
					} catch (e) {
						$('#btn_price_edit_<?=$key?>').css("display", "");
						$('#result<?=$key?>').html('err');
					}                    
                });


                $("#req_deposit_<?=$key?>").submit(function (event) {
                    console.log(<?=$key?>);
                    event.preventDefault();
					if(confirm('고객이름: ' + '<?=$value["name"]?>' + ' / 방문요청일: ' + '<?=$value["req_visit_date"]?>' +  ' / 가격: ' + '<?=$value["price"]?>'  + "\n배정받으시겠습니까?")){
						/* get the action attribute from the <form action=""> element */
						var $form = $(this),
							url = $form.attr('action');
						// console.log($('#mb_id').val());
						/* Send the data using post with element id name and name2*/
						var posting = $.post(url, {
							customer_id: '<?=$value["id"]?>',
							mb_id: '<?=$member["mb_id"]?>'

						});
						$('#btn_allocate_<?=$key?>').css("display", "none");

						/* Alerts the results */
						posting.done(function (data) {
							console.log(data);
							var result = JSON.parse(data);
							console.log(result.error);
							console.log(result.message);
							if (result.error === 200) {//정상
								console.log('error 200');
								$('#result<?=$key?>').html(result.message);
							} else {
								$('#btn_allocate_<?=$key?>').css("display", "");
							}
							if (result.error === 301) {//포인트 없음
								$('#result<?=$key?>').html(result.message);
							}
							if (result.error === 302) {//이미 배정받음
								$('#result<?=$key?>').html(result.message);
							}
						});
					}
					else{
		
					}
                    
                });
            </script>

            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<!--<nav class="pg_wrap"><span class="pg"><a class="pg_page pg_start" href="">처음</a>
<a class="pg_page" href="">1<span class="sound_only">페이지</span></a>
<a class="pg_page" href="">2<span class="sound_only">페이지</span></a>
<span class="sound_only">열린</span><strong class="pg_current">3</strong><span class="sound_only">페이지</span>
<a class="pg_page" href="">4<span class="sound_only">페이지</span></a>
<a class="pg_page" href="">5<span class="sound_only">페이지</span></a>
<a class="pg_page" href="">6<span class="sound_only">페이지</span></a>
<a class="pg_page" href="">7<span class="sound_only">페이지</span></a>
<a class="pg_page" href="">8<span class="sound_only">페이지</span></a>
<a class="pg_page" href="">9<span class="sound_only">페이지</span></a>
<a class="pg_page pg_end" href="">맨끝</a>
</span></nav>-->

<?php 
	$pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1" ;
//    echo "<script>console.log('Debug Objects: " . $page_per . "' );</script>";
	echo get_paging(10, $pageNum, $page_per, "https://globaldbtrade.co.kr/bbs/board_sell_list.php?");
?>

<?php
include_once(G5_THEME_PATH . '/tail.php');

?>

