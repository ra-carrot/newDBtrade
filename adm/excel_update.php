<?php

$sub_menu = "200900";
include_once('./_common.php');
auth_check($auth[$sub_menu], 'r');


$g5['title'] = '회원업데이트';
include_once ('./admin.head.php');
?>

<form id="file_upload_test" class="upload_test" method="post" enctype="multipart/form-data" action="./save_file.php">
    	<input type="file" id="excel_upload" name="excel_upload" class="" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
    	<input type="submit" name="upload_btn" class="" value="업로드">
</form>

<?php
include_once ('./admin.tail.php');
?>
