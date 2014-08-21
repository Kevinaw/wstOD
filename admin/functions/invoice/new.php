<?php
session_start();
  print "<div style='float:right;'><a href='../invoices.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";


$name=ucwords(str_replace(array("new.php","_","/admin/functions/invoice/"),array("invoices"," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}

?>
  <style>
  body,html { font-family:arial; font-size:9pt; }
  </style>

<h4>Find the listing to attach the invoice to</h4>
              <form action="#" method="post">
                <table>
                  <tr>
                    <td>Business Name:</td>
                    <td><input type='textbox' name='company'></td>
                  </tr>
                  <tr>
                    <td>Keyword(s):</td>
                    <td><input type='textbox' name='keyword'></td>
                  </tr>
                  <tr>
                    <td colspan=2 align=right>
                        <input type='image' src="../../../images/find.gif" name='search[]'>
                    </td>
                </table>
              </form>
<?php
    if(isset($_REQUEST["search"])){

      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();
      
    $sql=<<<EOD
      select listings.id,
             listings.name,
             listings.description
      from listings 
      where [where] 
      order by listings.name 
      limit 1000;
EOD;

    $ands=array();
    $keywords=array();
    $params=array();
    
    foreach($_REQUEST as $name=>$value){
        $params[]="{$name}={$value}";
        
        //split words into array if it isn't an array already
        if(is_array($value)){
          $values=array_keys($value);
        } else {
          $value=trim($value);
          if(!strlen($value)) continue;
          $values=split(" ",$value);
        }
        foreach($values as $valnum=>$value) $values[$valnum]=$db->escape($value);
        
        switch($name){
            case "company":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="name like '%{$db->escape($value)}%'";
                  $keywords[]=$value;
                }
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "keyword":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="description like '%{$db->escape($value)}%'";
                  $keywords[]=$value;
                }
                $ands[]="(".join(" or ",$ors).")";
            break;
        }
    }
    $where=join(" and ",$ands);
    $params=urlencode(join("&",$params));
    
    $sql=str_replace("[where]",$where,$sql);
//    $_REQUEST["user_id"]=$_SESSION["user"]["id"];
//$db->debug=true;

    if($data=$db->get_data($sql,$_REQUEST)){     
        foreach($data as $rownumber=>$row){
            if($rownumber==0) continue;
            print <<<EOD
                <form action="edit.php" method="post" target=_blank>
                <input type='submit' name='create_new' value='Create New Invoice' style='text-decoration:underline; border:none; background:none;'>
                <input type='hidden' name='listing_id' value="{$row["id"]}">
                {$row["name"]} 
                </form>
EOD;
        }
    } else {
        print "No Listings Found that match your criteria, please try again.";
    }
          
      
    } 
?>

