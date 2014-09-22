<?php

//my_listings action page


$action = $_REQUEST["action"];
$uuid = $_REQUEST["uuid"];
$update_to_id = $_REQUEST["update_to_id"];

switch ($action) {
    case "update":
        update($uuid, $update_to_id);
        break;
        break;
    case "delete":
        delete($uuid);
        break;
    case "accept":    //move data out of request_ tables
        accept($uuid, $update_to_id);
        break;
    default:
        print_page("Sorry, we were unable to process your request.");
        break;
}

function update($uuid, $update_to_id) {


    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
    $db = new Database();

    $sql = array();
    $sql[] = <<<EOD
          update ignore listings a,listings b  
          set a.active=0,b.notes=a.notes,b.next_contact=a.next_contact,b.salesperson_id=a.salesperson_id  
          where a.id=b.update_to_id and b.update_confirmation_id='[uuid]' 
EOD;
    $sql[] = <<<EOD
          update listings set active=1 
          where update_confirmation_id='[uuid]';
EOD;



    $sql[] = <<<EOD
          update logos a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update premium a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update invoice a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update banners a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;


    $sql[] = "insert into history_listings select *,'remove',current_timestamp from listings where id='[update_to_id]'";
    $sql[] = "insert into history_listing_locations select *,'remove',current_timestamp from listing_locations where listing_id='[update_to_id]'";
    $sql[] = "insert into history_listing_business_types select *,'remove',current_timestamp from listing_business_types where listing_id='[update_to_id]'";
    $sql[] = "insert into history_banners select *,'remove',current_timestamp from banners where listing_id='[update_to_id]'";
    $sql[] = "insert into history_logos select *,'remove',current_timestamp from logos where listing_id='[update_to_id]'";
    $sql[] = "insert into history_premium select *,'remove',current_timestamp from premium where listing_id='[update_to_id]'";
    $sql[] = "insert into history_videos select *,'remove',current_timestamp from videos where listing_id='[update_to_id]'";

    $sql[] = "delete from listings where id='[update_to_id]'";
    $sql[] = "delete from listing_locations where listing_id='[update_to_id]'";
    $sql[] = "delete from listing_business_types where listing_id='[update_to_id]'";
    $sql[] = "delete from banners where listing_id='[update_to_id]'";
    $sql[] = "delete from logos where listing_id='[update_to_id]'";
    $sql[] = "delete from premium where listing_id='[update_to_id]'";
    $sql[] = "delete from videos where listing_id='[update_to_id]'";

    $return = $db->set_data_multi($sql, array("uuid" => $uuid, "update_to_id" => $update_to_id));

    if ($return) {
        print_page("Your listing has been updated on Oildirectory.com");
    } else {
        print_page($db->lasterror . "Sorry but we were unable to update your listing from Oildirectory.com, please try again.  If this problem persists, please email <a href='mailto:service@oildirectory.com'>service@oildirectory.com</a>.");
    }
}

function delete($uuid) {


    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
    $db = new Database();

    $sql = array();
//----kevin----20140824:delete      
//      $sql[]=<<<EOD
//          update listings 
//          set active=0 
//          where update_confirmation_id='[uuid]';
//          
//EOD;
    $sql[] = <<<EOD
          delete from request_listings 
          where update_confirmation_id='[uuid]';
EOD;

    $return = $db->set_data_multi($sql, array("uuid" => $uuid));

    if ($return) {
        print_page("Your listing has been removed from Oildirectory.com");
    } else {
        print_page("Sorry but we were unable to remove your listing from Oildirectory.com, please try again.  If this problem persists, please email <a href='mailto:service@oildirectory.com'>service@oildirectory.com</a>.");
    }
}

function print_page($message) {
//----kevin----new code 08-24: admin user header to admin/index.php
    if ((isset($_POST['is_admin']) && $_POST['is_admin'] == true) ||
            (isset($_REQUEST['is_admin']) && $_REQUEST['is_admin'] == true))
        print <<<EOD
        <html>
        <body>
        <br>
        <div style='border:1px solid silver; margin:15px; padding:15px;'>{$message}</div>
        Click <a href="/admin/index.php">here</a> to return to Oildirectory.com/admin/
        </body>
        </html>
      
EOD;
    else
//end
        print <<<EOD
        <html>
        <body>
        <a href="http://www.oildirectory.com">
            <img src="http://www.oildirectory.com/images/logo_medium.jpg" border="0">
        </a>
        <br>
        <div style='border:1px solid silver; margin:15px; padding:15px;'>{$message}</div>
        Click <a href="http://www.oildirectory.com">here</a> to return to Oildirectory.com
        </body>
        </html>
      
EOD;
}

