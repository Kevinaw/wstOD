<?php
 // session_start();
//  if(isset($_SESSION["previous_post"])){
 //     $_POST["listing"]=$_SESSION["previous_post"];
//      print "session exists";
//  }

include 'action/add_new.php';

  //setup for a new listing
  if(!isset($_POST["listing"]) or isset($_REQUEST["new"])){
      $_POST["listing"]=array(
          "current"=>array(
              "info"=>array("id"=>-1,"name"=>"","description"=>""),
              "locations"=>array(),
              "categories"=>array()
          ),
          "premium"=>false,
          "expires"=>"Not Available"
      );
      $_POST["listing"]["new"]=$_POST["listing"]["current"];
  }
  if(!isset($_POST["listing"]["new"]["locations"])) $_POST["listing"]["new"]["locations"]=array();
  if(!isset($_POST["listing"]["new"]["categories"])) $_POST["listing"]["new"]["categories"]=array();
  if(!isset($_POST["listing"]["current"]["locations"])) $_POST["listing"]["current"]["locations"]=array();
  if(!isset($_POST["listing"]["current"]["categories"])) $_POST["listing"]["current"]["categories"]=array();

  //get required data  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  $sqls=array();  
  $sqls["countries"]="select * from countries order by name";
  $sqls["provinces"]="select * from prov_state order by name";
  $sqls["business_types"]="select * from businesstypes order by name"; 
  foreach($sqls as $sql_name=>$sql){
      if(isset($_SESSION[$sql_name])){
          $sqls[$sql_name]=$_SESSION[$sql_name];
      } else {
          $sqls[$sql_name]=$db->get_data($sql,array("id"=>$_REQUEST["listing_id"]));
          $_SESSION[$sql_name]=$sqls[$sql_name];
      }
  }
  
  if($_POST["listing"]["current"]["info"]["id"]==-1) $_POST["listing"]["premium"]=false;
  
?>
<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <TITLE>Welcome to the Oil Directory - Your online resource for the oil & gas industry!</TITLE>
	<META NAME="Description" CONTENT="The Oil Directory - A world wide market place for both buyers and sellers in the oil and gas industry!">
	<META NAME="Keywords" CONTENT="Abrasive Cutting,Abrasives,Accountants,Advertising,Promotion,Air Charter Services,Air Freight,Couriers,All-Terrain Vehicles,Auctioneers,Automotives,Cars &amp; Trucks,Backhoe Services,Blow Out Preventers,Camps,Cased Hole Logging,Cementers,Centrifuges,Chemical Oilfield,Closed Chamber Testers,Coating,Coiled Tubing,Communications,Compressors,Concrete Supplies,Construction,Construction Equipment,Construction Machinery,Containment,Directional Drilling,Downhole Tools / Equipment,Drill Bits,Drilling,Drilling Contractors,Drilling Fluids,Drilling Motors &amp; Tools,Drilling Rigs,Drillstem Testing,Engineering Consulting,Enhanced Production,Environmental Products &amp; Services,Exploration &amp; Production,Firefighting,Blowout Specialists,Geological Consulting,Geophysical Consulting,Human Resources Services,Employment,Classifieds,Machine Shops,Mining Equipment,Mining Supplies,Oil Companies,Oilfield Database,Oilfield Maintenance,Open Hole Logging,Pigging,Pipeline,Pipeline Services,Pumps,Rathole Drilling,Oilfield Rental Equipment,Safety Services,Safety Training,Service Rigs,Stimulation (Acidizing / Fracturing),Surveying,Underbalanced Drilling,Water Well Drillers,Wellsite Accommodation,Wellsite Consulting,Wellsite Reclamation,Wireline Services,drilling licenses,oil,gas,petroleum,oil and gas,oil industry,business index,business listings,marketing">
	<META HTTP-EQUIV="Reply-to" CONTENT="service@oildirectory.com (Canadian Jarrett Industries, Inc.)">
	<META http-equiv="PICS-Label" content='(PICS-1.1 "http://www.icra.org/ratingsv02.html" l gen true for "http://www.oildirectory.com/" r (cz 1 lz 1 nz 1 oz 1 vz 1) "http://www.rsac.org/ratingsv01.html" l gen true for "http://www.oildirectory.com/" r (n 0 s 0 v 0 l 0))'>
	<LINK REL="SHORTCUT ICON" href="../../images/OilDirectoryFavIcon.Ico">  

  <link rel="stylesheet" type="text/css" media="screen" href="../../css/home.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="../../css/ads.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="../../css/submission.css" />
  <style>
      fieldset { border:1px solid gray; }
  </style>
