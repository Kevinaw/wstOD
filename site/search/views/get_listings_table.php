<?php

foreach($_REQUEST as $name=>$value){
    if($name=="page_no" or $name=="new_page_no") continue;
    print <<<EOD
        <input type='hidden' name="{$name}" value="{$value}">
EOD;
}
print "<input type='hidden' name='old_page_no' value='{$page_no}'>";

function draw(){
    global $listings,$_REQUEST,$pages,$page_no,$keywords,$test_premium,$test;
    print <<<EOD
      <script>
              function showmore(url) {
                moreinfo = window.open(url, "more", "width=750,height=500,toolbar=no");
              }
       </script>
                  <table id='results-table' width="100%">
EOD;

             if($pages<=10){
                 $start=1; 
                 $end=$pages;
             } else {
                 if($page_no+5>$pages){
                     $end=$pages;
                     $start=$end-10;
                 } else {
                     if($page_no-5<1){
                         $start=1;
                         $end=10;
                     } else {
                       $end=$page_no+5;
                       $start=$page_no-5;
                     }
                 }
             }

             $pager="";
             if(isset($_REQUEST["affiliate"])) $title="Oildirectory.com <a href='affiliate_search.php'>Search</a> Results"; else $title="Search Results";
             if(!isset($test)){
                 $pager.=<<<EOD
                     <tr><td colspan=2 style='background:#ededed;'>
                         <div style='float:left;'><b>{$title}</b></div>
                         <div style='float:right;'>
                         Page <input type='text' size=3 name='new_page_no[]' value="{$page_no}" onchange="document.forms[0].submit();"> of {$pages}: 
EOD;
                 for($x=$start;$x<=$end;$x++){
                     if($x==$page_no) $color=red; else $color=blue;
                     $pager.="<input type='submit' name='page_no' value='{$x}' style='color:{$color}; background:none; border:none; text-decoration:underline;'> ";
                 }
                 $pager.="</div></td></tr>";
             }
             print $pager;

			
             foreach($listings as $rownumber=>$row){
                 
				 if($rownumber==0) continue;
					
                 $name=highlight($row["name"],$keywords);
                 $banner="";
                 $logo="";
                 $description="";
                 $categories=highlight($row["categories"],$keywords);
                 $locations=highlight($row["locations"],$keywords);
                 $ad_type="free";
				 $phone = substr($row["premium_locations"], strpos($row["premium_locations"],"Phone:")); // added by Lee
				  
                 $more=<<<EOD
                                <a href='../listings/add.php?action=Edit Listing&id={$row["id"]}'>Upgrade</a>
EOD;
                 $more2=<<<EOD
                             <input type='button' value='More Information' onclick="showmore('/site/search/views/more_info.php?id={$row["id"]}');">
EOD;

                 if($row["premium"]==1 or isset($test_premium)){
                   $ad_type="premium";
                   $name="<span style='font-size:12pt;'>".$name."</span>";
                   $description="<div style='padding:10px; font-size:10pt; '>".highlight(trim($row["description"]),$keywords)."</div>";
                   
                   $locations=highlight($row["premium_locations"],$keywords);
                   
                   $more=<<<EOD
                             <a href='../listings/add.php?action=Edit Listing&id={$row["id"]}' style='font-size:smaller;'>Edit</a>
EOD;

                   if(isset($test_premium)) $show_premium="&show_premium=true"; else $show_premium="";
                   $more2=<<<EOD
                             <input type='button' value='More Information' onclick="showmore('/site/search/views/more_info.php?id={$row["id"]}{$show_premium}');">
EOD;

                   //get the banner
                   if(strlen($row["banner_path"])){
                       if(strlen($row["banner_url"])){
                           $banner=<<<EOD
                               <div style='align:center;'>
                               <a style='margin:0 auto;' href="{$row["banner_url"]}" target="_blank">
                               <img src="../customer_images/banners/{$row["banner_path"]}" 
                               alt="{$row["banner_text"]}">
                               </a>
                               </div>
EOD;
                       } else {
                           $banner=<<<EOD
                               <div style='align:center;'>
                               <img style='margin:0 auto;' src="../customer_images/banners/{$row["banner_path"]}" 
                               alt="{$row["banner_text"]}">
                               </div>
EOD;
                       }
                   } else {
                       if(isset($test_premium)){
                           $banner=<<<EOD
                               <div style='align:center;'>
                               <img style='margin:0 auto;' src="../customer_images/banners/yourbanner.gif" 
                               alt="Your Banner Here">
                               </div>
EOD;
                       }
                   } 

                   //get the logo
                   if(strlen($row["logo_path"])){
                       if(strlen($row["logo_url"])){
                           $logo=<<<EOD
                               <div style='float:left; padding-right:10px; height:100%;'>
                               <a href="{$row["logo_url"]}" target="_blank">
                               <img src="../customer_images/Logos/{$row["logo_path"]}" 
                               alt="{$row["logo_text"]}">
                               </a>
                               </div>
EOD;
                       } else {
                           $logo=<<<EOD
                               <div style='float:left; padding-right:10px; height:100%;'>
                               <img src="../customer_images/Logos/{$row["logo_path"]}" 
                               alt="{$row["logo_text"]}">
                               </div>
EOD;
                       }
                   } else {
                       if(isset($test_premium)){
                           $logo=<<<EOD
                               <div style='float:left; padding-right:10px; height:100%;'>
                               <img src="../customer_images/Logos/yourlogo.jpg" 
                               alt="Your Logo Here">
                               </div>
EOD;
                       }
                   } 
                 }
                 
                 if($rownumber%2) $row_type="row"; else $row_type="altrow";
                 
                 if(isset($_REQUEST["affiliate"])) $more="";
                 
                 print <<<EOD
                   <tr class="{$row_type} {$ad_type} top left right">
                     <td>
                       <div id='ad-name'>
                       {$logo}{$name}
                       </div>
                       <div id='ad-description'>
                       {$description}
                       </div>
                       <div id='ad-location' style='max-height:100px; overflow:auto;'>
                       {$locations}
                       </div>
                       <div id='ad-category' style='clear:both;'>
                       {$banner}
                       {$phone}<br>
					   Categorie(s): {$categories}
					   
                       <div>
                     </td>
                     <td>
                     {$more2}
                     </td>
                   </tr>
                   <tr class="{$row_type} {$ad_type} left right">
                   <td colspan=2 style="padding-bottom:30px;">
                       {$more}
                   </td>
                   </tr>
EOD;
             }
    print $pager;
    print "</table>";

}   

draw();          

function highlight($buffer,$keywords) {
    $highlight_keywords=array();
    foreach($keywords as $num=>$value) $highlight_keywords[]="<span class='highlight'>{$value}</span>";
    //return (str_ireplace($keywords, $highlight_keywords, $buffer)); 
    
    $output=$buffer;
    foreach($keywords as $num=>$value){
        $output = preg_replace(
            "/(>|^)([^<]+)(?=<|$)/esx",
            "'\\1' . str_replace('" . $value . "', '<span class=\'highlight\'>" . $value . "</span>', '\\2')",
            $output
        );
    }
    return $output;
} 
?>