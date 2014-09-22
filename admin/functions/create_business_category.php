<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
$db = new Database();

if(isset($_POST['name']) && $_POST['name'] != "")
{ 
    $name = $_POST['name'];
    //if not exists, add it
    $sql = "select * from businesstypes where name like '[name]'";
    
    $data = $db->get_data($sql,array("name"=>$name));
    if (!$data || sizeof($data) <= 1) { 
        $sql = "insert into businesstypes (name) values('[name]')";
        $db->set_data($sql, array("name"=>$name));
    }
}

// get all the categories
$sql = "select * from businesstypes order by name";
$data = $db->get_data($sql, array());
array_shift($data);

$all_categories = array();
foreach($data as $rownumber=>$row){
    $all_categories[]=<<<EOD
        <option value="{$row["id"]}">{$row["name"]}</option>
EOD;
}





echo join("",$all_categories);