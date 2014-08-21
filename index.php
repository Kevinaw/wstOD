<?php
     //check if this is coming from a jumpout frame
     $start_src="site/main.php";
     if(isset($_REQUEST["jumpout"])){
         $start_src=$_REQUEST["jumpout"];
     }
?>
<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <TITLE>Oildirectory - directory of oilfield services and jobs!</TITLE>
	<META NAME="Description" CONTENT="Oildirectory - Locate services and jobs">
	<META NAME="Keywords" CONTENT="oilfield, service, jobs, employers">
	<META HTTP-EQUIV="Reply-to" CONTENT="service@oildirectory.com (Canadian Jarrett Industries, Inc.)">
	<META http-equiv="PICS-Label" content='(PICS-1.1 "http://www.icra.org/ratingsv02.html" l gen true for "http://www.oildirectory.com/" r (cz 1 lz 1 nz 1 oz 1 vz 1) "http://www.rsac.org/ratingsv01.html" l gen true for "http://www.oildirectory.com/" r (n 0 s 0 v 0 l 0))'>
	<LINK REL="SHORTCUT ICON" href="images/OilDirectoryFavIcon.ICO">  
  <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />

  <script>
      function update_tabs(tab){
          for(var i in tab.parentNode.childNodes){
              tab.parentNode.childNodes[i].id="";
          }
          tab.id="current";
      }
      function show_category(){
               document.getElementById('search_name').style.display='none';
               document.getElementById('search_keyword').style.display='none';
               document.getElementById('search_category').style.display='';
      }
      function show_name(){
               document.getElementById('search_name').style.display='';
               document.getElementById('search_keyword').style.display='';
               document.getElementById('search_category').style.display='none';
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
          var banner_name = xml.getElementsByTagName('banner_name').item(0).firstChild.nodeValue;
          document.getElementById(banner_name).innerHTML = html_content;
      
          try {
              clearTimeout(to);
          } catch (e) {}
      
          to = setTimeout("nextAd()", parseInt(reload_after));
      
      
      }
      
      function nextAd()
      {
          var now = new Date();
          var url = 'site/banners/get_banner.php?ts=' + now.getTime();
          makeHttpRequest(url, 'loadBanner', true);
      }
      
      window.onload = nextAd;
            
      
  </script>
</head>

<body>

<div id="framecontent">
<div class="innertube">

    <div id="banner-div">
        <div id="ajax-banner"></div>
<?php

     $scroll_text="";
    if(file_exists("site/scroll.txt")){
        $scroll_text=file_get_contents("site/scroll.txt");
    }

?>
          <div style='width:500px;'>
          <MARQUEE scrolldelay=130 style='font-weight:bold; font-size:10pt; color:red;'><?php echo $scroll_text; ?></MARQUEE>
          </div>
    </div>

    <div id="logo">
        <a href="http://www.oildirectory.com">
            <img src="images/logo_medium.jpg" border="0">
        </a>
    </div>
    
    <div id="search-bar">
      <form action="site/search/index.php" method="get" target="content">
      <table style='border:1px solid silver;background:#fff;'>
        <tr>
          <th colspan=3 style='background: url(images/left2_red.gif); color:white; font-weight:bold; height:21px;'>
          Quick Search
          </th>
        </tr>
        <tr>
            <td colspan=3>
                <input type='radio' name="type" checked onclick="if(this.checked) show_name();"> Business Name or  
                <input type='radio' name="type" onclick="if(this.checked) show_category();"> Category
            </td>
        </tr>
        <tr id='search_name' style='display:;'>
          <td>Name:</td>
          <td><input type='text' name="company"></td>
        </tr>
        <tr id='search_keyword' style='display:;'>
          <td>Keyword:</td>
          <td><input type='text' name="keyword"></td>
          <td><input type='submit' value='Find'></td>
        </tr>
        <tr id='search_category' style='display:none;'>
          <td>Category:</td>
          <td><input type='text' name="category"></td>
          <td><input type='submit' value='Find'></td>
        </tr>
        <tr>
          <td colspan=3 align=right>
              Browse:<a href="site/search/browse_names.php" target="content">names</a>
              <a href="site/search/browse_category.php" target="content">categories</a>
              <a href="site/search/browse_location.php" target="content">location</a>
              <a href="site/search/advanced.php" target="content">advanced search</a>
          </td>
        </tr>
      </table>
      </form>
    </div>
    
    <div id="navbar-container">
      <div id="tab-container">
        <ul id="tabs">
          <li id="current" onclick="update_tabs(this);"><a href="site/main.php" target="content">Home</a></li>
          <li onclick="update_tabs(this);"><a href="site/listings/add.php?new=true" target="content">Add Listing</a></li>
          <li onclick="update_tabs(this);"><a href="site/listings/edit.php" target="content">Edit Listing</a></li>
<!--          <li onclick="update_tabs(this);"><a href="site/blogs/" target="content">Blogs</a></li> -->
          <li onclick="update_tabs(this);"><a href="site/classifieds/" target="content">Banner Ad Rates</a></li>
          <li onclick="update_tabs(this);"><a href="site/prices/" target="content">Employment Services</a></li>
          <li onclick="update_tabs(this);"><a href="site/downloads/" target="content">Web Design Services</a></li>
<!--          <li onclick="update_tabs(this);"><a href="site/search/test_affiliate_search.php" target="content">Remote Search</a></li> -->
          <li onclick="update_tabs(this);"><a href="site/ourstaff/" target="content">Contact</a></li>
<!--          <li onclick="update_tabs(this);"><a href="site/links.php" target="content">Links</a></li> -->
        </ul>
      </div>
    </div>


</div>
</div>

<div id="maincontent">
<div class="innertube">

        <iframe id="content" name="content" frameborder="0" src="<?php echo $start_src; ?>">
        </iframe>

</div>
</div>

<div style='position:absolute; bottom:0px; z-index:3333; background-color:#fff; right:18px;'>
      <a href=# onclick="window.open('includes/suggest.php?url=' + escape(top.frames['content'].location.href),'suggest','status=0,toolbar=0,location=0,menubar=0,width=500,height=500,directories=0,scrollbars=0');">
      Send this page to a Friend
      </a>
</div>


</body>
</html>



