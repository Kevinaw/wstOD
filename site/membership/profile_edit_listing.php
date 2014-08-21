<?php
//login action page

  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      
  $db=new Database();
  
//get all of the company information
$sqls=array();
$sqls["listing"]="select * from listings where id=[id]";
$sqls["locations"]=<<<EOD
    select listing_locations.*, 
        prov_state.name as province_name,
        countries.name as country_name   
    from listing_locations 
        left join prov_state on prov_state.id=province_id 
        left join countries on countries.id=country_id 
    where listing_id=[id]
EOD;
$sqls["business_types"]=<<<EOD
    select businesstypes.*,case when listing_business_types.id is not null then 1 else 0 end as selected  
    from businesstypes 
    left join listing_business_types on business_type_id=businesstypes.id and listing_id=[id]
EOD;
$sqls["premium"]="select *,case when expires<current_timestamp then 1 else 0 end as expired from premium where listing_id=[id] order by expires desc limit 1";
$sqls["banners"]="select * from banners where listing_id=[id]";
$sqls["logos"]="select * from logos where listing_id=[id]";
$sqls["videos"]="select * from videos where listing_id=[id]";
$sqls["countries"]="select * from countries order by name";
$sqls["provinces"]="select * from prov_state order by name";



if(!$new_listing){
  foreach($sqls as $sql_name=>$sql){
      $sqls[$sql_name]=$db->get_data($sql,array("id"=>$_REQUEST["listing_id"]));
  }
  $sqls["listing"][1]["name"]=(isset($_REQUEST["name"]))?$_REQUEST["name"]:$sqls["listing"][1]["name"];
  $sqls["listing"][1]["description"]=(isset($_REQUEST["description"]))?$_REQUEST["description"]:$sqls["listing"][1]["description"];
    

  if($_SESSION["user"]["id"]!="unregistered"){
    print <<<EOD
      <form method="post" action="action/my_listings.php">
        <div style='text-align:right;'>
            <input type='hidden' name='listing_id' value="{$_REQUEST["listing_id"]}">
            <input type='submit' name='action' value='Unassociate Listing'> 
            <input type='submit' name='action' value='Delete Listing'>
        </div>
      </form>
EOD;
    }

    $action="save_listing";
} else {

    $action="new_listing";
    $sqls["listing"]=array();
    $sqls["listing"][1]=array();
    $sqls["listing"][1]["name"]=(isset($_REQUEST["name"]))?$_REQUEST["name"]:"";
    $sqls["listing"][1]["description"]=(isset($_REQUEST["description"]))?$_REQUEST["description"]:"";
    
}  

print <<<EOD
    <form method="post" action="action/my_listings.php">
      <fieldset>
      <legend>Company Information</legend>
      <input type='hidden' name='listing_id' value="{$_REQUEST["listing_id"]}">
      <input type='hidden' name='listing[id]' value="{$_REQUEST["listing_id"]}">
      <input type='hidden' name='action' value="{$action}">
      <table style='width:100%;' width="100%">
             <tr valign=top>
                 <td width="1%"><span style='color:red;'>*</span>Name:</td>
                 <td><input type='text' style='width:100%;' name='listing[name]' value="{$sqls["listing"][1]["name"]}"></td>
             </tr>
             <tr valign=top>
                 <td><span style='color:red;'>*</span>Description:</td>
                 <td><textarea rows=3 style='width:100%;' name="listing[description]">{$sqls["listing"][1]["description"]}</textarea></td>
                 <td width="1%" valign=bottom>
                     <input type='submit' value='Save'> 
                 </td>
             </tr>
      </table>
      </fieldset>
    </form>
EOD;


