<?php


  session_start();
  
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      
  $db=new Database();

  $sql=<<<EOD
      select listings.*,listing_users.id as listing_user_id 
      from listing_users 
      join listings on listings.id=listing_id 
      where user_id=[user_id] 
      order by listings.name
EOD;

  if(!$data=$db->get_data($sql,array("user_id"=>$_SESSION["user"]["id"]))){
      print "List currently unavailable<br>";
  }
  if(count($data)<2){
      print "You currently have no listings associated with your user id<br>";
  } else {
      foreach($data as $rownumber=>$row){
          if($rownumber==0) continue;
          
          print <<<EOD
              <div style='overflow:hidden; height:1em;'>
                  <div style='float:left; overflow:hidden;'>
                      {$row["name"]}
                  </div>
                  <div style='float:right;'> 
                       <a href="profile.php?action=edit_listing&listing_id={$row["id"]}">edit</a>
                  </div>
              </div>
EOD;
      }
  }
  
  print <<<EOD
      <br><b><a href="profile.php?action=find_listing">Find My Listings</a></b>
      <br><b><a href="profile.php?action=add_listing">Add a New Listings</a></b>
EOD;

?>