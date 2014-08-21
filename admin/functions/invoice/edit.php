<?php

require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/crypt.inc";
$db=new Database();
$crypt = new proCrypt;

//invoice functions
if(isset($_POST["save"])) save($_POST["invoice"]);
if(isset($_POST["sent"])) sent($_POST["invoice"]);
if(isset($_POST["paid"])) paid($_POST["invoice"]);
if(isset($_POST["commission_paid"])) commission_paid($_POST["invoice"]);

//invoice item functions
if(isset($_POST["delete"])) delete($_POST["invoice"]);
if(isset($_POST["delete_item"])) delete_item($_POST["invoice_item"]);
if(isset($_POST["save_item"])) save_item($_POST["invoice_item"]);
if(isset($_POST["add_item"])) add_item($_POST["invoice_item"]);

if(isset($_REQUEST["id"])) $_POST["id"]=$_REQUEST["id"];

if(isset($_REQUEST["create_new"])){
    if($id=$db->set_data_return_id("insert into invoice (listing_id) values ([id])",array("id"=>$_REQUEST["listing_id"]))){
        $_POST["id"]=$id;
        
        //get an address
        $sql="select listing_locations.*,prov_state.name as province,countries.name as country from listing_locations join prov_state on prov_state.id=province_id join countries on countries.id=country_id where listing_id=[id] limit 1";
        if($data=$db->get_data($sql,array("id"=>$_REQUEST["listing_id"]))){
            if(count($data)>1){
                $address=array();
                if(strlen($data[1]["contact_name"])) $address[]=$data[1]["contact_name"];
                if(strlen($data[1]["address1"])) $address[]=$data[1]["address1"];
                if(strlen($data[1]["address2"])) $address[]=$data[1]["address2"];
                if(strlen($data[1]["address2"])) $address[]=$data[1]["address2"];
                $address[]=$data[1]["city"].", ".$data[1]["province"];
                $address[]=$data[1]["pcode"]."  ".$data[1]["country"];

                $address=join("\r\n",$address);
                
                $sql="update invoice set header='[header]' where id=[id]";
                $db->set_data($sql,array("id"=>$id,"header"=>$address));
            }
        }
    } else {
        print "Unable to create new invoice.";
        exit;
    }
}

print <<<EOD
  <html>
  <head>
      <title>Invoice #{$_POST["id"]}</title>
      <link rel="stylesheet" href="/css/invoice_screen.css" media="screen" />
      <link rel="stylesheet" href="/css/invoice_print.css" media="print" />      
  </head>
  <body>
EOD;


    $sqls=array();
    $sqls["invoice"]="select invoice.*,listings.salesperson_id from invoice left join listings on listings.id=invoice.listing_id where invoice.id={$_POST["id"]}";
    $sqls["invoice_items"]="select * from invoice_items where invoice_id={$_POST["id"]}";
    $sqls["salesperson"]="select * from salesperson";
    
//    $db->debug=true;
    foreach($sqls as $rownumber=>$sql) $sqls[$rownumber]=$db->get_data($sql,array());
  
      
//$crypt = new proCrypt;    
//$crypt->decrypt( $encoded );
    
    $sqls["invoice"][1]["header"]=str_replace("<br>","\r\n",$sqls["invoice"][1]["header"]);
    $sqls["invoice"][1]["header_print"]=str_replace("\r\n","<br>",$sqls["invoice"][1]["header"]);
    $sqls["invoice"][1]["card_name"]=(strlen($sqls["invoice"][1]["card_name"]))?$crypt->decrypt($sqls["invoice"][1]["card_name"]):"";
    $sqls["invoice"][1]["card_number"]=(strlen($sqls["invoice"][1]["card_number"]))?$crypt->decrypt($sqls["invoice"][1]["card_number"]):"";
    $sqls["invoice"][1]["card_expiry"]=(strlen($sqls["invoice"][1]["card_expiry"]))?$crypt->decrypt($sqls["invoice"][1]["card_expiry"]):"";
    $sqls["invoice"][1]["card_security"]=(strlen($sqls["invoice"][1]["card_security"]))?$crypt->decrypt($sqls["invoice"][1]["card_security"]):"";
    
    if(strlen($sqls["invoice"][1]["card_number"])>4) $sqls["invoice"][1]["card_number"]=substr($sqls["invoice"][1]["card_number"],0,4).str_repeat("*",strlen($sqls["invoice"][1]["card_number"])-4); else $sqls["invoice"][1]["card_number"]='';
    
    $salespeople=get_salesperson($sqls["invoice"][1]["salesperson_id"],$sqls["salesperson"]);
    
