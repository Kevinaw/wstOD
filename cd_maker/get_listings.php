<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();

    $sql=<<<EOD
      select listings.id,
             listings.name,
             listings.description,
             case when premium.id is not null and premium.expires>current_timestamp then 1 else 0 end as premium,
             group_concat(distinct businesstypes.name SEPARATOR '||') as categories,
             group_concat(distinct businesstypes.id SEPARATOR '||') as category_ids,
             group_concat(distinct concat(countries.name,"|",prov_state.name,"|",listing_locations.city,"|",listing_locations.phone,"|",listing_locations.tollfree) SEPARATOR '<row>') as locations 
      from listings 
          left join listing_business_types on listings.id=listing_business_types.listing_id 
          left join businesstypes on businesstypes.id=listing_business_types.business_type_id 
          left join listing_locations on listing_locations.listing_id=listings.id 
          left join countries on countries.id=country_id 
          left join prov_state on prov_state.id=province_id 
          left join premium on premium.listing_id=listings.id
      [where] 
      group by 1,2,3
      order by premium desc, listings.name 
      limit 1000;
EOD;

    $ands=array();
    $keywords=array();
    $search_string=array();
    
    foreach($_REQUEST as $name=>$value){
        
        //split words into array if it isn't an array already
        if($name!="specific_category" and $name!="id"){
          if(is_array($value)){
            $values=array_keys($value);
          } else {
              $value=trim($value);
              if(!strlen($value)) continue;
              $values=split(" ",$value);
          }
          foreach($values as $valnum=>$value) $values[$valnum]=$db->escape($value);
        }
        
        switch($name){
            case "specific_category":
                  $ors[]="businesstypes.name = '{$db->escape($value)}'";
                  $keywords[]=$value;
                  $search_string[]="Category=".$value;
                  $ands[]="(".join(" or ",$ors).")";
            break;
            case "id":
                  $ors[]="listings.id = '{$db->escape($value)}'";
                  $keywords[]=$value;
                  $search_string[]="Specific Listing";
                  $ands[]="(".join(" or ",$ors).")";
            break;
            case "company":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="listings.name like '%{$db->escape($value)}%'";
                  $keywords[]=$value;
                }
                $search_string[]="Company like ".join(" ",$keywords);
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "keyword":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="listings.description like '%{$db->escape($value)}%'";
                  $keywords[]=$value;
                }
                $search_string[]="Keyword like ".join(" ",$keywords);
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "category":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="businesstypes.name like '%{$db->escape($value)}%'";
                  $keywords[]=$value;
                }
                $search_string[]="Category like ".join(" ",$keywords);
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "full_category":
                $value=join(" ",$values);
                $ands[]="businesstypes.name = '{$db->escape($value)}'";
            break;
            case "country":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="countries.name = '{$db->escape($value)}'";
                  $keywords[]=$value;
                }
                $search_string[]="Country = ".join(" ",$keywords);
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "full_country":
                $value=join(" ",$values);
                $ands[]="countries.name = '{$db->escape($value)}'";
            break;
            case "province":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="prov_state.name = '{$db->escape($value)}'";
                  $keywords[]=$value;
                }
                $search_string[]="Prov/State = ".join(" ",$keywords);
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "full_province":
                $value=join(" ",$values);
                $ands[]="prov_state.name = '{$db->escape($value)}'";
            break;
            case "city":
                $ors=array();
                foreach($values as $valnum=>$value){
                  $ors[]="listing_locations.city like '%{$db->escape($value)}%'";
                  $keywords[]=$value;
                }
                $search_string[]="City like ".join(" ",$keywords);
                $ands[]="(".join(" or ",$ors).")";
            break;
            case "full_city":
                $value=join(" ",$values);
                $ands[]="listing_locations.city = '{$db->escape($value)}'";
            break;
            
        }
    }
    $where="where ".join(" and ",$ands);
    
    $sql=str_replace("[where]",$where,$sql);
//$db->debug=true;

    $locations=array();
    $categories=array();
    $category_ids=array();
    $listings=array();
    if($data=$db->get_data($sql,$_REQUEST)){
        foreach($data as $rownumber=>$row){
            if($rownumber==0) continue;

            //cleanup the listing
            $listings[$rownumber]=$row;
            
            //get categories
            $listings[$rownumber]["categories"]=explode("||",$row["categories"]);
            foreach($listings[$rownumber]["categories"] as $num=>$value){
                if(!isset($categories[$value])) $categories[$value]=0;
                $categories[$value]++;
            }
            sort($listings[$rownumber]["categories"]);
            
            //get the ids
            foreach(explode("||",$row["category_ids"]) as $num=>$value){
                if(!strlen(trim($value))) continue;
                if(!in_array($value,$category_ids)) $category_ids[]=$value;
            }
            
            //get locations
            $new_location=array();
            if(strlen(trim($row["locations"]))){
              $location_list=explode("<row>",$row["locations"]);
              foreach($location_list as $num=>$value){
                  $location=explode("|",$value);
                  $country=$location[0];
                  $prov=$location[1];
                  $city=$location[2];
                  $phone=$location[3];
                  $tollfree=$location[4];
                  
                  
                  //remove blanks
                  if(!strlen(trim($tollfree))) unset($location[4]); else $location[4]="Toll Free: ".$tollfree;
                  if(!strlen(trim($phone))) unset($location[3]); else $location[3]="Phone: ".$phone;  
                  
                  if(!isset($locations[$country])) $locations[$country]=array("count"=>0,"provinces"=>array());
                  if(!isset($locations[$country]["provinces"][$prov])) $locations[$country]["provinces"][$prov]=array("count"=>0,"cities"=>array());
                  if(!isset($locations[$country]["provinces"][$prov]["cities"][$city])) $locations[$country]["provinces"][$prov]["cities"][$city]=0;
                  $locations[$country]["count"]++;
                  $locations[$country]["provinces"][$prov]["count"]++;
                  $locations[$country]["provinces"][$prov]["cities"][$city]++;
                  
                  $text_location=join(", ",$location);
                  if(!in_array($text_location,$new_location)) $new_location[]=$text_location;
              }
              sort($new_location);
            }
            $listings[$rownumber]["locations"]=$new_location;
            
        }

        foreach($locations as $country=>$provinces){
            foreach($provinces["provinces"] as $prov=>$cities){
                uasort($locations[$country]["provinces"][$prov]["cities"],'cmp');
            }
            uasort($locations[$country]["provinces"],'cmp');
        }
        uasort($locations,'cmp');
        uasort($categories,'cmp');
        
        
    }
    
    
function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}
    
?>
