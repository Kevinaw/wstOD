<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();

?>
<HTML>
<HEAD>
<LINK REL="stylesheet" HREF="grid.css" type="text/css">
</HEAD>
<BODY BGCOLOR="White">
<h3>Table of Contents</h3></a>
<table class='toc' ID="Table2">
<?php
	$sql="select distinct name from businesstypes order by name;";
	$data=$db->get_data($sql,array());
	
  $letterindex="";
	foreach($data as $rownumber=>$row){
      if($rownumber==0) continue;	
	    if(substr($row["name"],0,1)!=$letterindex){
	        $letterindex=substr($row["name"],0,1);
	        print "<tr><td><h4>{$letterindex}</h4></td></tr>";
      }
      $urlname=urlencode($row["name"]);
      print "<tr><td><a href=\"listing.php?specific_category={$urlname}\" target='contents'>{$row["name"]}</a></td></tr>";
   }
?>
</table>
</body>
</html>	