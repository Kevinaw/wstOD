<?php
//forgot password action page
  session_start();
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  $debug=true;
  
  //check captcha
  include("../captcha/securimage.php");
  $img = new Securimage();
  $valid = $img->check($_POST['code']);

  if($valid != true) {
    $_SESSION["error"]="Invalid Security Code Entered, please try again.";
    header("Location:../forgot_password.php");
    exit;
  } 
  
  //update the password
  $password=generatePassword();
  $sql="update users set password='[password]' where username='[email]'";
  $rtnval=$db->set_data($sql,array("email"=>$_POST["email"],"password"=>sha1($password)));
  if(!$rtnval){
    $_SESSION["error"]="Unable to reset password, please try again. ";
    header("Location:../forgot_password.php");
    exit;
  }
  
  
  //send the email confirmation
  $message=<<<EOD
      This message is being sent in response to a request for a new password 
      on www.oildirectory.com.  If you have received this 
      email in error, please disregard this notification.
      <br>
      <br>
      Your new password is:
      <br>
      <br>
      <b>New Password = {$password}</b>
      <br>
      <br>
      Thanks  
EOD;


  if($debug){
      $_SESSION["error"]=$message;
  } else {
    sendmail($_POST["email"],"Oildirectory.com New User Email Verification",$message);
    $_SESSION["error"]="A new password was sent to {$_POST["email"]}, please login with the new password.";
  }
  
  header("location:../login.php");
  
  
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
  
function sendmail($to,$subject,$message,$from="service@oildirectory.com"){

  ini_set("SMTP","oildirectory.com");
  
  $headers=array();

$headers[]= "From: ".$from." <".$from.">"; 
$headers[]= "Return-Path: ".$from; 
$headers[]= "MIME-Version: 1.0"; 
$headers[]= "Content-Type: text/html; charset=ISO-8859-1"; 


  $headers=join("\n",$headers);
  
  return mail($to,$subject,$message,$headers,"-f ".$from);

}
  
?>