<?php
if(!isset($_SESSION["admin_user"])) print '<script type="text/javascript" src="../../includes/forcetop.inc"></script>';
?>
  <link rel="stylesheet" type="text/css" href="subModal.css" />
  <script type="text/javascript" src="subModal.js"></script>
  <script>
      function show_location(i){
          var m = document.getElementsByTagName("DIV");
          for(j in m){
              if(m[j].id){
                  if(m[j].id.indexOf("location_div_")!=-1){
                      m[j].style.display='none';
                  }
              }
          }
          document.getElementById(i.value).style.display='inline';
      }
      function showmore(url) {
        moreinfo = window.open(url, "more", "width=750,height=500,toolbar=no");
      }
  </script>
</head>

<body onload="show_window();">
<div id='right-column'>
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>
</div>

<div style='margin-right:160px; '>       
    <form method="post" action="add_new.php" style='width:100%;'>

<?php

if($_POST["listing"]["current"]["info"]["id"]==-1){
    $title="Add A New Listing";
    $buttons=<<<EOD
      <input type='submit' name='action' value='Save Changes'> 
      <input type='submit' name='action' value='Cancel Changes'> 
EOD;
 
} else {
    $title="Edit Listing";
    $buttons=<<<EOD
      <input type='submit' name='action' value='Save Changes'> 
      <input type='submit' name='action' value='Cancel Changes'> 
      <input type='submit' name='action' value='Delete Listing'>
EOD;
}

//store all current information
foreach($_POST["listing"]["current"]["info"] as $name=>$value){
        $value=addslashes($value);
        print <<<EOD
            <input type='hidden' name="listing[current][info][{$name}]" value="{$value}">
EOD;
}
foreach($_POST["listing"]["current"]["locations"] as $id=>$info){
    foreach($info as $name=>$value){
        $value=addslashes($value);
        print <<<EOD
            <input type='hidden' name="listing[current][locations][{$id}][{$name}]" value="{$value}">
EOD;
    }
}
foreach($_POST["listing"]["current"]["categories"] as $id=>$value){
        print <<<EOD
            <input type='hidden' name="listing[current][categories][{$id}]" value="{$value}">
EOD;
}



print <<<EOD
  <div id="tab-container" style='width:100%;'>
      <ul>
          <li>
            <div style='float:left;'>
              <a style='font-size:8pt;'>{$title}</a>
            </div>
          </li>
      </ul>
  </div>
  <div id="tab-content" style='width:100%;'>
  
  <div id="error">{$_SESSION["error"]}</div>
  
  <table style='width:99%;'>
  <tr valign=top>
  <td align=center style='width:50%;'>

      <fieldset>
      <legend>Company Information</legend>
      <input type='hidden' name='listing[new][info][id]' value="{$_POST["listing"]["current"]["info"]["id"]}">
      <table style='width:100%;' width="100%">
             <tr valign=top>
                 <td width="1%"><span style='color:red;'>*</span>Name:</td>
                 <td>
                     <input type='text' style='width:100%;' name='listing[new][info][name]' value="{$_POST["listing"]["new"]["info"]["name"]}">
                 </td>
             </tr>
             <tr valign=top>
                 <td><span style='color:red;'>*</span>Description:</td>
                 <td>
                     <textarea rows=6 style='width:100%;' name="listing[new][info][description]">{$_POST["listing"]["new"]["info"]["description"]}</textarea>
                 </td>
             </tr>
             <tr valign=top>
                 <td colspan=2><span style='color:red;'>*</span>Administrator Email (will be used to confirm changes to listing):</td>
             </tr>
             <tr valign=top>
                 <td></td>
                 <td>
                     <input type='text' style='width:100%;' name="listing[new][info][update_email]" value="{$_POST["listing"]["new"]["info"]["update_email"]}">
                 </td>
             </tr>
      </table>
      </fieldset>
      
      <br>
      
      <fieldset>
      <legend>Business Categories</legend>
