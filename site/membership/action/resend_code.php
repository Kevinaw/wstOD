<?php

if($_POST["resend"]=="Yes"){
  header("location:../verify_code.php?email=".$_POST["email"]);
  exit;
}

$_SESSION["error"]="Email already exists, please try again.";
header("location:../login.php");
exit;
?>