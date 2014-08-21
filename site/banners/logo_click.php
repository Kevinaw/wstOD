<?php
    //when a banner is clicked on, tracks the click and loads the url in 
    //a new window
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();

    $sql="select * from logos where id=[id]";
    

    if($data=$db->get_data($sql,array("id"=>$_REQUEST["id"]))){
        if(count($data)>1){
            $sql="update logos set clicks=clicks+1 where id=".$data[1]["id"];
            $db->set_data($sql,array());
            header("location:{$data[1]["url"]}");
            exit;
        }
    }
    
?>
    