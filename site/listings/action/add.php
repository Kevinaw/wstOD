<?php

//my_listings action page
ob_start();
session_start();
$_SESSION["error"] = "";

//----kevin----new code 08-24: for admin add listing
if (isset($_REQUEST['is_admin']) && $_REQUEST['is_admin'] == true) {
    print "<div style='float:right;'><a href='/admin/index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

    $name = ucwords(str_replace(array(".php", "_", "/site/listings/"), array("", " ", ""), $_SERVER["PHP_SELF"]));
    if (!isset($_SESSION["admin_user"]["access"]) || !in_array($name, array_values($_SESSION["admin_user"]["access"]))) {
        print "Access Denied";
        exit;
    }
}
//end

$action = $_REQUEST["action"];
if (is_array($action)) {
    $id = array_shift(array_keys($action));
    if (is_array($action[$id])) {
        $action = $id;
    } else {
        $action = $action[$id];
    }
} else {
    if (isset($_REQUEST["id"]))
        $id = $_REQUEST["id"];
}



switch ($action) {
    case "Edit Listing":
        setup_post($id);
        break;
    case "Add Location":

        if (!isset($_POST["listing"]["new"]["locations"]))
            $_POST["listing"]["new"]["locations"] = array();
        $_POST["listing"]["new"]["locations"][] = array(
            "id" => -1,
            "contact_name" => "",
            "address1" => "",
            "address2" => "",
            "city" => "",
            "country_id" => "",
            "province_id" => "",
            "pcode" => "",
            "phone" => "",
            "fax" => "",
            "cell" => "",
            "tollfree" => "",
            "email" => "",
            "email2" => "",
            "website" => ""
        );



        break;
    case "Remove Location":
        unset($_POST["listing"]["new"]["locations"][$id]);

        break;
    case "Remove Category":
        $new_categories = array();
        foreach ($_POST["listing"]["new"]["categories"] as $id => $value) {
            if (!in_array($value, $_POST["remove_categories"]))
                $new_categories[] = $value;
        }
        $_POST["listing"]["new"]["categories"] = $new_categories;

        break;
    case "Add Category":
        foreach ($_POST["new_categories"] as $id => $value) {
            $_POST["listing"]["new"]["categories"][] = $value;
        }

        break;
        break;
    case "Cancel Changes":
//----kevin----new code 08-24: admin user header to admin/index.php
        if (isset($_POST['is_admin']) && $_POST['is_admin'] == true)
            header("location:/admin/index.php");
        else
            header("location:../main.php");
//end
        exit;

        break;
    case "Delete Listing":
        $errors = delete_listing($_POST["listing"]["current"]["info"]);
        if (!count($errors)) {
//----kevin----new code 08-24: admin user header to admin/index.php
            if (isset($_POST['is_admin']) && $_POST['is_admin'] == true)
                header("location:/admin/index.php");
            else
                header("location:../main.php");
//end
            exit;
        } else {
            $_SESSION["error"] = join("<br>", $errors);
        }


        break;
    case "Save Changes":
        $errors = save_listing();
        if (!count($errors)) {
//----kevin----new code 08-24: admin user header to admin/index.php
            if (isset($_POST['is_admin']) && $_POST['is_admin'] == true)
                header("location:/admin/index.php");
            else
                header("location:../main.php");
//end
            exit;
        } else {
            $_SESSION["error"] = join("<br>", $errors);
        }

        break;
}

