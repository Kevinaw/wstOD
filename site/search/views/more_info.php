<html >
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <TITLE>Welcome to the Oil Directory - Your online resource for the oil & gas industry!</TITLE>
	<META NAME="Description" CONTENT="The Oil Directory - A world wide market place for both buyers and sellers in the oil and gas industry!">
	<META NAME="Keywords" CONTENT="Abrasive Cutting,Abrasives,Accountants,Advertising,Promotion,Air Charter Services,Air Freight,Couriers,All-Terrain Vehicles,Auctioneers,Automotives,Cars &amp; Trucks,Backhoe Services,Blow Out Preventers,Camps,Cased Hole Logging,Cementers,Centrifuges,Chemical Oilfield,Closed Chamber Testers,Coating,Coiled Tubing,Communications,Compressors,Concrete Supplies,Construction,Construction Equipment,Construction Machinery,Containment,Directional Drilling,Downhole Tools / Equipment,Drill Bits,Drilling,Drilling Contractors,Drilling Fluids,Drilling Motors &amp; Tools,Drilling Rigs,Drillstem Testing,Engineering Consulting,Enhanced Production,Environmental Products &amp; Services,Exploration &amp; Production,Firefighting,Blowout Specialists,Geological Consulting,Geophysical Consulting,Human Resources Services,Employment,Classifieds,Machine Shops,Mining Equipment,Mining Supplies,Oil Companies,Oilfield Database,Oilfield Maintenance,Open Hole Logging,Pigging,Pipeline,Pipeline Services,Pumps,Rathole Drilling,Oilfield Rental Equipment,Safety Services,Safety Training,Service Rigs,Stimulation (Acidizing / Fracturing),Surveying,Underbalanced Drilling,Water Well Drillers,Wellsite Accommodation,Wellsite Consulting,Wellsite Reclamation,Wireline Services,drilling licenses,oil,gas,petroleum,oil and gas,oil industry,business index,business listings,marketing">
	<META HTTP-EQUIV="Reply-to" CONTENT="service@oildirectory.com (Canadian Jarrett Industries, Inc.)">
	<META http-equiv="PICS-Label" content='(PICS-1.1 "http://www.icra.org/ratingsv02.html" l gen true for "http://www.oildirectory.com/" r (cz 1 lz 1 nz 1 oz 1 vz 1) "http://www.rsac.org/ratingsv01.html" l gen true for "http://www.oildirectory.com/" r (n 0 s 0 v 0 l 0))'>
	<LINK REL="SHORTCUT ICON" href="/images/OilDirectoryFavIcon.Ico">  
  <link rel="stylesheet" type="text/css" media="screen" href="../../../css/home.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="../../../css/ads.css" />
  <style>
    html,body { height:100%; width:100%; }
    #globalnav {
    	position:relative;
    	float:left;
    	width:100%;
    	padding:0 0 0 1em;
    	margin:0;
    	list-style:none;
    	line-height:1em;
    }
    
    #globalnav LI {
    	float:left;
    	margin:0;
    	padding:0;
    }
    
    #globalnav A {
    	display:block;
    	color:#444;
    	text-decoration:none;
    	font-weight:bold;
    	background:#ddd;
    	margin:0;
    	padding:0.25em 1em;
    	border-left:1px solid #fff;
    	border-top:1px solid #fff;
    	border-right:1px solid #aaa;
    }
    
    #globalnav A:hover,
    #globalnav A:active,
    #globalnav A.here:link,
    #globalnav A.here:visited {
    	background:#bbb;
    }
    
    #globalnav A.here:link,
    #globalnav A.here:visited {
    	position:relative;
    	z-index:102;
    }
  
  </style>
  <script>
      function show(id){
      
          document.getElementById('location').style.display='none';
          document.getElementById('category').style.display='none';
          document.getElementById('desc').style.display='none';
          
          document.getElementById(id).style.display='inline';
      }
      function startup(){
               document.getElementById('startlink').setActive();
      }
      function search_category(url){
        if (window.opener && !window.opener.closed)
            window.opener.location.href = url;
        else
            window.open(url);
          window.close();
          
      
      }
      
      function makeHttpRequest(url, callback_function, return_xml)
      {
         var http_request = false;
      
         if (window.XMLHttpRequest) { // Mozilla, Safari,...
             http_request = new XMLHttpRequest();
             if (http_request.overrideMimeType) {
                 http_request.overrideMimeType('text/xml');
             }
      
         } else if (window.ActiveXObject) { // IE
             try {
                 http_request = new ActiveXObject("Msxml2.XMLHTTP");
             } catch (e) {
                 try {
                     http_request = new ActiveXObject("Microsoft.XMLHTTP");
                 } catch (e) {}
             }
         }
      
         if (!http_request) {
             //alert('Unfortunatelly you browser doesn\'t support this feature.');
             return false;
         }
         http_request.onreadystatechange = function() {
             if (http_request.readyState == 4) {
                 if (http_request.status == 200) {
                     if (return_xml) {
                         eval(callback_function + '(http_request.responseXML)');
                     } else {
                         eval(callback_function + '(http_request.responseText)');
                     }
                 } else {
                     //alert('There was a problem with the request.(Code: ' + http_request.status + ')');
                 }
             }
         }
         http_request.open('GET', url, true);
         http_request.send(null);
      }
      
      function loadBanner(xml)
      {
          var html_content = xml.getElementsByTagName('content').item(0).firstChild.nodeValue;
          var reload_after = xml.getElementsByTagName('reload').item(0).firstChild.nodeValue;
          var banner_name =  xml.getElementsByTagName('banner_name').item(0).firstChild.nodeValue;
          document.getElementById(banner_name).innerHTML = html_content;
      
          try {
              clearTimeout(to);
          } catch (e) {}
      
          to = setTimeout("nextAd()", parseInt(reload_after));
      
      
      }      
  </script>
