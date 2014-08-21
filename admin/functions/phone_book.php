<?php
session_start();
  print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    //$db->debug=true;



$sql=<<<EOD
 select distinct b.name as country,c.name as prov_state
 from listing_locations a 
 join countries b on b.id=a.country_id 
 join prov_state c on c.id=a.province_id 
 order by b.name,c.name
EOD;


$data=$db->get_data($sql,array());
if(!$data) print $db->lasterror;

$country="";
print "<ul>";
foreach($data as $rownumber=>$row){
    if($rownumber==0) continue;
    
    if($country!=$row["country"]){
        if($country!="") print "</ul>";
        print "<li>{$row["country"]}</li><ul>";
        $country=$row["country"];
    }
    
    print <<<EOD
        <li><a href="phonebook/list_creator.php?country={$row["country"]}&prov_state={$row["prov_state"]}" target="_blank">{$row["prov_state"]}</a></li>
EOD;

}
print "</ul>";
