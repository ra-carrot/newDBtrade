<?php

require_once '/var/www/html/comm/Dao.php';
require_once '/var/www/html/common.php';

use eftec\PdoOne;

//멤버 관련 변수
//var_dump($member);
header("Access-Control-Allow-Origin: *");

//var_dump($_POST);

$mb_id = htmlspecialchars($_POST['mb_id'], ENT_QUOTES, 'UTF-8');

$customer_id = htmlspecialchars($_POST['customer_id'], ENT_QUOTES, 'UTF-8');


try {
    $dao = new Dao();
    /**
     * member 확인
     */

    if($mb_id == null || empty($mb_id)){
        $result = array('error'=>104, 'message'=>"회원이 아닙니다.");
        echo json_encode($result).'\n';
        return;
    }
    if($dao->is_member($mb_id)){
        $point = $dao->getPoint($mb_id);
//        var_dump($point);
        if($point != false && $point > 0){
            /**
             * 배정받고싶은 금액보다 없어도 포인트가 부족하고
             * 날짜와 처음 금액 / 할인을 가져와서 금액에 따른 할인율을 정한다
             */
            $info =  $dao->getAllocateInfo($customer_id);
            $date = $info['req_date'];
            $price = $info['price'];

			$pTime = strtotime(date("Y-m-d")) - strtotime($date);
								
			$price = $price - ( 1000 * ceil($pTime/ (60*60*24))) ;
			$price = $price <= 1000 ? 1000 : $price;

            if($point < $price){
                $result = array('error' => 301, 'message' => number_format($price - $point)." 포인트가 부족합니다");
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                return;
            }else{
                /**
                 * 포인트 까고 배정해준다.
                 */
                if($dao->usePoint($mb_id, $customer_id, $price)){
                    $result = array('error' => 200, 'message' => "배정되었습니다.");
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    return;
                }else{
                    $result = array('error' => 500, 'message' => "문제발생");
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    return;
                }


            }
        }else {
            /**
             * false 거나 0 이어도 포인트가 부족
             */
            $result = array('error' => 301, 'message' => "포인트가 부족합니다");
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }
    }

    /**
     * 포인트가 있는지 확인
     */
    /**
     * 배정
     */
    /**
     * 배정 성공시 포인트 삭감
     */
    /**
     * 배정 실패 시 돌아감
     */
}catch (Exception $e){
    var_dump($e->getTrace());
}
