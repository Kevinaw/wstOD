<?php
session_start();
  print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}

  


$caption="Edit Sales People";

$grid1_table="salesperson";
$grid1_sql="SELECT id,name,username,password,commissioned,available_to_all_sales from ".$grid1_table;
$grid1_primary_key="id";
$grid1_sort_field="name";
$grid1_sort_direction="asc";


/* Ex.: "datagrid/" or "../datagrid/" */
/* Ex.: "datagrid/pear/" or "../datagrid/pear/" */
define ("DATAGRID_DIR", "../grid2/");    
define ("PEAR_DIR", "../grid2/pear/");       

require_once(DATAGRID_DIR.'datagrid.class.php');
require_once(PEAR_DIR.'PEAR.php');
require_once(PEAR_DIR.'DB.php');


$DB_USER='ch1647_oildir';       /* usually like this: prefix_name           */
$DB_PASS='8r:I|l2Rrf)P';          /* must be already encrypted (recommended) */
$DB_HOST='localhost';  /* usually localhost                        */
$DB_NAME='ch1647_oildir';     /* usually like this: prefix_dbName         */


ob_start();
 
## *** (example of ODBC connection string)
## *** $result_conn = $db_conn->connect(DB::parseDSN('odbc://root:12345@test_db'));
## *** (example of Oracle connection string)
## *** $result_conn = $db_conn->connect(DB::parseDSN('oci8://root:12345@localhost:1521/mydatabase)); 
## *** (example of PostgreSQL connection string)
## *** $result_conn = $db_conn->connect(DB::parseDSN('pgsql://root:12345@localhost/mydatabase)); 
## === (Examples of connections to other db types see in "docs/pear/" folder)

$db_conn =& DB::factory('mysql'); 
$result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
if(DB::isError($result_conn)){ 
   die($result_conn->getMessage()); 
}

##  *** put a primary key on the first place 

##  *** set needed options and create a new class instance 
// display SQL statements while processing 
$debug_mode = false;
// display system messages on a screen     
$messaging = true;
// prevent overlays - must be started with a letter
$unique_prefix = "grid1_";

$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);

##  *** set data source with needed options
// make default(first) ordering by this field
$default_order_field = $grid1_sort_field;
// default field order type
$default_order_type = $grid1_sort_direction;
$sql=$grid1_sql;

$dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);

##  *** set encoding (default - utf8)

$dg_encoding = "utf8"; 
$dgrid->SetEncoding($dg_encoding);

$dg_language = "en";  
$dgrid->SetInterfaceLang($dg_language);

##  *** set direction: "ltr" or "rtl" (default - ltr)

$direction = "ltr";
$dgrid->SetDirection($direction);

##  *** set layouts: 0 - tabular(horizontal) - default, 1 - columnar(vertical)
##  *** use "view"=>"0" and "edit"=>"0" only if you work on the same tables

$layouts = array("view"=>0, "edit"=>0, "filter"=>0); 
$dgrid->SetLayouts($layouts);


##  *** set modes for operations ("type" = "link|button|image"),
##  *** "view" - view mode | "edit" - add/edit/details modes
##  *** ("byFieldValue" - make the field as a link to edit mode page)

$modes = array(
  "add"     =>array("view"=>true, "edit"=>false, "type"=>"link"),
  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"link"),
  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"link"),
  "details" =>array("view"=>true, "edit"=>false, "type"=>"link"),
  "delete"  =>array("view"=>true, "edit"=>true, "type"=>"link")
);
$dgrid->SetModes($modes);
##  *** allow scrolling on datagrid

$scrolling_option = false;
$dgrid->AllowScrollingSettings($scrolling_option);  


##  *** set scrolling settings (optional)
$scrolling_width = "90%";
$scrolling_height = "100%";
$dgrid->SetScrollingSettings($scrolling_width, $scrolling_height);

##  *** allow multirow operations

$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);

$multirow_operations = array(
  "delete"  => array("view"=>true),
  "details" => array("view"=>true)
);
$dgrid->SetMultirowOperations($multirow_operations);  

##  *** set CSS class for datagrid
##  *** "default", "blue", "x-blue", "gray", "green" or "pink" or your own css file 


$css_class = "x-blue"; 
$dgrid->SetCssClass($css_class);


##  *** set auto-genereted columns in view mode
 $auto_column_in_view_mode = true;


///$auto_column_in_view_mode = true;
$dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);

 /*

 $vm_colimns = array(
     "id"=>array("header"=>"ID", "type"=>"label",      "align"=>"left"),
     "name"=>array("header"=>"Name", "type"=>"label",      "align"=>"left"),
     "username"=>array("header"=>"Logon ID", "type"=>"label"),
     "password"=>array("header"=>"Password", "type"=>"password"),
     "commissioned"=>array("header"=>"Commissioned", "type"=>"label",      "align"=>"left"),
     "available_to_all_sales"=>array("header"=>"Show All Contacts", "type"=>"label",      "align"=>"left")
    );
 $dgrid->setColumnsInViewMode($vm_colimns);
##  *** set auto-genereted columns in view mode
 $auto_column_in_view_mode = false;
  $dgrid->setAutoColumnsInViewMode($auto_column_in_view_mode);
     */
     
