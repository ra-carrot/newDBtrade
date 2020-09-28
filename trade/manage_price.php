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

$price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');



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
    if($dao->is_member($mb_id) && $mb_id === "admin"){
        /**
         * 금액을 변경한다.
         */
            $dao->updatePrice($customer_id, $price);
            $result = array('error' => 200, 'message' => $price);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
    }else{
        $result = array('error' => 404, 'message' => "0");
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
