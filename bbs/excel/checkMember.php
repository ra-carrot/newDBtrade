<?php


try {
    $id = $_POST['id'];
    $output = shell_exec('go ' . $id);

    if ($output === '[]') {
        echo 'false';
    } else {
        echo 'true';
    }
//    echo '<pre>' . $output . '</pre>';
} catch (Exception $e) {
    var_dump($e->getTrace());
}
