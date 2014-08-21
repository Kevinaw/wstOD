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
<h2>New User Registration - Step 1 of 2</h2>

We have made user registration very simple in order to allow you to easily 
add or make modifications to your listings. 
<br>
<ol>
  <li>Enter your email address (a validation email will be sent to this address)</li>
  <li>Enter and confirm a password for yourself</li>
  <li>Enter the security code displayed in the Security Image in the box provided</li>
  <li>Click on "Register User"</li>
</ol> 


<form method="POST" action="action/register.php">
<table>
  <tr>
    <td>Email Address:</td>
    <td><input type="text" name="email" value="<?php echo $_POST["email"]; ?>" /></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input type="password" name="password" /></td>
  </tr>
  <tr>
    <td>Confirm Password:</td>
    <td><input type="password" name="confirm_password" /></td>
  </tr>

<?php

  session_start();
  $sid=md5(uniqid(time()));

  print <<<EOD
    <tr>
      <td>Security Image:</td>
      <td>
        <img src="captcha/securimage_show.php?sid={$sid}">
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
      <input type="submit" value="Register User" />
    </th>
   </tr>
   </table> 
  <span style='color:red;'><?php echo $error; ?></span>
</form>


</div>
</body>
</html>
