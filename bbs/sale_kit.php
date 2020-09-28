<?php
include_once('./_common.php');
?>
<!doctype html>
<html lang="en">

<head>
<title>유전자검사키트 구매</title>
<?php
		include_once(G5_THEME_PATH.'/head.php');
?>

<h2 id="container_title"><span title="유전자검사키트 구매">유전자검사키트 구매</span></h2>
</head>
<style>
.tbl_head01 td{
	padding: 3px 5px;
	height:0px;
}

.dna_buy{
	background-color:#d35757; 
	font-family: Malgun Gothic,'맑은 고딕','돋움','dotum',sans-serif;	
	font-size:18px;
	font-weight:bold;
	padding: 10px 0px 10px 0px;
	color:#FFFFFF;
	border: 0px;
	width:100%;
}
.dna_input01 {
	border: 1px solid #bababa; width:138px; height:23px; padding: 0px 0px 0px 5px;
	font-size:12px; 
}

.dna_input03 {
	border: 1px solid #bababa; width:275px; height:23px; padding: 0px 0px 0px 5px;
	font-size:12px; 
}

.dna_input02 {
	border: 1px solid #bababa; width:360px; height:23px; padding: 0px 0px 0px 5px;
	font-size:12px; 
}

.dna_textarea {
	border: 1px solid #bababa; width:430px; height:50px; padding: 5px 0px 0px 5px;
	font-size:12px;
}
</style>
<body>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tbl_head01 tbl_wrap">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tbody><tr>
    	<td align="center" style="padding-top:50px;">
        	<table width="1100" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td width="490" valign="top">
                	<table width="0" border="0" cellspacing="0" cellpadding="0">
                      <tbody><tr>
                        <td><img src="../img/sale_kit/dna_product.jpg"></td>
                      </tr>                                
                    </tbody></table>
                </td>
                <td align="left" valign="top" style="padding: 0px 0px 0px 60px;">
					<form name="fwrite" onsubmit="return fSubmit();" action="" method="post">
					<input name="mode" type="hidden" value="ORDERS">
					<input name="mb_id" type="hidden" value="gilsarangyo">
					<input name="las_7" id="las_7" type="hidden" value="0">
					<input name="las_13" id="las_13" type="hidden" value="0">
					<input name="las_price" id="las_price" type="hidden" value="0">
					<input name="delivery_price" id="delivery_price" type="hidden" value="0">
					<input name="all_price" id="all_price" type="hidden" value="0">
                	<table width="550" border="0" cellspacing="0" cellpadding="0">
                      <tbody><tr>
                        <td align="center" class="dna_title">유전자 검사키트 도매가 판매 안내 / 구매단위: 1BOX(10개)</td>
                      </tr>
                      <tr>
                        <td align="left" class="dna_txt01">▶상품선택</td>
                      </tr>
                      <tr>
                        <td align="left" style="padding-bottom:15px;">
                        	<table width="550" border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td align="left" class="dan_product_txt">My Gene Box Basic 7종 (개당 26,000원)</td>
                                <td align="right">
                                	<table width="0" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td><a onclick="ch_num('7', '-');" href="javascript:;"><img src="../img/sale_kit/amount_01.jpg" border="0"></a></td>
                                        <td align="center" class="dna_box_input01" id="las_7_txt">0 Box (0개)</td>
                                        <td><a onclick="ch_num('7', '+');" href="javascript:;"><img src="../img/sale_kit/amount_02.jpg" border="0"></a></td>
                                      </tr>
                                    </tbody></table>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="dan_product_txt">My Gene Box Basic 13종 (개당 35,000원)</td>
                                <td align="right">
                                	<table width="0" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td><a onclick="ch_num('13', '-');" href="javascript:;"><img src="../img/sale_kit/amount_01.jpg" border="0"></a></td>
                                        <td align="center" class="dna_box_input01" id="las_13_txt">0 Box (0개)</td>
                                        <td><a onclick="ch_num('13', '+');" href="javascript:;"><img src="../img/sale_kit/amount_02.jpg" border="0"></a></td>
                                      </tr>
                                    </tbody></table>
                                </td>
                              </tr>
                            </tbody></table>
                        </td>
                      </tr>                      
                      <tr>
                      	<td align="center" class="dna_txt02" style="padding:15px 0px;" bgcolor="#f9f9f9">
                        	<table width="500" border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td width="425" align="left">상품금액</td>
                                <td align="right" id="las_price_txt" style="padding-right:5px;">0</td>
                                <td align="right">원</td>        
                              </tr>
                              <tr>
                                <td align="left">배송비</td>
                                <td align="right" id="delivery_price_txt" style="padding-right:5px;">0</td>
                                <td align="right">원</td>
                              </tr>
                              <tr>
                                <td align="left" style="color:#127bcc">입금액</td>
                                <td align="right" id="all_price_txt" style="padding-right:5px; color:#127bcc; font-size:16px;">0</td>
                                <td align="right" style="color:#127bcc">원</td>        
                              </tr>
                              <tr>
                              	<td align="center" style="padding-top:5px;" colspan="3">
                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                      	<td align="center" class="dna_bank " bgcolor="#ffffff">입금계좌 : 기업은행  000-00000-00-00 (주)회사이름<br>문의전화: 00-0000-0000</td>
                                      </tr>
                                    </tbody></table>
                                </td>
                              </tr>
                            </tbody></table>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" class="dna_txt01" style="padding-top:15px;">▶구매신청</td>
                      </tr>
                      <tr>
                      	<td align="center" class="dna_txt02" style="padding:15px 0px;" bgcolor="#f9f9f9">
                        	<table width="500" border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                              	<td width="75" align="left">이름</td>
                                <td align="left">
                                	<table width="0" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td align="left"><input name="name" class="dna_input01" required="" type="text" value=""></td>
                                        <td align="left" style="padding-left:25px;">연락처</td>
                                        <td align="left" style="padding-left:10px;"><input name="phone" class="dna_input01" required="" type="text" size="5" maxlength="11" value=""></td>
                                      </tr>
                                    </tbody></table>
                                </td>
                              </tr>
                              <tr>
                              	<td width="75" align="left">배송지</td>
                                <td align="left" style="padding-top:7px;">
									<script src="http://fcdb.kr/js/address.js" type="text/javascript"></script><script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script><script src="http://t1.daumcdn.net/postcode/api/core/200421/1587459050284/200421.js" type="text/javascript" charset="UTF-8"></script>
									<input name="address3" type="hidden" value="">
									<input name="address" type="hidden" value="">
                                	<table width="0" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td align="left"><input name="zipcode" class="dna_input03" style="background:#f4f4f4" required="" type="text" maxlength="6"></td>
                                        <td align="left" style="padding-left:10px;">
                                        <input class="address_btn" onclick="PostCode(2);" type="button" value="우편번호">
                                       </td>
                                      </tr>
                                    </tbody></table>
								</td>
                              </tr>
                              <tr>
                              	<td>&nbsp;</td>
                                <td style="padding-top:7px;" colspan="3">
                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="85%" align="left"><input name="address1" class="dna_input02" style="background:#f4f4f4" required="" type="text"></td>
                                        <td style="padding-left:5px;"><span class="dna_txt03">기본주소</span></td>
                                      </tr>
                                    </tbody></table>
                                </td>
                              </tr>
                              <tr>
                              	<td>&nbsp;</td>
                                <td style="padding-top:7px;" colspan="3">
                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="85%" align="left"><input name="address2" class="dna_input02" style="background:#fff;" required="" type="text"></td>
                                        <td style="padding-left:5px;"><span class="dna_txt03">상세주소</span></td>
                                      </tr>
                                    </tbody></table>
                                </td>
                              </tr>
                              <tr>
                              	<td width="75" align="left" valign="top" style="padding-top:10px;">기타문의</td>
                                <td align="left" style="padding-top:7px;" colspan="3"><textarea name="inquiry" class="dna_textarea"></textarea></td>
                              </tr>
                            </tbody></table>
                        </td>
                      </tr>
                      <tr>
                      	<td align="center" class="dna_txt04">구매신청 후 위 입금계좌로 송금하시면 됩니다.<br>(평일 오후 2시 이전 입금시 당일 출고가능)<br><!--<span style="color:#FF0000;">
