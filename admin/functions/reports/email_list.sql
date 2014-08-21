<?php

$sql=array();
$sql[]=<<<EOD
select contact_name,phone,fax,email,email2 from 
listing_locations where email!='' or email2!='';
EOD;

?>