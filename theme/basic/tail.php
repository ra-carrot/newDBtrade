<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>

 
 


</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<div id="ft">
    <!--<div id="ft_catch"><img src="<?php echo G5_IMG_URL; ?>/ft_logo.png" alt="<?php echo G5_VERSION ?>"></div>-->
    <div id="ft_company" class="ft_cnt">
		<div class="ft_info">
			회사명 : 회사명 / 대표 : 대표자명 | 주소  : OO도 OO시 OO구 OO동 123-45 | 사업자 등록번호  : 123-45-67890<br>
			전화 :  02-123-4567  팩스  : 02-123-4568 | 통신판매업신고번호 :  제 OO구 - 123호 |	개인정보관리책임자 :  정보책임자명
		</div>
	</div>
	
    <div id="ft_copy">Copyright &copy; <b>globaldbtrade</b> All rights reserved.</div>
    <button type="button" id="top_btn">
    	<i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span>
    </button>
    <script>
    $(function() {
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
    });
    </script>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>