$dgrid->columns_view_mode["password"]['type']="password";     


##  *** set auto-generated columns in edit mode


// Table for adding and editing
$table_name  = $grid1_table;
// Primary key for this table
$primary_key = $grid1_primary_key; 
// Condition. Ex.: table_name.field = 'xxx'
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);

$auto_column_in_edit_mode = true;
$dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);

$dgrid->columns_edit_mode["password"]['type']="password";

 $dgrid->setCaption($caption);


## +---------------------------------------------------------------------------+
## | 4. Sorting & Paging Settings:                                             | 
## +---------------------------------------------------------------------------+
##  *** set sorting option: true(default) or false 

 $paging_option = true;
 $rows_numeration = false;
 $numeration_sign = "N #";       
 $dgrid->allowPaging($paging_option, $rows_numeration, $numeration_sign);
##  *** set paging settings
 $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
 $top_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
 $pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
 $default_page_size = "10";
 $dgrid->setPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);


## +---------------------------------------------------------------------------+
## | 5. Filter Settings:                                                       | 
## +---------------------------------------------------------------------------+
##  *** set filtering option: true or false(default)
 $filtering_option = true;
 $dgrid->allowFiltering($filtering_option);
##  *** set aditional filtering settings
 $filtering_fields = array(
     "Name"=>array("table"=>"countries", "field"=>"name", "source"=>"self", "operator"=>false, "default_operator"=>"like",  "type"=>"textbox", "case_sensitive"=>false, "comparison_type"=>"string")
 );
 $dgrid->setFieldsFiltering($filtering_fields);



$dgrid->Bind(true);



if(isset($_GET['grid1_mode']) && (($_GET['grid1_mode'] == "edit"))){

  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();

  //handle actions
  if(isset($_POST["edit_type"])){
      switch(array_shift(array_keys($_POST["edit_type"]))){
          case "add":
              $items=array();
              if(count($_POST["categories"]["unselected"])){
                foreach($_POST["categories"]["unselected"] as $rownum=>$filename){
                    $items[]="(".$dgrid->rid.",'".$filename."')";
                }
                $sql="insert into access (salesperson_id,name) values ".join(",",$items);
                $db->set_data($sql,array());
              }              
          break;
          case "remove":
              $sql="delete from access where salesperson_id=[id] and name in ('".join("','",$_POST["categories"]["selected"])."')";
              if(count($_POST["categories"]["selected"])){
                  $db->set_data($sql,array("id"=>$dgrid->rid));
              }              
          break;
      }
  }

  
  $types=get_functions();
  $selected=$db->get_data("select id,name from access where salesperson_id=".$dgrid->rid,array());
  
  $all_categories=get_list($types,$selected);
  $include_categories=get_list($selected);
  
    print <<<EOD
        <form action="#" method="post">
        <div style='width:100%; text-align:center; font-family:arial;'>
        <div style='margin:0px auto; width:100%; text-align:-moz-center;'>
        <fieldset style='width:70%;'>
        <legend>Relate Business Categories</legenc>
          <table class="class_table" >
            <tr>
              <td>All Functions</td>
              <td></td>
              <td>Related Functions</td>
            </tr>
            <tr>
              <td width="50%">
                  <select name='categories[unselected][]' size=10 multiple style='width:100%;'>
                  {$all_categories}
                  </select>
              </td>
              <td>
                <input type='image' style='border:none;' src='../../images/left_arrow.png' name='edit_type[remove]'><br>
                <input type='image' style='border:none;' src='../../images/right_arrow.png' name='edit_type[add]'>
              </td>
              <td width="50%">
                  <select name='categories[selected][]' size=10 multiple style='width:100%;'>
                  {$include_categories}
                  </select>
              </td>
            </tr>
          </table>
        </fieldset>
        </div>
        </div>
        </form>
EOD;
  
  



}


ob_end_flush();

function get_functions(){
    $list=array();
    $list[]=array("id"=>"id","name"=>"name");

    $d=dir("../functions/");
    while(false!==($entry = $d->read())) {
        if($entry=="." or $entry==".." or $entry=="error_log" or is_dir("../functions/".$entry)) continue;
        $name=ucwords(str_replace(array(".php","_"),array(""," "),$entry));
        $list[]=array("id"=>$entry,"name"=>$name);
    }
    return $list;    
}

function get_list(&$list,$selected=array()){
    $options=array();
    
    foreach($list as $rownumber=>$row){
        if($rownumber==0) continue;
        $is_selected=false;
        foreach($selected as $rownumber2=>$row2){
            if($rownumber2==0) continue;
            if($row2["name"]==$row["name"]) $is_selected=true;
        }
        if(!$is_selected){
            $options[]=<<<EOD
                         <option value="{$row["name"]}">{$row["name"]}</option>
EOD;
        }
    }
    return join("",$options);
}


?>