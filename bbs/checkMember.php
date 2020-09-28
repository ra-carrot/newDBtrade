<?php


try {
    $id = $_GET['user_id'];
    if($id == null || $id == "")
        $id = $_POST['user_id'];
//    var_dump($_POST);
//    var_dump( $_SERVER['REQUEST_METHOD']);
//    var_dump($_GET);
    $output = shell_exec('../go/FindMember ' . $id);
//    var_dump($output);
//    echo '<br>';
//    var_dump(empty(trim($output)));
    $output = trim($output);
	
//    echo '<br>';
    if ( empty($output) == true) {
        echo 'false';
    } else {
        echo $output;
    }

} catch (Exception $e) {
    var_dump($e->getTrace());
}
