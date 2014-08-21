<?php
//login display page
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
    
  <style>
      #quick_links { border-collapse:collapse; }
      #quick_links TH { border: 1px solid #333333; background-color:#333333; color:white; }
      #quick_links TD { border: 1px solid #333333; padding:5px; }
      #quick_links TD TABLE TH { border:none; background-color:white; }
      #quick_links TD TABLE TD { border:none; padding:0px; }
  </style>
</head>

<body>

      <div id="left-column">
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>
      </div>

      <div id='right-column'>
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>
      </div>
      
      <div id="middle-column">

        <h2>Adding/Editing Directory Listings</h2>
        There are several options for adding/editing a directory listing.  Please 
        choose from the quick links menu below to begin.
        
        <p>
        <span style='color:red;'><?php echo $error; ?></span>
        </p>
        
        <table id="quick_links">
            <tr>
                <th colspan=2>Quick Links Menu</th>
            </tr>
            <tr valign=top>
                <td>
                    <b>Add a free listing</b><br><br>
                    It isn't necessary to register to add a new listing but registering 
                    will make updating your listing faster and easier. 
                </td>
                <td><a href="action/add_unregistered.php">Add a free listing without registering</a></td>
            </tr>
            <tr valign=top>
                <td>
                    <b>Login to update existing listings or create a Premium listing</b><br><br>
                    You must be a registered user to update existing listings.
                    <br><br>  
                    If you have already registered, login here to update listings 
                    associated with your id or to create new listings.
                    <br><br>
                    If you don't yet have a user id, please click on the Register as 
                    a New User link below to quickly register.
                </td>
                <td>
                    <form method="POST" action="action/login.php">
                    <input type='hidden' name='action' value="<?php echo (isset($_REQUEST["action"]))?$_REQUEST["action"]:''; ?>">
                    <input type='hidden' name='listing_id' value="<?php echo (isset($_REQUEST["listing_id"]))?$_REQUEST["listing_id"]:''; ?>">
                    <table style='font-size:10pt;'>
                    <tr>
                      <td nowrap>Email Address:</td>
                      <td><input type="text" name="email" /></td>
                    </tr>
                    <tr>
                      <td>Password:</td>
                      <td nowrap>
                        <input type="password" name="password" /> 
                        <a href='forgot_password.php'>reset</a>
                      </td>
                    </tr>
                    <tr>
                      <th colspan=2><input type="submit" value="Login" /></th>
                    </tr>
                    </table>
                    </form>
                </td>
            </tr>
            <tr valign=top>
                <td>
                    <b>Register as a new user</b><br><br>
                    By registering, you will be able to associate listings with 
                    your user id allowing you to more easily and quickly add or 
                    update your listings.  Registering is a very quick and simple 
                    process.
                </td>
                <td><a href="register.php">Register as a new user</a></td>
            </tr>
            </table>
        </div>
        

</body>
</html>
