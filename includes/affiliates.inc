<?php
//get the links
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  
  if(!isset($limit)) $limit=5;

  //first get the affiliates that are connected to the business types
  $connected_affiliates=array();
  $ids=array();
  if(isset($category_ids) and count($category_ids)){
      $category_ids=join(",",$category_ids);
      $sql=<<<EOD
          select distinct affiliates.id,html from affiliates 
          join affiliate_business_types on affiliates.id=affiliate_id and 
              business_type_id in ({$category_ids}) 
              order by rand() limit {$limit}
EOD;
      $connected_affiliates=$db->get_data($sql,array());
      @array_shift($connected_affiliates);
      if($connected_affiliates){
          foreach($connected_affiliates as $rownumber=>$row) $ids[]=$row["id"];
      }
  }
  
  $limit=$limit-count($connected_affiliates);
  
  
  //get random items if we don't have enough
  $random_items=array();
  if($limit>0){
    $where="";
    //make sure we don't duplicate
    if(count($ids)){
        $where="where id not in (".join(",",$ids).")";
    }
    
    $sql=<<<EOD
      SELECT distinct html FROM `affiliates` 
      {$where} 
      order by rand()  
      limit {$limit};
EOD;

    $random_items=$db->get_data($sql,array());
    @array_shift($random_items);
  }
  $data=@array_merge($connected_affiliates,$random_items);
  
  if($data){
      foreach($data as $rownumber=>$row){
          
          $row["html"]=stripslashes($row["html"]);
          print <<<EOD
              <div style='clear:both; padding:5px; margin-bottom:5px; border:1px dotted #efefef; text-align:center;'>
              <div style='margin:0 auto;'>
                  {$row["html"]}
              </div>
              </div>
EOD;
      }                                                                                                   
  }
  
  
?>