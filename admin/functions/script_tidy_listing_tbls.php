<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
$db = new Database();

// move the listing requests from listings to request_listings
// from listing_locations to request_listing_locations
// from listing_business_types to request_listing_business_types

$sql = <<<EOD
        SELECT a.* 
        FROM listings a
        INNER JOIN listings b ON a.update_to_id = b.id
        AND a.active =0
        AND b.active =1
EOD;
$update_requests = array();
if ($data = $db->get_data($sql, array()) and count($data) > 1){
    array_shift ($data);
    $update_requests = $data;
}

$sql = <<<EOD
        SELECT a.*
        FROM listings a
        WHERE a.active =0
        AND a.update_to_id = -1
        AND NOT 
        EXISTS (
            SELECT * 
            FROM listings b
            WHERE b.id > a.id
            AND b.update_to_id = a.id
        )
EOD;
$new_requests = array();
if ($data = $db->get_data($sql, array()) and count($data) > 1){
    array_shift ($data);
    $new_requests = $data;
}


$listings_requests = array_merge($new_requests, $update_requests);
$total_count = count($listings_requests);
foreach($listings_requests as $key => $value)
{
    unset($listings_requests[$key]);
    $listings_requests[$value['id']] = $value;
}
ksort($listings_requests);

$errors = array();
foreach($listings_requests as $id =>$listing)
{
    // insert it to request and return id
    $sql =<<<EOD
            insert into 
            request_listings(name,description,notes,next_contact,salesperson_id,active,update_to_id,update_confirmation_id,update_email) 
            values('[name]','[description]','[notes]','[next_contact]','[salesperson_id]','[active]','[update_to_id]','[update_confirmation_id]','[update_email]')
EOD;
    if (!$new_id = $db->set_data_return_id($sql, $listing)) {
        $error = "Unable to add listing request " . $db->lasterror;
        exit($error);
    }
    
    $sqls = array();
    // find all locations record, move them to request_listing_locations
    $sqls[] = <<<EOD
        insert into request_listing_locations (
            listing_id,contact_name,phone,fax,cell,tollfree,address1,address2,
            city,province_id,country_id,pcode,email,email2,website  
        ) select 
            '[new_id]',contact_name,phone,fax,cell,tollfree,address1,address2,
            city,province_id,country_id,pcode,email,email2,website
        from listing_locations where listing_id = '[id]'
EOD;
    
    // find all businesstypes records, move them to request_listing_business_types
    $sqls[] = <<<EOD
        insert into 
        request_listing_business_types (listing_id,business_type_id) 
        select '[new_id]',business_type_id from listing_business_types 
        where listing_id = '[id]'
EOD;

    $sqls[] = <<<EOD
        delete from listings where id = '[id]'
EOD;
    
    $sqls[] = <<<EOD
        delete from listing_locations where listing_id = '[id]'
EOD;
        
    $sqls[] = <<<EOD
        delete from listing_business_types where listing_id = '[id]'
EOD;
    
    $return = $db->set_data_multi($sqls, array("id"=>$id, "new_id"=>$new_id));

    if ($return) {
        //exit("Your listing has been updated");
    } else {
        $errors[] = $db->lasterror . "Sorry but we were unable to update your listing from Oildirectory.com, please try again.  If this problem persists, please email <a href='mailto:service@oildirectory.com'>service@oildirectory.com</a>.";
    }   
}

if(sizeof($error) > 1)
{
    echo join(",",$error);
}
else
{
    echo "succeed!";
}