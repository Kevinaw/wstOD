<?php

session_start();

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
<?php
if(!isset($_SESSION["admin_user"])) print '<script type="text/javascript" src="../../includes/forcetop.inc"></script>';
?>
</head>

<body>
<div id='right-column'>
<?php
//----kevin----new code 08-24: for admin add listing
if (isset($_REQUEST['is_admin']) && $_REQUEST['is_admin'] == true)
    ;
else {
    $limit = 3;
    include $_SERVER['DOCUMENT_ROOT'] . "/includes/affiliates.inc";
}
//end
?>
</div>

<div style='margin-right:170px;'>        
      <div style="text-align:center; margin:0 auto; width:100%;">
        <form action="#" method="post">
        <h3>Search for Your Listing</h3>
<?php
    print <<<EOD
        <table style='margin:0 auto;'>
          <tr>
            <td>Business Name:</td>
            <td><input type='textbox' name='company' value="{$_POST["company"]}"></td>
          </tr>
          <tr>
            <td>Keyword(s):</td>
            <td><input type='textbox' name='keyword' value="{$_POST["keyword"]}"></td>
          </tr>
          <tr>
            <td colspan=2 align=right>
                <input type='image' src="../../images/find_red.gif" name='action' value="Search">
            </td>
          </tr>
        </table>
EOD;

      include "../search/views/get_listings.php";
      
      $items=array();
      if(isset($listings) and count($listings)>1){
      
         if($page_no<6 or $pages<=10) $start=1; else $start=$page_no-5;
         if($page_no<6) $end=10; else $end=$page_no+5;
         if($end>$pages) $end=$pages;
         
         if(!isset($test)){
             print <<<EOD
                     <div style='clear:both;'>
                     Page {$page_no} of {$pages}: 
EOD;
             for($x=$start;$x<=$end;$x++){
                 if($x==$page_no) $color=red; else $color=blue;
                 print "<input type='submit' name='page_no' value='{$x}' style='color:{$color}; background:none; border:none; text-decoration:underline;'> ";
             }
             print "</div>";
         }

    $_SESSION["error"]="";

?>
        <hr>
        <div id="error"><?php echo $_SESSION["error"]; ?></div>
        </form>
      </div>
      <div style='width:100%;'>
        <form action="add.php" method="post">
<?php

          foreach($listings as $rownumber=>$info){
              if($rownumber==0) continue;
               //----kevin----new code 08-24: admin edit listing
                  $action_href = "<input type='submit' name='action[" . $info["id"] . "]' value='Edit Listing'>";
                  if (isset($_REQUEST['is_admin']) && $_REQUEST['is_admin'] == true) {
                      $action_href = "<a href='/site/listings/add.php?action=Edit Listing&id=" . $info["id"] . "&is_admin=true' target=_blank>edit listing</a>";
                  }
//end  
              $items[]=<<<EOD
                  <table style='width:100%;'>
                  <tr>
                  <td align=left>
              {$action_href}
                  </td>
                  <td align=left width=100%>
                    <b>{$info["name"]}</b><br>
                    {$info["description"]}
                  </td>
                  </tr>
                  </table>
                  <hr>
EOD;
          }
      } else {
          $items[]="No listings found for the specified search criteria, please try again.";
      }
      print join("",$items);


?>
    </form>
     </div>
</div>
<?php
include "../../google_analytics.php";
?>    

</body>
</html>