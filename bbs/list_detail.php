<?php
include_once('./_common.php');

if ($is_member == false) {
    Header("Location:/bbs/login.php");
    exit;
}

include_once(G5_THEME_PATH . '/head.sub.php');

$customer_id = $_GET["id"];

$d = new Dao();
$user_data = $d->getUser($customer_id);
//var_dump($user_data);
?>
<style>
.grid_2{
	width: 10%;
}
.grid_4{
	width: 40%;
}
.frm_input{
	width: 100%;
}
.memo{
	height: 150px;
}
.input_full{
	width: 80%;
}
.input_half{
	width: 30%;
}
</style>
<div class="tbl_frm01 tbl_wrap">
	<form method="post" enctype="multipart/form-data" action="./customer_from_update.php">
        <input type="hidden" name="mb_id" value="<?php echo $customer_id ?>">
		<table>
			<colgroup>
				<col class="grid_2">
				<col class="grid_4">
				<col class="grid_2">
				<col class="grid_4">
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="캠페인명">캠페인명</label></th>
					<td><input type="text" name="mb_campaign" value="<?php echo $user_data["campaign"] ?>" id="캠페인명" class=" frm_input"></td>
					<th scope="row"><label for="신청일">신청일</label></th>
					<td><input type="text" name="mb_date" value="<?php echo substr($user_data['req_date'], 0, -9) ?>" id="신청일" class=" frm_input"></td>
				</tr>
				<tr>
					<th scope="row"><label for="고객이름">고객이름</label></th>
					<td><input type="text" name="mb_name" value="<?php echo $user_data["name"] ?>" id="고객이름" class=" frm_input"></td>
					<th scope="row"><label for="성별">성별</label></th>
					<td><input type="text" name="mb_sex" value="<?php echo $user_data['sex'] == 0 ? "여자" : "남자" ?>" id="성별" class=" frm_input"></td>
					
				</tr>
				<tr>
					<th scope="row"><label for="생년월일">생년월일</label></th>
					<td><input type="text" name="mb_birth" value="<?php echo $user_data["birth"] ?>" id="생년월일" class=" frm_input"></td>
					<th scope="row"><label for="연락처">연락처</label></th>
					<td><input type="text" name="mb_hp" value="<?php echo $user_data["contact"] ?>" id="연락처" class="frm_input"></td>
				</tr>
				<tr>
					
					<th scope="row"><label for="직업">직업</label></th>
					<td><input type="text" name="mb_job" value="<?php echo $user_data["mb_job"] ?>" id="직업" class="frm_input"></td>
					<th scope="row">주소</th>
					<td class="td_addr_line">
						<input type="text" name="mb_addr1" value="<?php echo $user_data["mb_addr1"] ?>" id="mb_addr1" class="input_full frm_input">
						<label for="mb_addr1">기본주소</label><br>
						<input type="text" name="mb_addr2" value="<?php echo $user_data["mb_addr2"] ?>" id="mb_addr2" class="input_full frm_input">
						<label for="mb_addr2">상세주소</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="메모1">메모(특이사항)</label></th>
					<td><input type="textarea" name="mb_memo" value="<?php echo $user_data["mb_memo"] ?>" id="메모1" class="frm_input memo"></td>
					<th scope="row"><label for="메모2">메모(상담시 요청사항)</label></th>
					<td><input type="textarea" name="mb_request_memo" value="<?php echo $user_data["mb_request_memo"] ?>" id="메모2" class="frm_input memo"></td>
				</tr>
				<tr>
					<th scope="row"><label for="첨부1">첨부(이미지)</label></th>
					<td><input  class="fileHeight" name="mb_file1" class="" type="file" value=""></td>
					<th scope="row"><label for="첨부2">첨부(녹음파일)</label></th>
					<td><input  class="fileHeight" name="mb_file1" class="" type="file" value=""></td>
				</tr>					
			</tbody>
		</table>
		<input class="btn_cancel searchHeight" type="submit" value="수정하기">
	</form>
</div>

<script>

</script>
<?php
include_once(G5_THEME_PATH . '/tail.sub.php');

?>