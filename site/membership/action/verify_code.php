<?php
//verify code action page
  session_start();
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  
  //check for valid code
  $sql="update users set verified=1 where username='[email]' and verification_code='[code]'";
  $rtnval=$db->set_data($sql,array("email"=>$_REQUEST["email"],"code"=>$_POST["verification_code"]));
  if(!$rtnval){
    $_SESSION["error"]="Verification code invalid, please try again. ";
    header("Location:../verify_code.php");
    exit;
  }
  
  $_SESSION["error"]="Email address verified, please login.";
  header("location:../login.php");
  
?>