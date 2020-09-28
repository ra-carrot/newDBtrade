<?php

require_once '/var/www/html/comm/Dao.php';
require_once '/var/www/html/common.php';

use eftec\PdoOne;

//멤버 관련 변수
//var_dump($member);
header("Access-Control-Allow-Origin: *");

//var_dump($_POST);

global $is_admin;

var_dump($is_admin);

$fc_id = htmlspecialchars($_POST['fc_id'], ENT_QUOTES, 'UTF-8');

$customer_id = htmlspecialchars($_POST['customer_id'], ENT_QUOTES, 'UTF-8');


try {
    $dao = new Dao();
    /**
     * member 확인
     */

    if($fc_id == null || empty($fc_id)){
        $result = array('error'=>104, 'message'=>"회원이 아닙니다.");
        echo json_encode($result, JSON_UNESCAPED_UNICODE).'\n';
        return;
    }

    if($dao->is_member($fc_id)){


        /**
         * 배정 취소한다.
         * 사용된 포인트는 돌려주지 않는다. 수동으로 돌려준다.
         */
        if($dao->confirmCancelDeploy($customer_id)) {
            $result = array('error' => 200, 'message' => $price);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }else{
            $result = array('error' => 404, 'message' => "0");
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }
    }else{
        $result = array('error' => 406, 'message' => "0");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        return;

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
    var_dump($e->getMessage());
}
