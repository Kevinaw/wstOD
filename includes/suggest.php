<?php

  session_start();
  $sid=md5(uniqid(time()));
  
  $error=array();
  
  if(!isset($_REQUEST["url"])){
      $_REQUEST["url"]="http://www.oildirectory.com";
      $error["message"]=<<<EOD
              No Suggestion has been given to send, so we will suggest http://www.oildirectory.com
EOD;
    }
  
  if(isset($_POST["send"])){
    require_once $_SERVER['DOCUMENT_ROOT']."/site/membership/captcha/securimage.php";
    $img = new Securimage();
    $valid = $img->check($_POST['code']);
    
    if(!$valid){
        $error["code"]="Invalid security code given, please try again";
    }
    if(!strlen($_POST["sender_name"])) $error["sender_name"]="You must enter a sender name";
    if(!strlen($_POST["associate_name"])) $error["associate_name"]="You must enter a friends name";
    if(!strstr($_POST["sender_email"],"@")) $error["sender_email"]="You must enter a sender eMail";
    if(!strstr($_POST["associate_email"],"@")) $error["associate_email"]="You must enter a friends eMail";
    
    if(!count($error)){
        //no errors so sendmessage
        $to      = $_POST["associate_email"];
        $subject = "Suggestion from {$_POST["sender_name"]}";
        $message = <<<EOD
            Dear {$_POST["associate_name"]},<br>
            <br>{$_POST["sender_name"]} has suggested that you visit this website<br>
            <br>
            <a href="{$_REQUEST["url"]}">{$_REQUEST["url"]}</a><br>
            <br>
            Message: {$_POST["message"]}
EOD;
        $headers = 'From: {$_POST["sender_email"]}' . "\r\n" .
            'Reply-To: {$_POST["sender_email"]}' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        if(mail($to, $subject, $message, $headers)){
            $error["message"]=<<<EOD
                    A suggestion email was sent to {$_POST["associate_name"]} 
                    at {$_POST["associate_email"]} 
EOD;

            unset($_POST);
        } else {
            $error["message"]=<<<EOD
            Sending of email failed, please try again
EOD;
        }
    }
  }
?>
<html>
<head>
  <title>Oildirectory.com - Send this page to a Friend</title>
  <link rel="stylesheet" type="text/css" media="screen" href="/css/home.css" />
  <style>
      .error { color:red; font-size:smaller; }
  </style>      
</head>
<body>
    <img src="/images/logo_small.jpg" align=left>
    <br><b>Send this page to a Friend</b>
    
    
<?php

  print <<<EOD
      <div style="clear:both;">
          To suggest a friend view this page, please fill out the 
          required information below and click on "Send"
      </div>
      
      <div style="clear:both; text-align:center; margin:0 auto;">
      <form action="#" method="post">
          <table>
              <tr>
                  <td>Your Name:</td>
                  <td><input type='text' name='sender_name' value="{$_POST["sender_name"]}"></td>
                  <td class="error">{$error["sender_name"]}</td>
              </tr>
              <tr>
                  <td>Your eMail:</td>
                  <td><input type='text' name='sender_email' value="{$_POST["sender_email"]}"></td>
                  <td class="error">{$error["sender_email"]}</td>
              </tr>
              <tr>
                  <td>Friends Name:</td>
                  <td><input type='text' name='associate_name' value="{$_POST["associate_name"]}"></td>
                  <td class="error">{$error["associate_name"]}</td>
              </tr>
              <tr>
                  <td>Friends eMail:</td>
                  <td><input type='text' name='associate_email' value="{$_POST["associate_email"]}"></td>
                  <td class="error">{$error["associate_email"]}</td>
              </tr>
              <tr>
                  <td nowrap>Personal Message:</td>
                  <td><textarea rows=3 name='message'>{$_POST["message"]}</textarea></td>
              </tr>
              <tr>
                  <td nowrap>Suggested Page:</td>
                  <td>{$_REQUEST["url"]}</td>
                  <input type='hidden' name='url' value="{$_REQUEST["url"]}">
              </tr>
              <tr>
                  <td nowrap>Personal Message:</td>
                  <td><textarea rows=3 name='message'></textarea></td>
              </tr>
              <tr>
                <td>Security Image:</td>
                <td>
                  <img src="../site/membership/captcha/securimage_show.php?sid={$sid}"><br>
                  <div style='font-size:smaller;'>Enter this code below</div>
                </td>
              </tr>
              <tr>
                <td>Security Code:</td>
                <td>
                  <input type="text" name="code" />
                </td>
                  <td class="error">{$error["code"]}</td>
              </tr>
              <tr>
                  <th colspan=3><input type='submit' name='send' value="Send"></th>
              </tr>
          </table>
      </form>
      </div>
      <div style="clear:both; color:red;">
          {$error["message"]}
      </div>

EOD;


?>    
</body>
</html>