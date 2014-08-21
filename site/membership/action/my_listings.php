<?php
//my_listings action page

  session_start();
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      
  $db=new Database();
  
  if(!isset($_SESSION["user"])) header("location:../login.php");
  if(!isset($_REQUEST["action"])) exit;
  
  if(is_array($_REQUEST["action"])){
    $id=array_shift(array_keys($_REQUEST["action"]));
    $_REQUEST["action"]=$_REQUEST["action"][$id];
  }
  
  switch($_REQUEST["action"]){
      case "associate_listing":  
          $params=array("listing_id"=>$_REQUEST["listing_id"],
                        "user_id"=>$_SESSION["user"]["id"]);
          
          //$debug=true;
          $sql=array();
          $sql[]="insert into listing_users (user_id,listing_id) values ([user_id],[listing_id])";
          $sql[]="insert into history_listing_users (id,user_id,listing_id,action) select id,user_id,listing_id,'add' from listing_users where id=LAST_INSERT_ID()";

          $return=$db->set_data_multi($sql,$params);
          if(!$return){
              $_SESSION["error"]="Unable to associate listing. ".$db->lasterror;
          }
          //print "location:../profile.php?action=find_listing&{$_REQUEST["params"]}";
          
          header("location:../profile.php?action=find_listing&search=true&{$_REQUEST["params"]}");
          exit;
      break;
      case "Unassociate Listing":
          $params=array("listing_id"=>$_REQUEST["listing_id"],
                        "user_id"=>$_SESSION["user"]["id"]);

          //$db->debug=true;
          $sql=array();
          $sql[]="insert into history_listing_users (id,user_id,listing_id,action) select id,user_id,listing_id,'remove' from listing_users where user_id=[user_id] and listing_id=[listing_id]";
          $sql[]="delete from listing_users where user_id=[user_id] and listing_id=[listing_id]";

          $return=$db->set_data_multi($sql,$params);
          if(!$return){
              $_SESSION["error"]="Unable to unassociate listing. ".$db->lasterror;
          }
          header("location:../profile.php");
          exit;
      break;
      case "Delete Listing":
          //$db->debug=true;
          $sql=array();
          $sql[]="insert into history_listings select *,'remove',current_timestamp from listings where id=[listing_id];";
          $sql[]="insert into history_listing_locations select *,'remove',current_timestamp from listing_locations where listing_id=[listing_id];";
          $sql[]="insert into history_listing_users select *,'remove',current_timestamp from listing_users where listing_id=[listing_id];";
          $sql[]="insert into history_listing_business_types select *,'remove',current_timestamp from listing_business_types where listing_id=[listing_id];";
          $sql[]="insert into history_banners select *,'remove',current_timestamp from banners where listing_id=[listing_id];";
          $sql[]="insert into history_logos select *,'remove',current_timestamp from logos where listing_id=[listing_id];";
          $sql[]="insert into history_premium select *,'remove',current_timestamp from premium where listing_id=[listing_id];";
          $sql[]="insert into history_videos select *,'remove',current_timestamp from videos where listing_id=[listing_id];";

          $sql[]="delete from listings where id=[listing_id];";
          $sql[]="delete from listing_locations where id=[listing_id];";
          $sql[]="delete from listing_users where id=[listing_id];";
          $sql[]="delete from listing_business_types where id=[listing_id];";
          $sql[]="delete from banners where id=[listing_id];";
          $sql[]="delete from logos where id=[listing_id];";
          $sql[]="delete from premium where id=[listing_id];";
          $sql[]="delete from videos where id=[listing_id];";
          
          $return=$db->set_data_multi($sql,array("listing_id"=>$_POST["listing_id"]));
          if(!$return){
              $_SESSION["error"]="Unable to delete listing. ".$db->lasterror;

              header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
          } else {
              header("location:../profile.php");
          }
          exit;
          
      break;
      case "save_listing":
          //check for errors
          $errors=array();
          if(strlen($_POST["listing"]["name"])<5) $errors[]="The name must be greater than 4 characters.";
          if(strlen($_POST["listing"]["name"])>500) $errors[]="The name must be less than 500 characters.";
          if(strlen($_POST["listing"]["description"])<5) $errors[]="The description must be greater than 4 characters.";
          
          if(count($errors)>0){
              $_SESSION["error"]=join("<br>",$errors);
              $params="action=edit_listing&listing_id={$_REQUEST["listing_id"]}&name={$_POST["listing"]["name"]}&description={$_POST["listing"]["description"]}";
              header("location:../profile.php?{$params}");
              exit;
          }

          $sql=array();
          $sql[]="insert into history_listings select *,'update',current_timestamp from listings where id=[id];";
          $sql[]="update listings set name='[name]',description='[description]' where id=[id]";

          $return=$db->set_data_multi($sql,$_POST["listing"]);
          if(!$return){
              $_SESSION["error"]="Unable to update listing. ".$db->lasterror;
          } else {
              $_SESSION["error"]="Listing updated.";
          }
          $params="action=edit_listing&listing_id={$_REQUEST["listing_id"]}&name={$_POST["listing"]["name"]}&description={$_POST["listing"]["description"]}";
          header("location:../profile.php?{$params}");
          exit;
      break;
      case "new_listing":
          //check for errors
          $errors=array();
          if(strlen($_POST["listing"]["name"])<5) $errors[]="The name must be greater than 4 characters.";
          if(strlen($_POST["listing"]["name"])>500) $errors[]="The name must be less than 500 characters.";
          if(strlen($_POST["listing"]["description"])<5) $errors[]="The description must be greater than 4 characters.";
          
          if(count($errors)>0){
              $_SESSION["error"]=join("<br>",$errors);
              $params="action=add_listing&name={$_POST["listing"]["name"]}&description={$_POST["listing"]["description"]}";
              header("location:../profile.php?{$params}");
              exit;
          }

          $sql="insert into listings (name,description) values ('[name]','[description]')";
          if(!$id=$db->set_data_return_id($sql,$_POST["listing"])){
              $_SESSION["error"]="Unable to add listing. ".$db->lasterror;
              $params="action=add_listing&name={$_POST["listing"]["name"]}&description={$_POST["listing"]["description"]}";
              header("location:../profile.php?{$params}");
              exit;
          }
          
          $sql=array();
          $sql[]="insert into history_listings select *,'add',current_timestamp from listings where id={$id}";

          //only add association if the user is registered            
          if($_SESSION["user"]["id"]!="unregistered"){
              $_POST["listing"]["user_id"]=$_SESSION["user"]["id"];
              $sql[]="insert into listing_users (user_id,listing_id) values ([user_id],{$id})";
              $sql[]="insert into history_listing_users (id, user_id,listing_id,action) select id,user_id,listing_id,'add' from listing_users where id=LAST_INSERT_ID()";
          }
            
          $return=$db->set_data_multi($sql,$_POST["listing"]);
          $_SESSION["error"]="Listing added.";
            
          header("location:../profile.php?action=edit_listing&listing_id=".$id);
            
          
          exit;
      break;
      case "add_location":
          //check for errors
          $errors=array();
          if(strlen($_POST["listing_locations"]["city"])<5) $errors[]="The City must be greater than 4 characters.";
          if(strlen($_POST["listing_locations"]["phone"])<7) $errors[]="The Phone must be greater than 7 characters.";
          if(strlen($_POST["listing_locations"]["province_id"])==0) $errors[]="You must choose a Province/State.";
          if(strlen($_POST["listing_locations"]["country_id"])==0) $errors[]="You must choose a Country.";

          if(count($errors)>0){
              $_SESSION["error"]=join("<br>",$errors);
              $params="action=edit_listing&listing_id=".$_REQUEST["listing_id"];
              header("location:../profile.php?{$params}");
              exit;
          }
          
         $sql=array();
         $sql[]=<<<EOD
             insert into listing_locations (
                 listing_id,contact_name,phone,fax,cell,tollfree,address1,address2,
                 city,province_id,country_id,pcode,email,email2,website  
             ) values (
                 [listing_id],'[contact_name]','[phone]','[fax]','[cell]','[tollfree]',
                 '[address1]','[address2]','[city]','[province_id]',
                 '[country_id]','[pcode]','[email]','[email2]','[website]') 
EOD;
          $sql[]="insert into history_listing_locations select *,'add',current_timestamp from listing_locations where id=LAST_INSERT_ID()";

          $return=$db->set_data_multi($sql,$_POST["listing_locations"]);
          if(!$return){
              $_SESSION["error"]="Unable to add location. ".$db->lasterror;
          } else {
              $_SESSION["error"]="Location added.";
          }
          header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
          exit;
      break;
      case "edit_location":
          switch($_POST["edit_type"]){
              case "Save":
                  //check for errors
                  $errors=array();
                  if(strlen($_POST["listing_locations"]["city"])<5) $errors[]="The City must be greater than 4 characters.";
                  if(strlen($_POST["listing_locations"]["phone"])<7) $errors[]="The Phone must be greater than 7 characters.";
                  if(strlen($_POST["listing_locations"]["province_id"])==0) $errors[]="You must choose a Province/State.";
                  if(strlen($_POST["listing_locations"]["country_id"])==0) $errors[]="You must choose a Country.";
        
                  if(count($errors)>0){
                      $_SESSION["error"]=join("<br>",$errors);
                      $params="action=edit_listing&listing_id=".$_REQUEST["listing_id"];
                      header("location:../profile.php?{$params}");
                      exit;
                  }
                  
                 $sql=array();
                 $sql[]="insert into history_listing_locations select *,'update',current_timestamp from listing_locations where id=[id];";
                 $sql[]=<<<EOD
                     update listing_locations set 
                            contact_name='[contact_name]',
                            phone='[phone]',
                            fax='[fax]',
                            cell='[cell]',
                            tollfree='[tollfree]',
                            address1='[address1]',
                            address2='[address2]',
                            city='[city]',
                            province_id='[province_id]',
                            country_id='[country_id]',
                            pcode='[pcode]',
                            email='[email]',
                            email2='[email2]',
                            website='[website]' 
                     where id=[id]
EOD;

                  $return=$db->set_data_multi($sql,$_POST["listing_locations"]);
                  if(!$return){
                      $_SESSION["error"]="Unable to update location. ".$db->lasterror;
                  } else {
                      $_SESSION["error"]="Location updated.";
                  }
                  header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
                  exit;
                   
              break;
              case "Delete":
                 $sql=array();
                 $sql[]="insert into history_listing_locations select *,'remove',current_timestamp from listing_locations where id=[id];";
                 $sql[]="delete from listing_locations where id=[id]";

                  $return=$db->set_data_multi($sql,$_POST["listing_locations"]);
                  if(!$return){
                      $_SESSION["error"]="Unable to delete location. ".$db->lasterror;
                  } else {
                      $_SESSION["error"]="Location deleted.";
                  }
                  header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
                  exit;
              break;
          }
      break;
      case "edit_categories":
          switch(array_shift(array_keys($_POST["edit_type"]))){
              case "remove":
                  $_POST["categories"]["selected"]=join(",",$_POST["categories"]["selected"]);
                  $sql=array();
                  $sql[]="insert into history_listing_business_types (id,listing_id,business_type_id,action) select id,listing_id,business_type_id,'remove' from listing_business_types where listing_id=[listing_id] and business_type_id in ([selected])";
                  $sql[]="delete from listing_business_types where listing_id=[listing_id] and business_type_id in ([selected])";

                  $return=$db->set_data_multi($sql,$_POST["categories"]);
                  if(!$return){
                      $_SESSION["error"]="Unable to remove categories. ".$db->lasterror;
                  } else {
                      $_SESSION["error"]="Categories removed.";
                  }
                  header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
                  exit;
              break;
              case "add":
                  $_POST["categories"]["unselected"]=join(",",$_POST["categories"]["unselected"]);
                  $sql=array();
                  $sql[]="insert into listing_business_types (listing_id,business_type_id) select [listing_id],id from businesstypes where id in ([unselected])";
                  $sql[]="insert into history_listing_business_types (id,listing_id,business_type_id,action) select id,listing_id,business_type_id,'add' from listing_business_types where listing_id=[listing_id] and business_type_id in ([unselected])";

                  $return=$db->set_data_multi($sql,$_POST["categories"]);
                  if(!$return){
                      $_SESSION["error"]="Unable to add categories. ".$db->lasterror;
                  } else {
                      $_SESSION["error"]="Categories added.";
                  }
                  header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
                  exit;
              break;
          }
      break;
      case "add_premium":
           require_once $_SERVER['DOCUMENT_ROOT']."/includes/crypt.inc";          

            $crypt = new proCrypt;
            
            // encrypt the credit card strings
            $_POST["premium"]["payment_type"]=$crypt->encrypt($_POST["premium"]["payment_type"]);
            $_POST["premium"]["name_on_card"]=$crypt->encrypt($_POST["premium"]["name_on_card"]);
            $_POST["premium"]["card_number"]=$crypt->encrypt($_POST["premium"]["card_number"]);
            $_POST["premium"]["card_expiry"]=$crypt->encrypt($_POST["premium"]["card_expiry"]);
            $_POST["premium"]["security_code"]=$crypt->encrypt($_POST["premium"]["security_code"]);
            
            $sql=array();
            $sql[]="insert into premium (listing_id,expires) values ([listing_id],date_add(now(), interval 1 year))";
            $sql[]="insert into history_premium (id,listing_id,expires,action) select id,listing_id,expires,'add' from premium where id=LAST_INSERT_ID()";
            $sql[]="insert into invoice (listing_id,payment_type,card_name,card_number,card_expiry,card_security) values ([listing_id],'[payment_type]','[name_on_card]','[card_number]','[card_expiry]','[security_code]')";
            $sql[]="insert into invoice_items (invoice_id,description,quantity,unit_price) values (last_insert_id(),'Premium Listing',1,99.95)";
            
            $return=$db->set_data_multi($sql,$_POST["premium"]);
            if(!$return){
                $_SESSION["error"]="Unable to add premium listing. ".$db->lasterror;
            } else {
                $_SESSION["error"]="Premium Listing added.";
            }
            header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
            exit;


            // decrypt the string
            //echo $crypt->decrypt( $encoded );
            
            
      exit;
      break;
  }
    
    
  //catch all
  if(isset($_REQUEST["action"])){
      $_SESSION["error"]="Unhandled action '{$_REQUEST["action"]}'.";
  } else {
      $_SESSION["error"]="No action specified.";
  }
  if(isset($_REQUEST["listing_id"])){
    header("location:../profile.php?action=edit_listing&listing_id=".$_REQUEST["listing_id"]);
  } else {
    header("location:../profile.php");
  }
 
?>