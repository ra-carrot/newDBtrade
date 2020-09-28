<?php
include_once('./_common.php');
?>
<!doctype html>
<html lang="en">

<head>
    <title>입금신청자 현황</title>
    <?php
    include_once(G5_THEME_PATH . '/head.php');

    ?>

    <h2 id="container_title"><span title="입금 신청자 ">입금 신청자 리스트</span></h2>
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
    </style>
</head>

<body>
<div>

</div>

<?php

?>
<div style="text-align:center">
    <div class="tbl_head01 tbl_wrap">
        <table class="text-center">
            <thead>
            <tr class="tbl_head_tr">
                <th scope="cols">요청 FC 아이디</th>
                <th scope="cols">요청시간</th>
                <th scope="cols">입금자 이름</th>
                <th scope="cols">요청 금액</th>
                <th scope="cols">입금확인 금액</th>
				<th scope="cols">타입</th>
                <th scope="cols">입금확인</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $dao = new Dao();
            $requestList = $dao->reqDepositList();
            //   var_dump($requestList);

            foreach ($requestList as $key => $value) {
                echo '<form id = ' . $key . ' action="../trade/update_req_deposit.php">';
                echo '<tr>';
                echo '<td>' . $value['fc_id'] . '</td>';
                echo '<td>' . $value['req_time'] . '</td>';
                echo '<td>' . $value['deposit_name'] . '</td>';
                echo '<td>' . number_format($value['req_amount']) . '</td>';
                
				
				if($value['check_amount'] > 0){
					echo '<td>' . number_format(floor($value['check_amount'] /100) * 100) .'</td>';
					echo '<td>'.$value['deposit_type'].'</td>';
					echo '<td>입금완료</td>';
				}
				else{
					echo '<td><input class="text-center" type="text" onkeydown="return onlyNumber(event)" id="amount' . $key . '" value="' . $value['req_amount'] .'"></td>';
					echo '<td>'.$value['deposit_type'].'</td>';
					echo '<td><input class="attribution" type="submit" value="입금확인"></input><div id="result' . $key . '"></div></td>';
				}
                
                echo '<input type="hidden" id="keyid'.$key.'" value="'.$value['id'].'">';
                echo '<input type="hidden" id="fcid'.$key.'" value="'.$value['fc_id'].'">';
                echo '</tr>';
                echo '</form>';
                ?>

                <script type='text/javascript'>
					function onlyNumber(event){
						event = event || window.event;
						var keyID = (event.which) ? event.which : event.keyCode;
						if ((keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 9 || keyID == 46 || keyID == 37 || keyID == 39) {
							return;
						}
						else return false;
					}
					
					function inputPress(_this,num){
						$("#amount"+num).html(_this.value);
						
					}
                    /* attach a submit handler to the form */
					
					
                    $("#<?=$key?>").submit(function (event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        /* get the action attribute from the <form action=""> element */
                        var $form = $(this),
                            url = $form.attr('action');

                        console.log($('#keyid<?=$key?>').val());
                        /* Send the data using post with element id name and name2*/
                        var posting = $.post(url, {
                                id: $('#keyid<?=$key?>').val(),
                                amount: $('#amount<?=$key?>').val(),
                            fcid: $('#fcid<?=$key?>').val(),
                            }
                        );

                        /* Alerts the results */
                        posting.done(function (data) {
                            $('#result<?=$key?>').html(data);

                        });
                    });
                </script>
                <?php

            }
            ?>
            </tbody>
        </table>
    </div>


    <?php
    // $dao = new Dao();
    // $requestList = $dao->reqDepositList();
    // //   var_dump($requestList);

    // foreach ($requestList as $key => $value){
    // echo '<form id = '.$key.' action="https://www.globaldbtrade.co.kr/trade/update_req_deposit.php">';
    // echo '<ul>';
    // echo '<li> 요청 FC 아이디: '.$value['fc_id'].'</li>';
    // echo ' <li> 요청시간:'.$value['req_time'].'</li>';
    // echo ' <li> 입금자 이름:'.$value['deposit_name'].'</li>';
    // echo ' <li> 요청 금액:'.$value['req_amount'].'</li>';
    // echo ' <li> 입금확인 금액:'.$value['check_amount'].'</li>';
    // echo '<input type="text" id="amount">';
    // echo '<input type="hidden" id="mb_id" value='.$value['fc_id'].'>';
    // echo '<button>'.'입금확인'.'</button>';
    // echo '<div id="result'.$key.'"></div>';
    // echo '</ul>';

    // echo '<br>';
    // echo '</form>';

    ?>
    <script type='text/javascript'>
		
        // /* attach a submit handler to the form */
        // $("#<?=$key?>").submit(function(event) {

        // /* stop form from submitting normally */
        // event.preventDefault();
        // /* get the action attribute from the <form action=""> element */
        // var $form = $( this ),
        // url = $form.attr( 'action' );

        // console.log($('#mb_id').val());
        // /* Send the data using post with element id name and name2*/
        // var posting = $.post( url, { mb_id: $('#mb_id').val()} );

        // /* Alerts the results */
        // posting.done(function( data ) {
        // $('#result<?=$key?>').html(data);

        // });
        // });
    </script>

    <?php

    // }

    ?>
</div>
</body>

</html>


<?php
include_once(G5_THEME_PATH . '/tail.php');

?>
