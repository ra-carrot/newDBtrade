<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');

$mb_code   = trim($_POST['mb_code']);
if ($msg = valid_mb_code($mb_code)) die($msg);
?>