<?php
session_start();
  print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}

$image_name=$_POST["link_image"];
if(isset($_POST["upload"])){
    $image_name=save_image();
}
?>
  
    <link rel="stylesheet" type="text/css" media="screen" href="../grid2/css/stylecss" />
    
    <script>
        function update_html(){
            h=document.getElementById('html');
            p=document.getElementById('preview');
            lu=document.getElementById('link_url').value;
            lt=document.getElementById('link_text').value;
            ld=document.getElementById('link_description').value;
            li=document.getElementById('link_image').value;
            
            ival="<a href=\"" + lu + "\" target=_blank alt=\"" + lt + "\" title=\"" + lt + "\">";
            if(ld.length>0) ival=ival + ld;
            if(li.length>0) ival=ival + "<img src=\"" + li + "\" border=0>";
            ival=ival + "</a>";
            
            h.value=ival;
            p.innerHTML=ival;
            
        }
        function toggle(i){
            h=document.getElementById('builder');
            if(i.value=='Show HTML Builder'){
                h.style.display='inline';
                i.value='Hide HTML Builder';
            } else {
                h.style.display='none';
                i.value='Show HTML Builder';
            }
        }
    </script>
    <style>
        table,tr,td,th { font-family:arial; font-size:8pt; }
    </style>
    
    <input type='button' id='builder_button' value='Show HTML Builder' onclick='toggle(this);'>
    <div style='display:none;' id='builder'>
    <form method="post" enctype="multipart/form-data"  action="#">
    <table style='border:1px solid black; width:100%;'>
    <tr style='background:black; color:white; font-weight:bold;'>
        <th colspan=2>HTML Builder</th>
        <th>HTML</th>
        <th>Preview</th>
    </tr>
    <tr>
        <td>Link Text:</td>
        <td><input id='link_text' name='link_text' value="<?php echo $_POST["link_text"]; ?>"></td>
        <td rowspan=4 width=50% style='border:1px solid black;'>
            <textarea id='html' name='html' rows=6 style='width:100%; height:100%; border:none;'><?php echo $_POST["html"]; ?></textarea>
        </td>
        <td rowspan=4 style='border:1px solid black;' id='preview'>
        </td>
    </tr>
    <tr>
        <td>URL:</td>
        <td><input id='link_url' name="link_url" value="<?php echo $_POST["link_url"]; ?>"></td>
    </tr>
    <tr>
        <td>Description:</td>
        <td><input id='link_description' name="link_description" value="<?php echo $_POST["link_description"]; ?>"></td>
    </tr>
    <tr>
        <td>Link Image:</td>
        <td>
            <input type='hidden' id='link_image' name="link_image" value="<?php echo $image_name; ?>">
            <img src="<?php echo $image_name; ?>" border=0>
        </td>
    </tr>
    <tr>
        <td>
            <input type='file' name='upload_image'>
        </td>
        <td>
            <input type='submit' name='upload' value='Upload Image'>
        </td>
        <td><input type='button' onclick='update_html();' value='Create HTML'></td>
    </tr>
    </table>
    </form>
    </div>
  <?php

  
/* Ex.: "datagrid/" or "../datagrid/" */
/* Ex.: "datagrid/pear/" or "../datagrid/pear/" */
define ("DATAGRID_DIR", "../grid2/");    
define ("PEAR_DIR", "../grid2/pear/");       

require_once(DATAGRID_DIR.'datagrid.class.php');
require_once(PEAR_DIR.'PEAR.php');
require_once(PEAR_DIR.'DB.php');

$caption="Edit Affiliates";

$grid1_table="affiliates";
$grid1_sql="SELECT * from ".$grid1_table;
$grid1_primary_key="id";
$grid1_sort_field="name";
$grid1_sort_direction="asc";


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

$sql = $grid1_sql;

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


$auto_column_in_view_mode = true;
$dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);


##  *** set auto-generated columns in edit mode


