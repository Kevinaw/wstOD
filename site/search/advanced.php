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
  <script type="text/javascript" src="/includes/forcetop.inc"></script>
</head>

<body>
      <div id="left-column">
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>

      </div>
      <div id="right-column">
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>

      </div>
      
      <div id="middle-column" >
          <div id="tab-container" style="margin:0;padding:0;">
              <ul>
                  <li><a>Advanced Search</a></li>
              </ul>
          </div>
          <div id="tab-content">
              <form action="index.php" method="post">
                <table>
                  <tr>
                    <td>Business Name:</td>
                    <td><input type='textbox' name='company'></td>
                  </tr>
                  <tr>
                    <td>Business Category:</td>
                    <td><input type='textbox' name='category'></td>
                  </tr>
                  <tr>
                    <td>Keyword(s):</td>
                    <td><input type='textbox' name='keyword'></td>
                  </tr>
                  <tr>
                    <td>Country:</td>
                    <td><input type='textbox' name='country'></td>
                  </tr>
                  <tr>
                    <td>Province/State:</td>
                    <td><input type='textbox' name='province'></td>
                  </tr>
                  <tr>
                    <td>City:</td>
                    <td><input type='textbox' name='city'></td>
                    <td><input type='image' src="../../images/find_red.gif"></td>
                  </tr>
                </table>
              </form>
          </div>
      </div>
    </div>
    <?php
include "../../google_analytics.php";
?>    

</body>
</html>