</head>

<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    
    //  if admin view listing details, go to table request_listings
    //  if customer view listing details, go to table listings..
    $listings_tbl  =   "";
    $listing_business_types_tbl  =   "";
    $listing_locations_tbl  =   "";
    if (isset($_REQUEST['is_admin']) && $_REQUEST['is_admin'] == true)
    {
        $_REQUEST['listings_tbl'] = "request_listings";
        $_REQUEST['listing_business_types_tbl'] = "request_listing_business_types";
        $_REQUEST['listing_locations_tbl'] = "request_listing_locations";
    }
    else
    {
        $_REQUEST['listings_tbl'] = "listings";
        $_REQUEST['listing_business_types_tbl'] = "listing_business_types";
        $_REQUEST['listing_locations_tbl'] = "listing_locations";
    }
        
    $db=new Database();

    $sqls=array();
    $sqls["listing"]="select * from [listings_tbl] where id=[id]";
    $sqls["locations"]=<<<EOD
        select [listing_locations_tbl].*, 
            prov_state.name as province_name,
            countries.name as country_name   
        from [listing_locations_tbl] 
            left join prov_state on prov_state.id=province_id 
            left join countries on countries.id=country_id 
        where listing_id=[id]
EOD;
    $sqls["business_types"]=<<<EOD
        select businesstypes.*   
        from  businesstypes
        join [listing_business_types_tbl] on business_type_id=businesstypes.id and listing_id=[id]
EOD;
    $sqls["premium"]="select *,case when expires<current_timestamp then 1 else 0 end as expired from premium where listing_id=[id] order by expires desc limit 1";


    $sqls["banner"]="select * from banners where listing_id=[id]";

    $sqls["logo"]="select * from logos where listing_id=[id]";

    $category_ids=array();
    
    foreach($sqls as $name=>$sql){
        $sqls[$name]=$db->get_data($sql,$_REQUEST);
    }
    
    //premium
    $premium=false;
    $test_premium=false;
    if($sqls["premium"]!==false){
        if(count($sqls["premium"])==2){
            if($sqls["premium"][1]["expired"]==0){
                $premium=true;
                $page_width="100%";
            }
        }
    }
    if(isset($_REQUEST["show_premium"])){
        $premium=true;
        $test_premium=true;
    }


print <<<EOD
  <body onload="startup();">
  <div style='overflow:auto; height:490px; width:740px; '>
  <table style='width:720px;'>
  <tr>
  <td>
    <img src="/images/logo_small.jpg" align=left><br><b>More Information</b><br clear=all>
    <ul id="globalnav">
    <li><a href=# id="startlink" onclick="show('desc');">Company Description</a></li>
    <li><a href=# onclick="show('location');">Locations/Contact</a></li>
    <li><a href=# onclick="show('category');">Categories</a></li>
    </ul>
  </td>
EOD;

if(!$premium){
    $limit=3;
    print <<<EOD
          <td valign=top width=170 rowspan=3>
EOD;

    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";

    print <<<EOD
          </td>
EOD;
}

print <<<EOD
  </tr>
  <tr valign=top>
  <td height=100% style='border:1px solid silver;'>
    <div style='width:100%; padding:10px;'>
