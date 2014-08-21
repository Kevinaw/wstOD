<?php
//register action page
  session_start();

  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();

  //check captcha
  include("../captcha/securimage.php");
  $img = new Securimage();
  $valid = $img->check($_POST['code']);

  if($valid != true) {
    $_SESSION["error"]="Invalid Security Code Entered, please try again.";
    header("Location:../register.php");
    exit;
  } 
  
  //check confirm password
  if($_POST["password"]!=$_POST["confirm_password"]){
    $_SESSION["error"]="Password confirmation failed, please try again.";
    header("Location:../register.php");
    exit;
  }

  //check for duplicate email address
  $sql="select * from users where username='[email]'";
  if(!$users=$db->get_data($sql,array("email"=>$_POST["email"]))){
    $_SESSION["error"]="Unable to create new user at this time, please try again. ";
    header("Location:../register.php");
    exit;
  }
  if(count($users)>1){
    if($users[1]["verified"]==0){
      header("Location:../resend_code.php?email=".$_POST["email"]);
    } else {
      $_SESSION["error"]=<<<EOD
        {$_POST["email"]} already exists as a user, 
        please try resetting your password instead.
EOD;
      header("location:../forgot_password.php");
    }
    exit;
  }
  
  //create the user in the db
  $random_code=generatePassword();
  $sql="insert into users (username,password,verification_code) values ('[email]','[password]','[code]')";
  if(!$db->set_data($sql,array("email"=>$_POST["email"],"password"=>sha1($_POST["password"]),"code"=>$random_code))){
    $_SESSION["error"]="Unable to create new user, please try again. ";
    header("Location:../register.php");
    exit;
  }
  
  header("location:../verify_code.php?email=".$_POST["email"]);
  

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}


?>