※유전자검사 키트 재판매는 의료법상 고소고발및 민형사상  처벌됩니다.<br /> 각별히 주의 바랍니다.</span>--></td>
                      </tr>
                      <tr>
                      	<td><input class="dna_buy" type="submit" value="구매신청"></td>
                      </tr>
                    </tbody></table>
					</form>
                </td>
              </tr>
            </tbody></table>
        </td>
    </tr>
	<tr>
    	<td align="center" style="padding-top:50px;"><img src="../img/sale_kit/dna_introduce.jpg"></td>
    </tr>	
    <tr>
    	<td align="center" valign="top" style="padding-top:30px;">
            <table width="1100" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr> 
                <td align="left" class="table_txt04">▶구매내역</td> 
              </tr>
            </tbody></table>
        </td>
    </tr>
	<tr>
    	<td align="center">
        	<table width="1100" border="0" cellspacing="0" cellpadding="0">
				<tbody><tr>
                    <td width="150" align="center" class="table_txt01">날짜</td>
                    <td width="250" align="center" class="table_txt01">항목</td>
                    <td width="130" align="center" class="table_txt01">금액</td>
                    <td width="130" align="center" class="table_txt01">신청자</td>
                    <td width="130" align="center" class="table_txt01">연락처</td>
                    <td width="200" align="center" class="table_txt01">배송처</td>
                    <td width="150" align="center" class="table_txt01">상태</td>
                </tr>
				<tr><td class="empty_list" colspan="7">구매내역이 없습니다.</td></tr>            </tbody></table>
        </td>
    </tr>
    
  <tr>
    	<td align="center" valign="top" style=" padding: 20px 0px 40px 0px;">
						<div style="position:relative;">
							<span style="text-align:left;">
														</span>
						</div>
        </td>
    </tr> 
    
    <!--  12월16일에 수정할예정
    <tr>
    	<td align="center" style="padding-top:40px;"><img src="../img/sale_kit/dna_product.jpg" /></td>
    </tr>-->
	<tr>
    	<td align="center" style="padding: 0px 0px 40px  0px;">
        	<table border="0" cellspacing="0" cellpadding="0">
              <tbody><tr>
              	<td style="padding-right:20px;"><a href="../down/sale_kit/LAS_INFO.pdf" target="_blank"><img src="../img/sale_kit/pdf_btn01.jpg" border="0"></a></td>
                <td style="padding-right:20px;"><a href="../down/sale_kit/LAS_RESULT.pdf" target="_blank"><img src="../img/sale_kit/pdf_btn05.jpg" border="0"></a></td>
                <td style="padding-right:20px;"><a href="../down/sale_kit/LAS_7_MAN.pdf" target="_blank"><img src="../img/sale_kit/pdf_btn02.jpg" border="0"></a></td>
                <td style="padding-right:20px;"><a href="../down/sale_kit/LAS_13_MAN.pdf" target="_blank"><img src="../img/sale_kit/pdf_btn03.jpg" border="0"></a></td>
                <td>							<a href="../down/sale_kit/LAS_13_WOMAN.pdf" target="_blank"><img src="../img/sale_kit/pdf_btn04.jpg" border="0"></a></td>
              </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>


