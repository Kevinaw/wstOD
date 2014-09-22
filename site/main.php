<?php
#session_start();

?>

<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style='height:100%;'>
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
  
  <script>
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

      function show_category(){
/*
               document.getElementById('search_name').style.display='none';
               document.getElementById('search_keyword').style.display='none';
               document.getElementById('search_category').style.display='';
               document.getElementById('search_category2').style.display='';
*/
               
               document.getElementById('category').style.display='';
               document.getElementById('business_name').style.display='none';
      }
      function show_name(){
               /*
               document.getElementById('search_name').style.display='';
               document.getElementById('search_keyword').style.display='';
               document.getElementById('search_category').style.display='none';
               document.getElementById('search_category2').style.display='none';
*/

               document.getElementById('business_name').style.display='';
               document.getElementById('category').style.display='none';
      }
      
  </script>  
</head>

<body style='height:100%;'>
    
      <table style='width:100%;'  >
      <tr>
      <td width=250px valign=top>
      
<?php      
    $limit=3;
    include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
?>

      </td><td valign=top>
      
<?php 
  print <<<EOD
      <div id="error" style="color:red; margin:0 auto; text-align:center; padding:5px;">{$_SESSION["error"]}</div>      
EOD;

    $_SESSION["error"]="";

?>      
          
          <table style='height:100%; width:90%;'>
<tr><td>
          <div style='text-align:center; margin:auto auto;'>

      <form action="/site/search/index.php" method="get" target="content">
      <table style='border:1px solid silver;background:#fff; margin:0 auto; width:300px; height:175px;'>
        <tr>
          <th style='background: url(/images/left2_red.gif); color:white; font-weight:bold; height:21px;'>
          Search Oildirectory
          </th>
          <th style='background: url(/images/left2_red.gif); color:white; font-weight:bold; height:21px;'>
          Browse
          </th>
        </tr>
        <tr valign=top>
          <td>
                <input type='radio' name="type" checked onclick="if(this.checked) show_name();"> Business Name or  
                <input type='radio' name="type" onclick="if(this.checked) show_category();"> Category
               
              <table id='business_name' style='display:;'>
                <tr id='search_name'>
                  <td>Name:</td>
                  <td><input type='text' name="company"></td>
                </tr>
                <tr id='search_keyword'>
                  <td>Keyword:</td>
                  <td>
                  <input type='text' name="keyword">
                   </td>
                  <td><input type='submit' value='Find'></td>
                </tr>
              </table>
              
              <table id='category' style='display:none;'>
                <tr id='search_category' >
                  <td>Category:</td>
                  <td>
                  <input type='text' name="category">
                  </td>
                  <td><input type='submit' value='Find'></td>
                </tr>
              </table>

              <a href="/site/search/advanced.php" target="content">advanced search</a>
          
          </td>
          <td style='font-weight:bold; background:#eeeeee; padding:10px;' nowrap>
              Browse By:<br>
                <a href="/site/search/browse_names.php" target="content">names</a>
                <br>
                <a href="/site/search/browse_category.php" target="content">categories</a>
                <br>
                <a href="/site/search/browse_location.php" target="content">locations</a><br>
                
          </td>
        </table>
      </form>



<!---
<img src='../chat/chat_button.jpg' style='text-decoration:underline; color:blue; cursor:pointer;' 
onclick="window.open('../chat/chat.html','chat_win','location=0,toolbar=0,status=0,history=0,width=350,height=350')"><br>
<?php //echo file_get_contents("chat.txt"); ?>
-->

      </div>

</td></tr>
<tr><td>

            <div style='text-align:center; width:100%; margin:0 auto; margin-bottom:0; '>
              <div id="banner-div2">
                  <div id="ajax-banner2"></div>
              </div>
            </div>
            <script>
              var now = new Date();
              var url = '/site/banners/get_banner.php?banner_name=ajax-banner2&ts=' + now.getTime();
              makeHttpRequest(url, 'loadBanner', true);
            </script>
            
</td></tr>
</table>
        
        </td><td width=250px valign=top>
            <a href="/site/new_links.php" target="_blank">links</a>

<?php
////get the links
//  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
//  $db=new Database();
//
//  $types=array();
//  if($data=$db->get_data("select * from links order by type",array())){
//      foreach($data as $rownumber=>$row){
//          if($rownumber==0) continue;
//          
//          if(!isset($types[$row["type"]])) $types[$row["type"]]=array();
//          $types[$row["type"]][]=$row;
//      }
//  }
//
//
//
//  foreach($types as $type=>$rows){
//      $content=array();
//      foreach($rows as $rownumber=>$row){
//          $content[]=<<<EOD
//              <div style='clear:both; width:100%;'>
//                  <a href="{$row["url"]}" target=_blank>{$row["name"]}</a>
//              </div>
//              <div style='clear:both;width:100%;'>
//                  {$row["description"]}
//              </div>
//EOD;
//      }
//      $content=join("",$content);
//      
///*
//
//      print <<<EOD
//          <div style="width:95%; overflow:hidden; clear:both; margin:5px;">
//            <div id="tab-container">
//                <ul>
//                    <li>
//                      <a style='font-size:8pt;'>{$type}</a>
//                    </li>
//                </ul>
//            </div>
//            <div id="tab-content" style='position:relative; top:-2px; clear:both; height:175px; overflow:auto;'>
//              {$content}
//            </div>
//          </div>
//EOD;
//      
//*/
//    print <<<EOD
//
//        <div style="width:100%;">
//        {$content}
//        </div>
//EOD;
//     
//
//
//  }
?>
      </td></tr></table>
      

   
<?php
include "../google_analytics.php";
?>    


 


</body>
</html>
