<?php


$message=array();

foreach($_POST as $key=>$value) $message[]="{$key}={$value}";
//foreach($_SERVER as $key=>$value) $message[]="{$key}={$value}";

switch($_POST["txn_type"]){
    case "subscr_cancel":
        subscription_cancelled();
    break;
    case "subscr_signup":
        subscription_received();
    break;
    case "subscr_payment":
        payment_received();
    break;
}

function subscription_received(){
    global $message,$_POST;
    
    $message=join("<br>",$message);

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    
    $sql="select * from listings where id=[custom]";
    $details=="Listings Details Unavailable<br>";
    if($data=$db->get_data($sql,$_POST)){
        if(count($data)==2){
            $details=<<<EOD
                Listing ID: {$data[1]["id"]}<br>
                Name: {$data[1]["name"]}<br>
                Description: {$data[1]["description"]}<br>
EOD;
        }
    }
    
    $message=<<<EOD
                   <h4>A New Premium Subscription Has Been Received</h4>
                   {$details}
                   <hr>
                   <b>Transaction Details</b>
                   {$message}
EOD;

  $headers=array();
  $headers[]= "MIME-Version: 1.0"; 
  $headers[]= "Content-Type: text/html; charset=ISO-8859-1"; 
  $headers=join("\n",$headers);
  mail("ken.merkel@lekrem.ca","Premium Subscription Received",$message,$headers);

}
function subscription_cancelled(){
    global $message,$_POST;
    
    $message=join("<br>",$message);

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    
    $sql="select * from listings where id=[custom]";
    $details=="Listings Details Unavailable<br>";
    if($data=$db->get_data($sql,$_POST)){
        if(count($data)==2){
            $details=<<<EOD
                Listing ID: {$data[1]["id"]}<br>
                Name: {$data[1]["name"]}<br>
                Description: {$data[1]["description"]}<br>
EOD;
        }
    }
    
    $message=<<<EOD
                   <h4>A Premium Subscription Has Been Cancelled</h4>
                   {$details}
                   <hr>
                   <b>Transaction Details</b>
                   {$message}
EOD;

  $headers=array();
  $headers[]= "MIME-Version: 1.0"; 
  $headers[]= "Content-Type: text/html; charset=ISO-8859-1"; 
  $headers=join("\n",$headers);
    mail("ken.merkel@lekrem.ca","Premium Subscription Cancelled",$message,$headers);
}

function payment_received(){
    global $message,$_POST;

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    
    $sqls=array();
    $sqls[]=<<<EOD
        delete from premium where listing_id=[custom];
EOD;
    $sqls[]=<<<EOD
        insert into premium (listing_id,expires) values ([custom],current_timestamp + interval 54 week);
EOD;
    
    if(
       isset($_POST["custom"]) and 
       isset($_POST["payment_status"]) and 
       $_POST["payment_status"]=="Completed" and 
       isset($_POST["item_name"]) and 
       $_POST["item_name"]="Premium Listing"
    ){
      if($db->set_data_multi($sqls,$_POST)){
          $subject="Upgrade to Premium - Successful Payment";
      } else {
          $subject="Upgrade to Premium - Successful Payment - DB Update Failed";
      }
    } else {
          $subject="Upgrade to Premium - Unsuccessful Payment";
    }
    
    $sql="select * from listings where id=[custom]";
    $details=="Listings Details Unavailable<br>";
    if($data=$db->get_data($sql,$_POST)){
        if(count($data)==2){
            $details=<<<EOD
                Listing ID: {$data[1]["id"]}<br>
                Name: {$data[1]["name"]}<br>
                Description: {$data[1]["description"]}<br>
EOD;
        }
    }

    $message=join("<br>",$message);    
    $message=<<<EOD
                   <h4>{$subject}</h4>
                   {$details}
                   <hr>
                   <b>Transaction Details</b>
                   {$message}
EOD;

  $headers=array();
  $headers[]= "MIME-Version: 1.0"; 
  $headers[]= "Content-Type: text/html; charset=ISO-8859-1"; 
  $headers=join("\n",$headers);
  mail("ken.merkel@lekrem.ca",$subject,$message,$headers);    
    
}

exit;


// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
}
}
fclose ($fp);
}

?>

