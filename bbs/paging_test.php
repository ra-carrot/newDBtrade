<?php
include_once('./_common.php');
if ($is_admin == false) {
    Header("Location:/bbs/login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>DB공급현황</title>
    <?php
    include_once(G5_THEME_PATH . '/head.php');

//    $pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1" ;
//    		$filter = $_GET["filter"]!= NULL ? $_GET["filter"] : "" ;
//    		$search = $_GET["search"]!= NULL ? $_GET["search"] : "" ;
//
//    		$postvars = array('req'=>'ins_req_list', 'memberId'=>$member['mb_id'],'id'=>$member['mb_id'],'level'=>$member['mb_level'], 'page'=>$pageNum, 'filter'=>$filter, 'search'=>$search	);
//
//    		$header = array();
//    		$header[] = 'Content-Type: Application/json';
//
//    		$url = 'https://globaldbtrade.co.kr/bbs/paging_test.php';
//    		$http = curl_init();
//    		curl_setopt($http, CURLOPT_URL, $url);
//    		curl_setopt($http, CURLOPT_POST, 1);
//            curl_setopt($http, CURLOPT_POSTFIELDS, $postvars);
//
//
//    		curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
//
//
//    		$responseJson = curl_exec($http);
//    		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
//    		$requestList = json_decode($responseJson);
//    		//$maxNum = json_decode($responseJson)->pageNoLimit;
//    		echo "<script>console.log('$responseJson');</script>";
//
//    		$s_page = 1;
//    		$e_page = 10;
//    		//var_dump($responseJson);
//    		//var_dump($requestList);
//    		//var_dump($requestList);
//    		curl_close($http);

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
</head>

<body>
<div>
    <form>
        <select name="filter">
            <option value="" <?php if ($filter == "") echo "SELECTED"; ?>>검색조건선택</option>
            <option value="청구번호" <?php if ($filter == "청구번호") echo "SELECTED"; ?>>청구번호</option>
            <option value="성별" <?php if ($filter == "성별") echo "SELECTED"; ?>>성별(남,여)</option>
            <option value="생년월일" <?php if ($filter == "생년월일") echo "SELECTED"; ?>>생년월일(YYMMDD)</option>
        </select>
        <input name="search" type="text" value="<?= $search ?>">
        <input type="submit" value="검색">
    </form>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tbl_head01 tbl_wrap">
    <table class="text-center">
        <thead>
        <tr class="tbl_head_tr">
            <th scope="cols">고객 번호</th>
            <th scope="cols">고객이름</th>
            <th scope="cols">상태</th>
            <th scope="cols">생일</th>
            <th scope="cols">성별</th>
            <th scope="cols">연락처</th>
            <th scope="cols">방문요청일</th>
            <th scope="cols">상담내용</th>
            <th scope="cols">신청일</th>
            <th scope="cols">가격</th>
            <?php
            echo '<th scope="cols">배정받기</th>';
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $d = new Dao();
        $page_per = $d->getCustomersTotalPage();
//        var_dump($page_per);
        $data = $d->getCustomers();
        $i = 0;
        foreach ($data as $key => $value) {

            if ($i % 2 === 0)
                echo '<tr>';
            else
                echo '<tr bgcolor="#FFFACD">';

            $i = $i + 1;
            echo '<td>' . ($value['id']) . '</td>';
            echo '<td>' . ($value['name']) . '</td>';
            echo '<td>' . '<div id="result' . $key . '">' . ($value['status'] == 1 ? "배정완료" : "배정대기") . '</div></td>';
            echo '<td>' . ($value['birth']) . '</td>';
            echo '<td>' . ($value['sex'] == 0 ? "여자" : "남자") . '</td>';
            echo '<td>' . ($value['contact']) . '</td>';
            echo '<td>' . ($value['req_visit_date']) . '</td>';
            echo '<td>' . ($value['consult']) . '</td>';
            echo '<td>' . ($value['req_date']) . '</td>';
            if ($is_admin && $value['status'] != 1) {
                echo '<td><input id="price' . $key . '", value="' . ($value['price']) . '"></td>';
            } else {
                echo '<td>' . ($value['price']) . '</td>';
            }
            if ($value['status'] == 1) {
                echo '<td>' . $value['allocate_fc_id'] . '</td>';
            } else {
                echo '<td>';
                echo '<form id="req_deposit_' . $key . '" action="https://www.globaldbtrade.co.kr/trade/allocate.php" method="post" enctype="multipart/form-data">';
                echo '<input id="btn_allocate_' . $key . '" type="submit" class="attribution" value=" 배정받기 "/>';
                echo '</form>';
                if ($is_admin) {
                    echo '<form id="req_price_edit_' . $key . '" action="https://www.globaldbtrade.co.kr/trade/manage_price.php" method="post" enctype="multipart/form-data">';
                    echo '<input id="btn_price_edit_' . $key . '" type="submit" value=" 가격수정 "/>';
                    echo '</form>';
                }
                echo '</td>';
            }

            echo '</tr>';
            echo '<tr>';
            echo '</tr>';

            ?>
            <script type='text/javascript'>
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
//$page_per = 5;
$pageNum = $_GET["page"] != NULL ? $_GET["page"] : "1" ;
$endNum = floor(sizeof($data)/$page_per)+1;
echo get_paging($page_per, $pageNum, $endNum, "https://globaldbtrade.co.kr/bbs/paging_test.php?");
?>

</body>

</html>


<?php
include_once(G5_THEME_PATH . '/tail.php');

?>
