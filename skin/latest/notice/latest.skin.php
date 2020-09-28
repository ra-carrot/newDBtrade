<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="lat">
    <h2 class="lat_title"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h2>
	 <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tbl_head01 tbl_wrap">
			<table class="text-center">
				<thead>
				<tr class="tbl_head_tr">
					<th style="width: 70px;" scope="cols">등록일</th>
					<th style="width: 90px;" scope="cols">카테고리</th>
					<th style="width: 110px;" scope="cols">작성자</th>
					<th scope="cols">제목</th>
					<th style="width: 50px;" scope="cols">조회</th>

				</tr>
				</thead>
				<tbody>
					<?php for ($i=0; $i<$list_count; $i++) {  
						echo '<tr>';
						echo '<td class="height_35">'.$list[$i]['datetime2'].'</td>';
						echo '<td class="height_35">'.$list[$i]['ca_name'].'</td>';
						echo '<td class="height_35">'.$list[$i]['name'].'</td>';
						echo '<td class="height_35"><a href='.$list[$i][href].'>'.$list[$i]['subject'].'</td>';
						echo '<td class="height_35">'.$list[$i]['wr_hit'].'</td>';
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
        </div>
    </div>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>

    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more"><span class="sound_only"><?php echo $bo_subject ?></span>전체보기</a>

</div>
