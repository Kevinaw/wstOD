<?php
    $count=count($listings);
    print "<h2>{$_REQUEST["category"]} - {$count} listings</h2>";
?>
            <table id='results-table' width="100%">
            <?php
             foreach($listings as $rownumber=>$row){
             
                 $name=$row["name"];
                 $description="";
                 $categories=join(",",$row["categories"]);
                 $locations="";
                 $links="";
                 $ad_type="free";
                 $logo="";
                 $banner="";
                 
                 if($row["premium"]==1){
                   $ad_type="premium";
                   $description=trim($row["description"])."<br><br>";
                   $locations="<fieldset><legend>Locations</legend>".join("<br>",$row["locations"])."</fieldset>";
                   
                   if($row["logo"]==1){
                     $logo="<a href=\"{$row["logo_url"]}\" target=_blank><img src=\"../site/customer_images/Logos/{$row["logo_path"]}\" alt=\"{$row["logo_text"]}\" border=0></a>";
                   }

                   if($row["banner"]==1){
                       $banner="<a href=\"{$row["banner_url"]}\" target=_blank><img src=\"../site/customer_images/banners/{$row["banner_path"]}\" alt=\"{$row["banner_text"]}\" border=0></a>";
                   }

                 } else {
                     $locations=array_shift($row["locations"]);
                 }
                 
                 if($rownumber%2) $row_type="row"; else $row_type="altrow";
                 
                 print <<<EOD
                   <tr class="{$row_type} {$ad_type} top left right">
                     <td>
                       <div id='ad-name'>{$name}</div>
                       <div id='ad-description'>{$description}</div>
                       <div id='ad-location'>{$locations}</div>
                       <div id='ad-links'>{$links}</div>
                     </td>
                     <td>{$logo}</td>
                   </tr>
                   <tr class="{$row_type} {$ad_type} left right bottom">
                     <td align=center>
                     {$banner}
                     </td>
                     <td></td>
                   </tr>
EOD;
             }
             
            ?>
            </table>

