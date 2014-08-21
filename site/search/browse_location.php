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
	<LINK REL="SHORTCUT ICON" href="/images/OilDirectoryFavIcon.Ico">  
  <link rel="stylesheet" type="text/css" media="screen" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/ads.css" />
  <script type="text/javascript" src="/includes/forcetop.inc"></script>
  <script>
      function toggle_visible(i){
          if(document.getElementById(i).style.display=='none'){
              document.getElementById(i).style.display='block';
              document.getElementById(i + 'image').src='/images/minus.png';
          } else {
              document.getElementById(i).style.display='none';
              document.getElementById(i + 'image').src='/images/plus.png';
          }
      }
  </script>
  <style>
  li { cursor:pointer; }
  </style>
</head>

<body>
    <div id="container">
    <table style="width:100%">
    <tr valign=top>
    <td>
          <div id="tab-container">
              <ul>
                  <li class='pointer'>
                    <a>Browse Locations</a>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();
    
    $sql=<<<EOD
      select countries.name as country,
             prov_state.name as prov,
             listing_locations.city,
             count(*) as num_listings 
      from listings 
          join listing_locations on listing_locations.listing_id=listings.id 
          join countries on countries.id=country_id 
          join prov_state on prov_state.id=province_id 
      where listings.active=1 
      group by 1,2,3
      order by 1,2,3  
EOD;

    $browse_locations=array();
    if($data=$db->get_data($sql,$_REQUEST)){
        foreach($data as $rownumber=>$row){
            if($rownumber==0) continue;
            
            if(!isset($browse_locations[$row["country"]])){
                $browse_locations[$row["country"]]=array("count"=>0,"prov"=>array());
            }
            if(!isset($browse_locations[$row["country"]]["prov"][$row["prov"]])){
                $browse_locations[$row["country"]]["prov"][$row["prov"]]=array("count"=>0,"city"=>array());
            }
            $browse_locations[$row["country"]]["prov"][$row["prov"]]["city"][$row["city"]]=$row["num_listings"];
            $browse_locations[$row["country"]]["prov"][$row["prov"]]["count"]+=$row["num_listings"];
            $browse_locations[$row["country"]]["count"]+=$row["num_listings"];
        }
    } else {
        print "Currently Unavailable, please try again.";
    }
    
    print "<ul>";
    foreach($browse_locations as $country=>$info){
        print <<<EOD
              <li>
              <a onclick="toggle_visible('{$country}_prov');">
                  <img id="{$country}_provimage" src='/images/plus.png'>
              </a>
              <a href="index.php?full_country={$country}">
                  {$country}
              </a> ({$info["count"]}) 
              </li>
EOD;
        print "<ul style='display:none;' id='{$country}_prov'>";
        foreach($info["prov"] as $prov=>$info2){
            print <<<EOD
                  <li>
                  <a onclick="toggle_visible('{$prov}_city');">
                      <img id="{$prov}_cityimage" src='/images/plus.png'>
                  </a>
                  <a href="index.php?full_country={$country}&full_province={$prov}">
                  {$prov}
                  </a> ({$info2["count"]})
                  </li>
EOD;

            print "<ul style='display:none;' id='{$prov}_city'>";
            foreach($info2["city"] as $city=>$count){
                print <<<EOD
                      <li>
                      <a href="index.php?full_country={$country}&full_province={$prov}&full_city={$city}">
                      {$city}
                      </a> ({$count}) 
                      </li>
EOD;

            }
            print "</ul>";
        }
        print "</ul>";
    }
    print "</ul>";
    
?>
          </div>
      </td>
      <td style="width:150px;">
<?php      
    $limit=5;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>
      </td>
      </tr>
      </table>
    </div>


    <?php
include "../../google_analytics.php";
?>   


</body>
</html>