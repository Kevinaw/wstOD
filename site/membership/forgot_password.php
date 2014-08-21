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
<h2>Reset Password</h2>

Please enter your email address and the security code below and 
click on the "Send New Password" button and we will send you a 
new password.

<form method="POST" action="action/forgot_password.php">
<table>
  <tr>
    <td>Email Address:</td>
    <td><input type="text" name="email" value="<?php echo $_POST["email"]; ?>" /></td>
  </tr>
<?php

  session_start();
  $sid=md5(uniqid(time()));

  print <<<EOD
    <tr>
      <td>Security Image:</td>
      <td>
        <img src="../Membership/captcha/securimage_show.php?sid={$sid}">
      </td>
    </tr>
    <tr>
      <td>Security Code:</td>
      <td>
        <input type="text" name="code" />
      </td>
    </tr>
EOD;

?>
  <tr>
    <th colspan=2>
      <input type="submit" value="Send New Password" />
    </th>
   </tr>
   </table> 
  <span style='color:red;'><?php echo $error; ?></span>
</form>


</div>
</body>
</html>
