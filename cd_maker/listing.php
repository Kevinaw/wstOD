<HTML>
	<HEAD>
		<TITLE>Welcome to the Oil Directory - Your online resource for the oil & gas 
			industry!</TITLE>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
  <link rel="stylesheet" type="text/css" media="screen" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/ads.css" />
	</HEAD>
	<body topmargin=5 leftmargin=5 rightmargin=5 bottommargin=5>
<?php
    include 'get_listings.php';
    
    if(count($listings)){
        include 'get_listings_table.php';
    } else {
        include 'no_records.php';
    }
?>
</body>
</html>
