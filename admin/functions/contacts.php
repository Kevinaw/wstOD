<?php
ob_start();
session_start();
  print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    //$db->debug=true;

    if(isset($_POST["save"])) save();
    if(isset($_POST["delete"])) delete();
    if(isset($_POST["edit"])) header("location:contacts/contacts.php?id={$_POST["id"]}");;
    if(isset($_POST["add_date"])) add_date();


$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}
$salespeople=false;



?>
  <style>
  body,html { font-family:arial; font-size:9pt; }
  </style>
  <form action=# method="get">
<?php
  
  $_REQUEST["filter"]=array(
      "name"=>isset($_REQUEST["filter"]["name"])?$_REQUEST["filter"]["name"]:"",
      "next_contact"=>isset($_REQUEST["filter"]["next_contact"])?$_REQUEST["filter"]["next_contact"]:date("Y-m-d"),
      "salesperson_id"=>isset($_REQUEST["filter"]["salesperson_id"])?$_REQUEST["filter"]["salesperson_id"]:1,
      "inactive"=>isset($_REQUEST["filter"]["inactive"])?$_REQUEST["filter"]["inactive"]:"",
      "active"=>isset($_REQUEST["filter"]["active"])?$_REQUEST["filter"]["active"]:"checked",
      "use_name"=>isset($_REQUEST["filter"]["use_name"])?$_REQUEST["filter"]["use_name"]:"checked",
      "use_contact"=>isset($_REQUEST["filter"]["use_contact"])?$_REQUEST["filter"]["use_contact"]:"",
      "use_salesperson"=>isset($_REQUEST["filter"]["use_salesperson"])?$_REQUEST["filter"]["use_salesperson"]:""
  );
  
  $filter_sales=get_salesperson($_REQUEST["filter"]["salesperson_id"]);

print <<<EOD
  <fieldset>
  <legend>Contacts</legend>
      <table>
          <tr>
              <td>Name</td>
              <td>Next Contact</td>
              <td>Sales Person</td>
          </tr>
          <tr>
              <td>
                  <input type='hidden' name='filter[use_name]' value=''>
                  <input type='checkbox' name='filter[use_name]' value='checked' {$_REQUEST["filter"]["use_name"]}>
                  <input type='text' name='filter[name]' value="{$_REQUEST["filter"]["name"]}">
              </td>
              <td>
                  <input type='hidden' name='filter[use_contact]' value=''>
                  <input type='checkbox' name='filter[use_contact]' value='checked' {$_REQUEST["filter"]["use_contact"]}>
                  <input type='text' name='filter[next_contact]' value="{$_REQUEST["filter"]["next_contact"]}">
              </td>
              <td>
                  <input type='hidden' name='filter[use_salesperson]' value=''>
                  <input type='checkbox' name='filter[use_salesperson]' value='checked' {$_REQUEST["filter"]["use_salesperson"]}>
                  <select name='filter[salesperson_id]'>{$filter_sales}</select>
              </td>
              <td>
                  <input type='hidden' name='filter[active]' value=''>
                  <input type='checkbox' name='filter[active]' value='checked' {$_REQUEST["filter"]["active"]}>
                  Active
                  
                  <input type='hidden' name='filter[inactive]' value=''>
                  <input type='checkbox' name='filter[inactive]' value='checked' {$_REQUEST["filter"]["inactive"]}>
                  Inactive
              </td>
          </tr>
          <tr>
              <td colspan=4><input type='submit' name='action' value='Filter'></td>
          </tr>
      </table>
  </fieldset>
  <fieldset>
  <legend>Filter Results</legend>
  <style>
  table { border-collapse:collapse; width:100%; }
  td { border:1px solid silver; }
  </style>
