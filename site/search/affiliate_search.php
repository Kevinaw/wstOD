<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
</head>

<body>
      <form action="/site/search/index.php" method="get"  style='position:absolute; top:3; left:3;'>
      <input type='hidden' name='affiliate' value='true'>
      <table style='background:#fff;'>
        <tr>
          <th rowspan=3>
          <a href="/index.php" target=_blank>
          <img src="/images/logo_small.jpg" border=0><br>
          <span style='font-size:smaller;'>Goto Oildirectory</span>
          </a>
          </th>
          <td>Name:</td>
          <td><input type='text' name="company"></td>
        </tr>
        <tr id='search_keyword' style='display:;'>
          <td>Keyword:</td>
          <td><input type='text' name="keyword"></td>
        </tr>
        <tr id='search_category' style='display:;'>
          <td>Category:</td>
          <td><input type='text' name="category"></td>
          <td><input type='submit' value='Find'></td>
        </tr>
      </table>
      </form>
<?php
include "../../google_analytics.php";
?>    

</body>
</html>



