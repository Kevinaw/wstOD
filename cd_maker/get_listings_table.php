<script>
        function showmore(url) {
          moreinfo = window.open(url, "more", "width=750,height=500,toolbar=no");
        }
 </script>
          <div id="tab-container">
              <ul>
                  <li><a>Search Results for <?php echo $_REQUEST["specific_category"]; ?></a></li>
              </ul>
          </div>
          <div id="tab-content" style='width:100%;'>
            <table id='results-table' width="99%">

             <?php
             foreach($listings as $rownumber=>$row){
             
                 $name=highlight($row["name"],$keywords);
                 $description="";
                 $categories=highlight(join(",",$row["categories"]),$keywords);
                 $locations="";
                 $ad_type="free";
                 $more=<<<EOD
                             <a href='#' onclick="showmore('/site/search/views/more_info.php?id={$row["id"]}');">More Info</a> 
EOD;
                 $more2="";
                 
                 if($row["premium"]==1){
                   $ad_type="premium";
                   $name="<span style='font-size:12pt;'>".$name."</span>";
                   $description="<span style='margin-bottom:5px; font-size:10pt;'>".highlight(trim($row["description"]),$keywords)."<span>";
                   $locations=highlight(join(" - ",$row["locations"]),$keywords);
                   $more="";
                   $more2=<<<EOD
                             <input type='button' value='More Information' onclick="showmore('/site/search/views/more_info.php?id={$row["id"]}');">
EOD;
                 }
                 
                 if($rownumber%2) $row_type="row"; else $row_type="altrow";
                 
                 print <<<EOD
                   <tr class="{$row_type} {$ad_type} top left right">
                     <td>
                       <div id='ad-name'>{$name}</div>
                       <div id='ad-description'>{$description}</div>
                       <div id='ad-location'>{$locations}</div>
                       <div id='ad-category'>Categorie(s): {$categories}<div>
                     </td>
                     <td>
                     {$more2}
                     </td>
                   </tr>
                   <tr class="{$row_type} {$ad_type} left right">
                   <td colspan=2>
                       {$more}
                   </td>
                   </tr>
EOD;
             }



function highlight($buffer,$keywords) {
    return $buffer;
    $highlight_keywords=array();
    foreach($keywords as $num=>$value) $highlight_keywords[]="<span class='highlight'>{$value}</span>";
    return (str_ireplace($keywords, $highlight_keywords, $buffer)); 
}             
?>
            </table>
         </div>
