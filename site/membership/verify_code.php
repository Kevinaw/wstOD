<?php

  session_start();
  ob_start();
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  $debug=($_SERVER["SERVER_NAME"]=="localhost")?true:false;
  
  $error="";
  if(isset($_SESSION["error"])){
      $error=$_SESSION["error"];
      unset($_SESSION["error"]);
  }
  
  //get the information based on the email sent in
  $sql="select * from users where username='[email]'";
  if(!$data=$db->get_data($sql,array("email"=>$_REQUEST["email"]))){
      header("location:login.php");
      exit;
  }
  if(count($data)<2){
      header("location:login.php");
      exit;
  }
  $random_code=$data[1]["verification_code"];
  
  
  //send the email confirmation
  $message=<<<EOD
      This message is being sent in response to a request for a new user 
      registration on www.oildirectory.com.  If you have received this 
      email in error, please disregard this notification.
      <br>
      <br>
      To confirm your registration, please enter the following verfication code 
      in the verification code box on the www.oildirectory.com registration page.
      <br>
      <br>
      <b>Verification Code = {$random_code}</b>
      <br>
      <br>
      Thanks  
EOD;


  $_SESSION["code"]=$random_code;
  $_SESSION["email"]=$_REQUEST["email"];
  if($debug){
      $error=$message;
  } else {
    sendmail($_REQUEST["email"],"Oildirectory.com New User Email Verification",$message);
//    Header("location:../verify_code.php");
  }
  
  
?>
<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Oildirectory.com</title>
  <link rel="stylesheet" type="text/css" media="screen" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/ads.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/submission.css" />
  <script type="text/javascript" src="/includes/forcetop.inc"></script>
</head>

<body>
<div id="content">
<h2>New User Registration - Step 2 of 2</h2>

An email has just been sent to you at <?php echo $_REQUEST["email"]; ?> with 
a verification code.  Please enter the code in the box below and click on the 
"Verify Email Address" button to complete your registration.<br>


<form method="POST" action="action/verify_code.php">
<input type='hidden' name='email' value="<?php echo $_REQUEST["email"]; ?>">
<table>
  <tr>
    <td>Verification Code:</td>
    <td><input type="text" name="verification_code" /></td>
  </tr>
  <tr>
    <th colspan=2>
      <input type="submit" value="Verify Email Address" />
    </th>
   </tr>
   </table> 
  <span style='color:red;'><?php echo $error; ?></span>
</form>


</div>
</body>
</html>

<?php

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