EOD;

    get_categories($sqls["business_types"],$_POST["listing"]["new"]["categories"],$all_categories,$include_categories);

    print <<<EOD
          <table width="100%">
            <tr>
              <td>All Categories</td>
              <td></td>
              <td><span style='color:red;'>*</span>Include in Categories</td>
            </tr>
            <tr>
              <td width="50%">
                  <select name='new_categories[]' size=15 multiple style='width:100%;'>
                  {$all_categories}
                  </select>
              </td>
              <td>
                <input type='image' style='border:none;' src='../../images/left_arrow.png' name='action[Remove Category][]'><br>
                <input type='image' style='border:none;' src='../../images/right_arrow.png' name='action[Add Category][]'>
              </td>
              <td width="50%">
                  <select name='remove_categories[]' size=15 multiple style='width:100%;'>
                  {$include_categories}
                  </select>
              </td>
            </tr>
          </table>
      </fieldset>     

      <br>

      {$buttons}
</td>
<td style='width:50%;'>
      
      <fieldset>
      <legend>Location Information</legend>
      

      <table style='width:100%;'>
             <tr valign=top>
                 <td>
      <input type='submit' name='action' value='Add Location'>
      </td>
      </tr>
      <tr valign=top>
      <td>

EOD;

    //print location list
    $location_divs=array();
    if(isset($_POST["listing"]["new"]["locations"])){
      foreach($_POST["listing"]["new"]["locations"] as $locnum=>$info){
 
          $province_options=get_options($info["province_id"],$sqls["provinces"]);
          $country_options=get_options($info["country_id"],$sqls["countries"]);
          $location_divs[]=<<<EOD
              <div id="location_div_{$locnum}" style='display:; width:100%;'>
                  <table style='width:100%; font-size:10pt; border:1px solid silver;'>
                      <tr>
                          <th colspan=2>Edit Location #{$locnum}</td>
                      </tr>
                      <tr>
                          <td style='width:40%;'>
                          <input type='hidden' name='listing[new][locations][{$locnum}][id]' value="{$info["id"]}">
                            <table style='font-size:10pt; width:100%:'>
                                <tr>
                                    <td align=left nowrap>Contact Name:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][contact_name]' value="{$info["contact_name"]}"></td>
                                </tr>
                                <tr>
                                    <td align=left nowrap valign=top>Address:</td>
                                    <td>
                                        <input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][address1]' value="{$info["address1"]}">
                                        <br>
                                        <input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][address2]' value="{$info["address2"]}">
                                    </td>
                                </tr>
                                <tr>
                                    <td align=left nowrap>City:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][city]' value="{$info["city"]}"></td>
                                </tr>
                                <tr>
                                    <td align=left nowrap><span style='color:red;'>*</span>Province:</td>
                                    <td>
                                        <select style='width:100%;' 
                                         name="listing[new][locations][{$locnum}][province_id]">
                                        {$province_options}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=left nowrap><span style='color:red;'>*</span>Country:</td>
                                    <td width=100%>
                                        <select style='width:100%;' 
                                       name="listing[new][locations][{$locnum}][country_id]">
                                       {$country_options}
                                       </select>
                                     </td>
                                </tr>
                                <tr>
                                    <td align=left nowrap>Post/Zip Code:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][pcode]' value="{$info["pcode"]}"></td>
                                </tr>
                            </table>
                          </td>
                          <td style='width:60%;'>
                              <table style='font-size:10pt; width:100%:'>
                                <tr>
                                    <td align=left nowrap><span style='color:red;'>*</span>Phone:</td>
                                    <td width=100%><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][phone]' value="{$info["phone"]}"></td>
                                </tr>
                                <tr>
                                    <td align=left nowrap>Fax:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][fax]' value="{$info["fax"]}"></td>
                                </tr>
                                <tr>
                                    <td align=left nowrap>Cell:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][cell]' value="{$info["cell"]}"></td>
                                </tr>
                                <tr>
                                    <td align=left nowrap>Toll Free:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][tollfree]' value="{$info["tollfree"]}"></td>
                                </tr>
                                <tr>
                                    <td align=left nowrap valign=top>Email(s):</td>
                                    <td>
                                        <input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][email]' value="{$info["email"]}">
                                        <br>
                                        <input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][email2]' value="{$info["email2"]}">
                                    </td>
                                </tr>
                                <tr>
                                    <td align=left nowrap>Website URL:</td>
                                    <td><input type='text' style='width:100%;' name='listing[new][locations][{$locnum}][website]' value="{$info["website"]}"></td>
                                </tr>
                            </table>
                            <br>
                            <input type='submit' name='action[{$locnum}]' value='Remove Location'>
                          </td>
                      </tr>
                  </table>
              </div>
