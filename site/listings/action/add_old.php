<?php
//my_listings action page
ob_start();
  session_start();
  $_SESSION["error"]="";
  
  $action=$_REQUEST["action"];
  if(is_array($action)){
    $id=array_shift(array_keys($action));
    if(is_array($action[$id])){
        $action=$id;
    } else {
         $action=$action[$id];
    }
  } else {
      if(isset($_REQUEST["id"])) $id=$_REQUEST["id"];
  }


  
  switch($action){
      case "Edit Listing":
           setup_post($id);
      break;
      case "Add Location":
      
           if(!isset($_POST["listing"]["new"]["locations"])) $_POST["listing"]["new"]["locations"]=array();
           $_POST["listing"]["new"]["locations"][]=array(
               "id"=>-1,
               "contact_name"=>"",
               "address1"=>"",
               "address2"=>"",
               "city"=>"",
               "country_id"=>"",
               "province_id"=>"",
               "pcode"=>"",
               "phone"=>"",
               "fax"=>"",
               "cell"=>"",
               "tollfree"=>"",
               "email"=>"",
               "email2"=>"",
               "website"=>""
           );


           //return_result();
           break;
      case "Remove Location":
           unset($_POST["listing"]["new"]["locations"][$id]);
           //return_result();
           break;
      case "Remove Category":
          $new_categories=array();
          foreach($_POST["listing"]["new"]["categories"] as $id=>$value){
              if(!in_array($value,$_POST["remove_categories"])) $new_categories[]=$value;
          }
          $_POST["listing"]["new"]["categories"]=$new_categories;
          //return_result();
          break;
      case "Add Category":
          foreach($_POST["new_categories"] as $id=>$value){
              $_POST["listing"]["new"]["categories"][]=$value;
          }
         // return_result();
          break;
      break;
      case "Cancel Changes":
            header("location:../main.php");
            exit;

      break;
      case "Delete Listing":
          $errors=delete_listing($_POST["listing"]["current"]["info"]["id"]);
          if(!count($errors)){
            $_SESSION["error"]="Listing Deleted.";
            header("location:../main.php");
            exit;
          } else {
            $_SESSION["error"]=join("<br>",$errors);
         //   return_result();
          }
 //         header("location:../edit.php");
 //         exit;

      break;
      case "Save Changes":
          $errors=save_listing();
          $_SESSION["error"]=join("<br>",$errors);
  //        return_result();
      break;
      

  }
    
    
  //catch all
 // if(isset($_POST["action"])){
 //     $_SESSION["error"]="Unhandled action '{$action}'.".implode(",",$_POST["action"]);
 // } else {
  //    $_SESSION["error"]="No action specified.";
 // }
 // header("location:../add.php");
 // exit;
  
 // function return_result(){
 //    global $_SESSION,$_POST;
      
  //    $_SESSION["previous_post"]=$_POST["listing"];
  //    header("location:../add.php");
  //    exit;
 // }
 
  function save_listing(){
      global $_POST,$_SESSION;
      
      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();

      $errors=array();
      if(strlen($_POST["listing"]["new"]["info"]["name"])<5) $errors[]="The name must be greater than 4 characters.";
      if(strlen($_POST["listing"]["new"]["info"]["name"])>500) $errors[]="The name must be less than 500 characters.";
      if(strlen($_POST["listing"]["new"]["info"]["description"])<5) $errors[]="The description must be greater than 4 characters.";
      
      if(count($errors)>0) return $errors;

      $id=$_POST["listing"]["current"]["info"]["id"];
      if($id==-1){
          $sql="insert into listings (name,description) values ('[name]','[description]')";
          if(!$id=$db->set_data_return_id($sql,$_POST["listing"]["new"]["info"])){
              $errors[]="Unable to add listing. ".$db->lasterror;
              return $errors;
          }

          $sql=array();
          $sql[]="insert into history_listings select *,'add',current_timestamp from listings where id={$id}";
    
          $return=$db->set_data_multi($sql,$_POST["listing"]["new"]["info"]);
          $errors[]="Listing added.";
          $_POST["listing"]["new"]["info"]["id"]=$id;
          $_POST["listing"]["current"]["info"]=$_POST["listing"]["new"]["info"];
      } else {
      
          if($_POST["listing"]["current"]["info"]!=$_POST["listing"]["new"]["info"]){
            $sql=array();
            $sql[]="insert into history_listings select *,'update',current_timestamp from listings where id=[id];";
            $sql[]="update listings set name='[name]',description='[description]' where id=[id]";
  
            $return=$db->set_data_multi($sql,$_POST["listing"]["new"]["info"]);
            if(!$return){
                $errors[]="Unable to update Company Information. ".$db->lasterror;
            } else {
                $errors[]=<<<EOD
                    An email has been sent to {$_POST["listing"]["new"]["info"]["email"]} to confirm the listing change.  
                    Please click on the link in the confirmation email to confirm these changes.  If your email address 
                    we have on file is no longer valid, please email <a href="mailto:service@oildirectory.com">service@oildirectory.com</a> 
                    with your listing name to request a change.
EOD;

                $_POST["listing"]["current"]["info"]=$_POST["listing"]["new"]["info"];
            }
          }
      }
      
      if(isset($_POST["listing"]["new"]["locations"])){
          $errors=array_merge($errors,save_locations($id,$db));
      }

      if(isset($_POST["listing"]["new"]["categories"])){
          $errors=array_merge($errors,save_categories($id,$db));
      }


      return $errors;

  }
  
  function save_locations($listing_id,&$db){
      global $_POST;
      
      $locations=$_POST["listing"]["new"]["locations"];
  
      $errors=array();

      //check for deleted locations
      if(isset($_POST["listing"]["current"]["locations"])){
        foreach($_POST["listing"]["current"]["locations"] as $locnum=>$info){
            if(!isset($locations[$locnum])){
                //delete location 
                 $sql=array();
                 $sql[]="insert into history_listing_locations select *,'remove',current_timestamp from listing_locations where id=[id];";
                 $sql[]="delete from listing_locations where id=[id]";
  
                  $return=$db->set_data_multi($sql,$info);
                  if(!$return){
                      $errors[]="Unable to delete location #{$locnum}. ".$db->lasterror;
                      $_POST["listing"]["new"]["locations"][$locnum]=$info;
                  } else {
                      $errors[]="Location #{$locnum} deleted.";
                      unset($_POST["listing"]["current"]["locations"][$locnum]);
                  }
            }
        }
      }
      
      
      //check for errors in updated or added locations
      foreach($locations as $locnum=>$info){

          $new_errors=array();
          if(strlen($info["phone"])<7) $new_errors[]="The Phone for Location #{$locnum} must be greater than 7 characters.";
          if(strlen($info["province_id"])==0) $new_errors[]="You must choose a Province/State for Location #{$locnum}.";
          if(strlen($info["country_id"])==0) $new_errors[]="You must choose a Country for Location #{$locnum}.";

          //do the update if no errors
          if(count($new_errors)){
              $errors=array_merge($errors,$new_errors);
          } else {
              if($info["id"]==-1){
                  //add new location
                 $sql=array();
                 $sql=<<<EOD
                     insert into listing_locations (
                         listing_id,contact_name,phone,fax,cell,tollfree,address1,address2,
                         city,province_id,country_id,pcode,email,email2,website  
                     ) values (
                         [listing_id],'[contact_name]','[phone]','[fax]','[cell]','[tollfree]',
                         '[address1]','[address2]','[city]','[province_id]',
                         '[country_id]','[pcode]','[email]','[email2]','[website]') 
EOD;

                  $info["listing_id"]=$_POST["listing"]["current"]["info"]["id"];
                  if(!$id=$db->set_data_return_id($sql,$info)){
                      $errors[]="Unable to add location #{$locnum}. ".$db->lasterror;
                  } else {
                      $sql=array();
                      $sql[]="insert into history_listing_locations select *,'add',current_timestamp from listing_locations where id=LAST_INSERT_ID()";
                      $return=$db->set_data_multi($sql,$info);
                      $errors[]="Location #{$locnum} added.";
                      $info["id"]=$id;
                      $_POST["listing"]["new"]["locations"][$locnum]=$info;
                      $_POST["listing"]["current"]["locations"][$locnum]=$info;
                  }
              } else {
                  //update existing location if it has changed
                  if($info!=$_POST["listing"]["current"]["locations"][$locnum]){
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
                    $return=$db->set_data_multi($sql,$info);
                    if(strlen($db->lasterror)){
                        $errors[]="Unable to update location #{$locnum}. ".$db->lasterror;
                    } else {
                        $errors[]="Location #{$locnum} updated.";
                        $_POST["listing"]["current"]["locations"][$locnum]=$info;
                    }
                  }
              }
          }
      }

      return $errors;

  }

  function save_categories($listing_id,&$db){
      global $_POST;
  
      $errors=array();
      //check for new categories
      foreach($_POST["listing"]["new"]["categories"] as $rownum=>$id){
          if(!isset($_POST["listing"]["current"]["categories"]) or !in_array($id,$_POST["listing"]["current"]["categories"])){
              //add category
              $sql=array();
              $sql[]="insert into listing_business_types (listing_id,business_type_id) values ([listing_id],[id]);";
              $sql[]="insert into history_listing_business_types (id,listing_id,business_type_id,action) select last_insert_id(),[listing_id],[id],'add';";

              if($db->set_data_multi($sql,array("listing_id"=>$listing_id,"id"=>$id))){
                  $errors[]="Added Category";
                  $_POST["listing"]["current"]["categories"][]=$id;
              } else {
                  $errors[]="Add Category failed";
              }
          }
      }
      if(isset($_POST["listing"]["current"]["categories"])){
        foreach($_POST["listing"]["current"]["categories"] as $rownum=>$id){
            if(!in_array($id,$_POST["listing"]["new"]["categories"])){
                //remove category
                $sql=array();
                $sql[]="insert into history_listing_business_types (id,listing_id,business_type_id,action) select id,listing_id,business_type_id,'remove' from listing_business_types where listing_id=[listing_id] and business_type_id=[id];";
                $sql[]="delete from listing_business_types where listing_id=[listing_id] and business_type_id=[id]";
  
                if($db->set_data_multi($sql,array("listing_id"=>$listing_id,"id"=>$id))){
                    $errors[]="Removed Category";
                    unset($_POST["listing"]["current"]["categories"][$rownum]);
                } else {
                    $errors[]="Remove Category failed";
                }
            }
        }
      }

      return $errors;

  }

  function delete_listing($listing_id){
      global $_POST,$_SESSION;
      
      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();

      $errors=array();
      
      $sql=array();
      $sql[]="insert into history_listings select *,'remove',current_timestamp from listings where id=[listing_id];";
      $sql[]="insert into history_listing_locations select *,'remove',current_timestamp from listing_locations where listing_id=[listing_id];";
      $sql[]="insert into history_listing_business_types select *,'remove',current_timestamp from listing_business_types where listing_id=[listing_id];";
      $sql[]="insert into history_banners select *,'remove',current_timestamp from banners where listing_id=[listing_id];";
      $sql[]="insert into history_logos select *,'remove',current_timestamp from logos where listing_id=[listing_id];";
      $sql[]="insert into history_premium select *,'remove',current_timestamp from premium where listing_id=[listing_id];";
      $sql[]="insert into history_videos select *,'remove',current_timestamp from videos where listing_id=[listing_id];";

      $sql[]="delete from listings where id=[listing_id];";
      $sql[]="delete from listing_locations where listing_id=[listing_id];";
      $sql[]="delete from listing_business_types where listing_id=[listing_id];";
      $sql[]="delete from banners where listing_id=[listing_id];";
      $sql[]="delete from logos where listing_id=[listing_id];";
      $sql[]="delete from premium where listing_id=[listing_id];";
      $sql[]="delete from videos where listing_id=[listing_id];";
      
      $rtnval=$db->set_data_multi($sql,array("listing_id"=>$listing_id));
      if(strlen($db->lasterror)){
          $errors[]="Unable to delete listing.  ".$db->lasterror;
      }
      return $errors;

  }
  
  
  
  
  //following added
  
  function setup_post($listing_id){
      global $_POST,$_SESSION;
      
      $_POST["listing"]=array(
          "current"=>array(
              "info"=>array(),
              "locations"=>array(),
              "categories"=>array()
          ),
          "premium"=>false,
          "expires"=>"Not Available"
      );
      
      //get the data from the db
      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();
      //get the listing
      $sql="select id,name,description from listings where id=[id]";
      if(!$data=$db->get_data($sql,array("id"=>$listing_id)) or count($data)!=2){
          $_SESSION["error"]="Unable to retrieve listing, please try again.";
          return false;
      } else {
          $_POST["listing"]["current"]["info"]=$data[1];
      }
      
      //get the locations
      $sql=<<<EOD
                 select id,contact_name,address1,address2,city,province_id,
                        country_id,phone,fax,cell,tollfree,email,email2,website,pcode  
                 from listing_locations where listing_id=[id]
EOD;
      if(!$data=$db->get_data($sql,array("id"=>$listing_id))){
          $_SESSION["error"]="Unable to retrieve listing, please try again.";
          return false;
      } else {
          array_shift($data); //remove the header row
          $_POST["listing"]["current"]["locations"]=$data;
      }
      
      //get the locations
      $sql="select * from listing_business_types where listing_id=[id]";
      if(!$data=$db->get_data($sql,array("id"=>$listing_id))){
          $_SESSION["error"]="Unable to retrieve listing, please try again.";
          return false;
      } else {
          array_shift($data); //remove the header row
          foreach($data as $rownum=>$row){
              $_POST["listing"]["current"]["categories"][]=$row["business_type_id"];
          }
      }
      
      //see if they are already premium
      $_POST["listing"]["premium"]=false;
      $_POST["listing"]["expires"]="Not Available";
      $sql="select *,case when expires<current_timestamp then 1 else 0 end as expired from premium where listing_id=[id] order by expires desc limit 1";
      if($data=$db->get_data($sql,array("id"=>$listing_id))){
          if(count($data)==2){
              if($data[1]["expired"]==0){
                  $_POST["listing"]["premium"]=true;
                  $_POST["listing"]["expires"]=$data[1]["expires"];
              }
          }
      }

      //setup the new to = current
      $_POST["listing"]["new"]=$_POST["listing"]["current"];
      
      return true;
  }  
?>