EOD;

    
    //listing    
    print "<div id='desc' style='display:inline;'>";

    if($premium and $sqls["logo"]!=false){
        if(count($sqls["logo"])==2){
          print <<<EOD
            <div style='float:left;'>
              <a href="{$sqls["logo"][1]["url"]}" target=_blank>
              <img src="../../../site/customer_images/Logos/{$sqls["logo"][1]["path"]}" border=0 alt="{$sqls["logo"][1]["alternate_text"]}">
              </a>
            </div>
EOD;
        } elseif ($test_premium) {
          print <<<EOD
            <div style='float:left;'>
              <img src="../../../site/customer_images/Logos/yourlogo.jpg" border=0 alt="Your Logo Here">
            </div>
EOD;
        }
      }
    

    if($sqls["listing"]!==false){
        print <<<EOD
            <h3>{$sqls["listing"][1]["name"]}</h3><br>
            {$sqls["listing"][1]["description"]}
EOD;
    } else print "Unavailable";
    
    if($premium and $sqls["banner"]!=false){
        if(count($sqls["banner"])==2){
          print <<<EOD
            <div style='text-align:center;'>
              <a href="{$sqls["banner"][1]["url"]}" target=_blank>
              <img style='margin:0 auto;' src="../../../site/customer_images/banners/{$sqls["banner"][1]["path"]}" border=0 alt="{$sqls["banner"][1]["alternate_text"]}">
              </a>
            </div>
EOD;
        } elseif($test_premium){
          print <<<EOD
            <div style='text-align:center;'>
              <img style='margin:0 auto;' src="../../../site/customer_images/banners/yourbanner.gif" border=0 alt="Your Banner Here">
            </div>
EOD;
        }
    } 

    

    print "</div>";
    
    print "<div id='location' style='display:none; '>";
    if($sqls["locations"]!==false){
        
        foreach($sqls["locations"] as $rownumber=>$row){
            if($rownumber==0) continue;
            if($rownumber!=1) print "<hr>";
            
            $address=array();
            $contact=array();
            
            if($premium){
            
              if(strlen($row["address1"])) $address[]=$row["address1"];
              if(strlen($row["address2"])) $address[]=$row["address2"];
              if(strlen($row["city"])) $address[]=$row["city"].", ".$row["province_name"]; else $address[]=$row["province_name"];
              if(strlen($row["pcode"])) $address[]=$row["pcode"]."&nbsp;&nbsp;&nbsp;".$row["country_name"]; else $address[]=$row["country_name"];
  
              if(strlen($row["phone"])) $contact[]="<img src='../../../images/phone.gif' alt='phone'> ".$row["phone"];
              if(strlen($row["fax"])) $contact[]="<img src='../../../images/fax.gif' alt='fax'> ".$row["fax"];
              if(strlen($row["cell"])) $contact[]="<img src='../../../images/mobile.gif' alt='mobile'> ".$row["cell"];
              if(strlen($row["tollfree"])) $contact[]="<img src='../../../images/phone.gif' alt='toll free'> ".$row["tollfree"];
              
              if(strlen($row["email"])) $contact[]="<img src='../../../images/email.png' alt='email'> <a target=_blank href=\"mailto://".$row["email"]."?subject=Contact from Oildirectory.com\">".$row["email"]."</a>";            
              if(strlen($row["email2"])) $contact[]="<img src='../../../images/email.png' alt='email'> ".$row["email2"];            
              if(strlen($row["website"])) $contact[]="<img src='../../../images/website.png' alt='website'> <a target=_blank href=\"".$row["website"]."\">".$row["website"]."</a>";
            } else {
              if(strlen($row["city"])) $address[]=$row["country_name"].", ".$row["province_name"].", ".$row["city"]; else $address[]=$row["country_name"].", ".$row["province_name"];
              if(strlen($row["phone"])) $contact[]="<img src='../../../images/phone.gif' alt='phone'> ".$row["phone"];
            }

            print "<table><tr><td valign=top>";
            print join("<br>",$address);
            print "</td><td valign=top>";
            print join("<br>",$contact);
            print "</td></tr></table>";
        }
    } else print "Unavailable";
    print "</div>";
    
    //categories
    print "<div id='category' style='display:none;  '>";
    if($sqls["business_types"]!==false){
        $categories=array();
        foreach($sqls["business_types"] as $rownumber=>$row){
            if($rownumber==0) continue;
            $name=urlencode($row["name"]);
            $categories[]=<<<EOD
                <a href='#' onclick="search_category('/site/search/index.php?specific_category={$name}');">
                {$row["name"]}
                </a>
EOD;
            $category_ids[]=$row["id"];
        }
        print join(", ",$categories);
    } else print "Unavailable";
    print "</div>";
    
    
    

?>
</td>
</tr>
<?php
if(!$premium){
    print <<<EOD
          
          <tr>
          <td>
            <div style='text-align:center; width:100%; margin:0 auto; margin-top:10px; '>
              <div id="banner-div2">
                  <div id="ajax-banner2"></div>
              </div>
            </div>
            <script>
              var now = new Date();
              var url = '/site/banners/get_banner.php?banner_name=ajax-banner2&ts=' + now.getTime();
              makeHttpRequest(url, 'loadBanner', true);
            </script>
          </td>
          </tr>
EOD;
    
}
?>
</table>
</div>

    <?php
include "../../../google_analytics.php";
?>   

</body>
</html>