if(!$new_listing){
print <<<EOD
      <fieldset>
      <legend>Location Editor</legend>
EOD;

    foreach($sqls["locations"] as $rownumber=>$row){
        if($rownumber==0) continue;
        
        if($rownumber%2) $background="#fff"; else $background="#efefef";

        $province_options=get_options($row["province_id"],$sqls["provinces"]);
        $country_options=get_options($row["country_id"],$sqls["countries"]);
        $short_location=array();
        $short_location[]="Location #".($rownumber++).":";
        if(strlen($row["address1"])) $short_location[]=$row["address1"];
        if(strlen($row["city"])) $short_location[]=$row["city"];
        if(strlen($row["province_name"])) $short_location[]=$row["province_name"];
        if(strlen($row["country_name"])) $short_location[]=$row["country_name"];
        $short_location=join(" ",$short_location);
        
        print <<<EOD
            <form method="post" action="action/my_listings.php">
            <input type='hidden' name='listing_id' value="{$_REQUEST["listing_id"]}">
            <input type='hidden' name='listing_locations[id]' value="{$row["id"]}">
            <input type='hidden' name='action' value="edit_location">
            <div style="clear:both; background-color:{$background};">
                <div style='float:left;background-color:{$background};'>
                    <input type='button' onclick="document.getElementById('location_{$row["id"]}').style.display='block';" value='edit'>
                </div>
                <div style='float:left;background-color:{$background};'>
                    {$short_location}
                </div>
            </div>
            <div id="location_{$row["id"]}" style='background-color:silver; display:none; border:1px solid gray; position:absolute; left:25%; top:25%; z-index:2000;'>
                <h3>Edit Location</h3>
                  <table style="margin:5px; background-color:white;">
                      <tr valign=top>
                          <td nowrap>Contact Name:</td>
                          <td width="150px"><input type='text' style='width:100%;' 
                                     name="listing_locations[contact_name]" 
                                     value="{$row["contact_name"]}"></td>

                          <td><span style='color:red;'>*</span>Phone</td>
                          <td width="150px"><input type='text' style='width:100%;' 
                                     name="listing_locations[phone]" 
                                     value="{$row["phone"]}"></td>
                      </tr>
                      <tr>
                          <td nowrap>Address:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[address1]" 
                                     value="{$row["address1"]}"></td>

                          <td nowrap>Fax:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[fax]" 
                                     value="{$row["fax"]}"></td>
                      </tr>
                      <tr>
                          <td></td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[address2]" 
                                     value="{$row["address2"]}"></td>

                          <td nowrap>Cell:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[cell]" 
                                     value="{$row["cell"]}"></td>
                      </tr>
                      <tr>
                          <td nowrap><span style='color:red;'>*</span>City</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[city]" 
                                     value="{$row["city"]}"></td>

                          <td nowrap>Toll Free:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[tollfree]" 
                                     value="{$row["tollfree"]}"></td>
                      </tr>
                      <tr>
                          <td nowrap><span style='color:red;'>*</span>Country</td>
                          <td><select style='width:100%;' 
                                     name="listing_locations[country_id]">
                              {$country_options}
                              </select></td>

                          <td nowrap>Email(s):</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[email]" 
                                     value="{$row["email"]}"></td>
                      </tr>
                      <tr>
                          <td nowrap><span style='color:red;'>*</span>Province/State</td>
                          <td><select style='width:100%;' 
                                     name="listing_locations[province_id]">
                              {$province_options}
                              </select></td>

                          <td></td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[email2]" 
                                     value="{$row["email2"]}"></td>
                      </tr>
                      <tr>
                          <td nowrap>Post/Zip Code:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[pcode]" 
                                     value="{$row["pcode"]}"></td>

                          <td nowrap>Web Site Url:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[website]" 
                                     value="{$row["website"]}"></td>
                      </tr>
                  </table>
                  <div style='text-align:center;'>
                              <input type='button' onclick="document.getElementById('location_{$row["id"]}').style.display='none';" value='Close'> 
                              <input type='submit' name="edit_type" value='Save'>
                              <input type='submit' name="edit_type" value='Delete'>  
                  </div>
               </div>
               </form>
EOD;

    }

        $province_options=get_options("",$sqls["provinces"]);
        $country_options=get_options("",$sqls["countries"]);

        print <<<EOD
            <form method="post" action="action/my_listings.php">
            <input type='hidden' name='listing_id' value="{$_REQUEST["listing_id"]}">
            <input type='hidden' name='listing_locations[listing_id]' value="{$_REQUEST["listing_id"]}">
            <input type='hidden' name='action' value="add_location">
            <div style="clear:both;">
                <div style='float:left;'>
                    <input type='button' onclick="document.getElementById('location_0').style.display='block';" value='Add Location'>
                </div>
            </div>
            <div id="location_0" style='background-color:silver; display:none; border:1px solid gray; position:absolute; left:25%; top:25%; z-index:2000;'>
                <h3>Add Location</h3>
                  <table style="margin:5px; background-color:white;">
                      <tr valign=top>
                          <td nowrap>Contact Name:</td>
                          <td width="150px"><input type='text' style='width:100%;' 
                                     name="listing_locations[contact_name]"></td>

                          <td nowrap><span style='color:red;'>*</span>Phone</td>
                          <td width="150px"><input type='text' style='width:100%;' 
                                     name="listing_locations[phone]"></td>
                      </tr>
                      <tr>
                          <td nowrap>Address:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[address1]"></td>

                          <td nowrap>Fax:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[fax]"></td>
                      </tr>
                      <tr>
                          <td></td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[address2]"></td>

                          <td nowrap>Cell:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[cell]"></td>
                      </tr>
                      <tr>
                          <td nowrap><span style='color:red;'>*</span>City</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[city]"></td>

                          <td nowrap>Toll Free:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[tollfree]"></td>
                      </tr>
                      <tr>
                          <td nowrap><span style='color:red;'>*</span>Country</td>
                          <td><select style='width:100%;' 
                                     name="listing_locations[country_id]">
                              {$country_options}
                              </select></td>

                          <td nowrap>Email(s):</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[email]"></td>
                      </tr>
                      <tr>
                          <td nowrap><span style='color:red;'>*</span>Province/State</td>
                          <td><select style='width:100%;' 
                                     name="listing_locations[province_id]">
                              {$province_options}
                              </select></td>

                          <td></td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[email2]"></td>
                      </tr>
                      <tr>
                          <td nowrap>Post/Zip Code:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[pcode]"></td>

                          <td nowrap>Web Site Url:</td>
                          <td><input type='text' style='width:100%;' 
                                     name="listing_locations[website]"></td>
                      </tr>
                  </table>
                  <div style='text-align:center;'>
                              <input type='button' onclick="document.getElementById('location_0').style.display='none';" value='Close'> 
                              <input type='submit' name="edit_type" value='Add Location'>
                  </div>                  
               </div>
               </form>
      </fieldset>
      
    <form method="post" action="action/my_listings.php">
      <input type='hidden' name='listing_id' value="{$_REQUEST["listing_id"]}">
      <input type='hidden' name='categories[listing_id]' value="{$_REQUEST["listing_id"]}">
      <input type='hidden' name='action' value="edit_categories">
      <fieldset>
      <legend>Business Categories</legend>
EOD;

    //separate out the business types
    get_categories($sqls["business_types"],$all_categories,$include_categories);
    //draw out the list of business types
    print <<<EOD
          <table width="100%">
            <tr>
              <td>All Categories</td>
              <td></td>
              <td><span style='color:red;'>*</span>Include in Categories</td>
            </tr>
            <tr>
              <td width="50%">
                  <select name='categories[unselected][]' size=10 multiple style='width:100%;'>
                  {$all_categories}
                  </select>
              </td>
              <td>
                <input type='image' style='border:none;' src='../../images/left_arrow.png' name='edit_type[remove]'><br>
                <input type='image' style='border:none;' src='../../images/right_arrow.png' name='edit_type[add]'>
              </td>
              <td width="50%">
                  <select name='categories[selected][]' size=10 multiple style='width:100%;'>
                  {$include_categories}
                  </select>
              </td>
            </tr>
          </table>
      </fieldset>
    </form>
EOD;


print <<<EOD
      <fieldset>
      <legend>Upgrade to Premium</legend>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="custom" value="{$_REQUEST["listing_id"]}">
        <input type="hidden" name="hosted_button_id" value="10697773">
        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
       </fieldset>      
EOD;

//premium
//$sqls["premium"]="select * from premium where listing_id=[id]";
$payment_addon=<<<EOD
  <fieldset>
  <legend>Payment Information</legend>
  <table>
      <tr>
          <td>Payment Type:</td>
          <td>
              <select name='premium[payment_type]'>
              <option value="mastercard">MasterCard</option>
              <option value="visa">Visa</option>
              </select>
          </td>
      </tr>
      <tr>
          <td>Name on Card:</td>
          <td><input type='text' name='premium[name_on_card]'></td>
      </tr>
      <tr>
          <td>Card Number:</td>
          <td><input type='text' name='premium[card_number]'></td>
      </tr>
      <tr>
          <td>Expiry:</td>
          <td><input type='text' name='premium[card_expiry]'></td>
      </tr>
      <tr>
          <td>Security Code:</td>
          <td><input type='text' name='premium[security_code]'></td>
      </tr>
      <tr>
          <th colspan=2>
              <input type='submit' name='edit_type' value='Add Premium'>
          </th>
      </tr>
  </table>
  </fieldset>
EOD;


if($_SESSION["user"]["id"]=="unregistered"){
    $premium=<<<EOD
          <table>
          <tr>
              <td>
              <b>This is what you get with a free listing</b><br>
              <img src="../../images/free_listing.jpg" border=0 style='border:1px solid gray; margin:10px;'><br>
              <b>Or for less investment than the price of a cup of coffee 
              per week at Second Cup, you can get the following:</b><br>
              <ul>
              <li>Two (2) links to your company website</li>
              <li>The (More) button that opens a new window with all your contact information</li>
              <li>A description of your company services right in the listing</li>
              <li>Your fax number if desired</li>
              <li>Self addressed e-mail links</li>
              <li>Priority listing that displays at the top of search results</li>
              <li>Enhanced listing like below</li>
              </ul><br>
              <img src="../../images/premium_listing.jpg" border=0 style='border:1px solid gray; margin:10px;'><br>
              </td>
          </tr>
          <tr>
              <td>
              You must be a registered user to upgrade to premium.
              <br><br>
              <a href="register.php">Register</a> or 
              <a href="login.php?action=edit_listing&listing_id={$_REQUEST["listing_id"]}">Login</a> Now
              </td>
          </tr>
          </table>              
EOD;
} else {
  if(count($sqls["premium"])>1){
      //premium expired
      if($sqls["premium"][1]["expired"]==1){
          $premium=<<<EOD
            <table>
            <tr>
                <td>Expired On:</td>
                <td>{$sqls["premium"][1]["expires"]}</td>
            </tr>
            <tr>
                <td>
                <b>This is what you get with a free listing</b><br>
                <img src="../../images/free_listing.jpg" border=0 style='border:1px solid gray; margin:10px;'><br>
                <b>Or for less investment than the price of a cup of coffee 
                per week at Second Cup, you can get the following:</b><br>
                <ul>
                <li>Two (2) links to your company website</li>
                <li>The (More) button that opens a new window with all your contact information</li>
                <li>A description of your company services right in the listing</li>
                <li>Your fax number if desired</li>
                <li>Self addressed e-mail links</li>
                <li>Priority listing that displays at the top of search results</li>
                <li>Enhanced listing like below</li>
                </ul><br>
                <img src="../../images/premium_listing.jpg" border=0 style='border:1px solid gray; margin:10px;'><br>
                <br>
                To upgrade this listing to premium, please provide 
                payment information and click on 'Add Premium'.
                </td>
            </tr>
            <tr>
                <td>{$payment_addon}</td>
            </tr>
            </table>
EOD;
      } else {
          $premium=<<<EOD
             <table>
                 <tr>
                     <td>
                    This listing is already upgraded to a premium listing.
                    </td>
                 </tr>
                <tr>
                    <td>Expires On:</td>
                    <td>{$sqls["premium"][1]["expires"]}</td>
                </tr>
             </table>
EOD;
      }
  } else {
          $premium=<<<EOD
            <table>
            <tr>
                <td>
                <b>This is what you get with a free listing</b><br>
                <img src="../../images/free_listing.jpg" border=0 style='border:1px solid gray; margin:10px;'><br>
                <b>Or for less investment than the price of a cup of coffee 
                per week at Second Cup, you can get the following:</b><br>
                <ul>
                <li>Two (2) links to your company website</li>
                <li>The (More) button that opens a new window with all your contact information</li>
                <li>A description of your company services right in the listing</li>
                <li>Your fax number if desired</li>
                <li>Self addressed e-mail links</li>
                <li>Priority listing that displays at the top of search results</li>
                <li>Enhanced listing like below</li>
                </ul><br>
                <img src="../../images/premium_listing.jpg" border=0 style='border:1px solid gray; margin:10px;'><br>
                <br>
                To upgrade this listing to premium, please provide 
                payment information and click on 'Add Premium'.
                </td>
            </tr>
            <tr>
                <td>{$payment_addon}</td>
            </tr>
            </table>
EOD;

  }
}

print <<<EOD
    <fieldset>
    <legend>Premium Listing Enhancement</legend>
    <form method="post" action="action/my_listings.php">
    <input type='hidden' name='listing_id' value="{$_REQUEST["listing_id"]}">
    <input type='hidden' name='premium[listing_id]' value="{$_REQUEST["listing_id"]}">
    <input type='hidden' name='action' value="add_premium">
    {$premium}
    </form>
    </fieldset>
EOD;

//end premium




//logos
//print <<<EOD
//    <form enctype="multipart/form-data" method="post" action="action/my_listings.php" onsubmit="selectAllOptions('include_categories');">
//    <table>
//EOD;

//logos
//$sqls["logos"]="select * from logos where listing_id=[id]";
/*
$logo="";
$logo_text="";
$logo_url="";
if(count($sqls["logos"])>1){
    $logo=<<<EOD
        <img src="../customer_images/Logos/{$sqls["logos"][1]["path"]}">
EOD;
    $logo_text=$sqls["logos"][1]["alternate_text"];
    $logo_url=$sqls["logos"][1]["url"];
}
print <<<EOD
      <tr>
        <th>Logo</th>
      </tr>
      <tr>
        <td>{$logo}</td>
        <td>Logo Text:<br>Link To URL:<br>Upload New Logo:</td>
        <td>
            <input type='text' name='logo[text]' value="{$logo_text}"><br>
            <input type='text' name='logo[url]' value="{$logo_url}"><br>
            <input type="file" name="logo[file]" />
        </td>
      </tr>
      </table>
    </form>
    <form enctype="multipart/form-data" method="post" action="action/my_listings.php" onsubmit="selectAllOptions('include_categories');">
      <table>      
EOD;

//banners
//$sqls["banners"]="select * from banners where listing_id=[id]";
$banner="";
$banner_text="";
$banner_url="";
if(count($sqls["banners"])>1){
    $banner=<<<EOD
        <img src="../customer_images/banners/{$sqls["banners"][1]["path"]}">
EOD;
    $banner_text=$sqls["banners"][1]["alternate_text"];
    $banner_url=$sqls["banners"][1]["url"];

}
print <<<EOD
      <tr>
        <th>Banner</th>
      </tr>
      <tr>
        <td colspan=3>{$banner}</td>
      </tr>
      <tr>
        <td></td>
        <td>Banner Text:<br>Link To URL:<br>Upload New Banner:</td>
        <td>
            <input type='text' name='banner[text]' value="{$banner_text}"><br>
            <input type='text' name='banner[url]' value="{$banner_url}"><br>
            <input type="file" name="banner[file]" />
        </td>
      </tr>
      </table>
    </form>
EOD;


//videos
//$sqls["videos"]="select * from videos where listing_id=[id]";
*/


print <<<EOD
      </fieldset>
EOD;
}

function get_options($id,&$list){
    $options=array();
    $options[]=<<<EOD
                     <option value=""></option>
EOD;

    foreach($list as $rownumber=>$row){
        if($rownumber==0) continue;
        
        if($row["id"]==$id) $selected="selected"; else $selected="";
        
        $options[]=<<<EOD
                         <option value="{$row["id"]}" {$selected}>{$row["name"]}</option>
EOD;
    }
    return join("",$options);
}
function get_categories(&$list,&$all_categories,&$selected_categories){
    $all_categories=array();
    $selected_categories=array();
    foreach($list as $rownumber=>$row){
        if($rownumber==0) continue;
        
        if($row["selected"]==1){
            $selected_categories[]=<<<EOD
                         <option value="{$row["id"]}">{$row["name"]}</option>
EOD;
        } else {
            $all_categories[]=<<<EOD
                         <option value="{$row["id"]}">{$row["name"]}</option>
EOD;
        }
    }

    $all_categories=join("",$all_categories);
    $selected_categories=join("",$selected_categories);
}  

?>
</form>