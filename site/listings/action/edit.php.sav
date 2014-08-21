<?php
//my_listings action page
ob_start();

  session_start();
  $_SESSION["error"]="";

 
  if(is_array($_POST["action"])){
    $id=array_shift(array_keys($_POST["action"]));
    $_POST["action"]=$_POST["action"][$id];
  } else {
      if(isset($_REQUEST["action"])) $_POST["action"]=$_REQUEST["action"];
      if(isset($_REQUEST["id"])) $id=$_REQUEST["id"];
  }
  
  switch($_POST["action"]){
      case "Edit Listing":
           if(setup_post($id)){
               return_result();
           } else {
               header("location:../edit.php");
           }
           break;
  }
     
  //catch all
  if(isset($_POST["action"])){
      $_SESSION["error"]="Unhandled action '{$_POST["action"]}'.";
  } else {
      $_SESSION["error"]="No action specified.";
  }
  header("location:../edit.php");
  exit;
  
  function return_result(){
      global $_SESSION,$_POST;
      
      $_SESSION["previous_post"]=$_POST["listing"];
      header("location:../add.php");
      exit;
  }
  
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