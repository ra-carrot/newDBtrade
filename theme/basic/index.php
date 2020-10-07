<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//if (G5_IS_MOBILE) {
//    include_once(G5_THEME_MOBILE_PATH.'/index.php');
//    return;
//}

include_once(G5_THEME_PATH.'/head.php');


if($is_admin) {

} elseif($is_member) {



} else{

    header("Location:/bbs/login.php");
}
?>
    
    <!--<h2 class="sound_only">최신글</h2>-->

    <style>
        /* 떠다니는 배너 (Floating Menu) */
        #floatdiv {
            position:fixed; _position:absolute; _z-index:-1;
            width:220px; /* 가로폭 조절*/
            overflow:hidden;
            right:50%;
            top:27%; /* 이미지 높이 조절 */
            background-color: transparent;
            margin-right: -600px; /* 좌우측 여백 조절 */
            padding:0;
        }#floatdiv ul  { list-style: none; }
        #floatdiv li  { margin-bottom: 2px; text-align: center; }
        #floatdiv a  {padding: 10px; color: #5D5D5D; border: 0; text-decoration: none; display: block; }
        #floatdiv a:hover, #floatdiv .menu  { background-color: #5D5D5D; color: #fff; }
        #floatdiv .menu, #floatdiv .last    { margin-bottom: 0px; }
		
    </style>

