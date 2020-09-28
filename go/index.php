<?php

//read golang
try {
    echo 'hi';
    $output = shell_exec('command');

    echo '<pre>' . $output . '</pre>';
}catch (Exception $e){
    var_dump($e->getTrace());
}

//out goland