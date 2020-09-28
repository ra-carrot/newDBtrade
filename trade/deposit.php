<?php

require_once '/var/www/html/comm/Dao.php';
use eftec\PdoOne;




$id = htmlspecialchars($_POST['mb_id'], ENT_QUOTES, 'UTF-8');
$id = clear_text($id);
$id = strtolower($id);
$name = htmlspecialchars($_POST['deposit_name'], ENT_QUOTES, 'UTF-8');
$type = htmlspecialchars($_POST['deposit_type'], ENT_QUOTES, 'UTF-8');
$amount = htmlspecialchars($_POST['deposit_amount'], ENT_QUOTES, 'UTF-8');
$amount = clear_text($amount);
$amount = strtolower($amount);

try {
    $dao = new Dao();
    header("Access-Control-Allow-Origin: *");
    if(empty($name)){
        echo '이름을 입력해주세요';
        exit;
    }else{
        if(!$dao->is_member($id)){
            echo "회원이 아닙니다.";
            exit;
        }
    }
    if(empty($amount)){
        echo '금액을 입력해주세요';
        exit;
    }

    if($dao->reqDeposit($id, $amount, $name, $type))
    {
        /**
         * 제대로 된거
         */

        echo '정상 신청되었습니다.';
    }else{
        echo '문제가 발생했습니다. 관리자에게 문의해주세요';
    }
}catch (Exception $e){
    var_dump($e->getTrace());
}



function clear_text($str){
    $pattern1 = "/[\<\>\'\"\\\'\\\"\(\)]/";
    $pattern2 = "/\r\n|\r|\n|[^\x20-\x7e]/";

    $str = preg_replace($pattern1, "", clean_xss_tags($str, 1));
    $str = preg_replace($pattern2, "", $str);
    return $str;
}

function clean_xss_tags($str, $check_entities=0)
{
    $str_len = strlen($str);

    $i = 0;
    while($i <= $str_len){
        $result = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);

        if( $check_entities ){
            $result = str_replace(array('&colon;', '&lpar;', '&rpar;', '&NewLine;', '&Tab;'), '', $result);
        }

        $result = preg_replace('#([^\p{L}]|^)(?:javascript|jar|applescript|vbscript|vbs|wscript|jscript|behavior|mocha|livescript|view-source)\s*:(?:.*?([/\\\;()\'">]|$))#ius',
            '$1$2', $result);

        if((string)$result === (string)$str) break;

        $str = $result;
        $i++;
    }

    return $str;
}
