<?php
$error = $_FILES['excel_upload']['error'];

if ($error == UPLOAD_ERR_OK){

    $file_name = $_FILES['excel_upload']['name'];
    $tmp_file = $_FILES['excel_upload']['tmp_name'];
    $file_path = '../go/'.$file_name;

    // $file_overwrite = false;

    // if(is_file($file_path)){
    // 	echo "이미 파일 존재";
    // }else{
    // 	echo "파일 없음";
    // }

    if(move_uploaded_file($tmp_file, $file_path)){
        echo "파일 업로드 성공";
    }else{
        echo "파일 업로드 실패";
    }
}

?>