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
                    <a>Browse Names</a>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();
    
    $sqls=array();
    
    $sql=<<<EOD
      select left(trim(name),1) as name,
             count(*) as num_listings 
      from listings 
      where length(trim(name))>0 and listings.active=1 
      group by 1
      order by 1
EOD;

    if($data=$db->get_data($sql,$_REQUEST)){
        print "<ul>";
        foreach($data as $rownumber=>$row){
            if($rownumber==0) continue;

            $name=urlencode($row["name"]);
            print <<<EOD
                  <li><a href="index.php?name_starts_with={$name}">{$row["name"]} ({$row["num_listings"]})</a></li>
EOD;
        }
        print "</ul>";
    } else {
        print "Listing Unavailable, please try again.";
    }
    
    
?>            
          </div>
          </form>
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