<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
$db=new Database();

$sqls=array();
$sqls[]=<<<EOD
    delete from premium where listing_id=[id];
EOD;
$sqls[]=<<<EOD
    insert into premium (listing_id,expires) values ([id],current_timestamp + interval 1 hour);
EOD;

$db->set_data_multi($sqls,$_REQUEST);

?>

<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Oildirectory.com</title>
  <link rel="stylesheet" type="text/css" media="screen" href="../../css/home.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="../../css/ads.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="../../css/submission.css" />
</head>

<body style='text-align:left;'>
    <h4>Thank you for upgrading your listing</h4>
    Once you have completed your payment using Paypal, 
    please allow 1 hour for processing of your payment.  Your 
    listing will be upgraded to a premium listing and you will enjoy the 
    added benefits that come with a premium listing such as:
    <br>
    <br>
          <ul>
              <li>Links to your company website</li>
              <li>The "More" button that opens a new window with all of your contact and 
              location information</li>
              <li>A description of your company services right in the listing</li>
              <li>A summary of your contact information right in the listing</li>
              <li>Priority listing that displays at the top of search results</li>
          </ul>    
</body>
</html>