<?php
//forgot password action page
  session_start();
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  $debug=true;
  
  //check confirm password
  if($_POST["password"]!=$_POST["confirm_password"]){
    $_SESSION["error"]="Password confirmation failed, please try again.";
    header("Location:../profile.php");
    exit;
  }

  //update the password
  $sql="update users set password='[password]' where username='[email]'";
  $rtnval=$db->set_data($sql,array("email"=>$_POST["email"],"password"=>sha1($_POST["password"])));
  if(!$rtnval){
    $_SESSION["error"]="Unable to reset password, please try again. ".$db->lasterror;
    header("Location:../profile.php");
    exit;
  }

  $_SESSION["error"]="Password Changed Successfully. ";
  header("location:../profile.php");
  
  

  
?>