function save_listing() {
    global $_POST, $_SESSION;

    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
    $db = new Database();

    $errors = array();
    if (strlen($_POST["listing"]["new"]["info"]["name"]) < 5)
        $errors[] = "The name must be greater than 4 characters.";
    if (strlen($_POST["listing"]["new"]["info"]["name"]) > 500)
        $errors[] = "The name must be less than 500 characters.";
    if (strlen($_POST["listing"]["new"]["info"]["description"]) < 5)
        $errors[] = "The description must be greater than 4 characters.";
    if (!validEmail($_POST["listing"]["new"]["info"]["update_email"]))
        $errors[] = "You must enter a valid administrator email address, this will be used to confirm changes to the listing but will not be displayed in the listing";
    if (count($_POST["listing"]["new"]["locations"]) == 0)
        $errors[] = "You must include at least one location.";
    else
        $errors = array_merge($errors, check_locations());
    if (count($_POST["listing"]["new"]["categories"]) == 0)
        $errors[] = "You must select at least one category.";


    if (count($errors) > 0)
        return $errors;

    //$id=$_POST["listing"]["current"]["info"]["id"];
    $uuid = md5(uniqid());
    $_POST["listing"]["new"]["info"]["uuid"] = $uuid;
    $sql = "insert into listings (name,description,update_to_id,update_confirmation_id,update_email) values ('[name]','[description]','[id]','[uuid]','[update_email]')";
    if (!$id = $db->set_data_return_id($sql, $_POST["listing"]["new"]["info"])) {
        $errors[] = "Unable to update/add listing. " . $db->lasterror;
        return $errors;
    }

    $_POST["listing"]["new"]["info"]["id"] = $id;
    $_POST["listing"]["current"]["info"] = $_POST["listing"]["new"]["info"];

    if (isset($_POST["listing"]["new"]["locations"])) {
        $errors = array_merge($errors, save_locations($id, $db));
    }

    if (isset($_POST["listing"]["new"]["categories"])) {
        $errors = array_merge($errors, save_categories($id, $db));
    }

    if (count($errors)) {
        $errors[] = "Unable to update listing.";
        $sql = <<<EOD
              delete from listings where id=[id];
              delete from listing_locations where listing_id=[id];
              delete from listing_business_types where listing_id=[id];
EOD;
        $db->set_data_multi($sql, array("id" => $id));

        return $errors;
    }

    $_SESSION["error"] = <<<EOD
              An email has been sent to {$_POST["listing"]["new"]["info"]["update_email"]} to confirm 
              this update.  To complete the update, please click on the link in 
              the confirmation email.  If the email address in the listing is not valid, 
              please email <a href="mailto:service@oildirectory.com">service@oildirectory.com</a> 
              to update the email address and try again. 
EOD;

    $message = <<<EOD
              A request has been made to update your listing on Oildirectory.com.  If this request 
              has been made in error, please disregard this email message.<br>
              <br>
              To confirm this update and have your listing updated at Oildirectory.com, please 
              click <a href="http://www.oildirectory.com/site/listings/action/update.php?action=update&id={$uuid}">here</a>.
EOD;

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: ' . $_POST["listing"]["new"]["info"]["update_email"] . "\r\n";
    $headers .= 'From: Oildirectory.com <service@oildirectory.com>' . "\r\n";

    if ($_POST["is_admin"] == "true") {
        $_REQUEST["action"] = "update";
        $_REQUEST["id"] = $uuid;
        include "update.php";
        exit;
    } else {
        //mail($_POST["listing"]["new"]["info"]["update_email"], "Oildirectory.com Update Confirmation", $message, $headers);
    }


    return $errors;
}

function check_locations() {
    global $_POST;

    $locations = $_POST["listing"]["new"]["locations"];

    $errors = array();

    //check for errors in updated or added locations
    foreach ($locations as $locnum => $info) {


        if (strlen($info["phone"]) < 7)
            $errors[] = "The Phone for Location #{$locnum} must be greater than 7 characters.";
        if (strlen($info["province_id"]) == 0)
            $errors[] = "You must choose a Province/State for Location #{$locnum}.";
        if (strlen($info["country_id"]) == 0)
            $errors[] = "You must choose a Country for Location #{$locnum}.";
    }

    return $errors;
}

function save_locations($listing_id, &$db) {
    global $_POST;

    $locations = $_POST["listing"]["new"]["locations"];

    $errors = array();

    //check for errors in updated or added locations
    foreach ($locations as $locnum => $info) {

        //add new location
        $sql = array();
        $sql = <<<EOD
               insert into listing_locations (
                   listing_id,contact_name,phone,fax,cell,tollfree,address1,address2,
                   city,province_id,country_id,pcode,email,email2,website  
               ) values (
                   [listing_id],'[contact_name]','[phone]','[fax]','[cell]','[tollfree]',
                   '[address1]','[address2]','[city]','[province_id]',
                   '[country_id]','[pcode]','[email]','[email2]','[website]') 
EOD;

        $info["listing_id"] = $_POST["listing"]["current"]["info"]["id"];
        if (!$id = $db->set_data_return_id($sql, $info)) {
            $errors[] = "Unable to add location #{$locnum}. " . $db->lasterror;
        }
    }

    return $errors;
}

function save_categories($listing_id, &$db) {
    global $_POST;

    $errors = array();
    //check for new categories
    $sql = array();
    foreach ($_POST["listing"]["new"]["categories"] as $rownum => $id) {
        //add category
        $sql[] = "insert into listing_business_types (listing_id,business_type_id) values ([listing_id],{$id});";
    }

    if ($db->set_data_multi($sql, array("listing_id" => $listing_id))) {
        $_POST["listing"]["current"]["categories"][] = $id;
    } else {
        $errors[] = "Category add failed";
    }


    return $errors;
}

