<?php
session_start();
print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

$name = ucwords(str_replace(array(".php", "_", "/admin/functions/"), array("", " ", ""), $_SERVER["PHP_SELF"]));
if (!in_array($name, array_values($_SESSION["admin_user"]["access"]))) {
    print "Access Denied";
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/dbi.inc";

if (!isset($_REQUEST["page"]))
    $_REQUEST["page"] = 1;
if (!isset($_REQUEST["page_size"]))
    $_REQUEST["page_size"] = 10;
// get count of unhandled listing request
$db = new Database();
//$sql = <<<EOD
//        SELECT a.*, "EDIT" as request_type 
//        FROM listings a
//        INNER JOIN listings b ON a.update_to_id = b.id
//        AND a.active =0
//        AND b.active =1
//EOD;
//$update_requests = array();
//if ($data = $db->get_data($sql, array()) and count($data) > 1){
//    array_shift ($data);
//    $update_requests = $data;
////    foreach($update_requests as $key => $data)
////    {
////        $update_requests[$key]['request_type'] = "EDIT";
////    }
//}
//
//$sql = <<<EOD
//        SELECT a.*, "NEW" as request_type
//        FROM listings a
//        WHERE a.active =0
//        AND a.update_to_id = -1
//        AND NOT 
//        EXISTS (
//            SELECT * 
//            FROM listings b
//            WHERE b.id > a.id
//            AND b.update_to_id = a.id
//        )
//EOD;
//$new_requests = array();
//if ($data = $db->get_data($sql, array()) and count($data) > 1){
//    array_shift ($data);
//    $new_requests = $data;
////    foreach($new_requests as $key => $data)
////        $new_requests[$key]['request_type'] = "NEW";
//}
//
//
//$listings_requests = array_merge($new_requests, $update_requests);
//$total_count = count($listings_requests);
//
////----kevin----20140825: indexed by id
//foreach($listings_requests as $key => $value)
//{
//    unset($listings_requests[$key]);
//    $listings_requests[$value['id']] = $value;
//}
//krsort($listings_requests);
////end
 
$sql = <<<EOD
        SELECT *
        FROM request_listings 
        ORDER BY id DESC
EOD;
$listings_requests = array();
if ($data = $db->get_data($sql, array()) and count($data) > 1){
    array_shift ($data);
    $listings_requests = $data;
    foreach($listings_requests as $key => $data)
    {
        if($data['update_to_id'] == -1)
            $listings_requests[$key]['request_type'] = "NEW";
        else
            $listings_requests[$key]['request_type'] = "EDIT";
    }
}

$offset = ($_REQUEST["page"] - 1) * $_REQUEST["page_size"];
$page_size = $_REQUEST["page_size"];

$listings_requests = array_slice($listings_requests, $offset, $page_size);
?>

<style type="text/css">
    .class_nowrap { white-space: nowrap; }pre { padding: 0px; margin: 0px; }
    .class_fieldset { margin: 0px; BORDER: #dddddd 1px solid;}
    .class_filter_table { BORDER: #d0d0d0 0px solid; FONT: NORMAL 12px Tahoma;}
    .class_legend { FONT: NORMAL 12px Tahoma;}
    .class_paging_table { BORDER: #d0d0d0 0px solid; FONT: NORMAL 12px Tahoma;}
    .class_table { BORDER-COLLAPSE: collapse; BORDER: #d0d0d0 1px solid; FONT: NORMAL 12px Tahoma;}

    .class_th { BORDER-BOTTOM: #ffcc33 2px solid; BORDER-RIGHT: #d2d0bb 2px solid; PADDING-RIGHT: 2px; PADDING-LEFT: 5px; PADDING-BOTTOM: 2px; FONT: bold 13px Tahoma; COLOR: #333333; PADDING-TOP: 2px; }
    .class_th_normal { BORDER-BOTTOM: #d2d0bb 2px solid; BORDER-RIGHT: #d2d0bb 2px solid; BORDER-LEFT: #e1e2e3 2px solid; MARGIN-LEFT: 0px; PADDING-RIGHT: 2px; PADDING-LEFT: 5px; PADDING-BOTTOM: 2px; FONT: bold 13px Tahoma; COLOR: #333333; PADDING-TOP: 2px; BACKGROUND-COLOR: #e2e0cb}
    .class_th_selected { BORDER-BOTTOM: #cd0000 2px solid; BORDER-RIGHT: #d2d0bb 2px solid; PADDING-RIGHT: 2px; PADDING-LEFT: 5px; PADDING-BOTTOM: 2px; FONT: bold 13px Tahoma; COLOR: #333333; PADDING-TOP: 2px; BACKGROUND-COLOR: #e2e0cb}
    .class_td_main { BORDER-TOP: #f1efe2 1px solid; BORDER-RIGHT: #fefefe 1px solid; BORDER-LEFT: #e1e2e3 1px solid; PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 2px; PADDING-TOP: 2px; FONT: normal 12px Tahoma; }
    .class_td_selected { BORDER: #f1efe2 1px solid; PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 2px; FONT: normal 12px Tahoma; PADDING-TOP: 2px; }
    .class_td { BORDER: #f0eee1 1px solid; PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 2px; PADDING-TOP: 2px; FONT: normal 12px Tahoma;  }
    a.grid1_class_a { background: transparent; color: #72705b; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}a.grid1_class_a:link { background: transparent; color: #72705b; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}a.grid1_class_a:hover { background: transparent; color: #f0c030; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}a.grid1_class_a:visited { }
    a.grid1_class_a2 { background: transparent; color: #72705b; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}a.grid1_class_a2:link { background: transparent; color: #72705b; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}a.grid1_class_a2:hover { background: transparent; color: #ffcc33; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}a.grid1_class_a2:visited { background: transparent; color: #72705b; text-decoration: none; FONT-SIZE: 12px; FONT-FAMILY: Tahoma;}
    .class_button { BORDER-RIGHT: #b2b09b 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #ffffff 2px solid; PADDING-LEFT: 5px; PADDING-BOTTOM: 2px; FONT: bold 12px Tahoma; BORDER-LEFT: #ffffff 1px solid; COLOR: #333333; PADDING-TOP: 2px; BORDER-BOTTOM: #b2b09b 1px solid; BACKGROUND-COLOR: #e2e0cb}
    .class_select { BORDER: #b2b09b 1px solid; FONT: NORMAL 12px Tahoma; background-color: #fcfaf6;}
    .class_label { FONT-SIZE: 12px; FONT-FAMILY: Tahoma; }
    .class_textbox { BORDER: #b2b09b 1px solid; FONT: NORMAL 12px Tahoma; width:210px;padding-left:3px;}
    .class_checkbox { BORDER: 0px; FONT: NORMAL 12px Tahoma;width:20px;}
    .class_radiobutton { BORDER: 0px; FONT: NORMAL 12px Tahoma;width:20px;}
    .grid1_caption { FONT: NORMAL 14px Tahoma; font-weight: bold; text-align:center; Padding-bottom: 0;}
    .class_error_message { FONT: NORMAL 12px Tahoma; COLOR: #ff8822; }
    .class_ok_message { FONT: NORMAL 12px Tahoma; COLOR: #449944; }
    .class_left { TEXT-ALIGN: left; }
    .class_center { TEXT-ALIGN: center; }
    .class_right { TEXT-ALIGN: right; }
    .resizable-textarea .grippie { BORDER-RIGHT: #d2d0bb 1px solid; BORDER-TOP: #d2d0bb 1px solid; BACKGROUND: url(../grid2/images/common/grippie.png) #eee no-repeat center 2px; OVERFLOW: hidden; BORDER-LEFT: #d2d0bb 1px solid; CURSOR: s-resize; BORDER-BOTTOM: #d2d0bb 1px solid; height:6px; }
</style>
<div class="grid1_caption">Listings Requests</div><br/><br/>
<table dir="ltr" class="class_table" align="center" width="90%">
    <tbody>
        <tr class="class_tr" bgcolor="" id="grid1_row_" onmouseover="" onmouseout="">
            <td class="class_td class_center" bgcolor="#fcfaf6" width="26px" nowrap=""></td>
            <th class="class_th_normal class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="1%" nowrap=""><a class="grid1_class_a" title="Add new record">View</a></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Id </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="10%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Name </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Description </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="10%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Notes </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Next_contact </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Salesperson_id </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Active </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Update_to_id </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="10%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Update_confirmation_id </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Update_email </a></b></nobr></th>
            <th class="class_th class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="5%" wrap=""><nobr><b><a class="grid1_class_a" title="Sort">Request_Type </a></b></nobr></th>
            <th class="class_th_normal class_center" bgcolor="#e2e0cb" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" width="10%" nowrap="">Operations</th>
        </tr>
<?php
foreach ($listings_requests as $listings_request) {
    ?>
    <tr class="class_tr" bgcolor="#fcfaf6" id="grid1_row_0" onmouseover="bgColor = '#ebeadb';" onmouseout="bgColor = '#e2e0cb';" style="background: rgb(252, 250, 246);">
        <td class=" class_center" nowrap=""><input type="checkbox" name="grid1_checkbox_0" id="grid1_checkbox_0" value="1"></td>
        <td class="class_td_main class_center" bgcolor="#ebeadb" nowrap="">
            <a class="grid1_class_a" href="/site/search/views/more_info.php?is_admin=true&id=<?php echo $listings_request['id']; ?>" target="_blank" title="View details">Details</a>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['id']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['name']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['description']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['notes']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['next_contact']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['salesperson_id']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['active']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['update_to_id']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['update_confirmation_id']; ?></label>
        </td>
        <td class="class_td class_left" wrap="">
            <label class="class_label"><?php echo $listings_request['update_email']; ?></label>
        </td>
        <td class="class_td class_left" wrap="" >
            <label class="class_label" style="color: #D54E21;"><?php echo $listings_request['request_type']; ?></label>
        </td>
        <td class="class_td class_center" nowrap="">
            <a class="grid1_class_a" href="/site/listings/action/update.php?action=delete&uuid=<?php echo $listings_request['update_confirmation_id']; ?>&is_admin=true" title="Delete record">Delete</a> | 
            <a class="grid1_class_a" href="/site/listings/action/update.php?action=accept&uuid=<?php echo $listings_request['update_confirmation_id']; ?>&is_admin=true&update_to_id=<?php echo $listings_request['update_to_id']; ?>" title="Accept record">Accept</a> | 
            <a class="grid1_class_a" href='/site/listings/add.php?action=Edit Request Listing&id=<?php echo $listings_request['id']; ?>&is_admin=true' title="Edit record">Edit</a>
        </td>
    </tr>

    <?php
}
?>
</tbody>

</table>

<form name="frmPaginggrid1_Lower" action="" style="margin:0px; padding:5px; ">
    <table class="class_paging_table" dir="ltr" align="center" width="90%" border="0">
        <tbody>
            <tr>
                <td align="left" class="class_nowrap">&nbsp;Results:&nbsp;<?php echo ($offset + 1) . " - " . ($offset + $page_size); ?>&nbsp;of&nbsp;<?php echo $total_count; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td align="center" class="class_nowrap">&nbsp;Pages:&nbsp;&nbsp;
                    <a class="grid1_class_a" style="text-decoration: none;" title="previous" <?php
if ($_REQUEST['page'] > 1) {
    $previous_page = $_REQUEST['page'] - 1;
    print <<<EOD
                        href="?page={$previous_page}&page_size={$page_size}"
EOD;
}
?> >Previous Page,</a>&nbsp;&nbsp;
                    <a class="grid1_class_a" style="text-decoration: underline;" title="current" ><b><u><?php echo $_REQUEST['page']; ?></u></b></a>,&nbsp;&nbsp;
                    <a class="grid1_class_a" style="text-decoration: none;" title="next" <?php
                    if ($_REQUEST['page'] < floor($total_count / $page_size)) {
                        $next_page = $_REQUEST['page'] + 1;
                        print <<<EOD
                        href="?page={$next_page}&page_size={$page_size}"
EOD;
                    }
?> >Next Page</a>
                </td>
                <td align="right" class="class_nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Page size:&nbsp;
                    <select class="class_select" name="page_sizeLower" id="page_sizeLower" onchange="grid1_setPageSizeLower()">
                        <option value="10" <?php if ($page_size == 10) echo "selected=''"; ?>>10</option>
                        <option value="25" <?php if ($page_size == 25) echo "selected=''"; ?>>25</option>
                        <option value="50" <?php if ($page_size == 50) echo "selected=''"; ?>>50</option>
                        <option value="100" <?php if ($page_size == 100) echo "selected=''"; ?>>100</option>
                        <option value="250" <?php if ($page_size == 250) echo "selected=''"; ?>>250</option>
                        <option value="500" <?php if ($page_size == 500) echo "selected=''"; ?>>500</option>
                        <option value="1000" <?php if ($page_size == 1000) echo "selected=''"; ?>>1000</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<script type="text/javascript">
<!--
    function grid1_setPageSizeLower()
    {
        document.location.href = '?page=1&page_size=' + document.frmPaginggrid1_Lower.page_sizeLower.value;
    }
//-->
</script>