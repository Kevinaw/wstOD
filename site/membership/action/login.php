<?php
//login action page

  session_start();
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  
  $parms="action={$_REQUEST["action"]}&listing_id={$_REQUEST["listing_id"]}";
      
  $db=new Database();

  $sql="select * from users where username='[email]' and password='[password]'";
  if(!$data=$db->get_data($sql,array("email"=>$_POST["email"],"password"=>sha1($_POST["password"])))){
      $_SESSION["error"]="Unable to login at this time, please try again later.";
      header("location:../login.php?{$parms}");
      exit;
  }
  if(count($data)<2){
      $_SESSION["error"]="Invalid user id or password, please try again.";
      header("location:../login.php?{$parms}");
      exit;
  }

  if($data[1]["verified"]){
      $_SESSION["user"]=$data[1];
      header("location:../profile.php?{$parms}");

  } else {

    header("Location:../resend_code.php?email={$_POST["email"]}");
  }
  
?>