function accept($uuid, $update_to_id) {

    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
    $db = new Database();


    $sql = <<<EOD
            insert into listings 
            (name,description,update_to_id,update_confirmation_id,update_email) 
            select name,description,update_to_id,update_confirmation_id,update_email 
            from request_listings
            where update_confirmation_id = '[uuid]'
EOD;
    $id = '';
    if (!$id = $db->set_data_return_id($sql, array("uuid" => $uuid))) {
        $errors[] = "Unable to update/add listing. " . $db->lasterror;
        return $errors;
    }

    $sql = array();
    $sql[] = <<<EOD
          update ignore listings a,listings b  
          set a.active=0,b.notes=a.notes,b.next_contact=a.next_contact,b.salesperson_id=a.salesperson_id  
          where a.id=b.update_to_id and b.update_confirmation_id='[uuid]' 
EOD;
    $sql[] = <<<EOD
        update listings set active=1 
        where update_confirmation_id='[uuid]';
EOD;

    $sql[] = <<<EOD
        update logos a, listings b 
        set a.listing_id=b.id 
        where b.update_confirmation_id='[uuid]'
        and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update premium a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update invoice a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update banners a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

    $sql[] = <<<EOD
          update request_listing_locations a, request_listings b 
          set a.listing_id='[id]'
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.id;
EOD;

    $sql[] = <<<EOD
        update request_listing_business_types a, request_listings b 
        set a.listing_id='[id]'
        where b.update_confirmation_id='[uuid]'
        and a.listing_id=b.id;
EOD;

    $sql[] = <<<EOD
        insert into listing_locations
        (listing_id, contact_name, phone, fax, cell, tollfree, address1, address2, city, province_id, country_id, pcode, email, email2, website)
        select 
        listing_id, contact_name, phone, fax, cell, tollfree, address1, address2, city, province_id, country_id, pcode, email, email2, website
        from request_listing_locations
        where listing_id = '[id]'
EOD;

    $sql[] = <<<EOD
        insert into listing_business_types
        (listing_id, business_type_id)
        select 
        listing_id, business_type_id
        from request_listing_business_types
        where listing_id = '[id]'
EOD;

    $sql[] = "insert into history_listings select *,'remove',current_timestamp from listings where id='[update_to_id]'";
    $sql[] = "insert into history_listing_locations select *,'remove',current_timestamp from listing_locations where listing_id='[update_to_id]'";
    $sql[] = "insert into history_listing_business_types select *,'remove',current_timestamp from listing_business_types where listing_id='[update_to_id]'";
    $sql[] = "insert into history_banners select *,'remove',current_timestamp from banners where listing_id='[update_to_id]'";
    $sql[] = "insert into history_logos select *,'remove',current_timestamp from logos where listing_id='[update_to_id]'";
    $sql[] = "insert into history_premium select *,'remove',current_timestamp from premium where listing_id='[update_to_id]'";
    $sql[] = "insert into history_videos select *,'remove',current_timestamp from videos where listing_id='[update_to_id]'";

    $sql[] = "delete from listings where id='[update_to_id]'";
    $sql[] = "delete from listing_locations where listing_id='[update_to_id]'";
    $sql[] = "delete from listing_business_types where listing_id='[update_to_id]'";
    $sql[] = "delete from banners where listing_id='[update_to_id]'";
    $sql[] = "delete from logos where listing_id='[update_to_id]'";
    $sql[] = "delete from premium where listing_id='[update_to_id]'";
    $sql[] = "delete from videos where listing_id='[update_to_id]'";
    
    $sql[] = "delete from request_listings where update_confirmation_id='[uuid]'";
    $sql[] = "delete from request_listing_locations where listing_id='[id]'";
    $sql[] = "delete from request_listing_business_types where listing_id='[id]'";

    $return = $db->set_data_multi($sql, array("uuid" => $uuid, "update_to_id" => $update_to_id, "id" => $id));

    if ($return) {
        print_page("Your listing has been updated on Oildirectory.com");
    } else {
        print_page($db->lasterror . "Sorry but we were unable to update your listing from Oildirectory.com, please try again.  If this problem persists, please email <a href='mailto:service@oildirectory.com'>service@oildirectory.com</a>.");
    }
}

?>