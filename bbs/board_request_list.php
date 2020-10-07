<?php
include_once('./_common.php');
if ($is_member == false) {
    Header("Location:/bbs/login.php");
    exit;
}
include_once(G5_THEME_PATH . '/head.php');
$ca_id = 10;
$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
$ca = sql_fetch($sql);

if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
    $ca['ca_skin']       = (isset($tconfig['ca_skin']) && $tconfig['ca_skin']) ? $tconfig['ca_skin'] : $ca['ca_skin'];
    $ca['ca_img_width']  = (isset($tconfig['ca_img_width']) && $tconfig['ca_img_width']) ? $tconfig['ca_img_width'] : $ca['ca_img_width'];
    $ca['ca_img_height'] = (isset($tconfig['ca_img_height']) && $tconfig['ca_img_height']) ? $tconfig['ca_img_height'] : $ca['ca_img_height'];
    $ca['ca_list_mod']   = (isset($tconfig['ca_list_mod']) && $tconfig['ca_list_mod']) ? $tconfig['ca_list_mod'] : $ca['ca_list_mod'];
    $ca['ca_list_row']   = (isset($tconfig['ca_list_row']) && $tconfig['ca_list_row']) ? $tconfig['ca_list_row'] : $ca['ca_list_row'];
}
$skin_dir = G5_SHOP_SKIN_PATH;	

if($ca['ca_skin_dir']) {
    if(preg_match('#^theme/(.+)$#', $ca['ca_skin_dir'], $match))
        $skin_dir = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_skin_dir'];

    if(is_dir($skin_dir)) {
        $skin_file = $skin_dir.'/'.$ca['ca_skin'];

        if(!is_file($skin_file))
            $skin_dir = G5_SHOP_SKIN_PATH;
    } else {
        $skin_dir = G5_SHOP_SKIN_PATH;
    }
}


if ($is_admin)
    echo '<div class="sct_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/categoryform.php?w=u&amp;ca_id='.$ca_id.'" class="btn_admin btn"><span class="sound_only">분류 관리</span><i class="fa fa-cog fa-spin fa-fw"></i></a></div>';


?>

<h2 id="container_title"><span title="DB공급현황">DB신청하기</span></h2>
<style>
	
</style>
<!--<div class="popLink"><a  href='#' onClick="window.open('https://docs.google.com/forms/d/e/1FAIpQLSf2EbdnMerPVqytlqKeAVDF4UOYYX9hxYXZV86jBpkcLR1Gsg/viewform?embedded=true', '_blank', 'resizable=no scrollbars=yes width=700 height=800 left=100 top=200')">보험료줄이기캠페인DB 신청 (7월)</a></div>
<div class="popLink"><a  href='#' onClick="window.open('https://docs.google.com/forms/d/e/1FAIpQLScIPV3DnjzOHy6Ln6pySkyDJyooMQxJsnYhXzDXgLRJPCw73A/viewform?embedded=true', '_blank', 'resizable=no scrollbars=yes width=700 height=800 left=200 top=200')">숨은보험금찾기 DB 신청 (7월)</a></div>
<div class="popLink"><a  href='#' onClick="window.open('https://docs.google.com/forms/d/e/1FAIpQLScIPV3DnjzOHy6Ln6pySkyDJyooMQxJsnYhXzDXgLRJPCw73A/viewform?embedded=true', '_blank', 'resizable=no scrollbars=yes width=700 height=800 left=300 top=200')">숨은보험금찾기 DB 신청 (7월)</a></div>-->

<div>
<?php
 $skin_file = is_include_path_check($skin_dir.'/'.$ca['ca_skin']) ? $skin_dir.'/'.$ca['ca_skin'] : $skin_dir.'/list.10.skin.php';
if (file_exists($skin_file)) {

	// 총몇개 = 한줄에 몇개 * 몇줄
	$items = $ca['ca_list_mod'] * $ca['ca_list_row'];
	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;
	// 시작 레코드 구함
	$from_record = ($page - 1) * $items;

	$list = new item_list($skin_file, $ca['ca_list_mod'], $ca['ca_list_row'], $ca['ca_img_width'], $ca['ca_img_height']);
	$list->set_category($ca['ca_id'], 1);
	$list->set_category($ca['ca_id'], 2);
	$list->set_category($ca['ca_id'], 3);
	$list->set_is_page(true);
	$list->set_order_by($order_by);
	$list->set_from_record($from_record);
	$list->set_view('it_img', true);
	$list->set_view('it_id', false);
	$list->set_view('it_name', true);
	$list->set_view('it_basic', false);
	$list->set_view('it_cust_price', false);
	$list->set_view('it_price', false);
	$list->set_view('it_icon', false);
	$list->set_href("33");
	$list->set_view('sns', false);
	echo $list->run();

	// where 된 전체 상품수
	$total_count = $list->total_count;
	// 전체 페이지 계산
	$total_page  = ceil($total_count / $items);
}
?>
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');

?>

