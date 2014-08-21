<?php

    if(isset($_REQUEST["search"])){

      session_start();
      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();
      
    $sql=<<<EOD
      select listings.id,
             listings.name,
             listings.description
      from listings 
      where listings.id not in (select listing_id from listing_users where 
          user_id=[user_id]) and [where] 
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
    $_REQUEST["user_id"]=$_SESSION["user"]["id"];
//$db->debug=true;

    if($data=$db->get_data($sql,$_REQUEST)){     
        foreach($data as $rownumber=>$row){
            if($rownumber==0) continue;
            print <<<EOD
                {$row["name"]} 
                <a href="action/my_listings.php?action=associate_listing&listing_id={$row["id"]}&params={$params}">Associate</a>
                <br>
EOD;
        }
    } else {
        print "No Listings Found that match your criteria, please try again.";
    }
          
      
    } else {
?>

              <form action="profile.php?action=find_listing" method="post">
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
                        <input type='image' src="../../images/find_red.gif" name='search[]'>
                    </td>
                </table>
              </form>

<?php
     }
?>