<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();
    
    $sql_count=<<<EOD
        select count(*) as rowcount from (
          select listings.id
                    from listings 
              left join listing_business_types on listings.id=listing_business_types.listing_id 
              left join businesstypes on businesstypes.id=listing_business_types.business_type_id 
              left join listing_locations on listing_locations.listing_id=listings.id 
              left join countries on countries.id=country_id 
              left join prov_state on prov_state.id=province_id 
              left join premium on premium.listing_id=listings.id
          [where] 
          group by 1
        ) a
EOD;

    $ands=array();
    $ands[]="listings.active=1";
    $keywords=array();
    foreach($_REQUEST as $name=>$value){
        
        switch($name){
            case "name_starts_with":
                $ands[]="listings.name like '{$db->escape($value)}%'";
                $keywords[]=$value;
            break;
            case "id":
                  $ands[]="listings.id = '{$db->escape($value)}'";
            break;
            case "company":
                $ands[]="listings.name like '%{$db->escape($value)}%'";
                $keywords[]=$value;
            break;
            case "keyword":
                $ands[]="listings.description like '%{$db->escape($value)}%'";
                $keywords[]=$value;
            break;
            case "category":
                $ands[]="(businesstypes.name like '%{$db->escape($value)}%' or businesstypes.name is null)";
                $keywords[]=$value;
            break;
            case "specific_category":
            case "full_category":

                $ands[]="businesstypes.name = '{$db->escape($value)}'";
                $keywords[]=$value;
            break;
            case "country":
                $ands[]="countries.name like '%{$db->escape($value)}%'";
                $keywords[]=$value;
            break;
            case "full_country":

                $ands[]="countries.name = '{$db->escape($value)}'";
                $keywords[]=$value;
            break;
            case "province":
                $ands[]="prov_state.name like '%{$db->escape($value)}%'";
                $keywords[]=$value;
            break;
            case "full_province":
                $ands[]="prov_state.name = '{$db->escape($value)}'";
                $keywords[]=$value;
            break;
            case "city":
                $ands[]="listing_locations.city like '%{$db->escape($value)}%'";
                $keywords[]=$value;
            break;
            case "full_city":
                $ands[]="listing_locations.city = '{$db->escape($value)}'";
                $keywords[]=$value;
            break;
            
        }
    }
    $where="where ".join(" and ",$ands);
    
    $sql_count=str_replace("[where]",$where,$sql_count);

    $pages=1;    
    $page_size=25;
    $page_no=1;
    $old_page_no=1;
    if($data=$db->get_data($sql_count,$_REQUEST) and count($data)==2){
        $max_rows=$data[1]["rowcount"];
        $pages=ceil($max_rows/$page_size);
    }
    if(isset($_REQUEST["old_page_no"])) $old_page_no=$_REQUEST["old_page_no"];
    if(isset($_REQUEST["new_page_no"])){
        foreach($_REQUEST["new_page_no"] as $num=>$page){
            if($page!=$old_page_no) $page_no=$page;
        }
    }
    if(isset($_REQUEST["page_no"]))$page_no=$_REQUEST["page_no"];
    if($page_no>$pages) $page_no=$pages;
    if($page_no<1) $page_no=1;
    $offset=($page_no-1)*$page_size;
    
$db->set_data("SET group_concat_max_len = 10000;",array());

    $sql=<<<EOD
      select listings.id,
             listings.name,
             listings.description,
             banners.path as banner_path,
             banners.url as banner_url,
             banners.alternate_text as banner_text,
             logos.path as logo_path,
             logos.url as logo_url,
             logos.alternate_text as logo_text,
             case when premium.id is not null and premium.expires>current_timestamp then 1 else 0 end as premium,
             group_concat(distinct businesstypes.name SEPARATOR ', ') as categories,
             group_concat(distinct businesstypes.id SEPARATOR ', ') as category_ids,
             group_concat(distinct concat('<b>',city,', ',prov_state.name,', ',countries.name,'</b><br>&nbsp;&nbsp;&nbsp;',case when length(phone)>0 then concat('Phone: ',phone) else '' end,case when length(fax)>0 then concat(', Fax: ',fax) else '' end,case when length(tollfree)>0 then concat(', TollFree: ',tollfree) else '' end,case when length(email)>0 then concat(', Email: ',email) else '' end,case when length(website)>0 then concat('<br>&nbsp;&nbsp;&nbsp;Website: <a href="',website,'">',website,'</a>') else '' end) SEPARATOR '<hr>') as premium_locations,    
             group_concat(distinct concat(countries.name,', ',prov_state.name,', ',listing_locations.city) SEPARATOR '<br>') as locations 
      from listings 
          left join listing_business_types on listings.id=listing_business_types.listing_id 
          left join businesstypes on businesstypes.id=listing_business_types.business_type_id 
          left join listing_locations on listing_locations.listing_id=listings.id 
          left join countries on countries.id=country_id 
          left join prov_state on prov_state.id=province_id 
          left join premium on premium.listing_id=listings.id
          left join banners on banners.listing_id=listings.id 
          left join logos on logos.listing_id=listings.id
      [where] 
      group by 1,2,3,4,5,6,7,8,9
      order by premium desc, listings.name 
      limit {$offset},{$page_size}
EOD;

    $sql=str_replace("[where]",$where,$sql);

$listings=$db->get_data($sql,$_REQUEST);


?>