EOD;


    $where=array(
      "inactive"=>($_REQUEST["filter"]["inactive"]=='checked')?"a.active in (0,1)":"a.active=1",
      "hide_active"=>($_REQUEST["filter"]["active"]=='checked')?"a.active in (0,1)":"a.active=0",
      "name"=>($_REQUEST["filter"]["use_name"]=='checked')?"a.name like '%{$_REQUEST["filter"]["name"]}%'":"1=1",
      "next_contact"=>($_REQUEST["filter"]["use_contact"]=='checked')?"next_contact <= '{$_REQUEST["filter"]["next_contact"]}'":"1=1",
      "salesperson_id"=>($_REQUEST["filter"]["use_salesperson"]=='checked')?"salesperson_id = '{$_REQUEST["filter"]["salesperson_id"]}'":"1=1"
    );
    
    $where=join(" and ",$where);
    
    
    //pager
    if(!isset($_REQUEST["page"])) $_REQUEST["page"]=1;
    $sql=<<<EOD
        select count(*)/10 as pages from listings a where {$where}
EOD;
    $pages=1;
    if($data=$db->get_data($sql,array()) and count($data)==2) $pages=$data[1]["pages"];
    $pager="Current Page: ".$_REQUEST["page"]."<br>";
    for($i=1;$i<=$pages;$i++) $pager.="<input type='submit' name='page' value='{$i}'>";
   

    $offset=($_REQUEST["page"]-1)*10;
    $sql=<<<EOD
        select a.*,b.id as salesperson_id 
        from listings a 
        left join salesperson b on b.id=a.salesperson_id 
        where {$where} order by next_contact desc 
        limit 10 offset {$offset}
EOD;

    if($invoices=$db->get_data($sql,array())){
        print <<<EOD
            {$pager}
            </form>
            <table>
            <tr>
            <th></th>
            <th>Active</th>
            <th>Name</th>
            <th>Notes</th>
            <th>Next Contact</th>
            <th>Sales Person</th>
            <th>Admin Email</th>
            </tr>
EOD;




        foreach($invoices as $rownumber=>$row){
            if($rownumber==0) continue;
            $row["next_contact"]=date("Y-m-d",strtotime($row["next_contact"]));
            $sales_list=get_salesperson($row["salesperson_id"]);
            
            if($row["active"]=="0"){
                $delete="<input type='submit' name='delete' value='delete' id='form_{$row["id"]}'><br>"; 
                $active_checked="";
            } else {
                $delete="";
                $active_checked="checked";
            }
            
            print <<<EOD
                <form action="#" method="post">
                <tr valign=top>
                    <td nowrap>
                        <input type='hidden' name='id' value="{$row["id"]}">
                        <input type='submit' name='edit' value="edit" id="form_{$row["id"]}"><br>
                        <input type='submit' name='save' value="save" id="form_{$row["id"]}"><br>
                        {$delete}
                        <a href="../../site/listings/add.php?action=Edit Listing&id={$row["id"]}&is_admin=true" target=_blank>edit listing</a>
                   </td>
                   <td><input type='hidden' name='active' value='0'>
                   <input type='checkbox' name='active' value='1' {$active_checked}></td>
                    <td>{$row["name"]}</td>
                    <td><textarea rows=3 style='width:100%;' name='notes'>{$row["notes"]}</textarea></td>
                    <td>
                        <input style='width:100%;' type='text' name='next_contact' value="{$row["next_contact"]}"><br>
                        <input type='submit' name='add_date' value="+1 day"><br>
                        <input type='submit' name='add_date' value="+1 month"><br>
                        <input type='submit' name='add_date' value="+1 year">
                    </td>
                    <td><select style='width:100%;' name='sales_person'>{$sales_list}</select></td>
                    <td><input type='text' name='update_email' value="{$row["update_email"]}"></td>
                </tr>
                </form>
EOD;

        }
        print <<<EOD
            </table>

EOD;

    } else {
        print "Results unavailable ({$db->lasterror})";
    }

?>
</fieldset>
<?php


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
        update listings set notes='[notes]',update_email='[update_email]', active='[active]',
            next_contact='[next_contact]',salesperson_id='[sales_person]' 
        where id=[id]
EOD;

    if($db->set_data($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>"; 
    
    print $db->lastsql;
}


function delete(){
    global $db,$_POST;
    
    $sql=array();
    
    $sql[]="delete from listing_locations where listing_id=[id]";
    $sql[]="delete from listing_business_types where listing_id=[id]";
    $sql[]="delete from listings where id=[id]";

    if($db->set_data_multi($sql,$_POST)) print "<b>Update Successfull</b>"; else print "<b>Update Failed</b>"; 
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
?>