print <<<EOD
    <form action=# method="post">
    <input type='hidden' name='id' value="{$_POST["id"]}">
    <input type='hidden' name='invoice[listing_id]' value="{$sqls["invoice"][1]["listing_id"]}">
    <input type='hidden' name='invoice[id]' value="{$_POST["id"]}">
    <table id="header">
        <tr>
            <td rowspan=2 class="noprint">
                <fieldset class="noprint" style=' border:2px solid black; padding:5px;'>
                <legend>Invoice & Payment Options</legend>
                    <table>
                      <tr>
                        <td><input type='submit' name='sent' value='set sent'></td>
                        <td>{$sqls["invoice"][1]["sent"]}</td>
                      </tr>
                      <tr>
                        <td><input type='submit' name='paid' value='set paid'></td>
                        <td>{$sqls["invoice"][1]["date_paid"]}</td>
                      </tr>
                      <tr>
                        <td><input type='submit' name='commission_paid' value='set commission paid'></td>
                        <td>{$sqls["invoice"][1]["commission_paid"]}</td>
                      </tr>
                      <tr>
                        <td>Tax Rate:</td>
                        <td><input type='text' name="invoice[tax_rate]" value="{$sqls["invoice"][1]["tax_rate"]}"></td>
                      </tr>
                      <tr>
                        <td>Salesperson:</td>
                        <td><select name="invoice[salesperson_id]">{$salespeople}</select></td>
                      </tr>
                      <tr>
                        <td>Payment Type:</td>
                        <td><input type='text' name="invoice[payment_type]" value="{$sqls["invoice"][1]["payment_type"]}"></td>
                      </tr>
                      <tr>
                        <td>Card Name:</td>
                        <td><input type='text' name="invoice[card_name]" value="{$sqls["invoice"][1]["card_name"]}"></td>
                      </tr>
                      <tr>
                        <td>Card Number:</td>
                        <td><input type='text' name="invoice[card_number]" value="{$sqls["invoice"][1]["card_number"]}"></td>
                      </tr>
                      <tr>
                        <td>Card Expiry:</td>
                        <td><input type='text' name="invoice[card_expiry]" value="{$sqls["invoice"][1]["card_expiry"]}"></td>
                      </tr>
                      <tr>
                        <td>Card Security:</td>
                        <td><input type='text' name="invoice[card_security]" value="{$sqls["invoice"][1]["card_security"]}"></td>
                      </tr>
                      <tr>
                        <td colspan=2 align=center>
                          <input type='submit' name='delete' value='Delete Invoice'> 
                          <input type='submit' name='save' value='Save Invoice & Payment Options'>
                        </td>
                      </tr>
                    </table>
                </fieldset>

            </td>
            <td width=100%>
                <img src="/images/logo_medium.jpg" border=0><br>
                Div of Canadian Jarrett Industries Inc.<br>
                440, 17008 - 90 Ave Edmonton, AB. Canada<br>
                T5T-1L6<br> 
                Ph: 1-888-496-9722<br> 
            </td>
            <td align=right id="date" nowrap>
            Invoice #: {$sqls["invoice"][1]["id"]}<br>
            Date: {$sqls["invoice"][1]["occurred"]}
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <table id="billing">
                    <tr>
                        <th>Billing Information</th>
                    </tr>
                    <tr>
                        <td>
                          <textarea class="noprint" name="invoice[header]" rows=5 style='width:100%;'>{$sqls["invoice"][1]["header"]}</textarea>
                          <div class="print" style='width:100%;'>
                          {$sqls["invoice"][1]["header_print"]}
                          </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </form>
    
    <table id="items">
        <tr>
            <th class="noprint"></th>
            <th>Description</th>
            <th align=right>Quantity</th>
            <th nowrap align=right>Unit Price</th>
            <th align=right>Subtotal</th>
        </tr>
EOD;

$subtotal=0;
foreach($sqls["invoice_items"] as $rownumber=>$row){
    if($rownumber==0) continue;
    
    $item_subtotal=number_format($row["quantity"]*$row["unit_price"],2);
    $subtotal+=$item_subtotal;
    print <<<EOD
        <form action=# method="post">
        <input type='hidden' name='id' value="{$_POST["id"]}">
        <tr>
            <td class='noprint' nowrap>
                <input type='submit' name='delete_item' value='delete'>
                <input type='submit' name='save_item' value='save'>
                <input type='hidden' name='invoice_item[id]' value="{$row["id"]}">
            </td>
            <td style='width:75%;'>
                <textarea class="noprint" style='width:100%; height:100%;' name='invoice_item[description]'>{$row["description"]}</textarea>
                <div class="print">{$row["description"]}</div>
            </td>
            <td align=right>
                <input class="noprint" type='text' name='invoice_item[quantity]' value="{$row["quantity"]}">
                <div class="print">{$row["quantity"]}</div>
            </td>
            <td align=right>
                <input class="noprint" type='text' name='invoice_item[unit_price]' value="{$row["unit_price"]}">
                <div class="print">\${$row["unit_price"]}</div>
            </td>
            <td align=right>
                \${$item_subtotal}
            </td>
        </tr>
        </form>
EOD;


}

