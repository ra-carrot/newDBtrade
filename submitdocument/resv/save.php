<?php
$img = $_POST['signImg'];
//var_dump($img);
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);

//$filename_path = md5(time().uniqid()).".jpg";
//$decoded=base64_decode($img);
try {
//file_put_contents("upload/".$filename_path,$decoded);
$fileData = base64_decode($img);
//saving
$fileName = md5(time().uniqid()).".jpg";

//    var_dump($fileData);
    file_put_contents("upload/".$fileName, $fileData);
}catch (Exception $e){
    var_dump($e->getTrace());
}

echo 'hello';