<?php

require_once '/var/www/html/comm/Dao.php';
require_once '/var/www/html/_common.php';
use eftec\PdoOne;


$fcid = htmlspecialchars($_POST['fcid'], ENT_QUOTES, 'UTF-8');
$fcid = clear_text($fcid);
$fcid = strtolower($fcid);

$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
$id = clear_text($id);
$id = strtolower($id);

$amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
$amount = clear_text($amount);
$amount = strtolower($amount);

//var_dump($id);
//var_dump($amount);
//var_dump($fcid);
try {
    $dao = new Dao();
    header("Access-Control-Allow-Origin: *");
    if($dao->is_member($fcid)){
        if($dao->confirmDeposit($id, $amount)){
            try {
                if($dao->confirmAddDeposit($fcid, $amount)){
                    echo '완료';
                }else{
                    $dao->confirmDepositRollback($id);
                    echo '실패';
                }
            }catch (Exception $e){
                echo $e->getMessage();
            }
        }else{
            echo '실패';
        }

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
