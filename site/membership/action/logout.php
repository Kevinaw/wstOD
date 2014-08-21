<?php
//logout action page
  session_start();
  
  $_SESSION=array();
  unset($_SESSION);
  
  session_write_close();
  
  header("location:../login.php");
?>