$subtotal=number_format($subtotal,2);
$taxes=number_format($subtotal * $sqls["invoice"][1]["tax_rate"],2);
$total=number_format($subtotal + $taxes,2);
print <<<EOD
        <form action=# method="post" class="noprint">
        <input type='hidden' name='id' value="{$_POST["id"]}">
        <input type='hidden' name='invoice_item[id]' value="{$_POST["id"]}">
        <tr class="noprint">
            <td class='noprint' nowrap>
                <input type='submit' name='add_item' value='add'>
            </td>
            <td style='width:75%;'>
                <textarea class="noprint" style='width:100%; height:100%;' name='invoice_item[description]'></textarea>
            </td>
            <td>
                <input class="noprint" type='text' name='invoice_item[quantity]'>
            </td>
            <td>
                <input class="noprint" type='text' name='invoice_item[unit_price]'>
            </td>
            <td>
            </td>
        </tr>
        </form>
        
        <tr>
            <td class="noprint noborder" style='border:none;'></td>
            <td colspan=3 align=right class="noborder bold" style='border:none;'>Subtotal</td>
            <td align=right>\${$subtotal}</td>
        </tr>
        <tr>
            <td class="noprint noborder" style='border:none;'></td>
            <td colspan=3 align=right class="noborder bold" style='border:none;'>Taxes</td>
            <td align=right>\${$taxes}</td>
        </tr>
        <tr>
            <td class="noprint noborder" style='border:none;'></td>
            <td colspan=3 align=right class="noborder bold" style='border:none;'>Total</td>
            <td align=right>\${$total}</td>
        </tr>
    </table>
EOD;



?>
</form>
</body>
</html>

<?php

function save($invoice){
    global $db,$crypt;

    
    //$invoice["header"]=str_replace("\r\n","<br>",$invoice["header"]);
    if(strlen($invoice["card_name"])) $invoice["card_name"]=$crypt->encrypt($invoice["card_name"]);
    if(strlen($invoice["card_number"])) $invoice["card_number"]=$crypt->encrypt($invoice["card_number"]);
    if(strlen($invoice["card_expiry"])) $invoice["card_expiry"]=$crypt->encrypt($invoice["card_expiry"]);
    if(strlen($invoice["card_security"])) $invoice["card_security"]=$crypt->encrypt($invoice["card_security"]);
    
    $sql=array();
    $sql[]=<<<EOD
        update invoice set 
            header='[header]',
            tax_rate='[tax_rate]',
            payment_type='[payment_type]',
            card_name='[card_name]',
            card_number='[card_number]',
            card_expiry='[card_expiry]',
            card_security='[card_security]'
        where id=[id]
EOD;

    $sql[]="update listings set salesperson_id=[salesperson_id] where id=[listing_id]";

    $db->set_data_multi($sql,$invoice);
}
function sent($invoice){
    global $db;
    
    $sql="update invoice set sent=current_timestamp where id=[id]";
    $db->set_data($sql,$invoice);
}
function paid($invoice){
    global $db;
    
    $sql="update invoice set date_paid=current_timestamp where id=[id]";
    $db->set_data($sql,$invoice);
}
function commission_paid($invoice){
    global $db;
    
    $sql="update invoice set commission_paid=current_timestamp where id=[id]";
    $db->set_data($sql,$invoice);
}
function delete_item($item){
    global $db;
    
    $sql="delete from invoice_items where id=[id]";
    $db->set_data($sql,$item);
}
function delete($item){
    global $db;
    
    $sql=array();
    $sql[]="delete from invoice where id=[id]";
    $sql[]="delete from invoice_items where invoice_id=[id]";
    if($db->set_data_multi($sql,$item)){
        print "<script>window.close();</script>";
    }
    
    
}
function save_item($item){
    global $db;
    
    $sql=<<<EOD
        update invoice_items set 
            description='[description]',
            quantity='[quantity]',
            unit_price='[unit_price]' 
        where id=[id]
EOD;
    $db->set_data($sql,$item);
}
function add_item($item){
    global $db;

    $sql=<<<EOD
        insert into invoice_items (description,quantity,unit_price,invoice_id) values ( 
            '[description]','[quantity]','[unit_price]',[id]
        ) 
EOD;
    $db->set_data($sql,$item);

}

function get_salesperson($id,&$rows){
    
    $output=array();
    foreach($rows as $rownumber=>$row){
        if($rownumber==0) continue;
        
        if($row["id"]==$id) $selected="selected"; else $selected="";
        
        $output[]=<<<EOD
            <option value="{$row["id"]}" {$selected}>{$row["name"]}</option>
EOD;
    }
    
    return join("",$output);
}
?>