</div>
</body>

</html>
<script>
function ch_num(prod, type)
{
	var v = parseInt($('#las_'+prod).val());
	if (type == '+') { v = v+1; }
	else
	{
		v = v-1;
		if (v < 0) { v = 0; }
	}
	$('#las_'+prod).val(v);
	$('#las_'+prod+'_txt').html(v+' Box ('+(v*10)+'개)');
	get_price();
}
function get_price()
{
	var price = parseInt(0);
	var all_price = parseInt(0);
	var las_7 = parseInt($('#las_7').val());
	var las_13 = parseInt($('#las_13').val());
	price = price+(las_7*260000);
	price = price+(las_13*350000);

	$('#las_price').val(price);
	$('#delivery_price').val(price > 0 ? '2500' : 0);

	all_price = parseInt(price)+parseInt($('#delivery_price').val());
	$('#all_price').val((all_price ? all_price : 0));

	$('#las_price_txt').html(comma(price));
	$('#delivery_price_txt').html(comma(price > 0 ? '2500' : 0));
	$('#all_price_txt').html(comma((all_price ? all_price : 0)));
}

function comma(x)
{
	var txtNumber = '' + x;
	var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])');
	var arrNumber = txtNumber.split('.');
	arrNumber[0] += '.';
	do { arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2'); } while (rxSplit.test(arrNumber[0]));
	if (arrNumber.length > 1) { return arrNumber.join(''); }
	else { return arrNumber[0].split('.')[0]; }
}

function fSubmit()
{
	var f = document.fwrite;
	//if (confirm('※ 유전자검사 키트 재판매는\n의료법상 고소고발 및 민형사상 처벌됩니다.\n각별히 주의 바랍니다.'))
	//{
		if ($('#all_price').val() > 0)
		{
			return true;
		}
		else
		{
			alert('상품을 선택해주세요.');
			return false;
		}
	//} else { return false; }
}
</script>

<?php
include_once(G5_THEME_PATH.'/tail.php');

?>
