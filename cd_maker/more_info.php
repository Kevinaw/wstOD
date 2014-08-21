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
          document.getElementById('description').style.display='none';
          document.getElementById('location').style.display='none';
          document.getElementById('category').style.display='none';
          
          document.getElementById(id).style.display='block';
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
  </script>
</head>

<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();

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
        select businesstypes.*   
        from businesstypes 
        join listing_business_types on business_type_id=businesstypes.id and listing_id=[id]
EOD;
    $sqls["premium"]="select *,case when expires<current_timestamp then 1 else 0 end as expired from premium where listing_id=[id] order by expires desc limit 1";
    $category_ids=array();
    
    foreach($sqls as $name=>$sql){
        $sqls[$name]=$db->get_data($sql,$_REQUEST);
    }
    
    //premium
    $premium=false;
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
    }


print <<<EOD
  <body onload="startup();" style='width:100%; height:100%; overflow:hidden;'>
  <table width=100%>
  <tr>
  <td>
    <img src="/images/logo_small.jpg" align=left><br><b>More Information</b><br clear=all>
    <ul id="globalnav">
    <li><a href=# id="startlink" onclick="show('description');">Company Description</a></li>
    <li><a href=# onclick="show('location');">Locations/Contact</a></li>
    <li><a href=# onclick="show('category');">Categories</a></li>
    </ul>
    <div style='width:100%; border:1px solid silver; padding:10px;'>
EOD;

    
    //listing    
    print "<div id='description' style='display:block; overflow:auto; height:408px;'>";
    if($sqls["listing"]!==false){
        print <<<EOD
            {$logo}
            <h3>{$sqls["listing"][1]["name"]}</h3><br>
            {$sqls["listing"][1]["description"]}
EOD;
    } else print "Unavailable";
    print "</div>";
    
    print "<div id='location' style='display:none; overflow:auto; height:408px;'>";
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
    print "<div id='category' style='display:none;  height:408px; overflow:auto; '>";
    if($sqls["business_types"]!==false){
        $categories=array();
        foreach($sqls["business_types"] as $rownumber=>$row){
            if($rownumber==0) continue;
            $categories[]=<<<EOD
                <a href='#' onclick="search_category('/site/search/index.php?specific_category={$row["name"]}');">
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
<?php
if(!$premium){
    $limit=3;
    print <<<EOD
          <td valign=top width=170>
EOD;

    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";

    print <<<EOD
          </td>
EOD;
    
}
?>
</tr>
</table>
