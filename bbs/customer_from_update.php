<?php
include_once('./_common.php');
include_once('../comm/Dao.php');

$d = new Dao();

$mb_id = htmlspecialchars($_POST['mb_id'], ENT_QUOTES, 'UTF-8');
$mb_campaign = htmlspecialchars($_POST['mb_campaign'], ENT_QUOTES, 'UTF-8');
$mb_date = htmlspecialchars($_POST['mb_date'], ENT_QUOTES, 'UTF-8'); // 신청일
$mb_name = htmlspecialchars($_POST['mb_name'], ENT_QUOTES, 'UTF-8');
$mb_sex = htmlspecialchars($_POST['mb_sex'], ENT_QUOTES, 'UTF-8');
$mb_birth = htmlspecialchars($_POST['mb_birth'], ENT_QUOTES, 'UTF-8');
$mb_hp = htmlspecialchars($_POST['mb_hp'], ENT_QUOTES, 'UTF-8');
$mb_job = htmlspecialchars($_POST['mb_job'], ENT_QUOTES, 'UTF-8');
$mb_addr1 = htmlspecialchars($_POST['mb_addr1'], ENT_QUOTES, 'UTF-8');
$mb_addr2 = htmlspecialchars($_POST['mb_addr2'], ENT_QUOTES, 'UTF-8');
$mb_memo = htmlspecialchars($_POST['mb_memo'], ENT_QUOTES, 'UTF-8');
$mb_request_memo = htmlspecialchars($_POST['mb_request_memo'], ENT_QUOTES, 'UTF-8');

$result = $d->update_customer_info($mb_id , $mb_campaign, $mb_date, $mb_job, $mb_addr1, $mb_addr2, $mb_memo, $mb_request_memo);
if($result){
    echo '<script>alert("정보 수정 완료.");</script>';;
}else{
    echo '<script>alert("정보 수정 오류 발생, 문의 부탁드립니다.");</script>';;
}
    echo "<script> self.close(); </script>";
?>