EOD;
      }
    }
      
    //print location divs
    print join("",$location_divs);
            
print <<<EOD

                  </td>
               </tr>
            </table>    
      </fieldset>

</td>

</tr>
</table>      
        <input type='hidden' name='listing[premium]' value="{$_POST["listing"]["premium"]}">
        <input type='hidden' name='listing[expires]' value="{$_POST["listing"]["expires"]}">
EOD;



?>
    </form>
   </div>
</div>

<?php
//show premium window if necessary
$show_upgrade=true;
$show_premium=false;
if(isset($_POST["listing"]["current"]["info"]["id"]) and $_POST["listing"]["current"]["info"]["id"]==-1) $show_upgrade=false;
if(isset($_POST["listing"]["premium"]) and $_POST["listing"]["premium"]==true){
    $show_upgrade=false;
    $show_premium=true;
}

if($show_upgrade){

    print <<<EOD
    			<div style='margin:0 auto; text-align:center; margin-bottom:10px;'>
          <h5>To subscribe now for only $99.95/year, click on the subscribe button below</h5>
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="custom" value="{$_POST["listing"]["new"]["info"]["id"]}">
          <input type="hidden" name="hosted_button_id" value="10697773">
          <input onclick="paypal_clicked('{$_POST["listing"]["new"]["info"]["id"]}');" type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
          </form>
          </div>
EOD;

}