<div class="grid">
    <div class="row">
        <!-- 성공후기 -->
		<div  class="latest_top_wr">
			<div>
				<div class="lat latLink lat_1">
					<a class="linkBtn" href="https://globaldbtrade.co.kr/bbs/board_sell_list.php"></a>
				</div>
				<div class="lat latLink lat_2">
					<a class="linkBtn" href="https://globaldbtrade.co.kr/bbs/board_request_list.php"></a>
				</div>
				<div class="lat latLink lat_3">
					<a class="linkBtn" href="https://globaldbtrade.co.kr/bbs/board_sell_my_list.php"></a>
				</div>
				<div class="bar"></div>
			</div>
			<div>
				<div class="lat latLink lat_4">
					<a class="linkBtn" href="https://globaldbtrade.co.kr/bbs/deposit.php"></a>
				</div>
				<div class="lat latLink lat_5">
					<a class="linkBtn" href="https://globaldbtrade.co.kr/bbs/board.php?bo_table=notice"></a>
				</div>			
				<div class="lat latLink lat_6">
					<a class="linkBtn" href="https://globaldbtrade.co.kr/bbs/board.php?bo_table=notice"></a>
				</div>
				<div class="bar"></div>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-1">
			<!--<div class="col-12 textBox">사용후기, 성공사례, 노하우등 공유하고 보너스 받아요^^</div>-->
			<?php echo latest("basic", review_success, 5, 50);?>
        </div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-1">
			<!--<div class="col-12 textBox">사용후기, 성공사례, 노하우등 공유하고 보너스 받아요^^</div>-->
			<?php echo latest("notice", notice, 5, 50);?>
        </div>
		
    </div>
	<div class="row" style="padding-top:10px;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-10">
			<div class="lat">
				<h2 class="lat_title"><a href="https://globaldbtrade.co.kr/bbs/board_sell_list.php" >신청자현황</a></h2>
				<!--<a class="lt_more" href="https://globaldbtrade.co.kr/bbs/board_sell_list.php"><span class="sound_only">신청자현황</span>더보기</a>-->
				<div class="tbl_head03 tbl_wrap">
					<table class="text-center">
						<thead>
						<tr class="tbl_head_tr">
							<th scope="cols">번호</th>
							<th scope="cols">캠페인명</th>
							<th scope="cols">신청일</th>
							<th scope="cols">고객이름</th>
							<th scope="cols">생년월일</th>
							<th scope="cols">연락처</th>
							<th scope="cols">지역</th>
							<th scope="cols">방문요청일</th>
							<th scope="cols">요청사항</th>
							<th scope="cols">공급가격</th>
							<th scope="cols">상태</th>
							<th scope="cols">배정받기</th>
						</tr>
						</thead>
						<tbody>
							<?php
							$d = new Dao();
							$i=0;

							foreach ($d->getCustomers() as $key => $value) {
								if ($i % 2 === 0)
									echo '<tr>';
								else
									echo '<tr bgcolor="#f2f2f2">';

								$i = $i + 1;
								if($i > 10) break;
								if($member["mb_id"] != $value['allocate_fc_id'])
								{
									$value['birth'] = substr($value['birth'], 2, 2)."****";
									$value['contact'] = substr($value['contact'], 0, 6)."**-****";
								}
								$pTime = strtotime(date("Y-m-d")) - strtotime($value['req_date']);
													
								$value['price'] = $value['price'] - ( 1000 * ceil($pTime/ (60*60*24))) ;
								$value['price'] = $value['price'] <= 1000 ? 1000 : $value['price'];
								echo '<td>' . ($i) . '</td>';
								echo '<td>' . "캠페인" . '</td>';
								echo '<td>' . (substr($value['req_date'],0,-9)) . '</td>';
								echo '<td>' . ($value['name']).($value['sex'] == 0 ? "(여)" : "(남)"). '</td>';
								echo '<td>' . ($value['birth']) . '</td>';
								echo '<td>' . ($value['contact']) . '</td>';
								echo '<td>' . "지역" . '</td>';
								echo '<td>' . ($value['req_visit_date']) . '</td>';
								echo '<td>' . ($value['consult']) . '</td>';
								echo '<td>' . (number_format($value['price'])) . '</td>';
								echo '<td>' . '<div id="result' . $key . '">' . ($value['status'] == 1 ? "배정완료" : "배정대기") . '</div></td>';
								if ($value['status'] == 1) {
									echo '<td>' . $value['allocate_fc_id'] . '</td>';
								} else {
									echo '<td>';
									echo '<form id="req_deposit_' . $key . '" action="https://www.globaldbtrade.co.kr/trade/allocate.php" method="post" enctype="multipart/form-data">';
									echo '<input id="btn_allocate_' . $key . '" type="submit" class="attribution" value=" 배정받기 "/>';
									echo '</form>';
									echo '</td>';
								}
								echo '</tr>';
								echo '<tr>';
								echo '</tr>';	

							



								/**
                                 * ajax 로
                                 * 요청 -> 포인트 검사 -> OK -> 배정 여부 -> NO -> 배정 -> 완료 -> 포인트 감소 -> OK
                                 * 넘길건 없지
                                 * 받은 곳에서 mb_id 를 체크해야지
                                 */
								?>

                                <script type='text/javascript'>
                                    /* attach a submit handler to the form */
                                    $("#req_deposit_<?=$key?>").submit(function(event) {
                                        console.log(<?=$key?>);
                                        event.preventDefault();
                                        /* get the action attribute from the <form action=""> element */
                                        var $form = $( this ),
                                            url = $form.attr( 'action' );
                                        // console.log($('#mb_id').val());
                                        /* Send the data using post with element id name and name2*/
                                        var posting = $.post( url, {
                                            customer_id: '<?=$value["id"]?>',
                                            mb_id: '<?=$member["mb_id"]?>'

                                        } );
                                        $('#btn_allocate_<?=$key?>').css("display", "none");

                                        /* Alerts the results */
                                        posting.done(function( data ) {
                                            console.log(data);
                                            var result = JSON.parse(data);
                                            console.log(result.error);
                                            console.log(result.message);
                                            if(result.error === 200){//정상
                                                console.log('error 200');
                                                $('#result<?=$key?>').html(result.message);
                                            }else{
                                                $('#btn_allocate_<?=$key?>').css("display", "block");
                                            }
                                            if(result.error === 301){//포인트 없음
                                                $('#result<?=$key?>').html(result.message);
                                            }
                                            if(result.error === 302){//이미 배정받음
                                                $('#result<?=$key?>').html(result.message);
                                            }
                                        });
                                    });
                                </script>

                                <?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
</div>






<?php
include_once(G5_THEME_PATH.'/tail.php');
?>