// Table for adding and editing
$table_name  = $grid1_table;
// Primary key for this table
$primary_key = $grid1_primary_key; 
// Condition. Ex.: table_name.field = 'xxx'
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);



 $em_columns = array(
     "name" =>array("header"=>"Name", "type"=>"textbox",  "req_type"=>"rt", "title"=>"Name", "readonly"=>false, "maxlength"=>"-1"),
     "html" =>array("header"=>"HTML", "type"=>"textarea", "req_type"=>"rt", "title"=>"HTML", "readonly"=>false, "maxlength"=>"-1", "edit_type"=>"simple", "resizable"=>"true", "rows"=>"7", "cols"=>"50")
///     "FieldName_3" =>array("header"=>"Name_C", "type"=>"label",    "req_type"=>"rt", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>""),
///     "FieldName_4" =>array("header"=>"Name_D", "type"=>"date",     "req_type"=>"rt", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>""),
///     "FieldName_5" =>array("header"=>"Name_E", "type"=>"datetime", "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>""),
///     "FieldName_6" =>array("header"=>"Name_F", "type"=>"image",    "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "image_width"=>"Xpx", "image_height"=>"Ypx", "file_name"=>"Image_Name", "host"=>"local|remote"),
///     "FieldName_7" =>array("header"=>"Name_G", "type"=>"password", "req_type"=>"rp", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>""),
///     "FieldName_8" =>array("header"=>"Name_H", "type"=>"enum",     "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>"", "source"=>"self"|$fill_from_array, "view_type"=>"dropdownlist(default)|radiobutton"),
///     "FieldName_9" =>array("header"=>"Name_I", "type"=>"print",    "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>""),
///     "FieldName_10"=>array("header"=>"Name_J", "type"=>"checkbox", "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>"", "true_value"=>1, "false_value"=>0),
///     "FieldName_11"=>array("header"=>"Name_K", "type"=>"file",     "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "file_name"=>"File_Name", "host"=>"local|remote"),
///     "FieldName_12"=>array("header"=>"Name_L", "type"=>"link",     "req_type"=>"st", "width"=>"210px", "title"=>"Short Description", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>"", "field_key"=>"field_name_0"|"field_key_1"=>"field_name_1"|..., "field_data"=>"field_name_2", "target"=>"_new", "href"=>"http://mydomain.com?act={0}&act={1}&code=ABC"),
///     "FieldName_13"=>array("header"=>"",       "type"=>"hidden",   "req_type"=>"st", "default"=>"default_value", "unique"=>false|true),
///     "delimiter"   =>array("inner_html"=>"<br />")
 );
 $dgrid->setColumnsInEditMode($em_columns);
##  *** set auto-genereted columns in edit mode
 $auto_column_in_edit_mode = true;
 //$dgrid->setAutoColumnsInEditMode($auto_column_in_edit_mode);


//$auto_column_in_edit_mode = true;
//$dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);


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
/// $top_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
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
     "Name"=>array("table"=>$grid1_table, "field"=>$grid1_sort_field, "source"=>"self", "operator"=>false, "default_operator"=>"like",  "type"=>"textbox", "case_sensitive"=>false, "comparison_type"=>"string")
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
              $sql="insert into affiliate_business_types (affiliate_id,business_type_id) select [id],id from businesstypes where id in ([ids])";
              $db->set_data($sql,array("id"=>$dgrid->rid,"ids"=>join(",",$_POST["categories"]["unselected"])));              
          break;
          case "remove":
              $sql="delete from affiliate_business_types where affiliate_id=[id] and business_type_id in ([ids])";
              $db->set_data($sql,array("id"=>$dgrid->rid,"ids"=>join(",",$_POST["categories"]["selected"])));              
          break;
      }
  }

  
  $types=$db->get_data("select * from businesstypes order by name",array());
  $selected=$db->get_data("select businesstypes.* from affiliate_business_types join businesstypes on business_type_id=businesstypes.id where affiliate_id=".$dgrid->rid." order by businesstypes.name",array());
  
  $all_categories=get_list($types);
  $include_categories=get_list($selected);
  
    print <<<EOD
        <form action="#" method="post">
        <div style='width:100%; text-align:center; font-family:arial;'>
        <div style='margin:0px auto; width:100%; text-align:-moz-center;'>
        <fieldset style='width:70%;'>
        <legend>Relate Business Categories</legenc>
          <table class="class_table" >
            <tr>
              <td>All Categories</td>
              <td></td>
              <td>Related Categories</td>
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



function get_list(&$list){
    $options=array();

    foreach($list as $rownumber=>$row){
        if($rownumber==0) continue;
        
        $options[]=<<<EOD
                         <option value="{$row["id"]}">{$row["name"]}</option>
EOD;
    }
    return join("",$options);
}

function save_image(){
    global $_FILES,$_POST;
    
    
    $returnFilename= "/site/customer_images/affiliates/".$_FILES["upload_image"]['name'];
    $uploadFilename=$_SERVER['DOCUMENT_ROOT'].$returnFilename;

    if(move_uploaded_file($_FILES["upload_image"]['tmp_name'], $uploadFilename)){
        return $returnFilename;
    } 
}
?>