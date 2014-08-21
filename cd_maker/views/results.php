    <script>
        function show_categories(i){
            i.style.display='none';
            i.nextSibling.style.display='inline';
            var l=document.getElementById('categories_list');
            for(var j in l.childNodes){
                if(l.childNodes[j].id=='hide_category') l.childNodes[j].style.display='block';
            }
        }
        function hide_categories(i){
            i.style.display='none';
            i.previousSibling.style.display='inline';
            var l=document.getElementById('categories_list');
            for(var j in l.childNodes){
                if(l.childNodes[j].id=='hide_category') l.childNodes[j].style.display='none';
            }
        }
    
    </script>
    
    <div id="container">
    <table style="width:100%">
    <tr valign=top>
    <td style="width:200px;">
          <form action="/site/search/index.php" method="post">
          <div id="tab-container">
              <ul>
                  <li class='pointer' onclick="document.getElementById('submit_search').click();">
                    <a>Refine Search</a>
                    <input type='submit' id='submit_search' value='Refine Search' style='display:none;'>
                  </li>
              </ul>
          </div>
          <div id="tab-content">
            <span id="refine-box">
              <?php
                  $search_string=array();
                  if(isset($_REQUEST["company"]) and strlen($_REQUEST["company"])){
                    print "<input type='hidden' name='company' value=\"{$_REQUEST["company"]}\">";
                    $search_string[]="Company Name = ".$_REQUEST["company"];
                  }
                  if(isset($_REQUEST["keyword"]) and strlen($_REQUEST["keyword"])){
                    print "<input type='hidden' name='keyword' value=\"{$_REQUEST["keyword"]}\">";
                    $search_string[]="Keywords = ".$_REQUEST["keyword"];
                  }
                  $search_string[]="Count=".count($listings);
              ?>
              <b>by Category</b>
                <ul id='categories_list'>
                  <?php
                   $category_limit=10;
                   $category_count=0;
                   $item_id="";
                   $display="block";
                   foreach($categories as $category=>$count){
                       $category_count++;
                       
                       if(isset($_REQUEST["category"][$category])) $checked="checked"; else $checked="";
                       print "<li id=\"{$item_id}\" style=\"display:{$display};\" title=\"{$category} ({$count})\">";
                       print "<input type='checkbox' style='border:none;' name=\"category[{$category}]\" {$checked}>{$category} ({$count})";
                       
                       if($category_count==$category_limit){
                           $item_id="hide_category";
                           $display="none";
                           print <<<EOD
                                   <a style='float:right;display:inline;' href="#" onclick="show_categories(this);">
                                   more...
                                   </a><a style='float:right;display:none;' href="#" onclick="hide_categories(this);">
                                   less...
                                   </a>
EOD;
                       }
                       
                       
                       print "</li>";
                   }
                  ?>
    
               </ul>
               <b>by Location</b>
               <ul>
                <?php
                   $skip_small=count($locations)>5;
                   foreach($locations as $country=>$provinces){
                       if(($country=="zzzz" or $provinces["count"]<2) and $skip_small) continue; //skip small counts
                       
                       if(isset($_REQUEST["country"][$country])) $checked="checked"; else $checked="";
                       print "<li title=\"{$country} ({$provinces["count"]})\">";
                       print "<input type='checkbox' style='border:none;' name=\"country[{$country}]\" {$checked}>{$country} ({$provinces["count"]})";
                       print "</li>";
                       print "<ul>";
                       foreach($provinces["provinces"] as $province=>$cities){
                           if($cities["count"]<2 or $province=="zzzz") continue; //skip small counts
                           
                           if(isset($_REQUEST["province"][$province])) $checked="checked"; else $checked="";
                           print "<li title=\"{$province} ({$cities["count"]})\">";
                           print "<input type='checkbox' style='border:none;' name=\"province[{$province}]\" {$checked}>{$province} ({$cities["count"]})";
                           print "</li>";
                           print "<ul>";
                           foreach($cities["cities"] as $city=>$count){
                               if($count<5) continue; //skip small counts
                               
                               if(isset($_REQUEST["city"][$city])) $checked="checked"; else $checked="";
                               print "<li title=\"{$city} ({$count})\">";
                               print "<input type='checkbox' style='border:none;' name=\"city[{$city}]\" {$checked}>{$city} ({$count})";
                               print "</li>";
                           }
                           print "</ul>";
                       }
                       print "</ul>";
                   }
                ?>
              </ul>
            </span>
          </div>
          </form>
      </td>
      <td>
      
          <div id="tab-container">
              <ul>
                  <li><a>Search Results for <?php echo join(", ",$search_string); ?></a></li>
              </ul>
          </div>
          <div id="tab-content">
            <table id='results-table' width="100%">
            <?php
             foreach($listings as $rownumber=>$row){
             
                 $name=highlight($row["name"],$keywords);
                 $description="";
                 $categories=highlight(join(",",$row["categories"]),$keywords);
                 $locations="";
                 $links="";
                 $ad_type="free";
                 $logo="";
                 $banner="";
                 
                 if($row["premium"]==1){
                   $ad_type="premium";
                   $description=highlight(trim($row["description"]),$keywords);
                   $locations=highlight(join(" - ",$row["locations"]),$keywords);
                   
                   if($row["logo"]==1){
                     $logo="<a href=\"{$row["logo_url"]}\" target=_blank><img src=\"../customer_images/Logos/{$row["logo_path"]}\" alt=\"{$row["logo_text"]}\" border=0></a>";
                   }

                   if($row["banner"]==1){
                       $banner="<a href=\"{$row["banner_url"]}\" target=_blank><img src=\"../customer_images/banners/{$row["banner_path"]}\" alt=\"{$row["banner_text"]}\" border=0></a>";
                   }

                 }
                 
                 if($rownumber%2) $row_type="row"; else $row_type="altrow";
                 
                 print <<<EOD
                   <tr class="{$row_type} {$ad_type} top left right">
                     <td>
                       <div id='ad-name'>{$name}</div>
                       <div id='ad-description'>{$description}</div>
                       <div id='ad-location'>{$locations}</div>
                       <div id='ad-category'>Categorie(s): {$categories}<div>
                       <div id='ad-links'>{$links}</div>
                     </td>
                     <td>{$logo}</td>
                   </tr>
                   <tr class="{$row_type} {$ad_type} left right">
                   <td colspan=2>
                       <a href="views/more_info.php?id={$row["id"]}" target="_blank">More Info</a> | 
                   </td>
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
         </div>
      </td>
      <td style="width:100px;">
      Affiliates will go here.
      </td>
      </tr>
      </table>
    </div>


<?php

function highlight($buffer,$keywords) {
    $highlight_keywords=array();
    foreach($keywords as $num=>$value) $highlight_keywords[]="<span class='highlight'>{$value}</span>";
    return (str_ireplace($keywords, $highlight_keywords, $buffer)); 
} 

?>