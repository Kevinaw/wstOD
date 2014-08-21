<?php
//profile action page
  session_start();
  
  $_SESSION["user"]=array("id"=>"unregistered","username"=>"Unregistered User");
  
  header("location:../profile.php");  
?>