<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    //$db->debug=true;


$sql=<<<EOD
 select distinct listings.id,
             listings.name,
             listings.description,
             businesstypes.name as category,
             case when premium.id is not null and premium.expires>current_timestamp then 1 else 0 end as premium,
             group_concat(concat('<div class="location"><div class="address">',city,'</div><div class="phone">',phone,'</div></div>') separator '\r\n') as address,
             group_concat(concat('<div class="location"><div class="address">',address1,' ',address2,' ',city,'</div><div class="phone">',phone,'</div></div>') separator '\r\n') as premium_address
      from listings 
          join listing_business_types on listings.id=listing_business_types.listing_id 
          join businesstypes on businesstypes.id=listing_business_types.business_type_id 
          join (
               select distinct listing_id,city,phone,country_id,prov_state.name as prov_state,
               countries.name as country,address1,address2 
               from listing_locations 
               join countries on countries.id=country_id 
               join prov_state on prov_state.id=province_id
               where prov_state.name='{$_REQUEST["prov_state"]}' and countries.name='{$_REQUEST["country"]}'
          ) as listing_locations on listing_locations.listing_id=listings.id 
          left join premium on premium.listing_id=listings.id
      
      group by listings.id,listings.name,description,category,premium.id       
      order by businesstypes.name,premium desc, listings.name 
EOD;

$data=$db->get_data($sql,array());
if(!$data) print $db->lasterror;


print <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <style>
          body,html,div,ol,li  { font-family:arial; font-size:8pt; }
        
          /* separate the list from subsequent markup */
          div.wrapper
          {
              -moz-column-count:3;
              -moz-column-gap:5px;
              column-count:3;
              column-gap:5px;
          }
          
          div.category { padding:3px; margin-top:5px; font-size:10pt; font-weight:bold; clear:both; border-top:1px solid black; background-color:#ccddee; width:100%; }
          div.location { positon:relative; z-index:2; float:left; background-color:white; overflow:hidden; width:100%; background-image:url('dot.jpg'); backround-repeat: repeat-x; }
          div.address { float:left; background-color:white; }
          div.phone { float:right; position:relative; z-index:3; background-color:white; }
          
    </style>
  </head>
  <body>
  <div style="page-break:always; text-align:center; margin:0 auto;">
      <img src="../../../images/logo_medium.jpg">
      <div style="font-size:12pt; font-weight:bold;">{$_REQUEST["country"]} {$_REQUEST["prov_state"]}</div>
  </div>
  <div class="wrapper">

EOD;

$current_category="";

foreach($data as $rownumber=>$row){
    if($rownumber==0) continue;
    
    if($row["category"]!=$current_category){
    
        if($current_category!=""){
        }
        print <<<EOD
            <div class="category">{$row["category"]}</div>
EOD;
        $current_category=$row["category"];

    }
    
    
    if($row["premium"]=="1"){
        print <<<EOD
            <fieldset>
            <legend style="font-weight:bold; color:red;">{$row["name"]}</legend>
            <div style="text-align:center; clear:both; margin-bottom:5px;">{$row["description"]}</div>
            <div style="clear:both; padding-left:10px;">{$row["premium_address"]}</div>
            </fieldset>
EOD;
    } else {
        print <<<EOD
            <div style="width:100%;">
              <div style="clear:both; font-weight:bold;">{$row["name"]}</div>
              <div style="clear:both; padding-left:10px;">{$row["address"]}</div>
            </div>
EOD;

    }
}

print <<<EOD

            </div>
    </body>
</html>
EOD;



?>
 