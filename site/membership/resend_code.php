<?php

  session_start();
  
  $error="";
  if(isset($_SESSION["error"])){
      $error=$_SESSION["error"];
      unset($_SESSION["error"]);
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
<h2>Email exists</h2>

<form method="POST" action="action/resend_code.php">
      <input type='hidden' name='email' value="<?php echo $_REQUEST["email"]; ?>">
      The email address <?php echo $_REQUEST["email"]; ?> already exists as a 
      user but has not been verified.<br>
      <br>
      Would you like me to resend the verification email?<br>
      <br> 
      <input type='submit' name='resend' value='Yes'> 
      <input type='submit' name='no' value='No'>
</form>


</div>
</body>
</html>
