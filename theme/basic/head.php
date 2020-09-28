<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//if (G5_IS_MOBILE) {
//    include_once(G5_THEME_MOBILE_PATH.'/head.php');
//    return;
//}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

require_once '/var/www/html/comm/Dao.php';
require_once '/var/www/html/common.php';

use eftec\PdoOne;

if($member[mb_id])
{
    $checktime = mktime(date("H"),date("i")-30,date("s"),date("m"),date("d"),date("Y")); // 시간지정
    if($_SESSION['ss_login_time'] && ($_SESSION['ss_login_time'] < $checktime)) {
        // 페이지를 연 시점이 되어있고, 저장된 시간이 특정시간 이전일때
        goto_url(G5_BBS_URL.'/logout.php');
    } else {
        // 로그인 타임(페이지를 연 시간)이 없거나, 특정시간을 넘기지 않은 경우는 시간재저장
        $login_time = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")); // 현재시간 저장
        set_session("ss_login_time", $login_time);
    }
}
?>


<!-- 상단 시작 { -->
<div id="hd">
	<div class="ulBack"></div>
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb">
    	<div class="inner">
			<ul id="hd_qnb">
			<!--
	            <li><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></li>
	            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">Q&A</a></li>
	            <li><a href="<?php echo G5_BBS_URL ?>/new.php">새글</a></li>
	            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php" class="visit">접속자<strong class="visit-num"><?php echo connect('theme/basic'); // 현재 접속자수, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?></strong></a></li>
				-->
	        </ul>
		</div>
    </div>
    <div id="hd_wrapper">

        <div id="" >
            <a style="font-size: 35px;" class="gnb_1da" href="<?php echo G5_URL ?>"><img src="" alt="">메인</a>
            <!--<a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo1.png" alt="<?php echo $config['cf_title']; ?>"></a>-->
        </div>
		<ul id="gnb_1dul">
			
			<?php
			$menu_datas = get_menu_db(0, true);
			$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
			$i = 0;
			foreach( $menu_datas as $row ){
				if( empty($row) ) continue;
				$add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
			?>
			<li class="gnb_1dli <?php echo $add_class; ?>" style="z-index:<?php echo $gnb_zindex--; ?>">
				<a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
				<?php
				$k = 0;
				foreach( (array) $row['sub'] as $row2 ){

					if( empty($row2) ) continue;

					if($k == 0)
						echo '<span class="bg">하위분류</span><div class="gnb_2dul"><ul class="gnb_2dul_box">'.PHP_EOL;
				?>
					<li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
				<?php
				$k++;
				}   //end foreach $row2

				if($k > 0)
					echo '</ul></div>'.PHP_EOL;
				?>
			</li>
			<?php
			$i++;
			}   //end foreach $row

			if ($i == 0) {  ?>
				<li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
			<?php } ?>
		</ul>
		<div id="gnb_all_bg"></div>
		
        <ul class="hd_login">        
            <?php if ($is_member) {
                $dao = new Dao();
                $point = $dao->getPoint($member['mb_id']);
                ?>

           <!-- <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>  -->
		    <li class="gnb_text"><a><?php echo $member[mb_1] ?></a></li>
		    <li class="gnb_text"><a><?php echo $member[mb_2] ?></a></li>
            <li class="gnb_text"><a><?php echo $member[mb_name] ?></a></li>
			<li class="gnb_text gnb_point"><a>포인트 : </a> <a href="https://globaldbtrade.co.kr/bbs/deposit.php"><?php echo number_format($point).' '?>P</a></li>
			<li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php">회원정보변경</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php if ($is_admin) {  ?>
            <li class="tnb_admin"><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a></li>
                    <li class="tnb_admin"><a href="<?php echo 'https://globaldbtrade.co.kr/bbs/board_req_amount_list.php'; ?>">입금자신청관리</a></li>
                    <li class="tnb_admin"><a href="<?php echo 'https://globaldbtrade.co.kr/bbs/board_sell_manage_list.php'; ?>">배정관리</a></li>
            <?php }  ?>
            <?php } else {  ?>
           <!-- <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>  -->
            <li><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
            <?php }  ?>

        </ul>
		
    </div>
	
	<?php include_once(G5_THEME_PATH.'/skin/banner/basic/banner.php');?>
    <script>
    
    $(function(){
        $(".gnb_menu_btn").click(function(){
            $("#gnb_all, #gnb_all_bg").show();
        });
        $(".gnb_close_btn, #gnb_all_bg").click(function(){
            $("#gnb_all, #gnb_all_bg").hide();
        });
    });

    </script>
</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
