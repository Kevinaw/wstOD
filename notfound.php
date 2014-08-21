<?php

//$id=strtolower(array_shift(explode(".",$_SERVER["SERVER_NAME"])));

$new_file="/home/ch1647/public_html/customer_sites{$_SERVER["REDIRECT_URL"]}";
$new_url="/customer_sites{$_SERVER["REDIRECT_URL"]}?{$_SERVER["REDIRECT_QUERY_STRING"]}";
if(file_exists($new_file)){
    header("Location:{$new_url}");
    exit;
}

header("Location:/");



?>