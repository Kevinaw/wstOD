<?php

  session_start();
  ob_start();

  if(!isset($_SESSION["user"])){
      header("location:login.php");
      exit;      
  }
  
  $error="";
  if(isset($_SESSION["error"])){
      $error=$_SESSION["error"]."<br><br>";
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
<div id='left-column'>



<?php  if($_SESSION["user"]["id"]=="unregistered"){  ?>
          <!-- My Listings Box -->
          <div id="tab-container">
              <ul>
                  <li>
                    <a>Unregistered User</a>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
              By registering, you will be able to associate listings with your id 
              and gain the ability to quickly add/edit/upgrade your listings.<br><br>
              <a href="register.php">Register</a> or 
              <a href="login.php?action=edit_listing&listing_id=<?php echo $_REQUEST["listing_id"]; ?>">Login</a> Now
          </div>

<?php
         $logout_text="close";

          //the only option for unregistered users is to add listings
          if(!isset($_REQUEST["action"])) $_REQUEST["action"]="add_listing";  
       } else {
           $logout_text="logout";  
?>
       
          <!-- My Listings Box -->
          <div id="tab-container">
              <ul>
                  <li>
                    <a>My Listings</a>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
              <form action="action/my_listings.php" method="post">
<?php
                    include 'my_listings.php';
?>            
              </form>
          </div>    
          <!-- end My Listings box -->    


          <!-- Change Password Box -->
          <div id="tab-container">
              <ul>
                  <li>
                    <a>Change Password</a>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
                  <form action="action/change_password.php" method="post">
                  <input type='hidden' name='email' value="<?php echo $_SESSION["user"]["username"]; ?>">
                    <table>
                      <tr>
                        <td>New Password:</td>
                        <td><input type='password' name='password'></td>
                      </tr>
                      <tr>
                        <td>Confirm Password:</td>
                        <td><input type='password' name='confirm_password'></td>
                      </tr>
                      <tr>
                        <td colspan=2 align=right><input type='submit' value='Save'></td>
                      </tr>
                    </table>
                  </form>
          </div>    
          <!-- end change password box -->
<?php  }  ?>       

</div>
<div id='right-column'>
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>
</div>

<div id='middle-column'>       

          <div id="tab-container">
              <ul>
                  <li>
                    <div style='float:left;'>
                      <a><?php echo $_SESSION["user"]["username"]; ?></a>
                    </div>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
                    <div style='float:right;'>
                        <a href="action/logout.php"><?php echo $logout_text; ?></a>
                    </div>
          
<?php
               $new_listing=false;
               switch($_REQUEST["action"]){
                   case "find_listing":
                       print "<h3>Find and Associate Listings</h3>";
                       print "<div style='color:red;'>{$error}</div>";
                       include 'profile_find_listing.php';
                   break;
                   case "edit_listing":
                       print "<h3>Edit Listings</h3>";
                       print "<div style='color:red;'>{$error}</div>";
                       include 'profile_edit_listing.php';
                   break;
                   case "add_listing":
                       $new_listing=true;
                       print "<h3>Add New Listings</h3>";
                       print "<div style='color:red;'>{$error}</div>";
                       include 'profile_edit_listing.php';
                   break;
                   default:
                       print "<h3>Manage Listings</h3>";
                       print "<div style='color:red;'>{$error}</div>";
                       include 'profile_home.php';
                   break;
               }
?>

       </div>
</div>
</body>
</html>