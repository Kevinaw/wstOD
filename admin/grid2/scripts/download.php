<?php

    $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : "";
    $file = isset($_REQUEST['file']) ? $_REQUEST['file'] : "";
    
    $file_path = "../".$file;
    
    if (file_exists($file_path)) { 
        header("Content-type: application/force-download"); 
        header('Content-Disposition: inline; filename="'.$file.'"'); 
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-length: ".filesize($file_path)); 
        header('Content-Type: application/octet-stream'); 
        header('Content-Disposition: attachment; filename="'.$file.'"'); 
        readfile("$file_path");
    } else { 
        echo "Can not find such path: $file_path !"; 
    }
    exit(0);

?>