function delete_listing($listing) {
    global $_POST, $_SESSION;

    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
    $db = new Database();

    $errors = array();

    $sql = array();

    $sql[] = "update listings set update_confirmation_id='[uuid]' where id=[listing_id];";
    $uuid = md5(uniqid());
    $rtnval = $db->set_data_multi($sql, array("listing_id" => $listing["id"], "uuid" => $uuid));
    if (strlen($db->lasterror)) {
        $errors[] = "Unable to delete listing.  " . $db->lasterror;
    } else {
        $_SESSION["error"] = <<<EOD
              An email has been sent to {$listing["update_email"]} to confirm 
              this deletion.  To complete the deletion, please click on the link in 
              the confirmation email.  If the email address in the listing is not valid, 
              please email <a href="mailto:service@oildirectory.com">service@oildirectory.com</a> 
              to update the email address and try again.
EOD;

        $message = <<<EOD
              A request has been made to remove your listing on Oildirectory.com.  If this request 
              has been made in error, please disregard this email message.<br>
              <br>
              To confirm this deletion and have your listing removed from Oildirectory.com, please 
              click <a href="http://www.oildirectory.com/site/listings/action/update.php?action=delete&id={$uuid}">here</a>.
EOD;

        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'To: ' . $_POST["listing"]["new"]["info"]["update_email"] . "\r\n";
        $headers .= 'From: Oildirectory.com <service@oildirectory.com>' . "\r\n";

        if ($_POST["is_admin"] == "true") {
            $_REQUEST["action"] = "delete";
            $_REQUEST["id"] = $uuid;
            include "update.php";
            exit;
        } else {
           // mail($listing["update_email"], "Oildirectory.com Deletion Confirmation", $message, $headers);
        }
    }
    return $errors;
}

//following added

function setup_post($listing_id) {
    global $_POST, $_SESSION;

    $_POST["listing"] = array(
        "current" => array(
            "info" => array(),
            "locations" => array(),
            "categories" => array()
        ),
        "premium" => false,
        "expires" => "Not Available"
    );




    //get the data from the db
    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";
    $db = new Database();
    //get the listing
    $sql = "select id,name,description,update_email from listings where id=[id]";
    if (!$data = $db->get_data($sql, array("id" => $listing_id)) or count($data) != 2) {
        $_SESSION["error"] = "Unable to retrieve listing, please try again.";
        return false;
    } else {
        $_POST["listing"]["current"]["info"] = $data[1];
    }

    //get the locations
    $sql = <<<EOD
                 select id,contact_name,address1,address2,city,province_id,
                        country_id,phone,fax,cell,tollfree,email,email2,website,pcode  
                 from listing_locations where listing_id=[id]
EOD;
    if (!$data = $db->get_data($sql, array("id" => $listing_id))) {
        $_SESSION["error"] = "Unable to retrieve listing, please try again.";
        return false;
    } else {
        array_shift($data); //remove the header row
        $_POST["listing"]["current"]["locations"] = $data;
    }

    //get the locations
    $sql = "select * from listing_business_types where listing_id=[id]";
    if (!$data = $db->get_data($sql, array("id" => $listing_id))) {
        $_SESSION["error"] = "Unable to retrieve listing, please try again.";
        return false;
    } else {
        array_shift($data); //remove the header row
        foreach ($data as $rownum => $row) {
            $_POST["listing"]["current"]["categories"][] = $row["business_type_id"];
        }
    }

    //see if they are already premium
    $_POST["listing"]["premium"] = false;
    $_POST["listing"]["expires"] = "Not Available";
    $sql = "select *,case when expires<current_timestamp then 1 else 0 end as expired from premium where listing_id=[id] order by expires desc limit 1";
    if ($data = $db->get_data($sql, array("id" => $listing_id))) {
        if (count($data) == 2) {
            if ($data[1]["expired"] == 0) {
                $_POST["listing"]["premium"] = true;
                $_POST["listing"]["expires"] = $data[1]["expires"];
            }
        }
    }

    //setup the new to = current
    $_POST["listing"]["new"] = $_POST["listing"]["current"];

    return true;
}

function validEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if
        (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
            // character not valid in local part unless 
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") ||
                checkdnsrr($domain ,"A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}

?>
