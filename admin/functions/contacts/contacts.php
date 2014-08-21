<?php
session_start();
  print "<div style='float:right;'><a href='../contacts.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    //$db->debug=true;

    if(isset($_POST["make_premium"])) make_premium();
    if(isset($_POST["save_expires"])) save_expires();
    if(isset($_POST["cancel_premium"])) cancel_premium();
    
    if(isset($_POST["update_logo"])) update_logo();
    if(isset($_POST["remove_logo"])) remove_logo();

    if(isset($_POST["update_banner"])) update_banner();
    if(isset($_POST["remove_banner"])) remove_banner();

    if(isset($_POST["save"])) save();
    if(isset($_POST["add_date"])) add_date();


$name=ucwords(str_replace(array(".php","_","/admin/functions/contacts/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}
$salespeople=false;



?>
  <style>
  body,html,table,tr,td,th,input,textarea { font-family:arial; font-size:9pt; }
  th { font-weight:bold; }
  </style>
  <form action=# method="post" enctype="multipart/form-data">
<?php

print <<<EOD
  <fieldset>
  <legend>Edit Contact</legend>
  <style>
  table { border-collapse:collapse; width:100%; }
  </style>
EOD;

    $sql=<<<EOD
        select a.*,b.id as salesperson_id,c.expires,case when c.expires is null then 0 else 1 end as is_premium,
               d.path as logo_path,d.url as logo_url,d.alternate_text as logo_alternate_text,case when d.path is null then 0 else 1 end as has_logo,
               e.path as banner_path,e.url as banner_url,e.alternate_text as banner_alternate_text,case when e.path is null then 0 else 1 end as has_banner,
               group_concat(concat(coalesce(f.contact_name,'no contact name'), ' (phone: ', coalesce(f.phone,'n/a'), ') (cell: ', coalesce(f.cell,'n/a'), ') (tollfree: ',coalesce(f.tollfree,'n/a'),')') separator '<br>') as phones   
        from listings a 
        join listing_locations f on a.id=f.listing_id 
        left join salesperson b on b.id=a.salesperson_id 
        left join premium c on a.id=c.listing_id 
        left join logos d on a.id=d.listing_id 
        left join banners e on a.id=e.listing_id  
        where a.id=[id]
EOD;

    if($invoices=$db->get_data($sql,array("id"=>$_REQUEST["id"])) and count($invoices)==2){
        $row=$invoices[1];

        $row["next_contact"]=date("Y-m-d",strtotime($row["next_contact"]));
        $sales_list=get_salesperson($row["salesperson_id"]);
    
        print <<<EOD
            <table>
                <input type='hidden' name='id' value="{$row["id"]}">
                <tr valign=top>
                    <td>Name:</td>
                    <td>{$row["name"]}</td>
                </tr>
                <tr valign=top>
                    <td>Notes:</td>
                    <td><textarea rows=3 style='width:100%;' name='notes'>{$row["notes"]}</textarea></td>
                </tr>
                <tr valign=top>
                    <td>Next Contact:</td>
                    <td>
                        <input style='width:100%;' type='text' name='next_contact' value="{$row["next_contact"]}">
                    </td>
                    <td>
                        <input type='submit' name='add_date' value="+1 day">
                        <input type='submit' name='add_date' value="+1 month">
                        <input type='submit' name='add_date' value="+1 year">
                    </td>
                </tr>
                <tr valign=top>
                    <td>Salesperson:</td>
                    <td><select style='width:100%;' name='sales_person'>{$sales_list}</select></td>
                </tr>
                <tr valign=top>
                    <td>Contact Info:</td>
                    <td>{$row["phones"]}</td>
                </tr>
                 <tr valign=top>
                    <td colspan=2 align=center>
                        <input type='submit' name='save' value="Save Next Contact Information" id="form_{$row["id"]}"> 
                        <a href="../../../site/listings/add.php?action=Edit Listing&id={$row["id"]}" target=_blank>edit listing</a>
                    </td>
                 </tr>
            </table>

EOD;


?>
</fieldset>

<fieldset>
<legend>Products</legend>

<fieldset style='width:98%;'>
<legend>Premium Listing</legend>
<?php

     if($row["is_premium"]=="0"){
         //not a premium
         print <<<EOD
             <input type='submit' name='make_premium' value="Make Premium Listing">
EOD;
     } else {
         //is a premium
         print <<<EOD
             Expires on: <input type='text' name='premium_expires' value="{$row["expires"]}"> 
             <input type='submit' name='save_expires' value='Save New Expiry'> 
             <input type='submit' name='cancel_premium' value="Cancel Premium Listing">
EOD;
     }

?>
</fieldset>
<fieldset style='width:98%;'>
<legend>Logos</legend>
<table>
<tr>
<?php
    if($row["has_logo"]=="1"){
        print <<<EOD
        <td>
            Current Logo:<br>
            <img src="/site/customer_images/Logos/{$row["logo_path"]}" alt="{$row["logo_alternate_text"]}"><br>
            Jumps to: {$row["logo_url"]}<br>
            <input type='submit' name='remove_logo' value='Remove Logo'>
        </td>
EOD;
    } else {
    
    print <<<EOD
    <td>
        Add/Update Logo:<br>
        File: <input type='file' name='logo_path'>
        <input type='hidden' name='old_logo_path' value="{$row["logo_path"]}">
        <br>
        Alternate Text: <input type='text' name='logo_alternate_text' value="{$row["logo_alternate_text"]}"><br>
        Jump to URL: <input type='text' name='logo_url' value="{$row["logo_url"]}"><br>
        <input type='submit' name='update_logo' value='Add/Update Logo'>
      </td> 
EOD;

    }

?>
</tr>
</table>
</fieldset>
<fieldset style='width:98%;'>
<legend>Banners</legend>
<table>
<tr>
<?php
    if($row["has_banner"]=="1"){
        print <<<EOD
            <td>
            Current Banner:<br>
            Source: {$row["banner_path"]}<br>
            <img src="/site/customer_images/banners/{$row["banner_path"]}" alt="{$row["banner_alternate_text"]}"><br>
            Jumps to: {$row["banner_url"]}<br>
            <input type='submit' name='remove_banner' value='Remove Banner'>
            </td>
EOD;
    } else {
    
    print <<<EOD
    <td>
        Add/Update Banner:<br>
        File: <input type='file' name='banner_path'>
        <input type='hidden' name='old_banner_path' value="{$row["banner_path"]}">
        <br>
        Alternate Text: <input type='text' name='banner_alternate_text' value="{$row["banner_alternate_text"]}"><br>
        Jump to URL: <input type='text' name='banner_url' value="{$row["banner_url"]}"><br>
        <input type='submit' name='update_banner' value='Add/Update Banner'> 
    </td>
EOD;
    }
?>
</tr>
</table>
</fieldset>
</fieldset>


<fieldset>
<legend>Invoices</legend>
  <style>
  table { border-collapse:collapse; }
  td,th { border:1px solid silver; }
  </style>

<?php

    $output=array();
    $output[]=<<<EOD
      <a href="../invoice/edit.php?create_new=true&listing_id={$row["id"]}" target=_blank>Create New</a>
      <table>
      <tr>
          <th>ID</th>
          <th>Header</th>
          <th>Date</th>
          <th>Sent</th>
          <th>Paid</th>
      </tr>          
EOD;
    
    //get the invoices
    $sql="select * from invoice where listing_id=[id]";
    if($invoices=$db->get_data($sql,array("id"=>$_REQUEST["id"])) and count($invoices)>1){
        foreach($invoices as $rownumber=>$row){
          if($rownumber==0) continue;
          $output[]=<<<EOD
              <tr>
                  <td><a href="../invoice/edit.php?id={$row["id"]}" target=_blank>{$row["id"]}</a></td>
                  <td>{$row["header"]}</td>
                  <td>{$row["occurred"]}</td>
                  <td>{$row["sent"]}</td>
                  <td>{$row["date_paid"]}</td>
              </tr>
EOD;
        }
    }
    $output[]="</table>";

print join("",$output);

?>
</fieldset>
</form>


<?php

    } else {
        print "Results unavailable ({$db->lasterror})";
    }

function add_date(){
global $db,$_POST;

            $date = date("Y-m-d");
            $next_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($date)) . $_POST["add_date"]));
            

    $sql=<<<EOD
        update listings set next_contact='[next_date]' where id=[id]
EOD;
    if($db->set_data($sql,array("next_date"=>$next_date,"id"=>$_POST["id"]))) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>";
}
function save(){
    global $db,$_POST;
    
    $sql=<<<EOD
        update listings set notes='[notes]',
            next_contact='[next_contact]',salesperson_id='[sales_person]' 
        where id=[id]
EOD;

    if($db->set_data($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>"; 
}
function get_salesperson($in_id){
    global $salespeople,$db;
    
    if(!$salespeople){
        if($data=$db->get_data("select * from salesperson",array()) and count($data)>1){
            $salespeople=array();
            foreach($data as $rownumber=>$row){
                if($rownumber==0) continue;
                $salespeople[$row["id"]]=$row["name"];
            }
        }
    }
    
    $output=array();
    if($salespeople){
        foreach($salespeople as $id=>$name){
            $checked=($id==$in_id)?"selected":"";
            $output[]=<<<EOD
                <option value="{$id}" {$checked}>{$name}</option>
EOD;

        }
    }
    
    return join("",$output);    
}
function make_premium(){
    global $db,$_POST;
    
    $sql=<<<EOD
        insert into premium (listing_id,expires) 
        values ([id],current_date + interval 1 year);
EOD;

    if($db->set_data($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>"; 
}
function save_expires(){
    global $db,$_POST;
    
    $sql=<<<EOD
        update premium set expires='[premium_expires]'  
        where listing_id=[id];
EOD;

    if($db->set_data($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>"; 
}
function cancel_premium(){
    global $db,$_POST;
    
    $sql=<<<EOD
        delete from premium   
        where listing_id=[id];
EOD;

    if($db->set_data($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>"; 
}
function update_logo(){
    global $db,$_POST;
    
    if(isset($_FILES)){
      $_POST["logo_path"]=$_POST["old_logo_path"];
      
      /* Add the original filename to our target path.  
      Result is "uploads/filename.extension" */
      $target_path = $_POST["id"]. basename( $_FILES['logo_path']['name']); 
      if(move_uploaded_file($_FILES['logo_path']['tmp_name'], "../../../site/customer_images/Logos/".$target_path)) {
          echo "The file ".  basename( $_FILES['logo_path']['name'])." has been uploaded<br>";
          $_POST["logo_path"]=$target_path;
          
          if(strlen($_POST["old_logo_path"])) unlink("../../../site/customer_images/Logos/".$_POST["old_logo_path"]);
      } else{
          echo "There was an error uploading the file, please try again!";
      }
    }
    
    $sql=array();
    $sql[]=<<<EOD
        delete from logos where listing_id=[id];
EOD;
    $sql[]=<<<EOD
        insert into logos (listing_id,path,url,alternate_text) 
        values ([id],'[logo_path]','[logo_url]','[logo_alternate_text]');
EOD;

    if($db->set_data_multi($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>";
    
    
}
function remove_logo(){
    global $db,$_POST;
    
    if(strlen($_POST["old_logo_path"])) unlink("../../../site/customer_images/Logos/".$_POST["old_logo_path"]);
    
    $sql=array();
    $sql[]=<<<EOD
        delete from logos where listing_id=[id];
EOD;
    if($db->set_data_multi($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>";
    
    
}

function update_banner(){
    global $db,$_POST;
    
    if(isset($_FILES)){
      $_POST["banner_path"]=$_POST["old_banner_path"];
      
      /* Add the original filename to our target path.  
      Result is "uploads/filename.extension" */
      $target_path = $_POST["id"]. basename( $_FILES['banner_path']['name']); 
      if(move_uploaded_file($_FILES['banner_path']['tmp_name'], "../../../site/customer_images/banners/".$target_path)) {
          echo "The file ".  basename( $_FILES['banner_path']['name'])." has been uploaded<br>";
          $_POST["banner_path"]=$target_path;
          
          if(strlen($_POST["old_banner_path"])) unlink("../../../site/customer_images/banners/".$_POST["old_banner_path"]);
      } else{
          echo "There was an error uploading the file, please try again!";
      }
    }
    
    $sql=array();
    $sql[]=<<<EOD
        delete from banners where listing_id=[id];
EOD;
    $sql[]=<<<EOD
        insert into banners (listing_id,path,url,alternate_text) 
        values ([id],'[banner_path]','[banner_url]','[banner_alternate_text]');
EOD;

    if($db->set_data_multi($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>";
    
    
}
function remove_banner(){
    global $db,$_POST;
    
    if(strlen($_POST["old_banner_path"])) unlink("../../../site/customer_images/banners/".$_POST["old_banner_path"]);
    
    $sql=array();
    $sql[]=<<<EOD
        delete from banners where listing_id=[id];
EOD;
    if($db->set_data_multi($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>";
    
    
}

?>