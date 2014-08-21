<?php
//my_listings action page

 
  $action=$_REQUEST["action"];
  $id=$_REQUEST["id"];
  
  
  
  switch($action){
      case "update":
           update($id);
           break;
      break;
      case "delete":
           delete($id);
           break;
      default:
          print_page("Sorry, we were unable to process your request.");
          break;
      

  }
    
  
 
  function update($uuid){

      
      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();               
      
      $sql=array();
      $sql[]=<<<EOD
          update ignore listings a,listings b  
          set a.active=0,b.notes=a.notes,b.next_contact=a.next_contact,b.salesperson_id=a.salesperson_id  
          where a.id=b.update_to_id and b.update_confirmation_id='[uuid]' 
EOD;
      $sql[]=<<<EOD
          update listings set active=1 
          where update_confirmation_id='[uuid]';
EOD;



      $sql[]=<<<EOD
          update logos a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

      $sql[]=<<<EOD
          update premium a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;

       $sql[]=<<<EOD
          update invoice a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;
         
       $sql[]=<<<EOD
          update banners a, listings b 
          set a.listing_id=b.id 
          where b.update_confirmation_id='[uuid]'
            and a.listing_id=b.update_to_id;
EOD;



      $return=$db->set_data_multi($sql,array("uuid"=>$uuid));
          
      if($return){
          print_page("Your listing has been updated on Oildirectory.com");
      } else {
          print_page($db->lasterror."Sorry but we were unable to update your listing from Oildirectory.com, please try again.  If this problem persists, please email <a href='mailto:service@oildirectory.com'>service@oildirectory.com</a>.");          
      }



  }


  function delete($uuid){

      
      require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
      $db=new Database();

      $sql=array();
      $sql[]=<<<EOD
          update listings 
          set active=0 
          where update_confirmation_id='[uuid]';
          
EOD;
    
      $return=$db->set_data_multi($sql,array("uuid"=>$uuid));    
      
      if($return){
          print_page("Your listing has been removed from Oildirectory.com");
      } else {
          print_page("Sorry but we were unable to remove your listing from Oildirectory.com, please try again.  If this problem persists, please email <a href='mailto:service@oildirectory.com'>service@oildirectory.com</a>.");          
      }

  }
  
  
  function print_page($message){
      print <<<EOD
        <html>
        <body>
        <a href="http://www.oildirectory.com">
            <img src="http://www.oildirectory.com/images/logo_medium.jpg" border="0">
        </a>
        <br>
        <div style='border:1px solid silver; margin:15px; padding:15px;'>{$message}</div>
        Click <a href="http://www.oildirectory.com">here</a> to return to Oildirectory.com
        </body>
        </html>
      
EOD;

  }
  
  
?>