//old popup for paypal
//temporarily turn off
$show_upgrade=false;
if($show_upgrade){
    $categories="None Selected";
    if(isset($_POST["listing"]["new"]["categories"])) join(",",$_POST["listing"]["new"]["categories"]);

    $locations=array();
    if(isset($_POST["listing"]["new"]["locations"])){
        foreach($_POST["listing"]["new"]["locations"] as $locnum=>$info){
            $items=array();
            $items[]=get_country($info["country_id"]);
            $items[]=get_province($info["province_id"]);
            if(strlen($info["city"])) $items[]=$info["city"];
            if(strlen($info["phone"])) $items[]="Phone: ".$info["phone"];
            if(strlen($info["tollfree"])) $items[]="Toll Free: ".$info["tollfree"];
            $locations[]=join(",",$items);
        }
    }
    if(count($locations)){
        $location=join("<br>",$locations);
    } else $location="None Entered";
    
    
    print <<<EOD
      <div id='popupMask'>
      </div>
      <div id='popupContainer'>
        <div id="popupInner">
    			<div id="popupTitleBar">
    				<div id="popupTitle">Upgrade to Premium Today</div>
    				<div id="popupControls">
    					<img src="close.gif" onclick="hide_window();" id="popCloseBox" />
    				</div>
    			</div>
    			<div style='text-align:left; margin:10px; width:100%;'>
    			<h4 style='color:#dd3333;'>Your Free Listing Includes:</h4>
    			    <ul>
    			    <li>You company name</li>
    			    <li>The "More Info" link that opens a new window with only your state/province, country and phone number</li>
              </ul>
              <div style='border:1px solid silver; margin-left:10px; margin-right:10px; width:90%;'>
EOD;

    $_REQUEST["id"]=$_POST["listing"]["new"]["info"]["id"];
    $test=true;
    include '../search/views/get_listings.php';
    include '../search/views/get_listings_table.php';

    print <<<EOD
                </div>
                   
          <h4 style='color:#228b22;'>Or...For less investment than the price of a cup of coffee per 
          week, you can get the following:</h4>
          <ul>
              <li>Links to your company website</li>
              <li>The "More Information" button that opens a new window with all of your contact and 
              location information</li>
              <li>A description of your company services right in the listing</li>
              <li>A summary of your contact information right in the listing</li>
              <li>Priority listing that displays at the top of search results</li>
          </ul>

              <div style='border:1px solid silver; margin-left:10px; margin-right:10px; width:90%;'>
EOD;

    $_REQUEST["id"]=$_POST["listing"]["new"]["info"]["id"];
    $test_premium=true;
    draw();

    print <<<EOD
                </div>
    			</div>
    			<div style='margin:0 auto; text-align:center; margin-bottom:10px;'>
          <h5>To subscribe now for only $99.95/year, click on the subscribe button below</h5>
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="custom" value="{$_POST["listing"]["new"]["info"]["id"]}">
          <input type="hidden" name="hosted_button_id" value="10697773">
          <input onclick="paypal_clicked('{$_POST["listing"]["new"]["info"]["id"]}');" type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
          </form>
          </div>
    		</div>
      </div>

EOD;
} 
if($show_premium){
  print <<<EOD
        <div style='margin:0 auto; text-align:center; width:50%; margin-bottom:10px;'>
          <h5>Your Premium Listing Expires on {$_POST["listing"]["expires"]}</h5>
          You will be rebilled through paypal for another year of premium listings 
          on {$_POST["listing"]["expires"]}.  If you would like to cancel your 
          subscription renewal, click on the "Unsubscribe" button below.  <br>
          <br>
          <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=RUL8UPSEF4ZSC" target=_blank>
          <IMG SRC="https://www.paypal.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0"></a>
          <br>
          <br>
          <i>Note: If you unsubscribe, your listing will remain a premium listing 
          until {$_POST["listing"]["expires"]}</i>
          </A>
        </div>
EOD;
}
    
//    print "<pre>";
//    print_r($_POST);
?>
</body>
</html>

<?php

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
function get_categories(&$list,&$current_categories,&$all_categories,&$selected_categories){

    $all_categories=array();
    $selected_categories=array();
    foreach($list as $rownumber=>$row){
        if($rownumber==0) continue;
        
        if(in_array($row["id"],$current_categories)){
            print <<<EOD
                  <input type='hidden' name="listing[new][categories][]" value="{$row["id"]}">
EOD;
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

function get_country($id){
    global $_SESSION;
    
    $country="";
    if(isset($_SESSION["countries"])){
      foreach($_SESSION["countries"] as $rownumber=>$row){
          if($rownumber==0) continue;
          if($row["id"]==$id){
              $country=$row["name"];
              break;
          }
      }
    }
    return $country;
}
function get_province($id){
    global $_SESSION;

    $province="";
    if(isset($_SESSION["provinces"])){
      foreach($_SESSION["provinces"] as $rownumber=>$row){
          if($rownumber==0) continue;
          if($row["id"]==$id){
              $province=$row["name"];
              break;
          }
      }
    }
    return $province;
}

    $_SESSION["error"]="";




?>

<?php
include "../../google_analytics.php";
?>    

</body>
</html>