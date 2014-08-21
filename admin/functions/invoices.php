<?php
session_start();
  print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}


  

?>
  <style>
  body,html { font-family:arial; font-size:9pt; }
  </style>
  <form action=# method="post">
<?php
  
  $checked=array(
      "sent"=>isset($_REQUEST["filter"]["sent"])?"checked":"",
      "paid"=>isset($_REQUEST["filter"]["paid"])?"checked":"",
      "commission_paid"=>isset($_REQUEST["filter"]["commission_paid"])?"checked":"",
  );
print <<<EOD
  <fieldset>
  <legend>Invoices</legend>
      <table>
          <tr>
              <td>Invoice #</td>
              <td>Sent</td>
              <td>Paid</td>
              <td>Commission Paid</td>
          </tr>
          <tr>
              <td><input type='text' name='filter[invoice_number]' value="{$_REQUEST["filter"]["invoice_number"]}"></td>
              <td><input {$checked["sent"]} type='checkbox' name='filter[sent]' value="{$_REQUEST["filter"]["sent"]}"></td>
              <td><input {$checked["paid"]} type='checkbox' name='filter[paid]' value="{$_REQUEST["filter"]["paid"]}"></td>
              <td><input {$checked["commission_paid"]} type='checkbox' name='filter[commission_paid]' value="{$_REQUEST["filter"]["commission_paid"]}"></td>
          </tr>
          <tr>
              <td colspan=4><input type='submit' name='action' value='Filter'></td>
          </tr>
      </table>
  </fieldset>
  </form>
  <fieldset>
  <legend>Filter Results</legend>
  <style>
  table { border-collapse:collapse; width:100%; }
  td { border:1px solid silver; }
  </style>
EOD;

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();
    //$db->debug=true;
    
    $where=array(
      "id"=>strlen($_REQUEST["filter"]["invoice_number"])?"id={$_REQUEST["filter"]["invoice_number"]}":"true",
      "sent"=>isset($_REQUEST["filter"]["sent"])?"sent is not null":"sent is null",
      "paid"=>isset($_REQUEST["filter"]["paid"])?"date_paid is not null":"date_paid is null",
      "commission_paid"=>isset($_REQUEST["filter"]["commission_paid"])?"commission_paid is not null":"commission_paid is null",
    );

    $sql="select * from invoice where ".join(" and ",$where);
    if($invoices=$db->get_data($sql,array())){
        print <<<EOD
            <table>
            <tr>
            <th>
                    <a href="invoice/new.php">Create New Invoice</a>
            </th>
            <th>Invoice #</th>
            <th>Sent</th>
            <th>Paid</th>
            <th>Commission Paid</th>
            </tr>
EOD;

        foreach($invoices as $rownumber=>$row){
            if($rownumber==0) continue;
            print <<<EOD
                <form action="invoice/edit.php" method="post" target="_blank">
                <tr>
                    <td>
                        <input type='hidden' name='id' value="{$row["id"]}">
                        <input type='submit' name='edit' value="edit">
                    </td>
                    <td>{$row["id"]}</td>
                    <td>{$row["sent"]}</td>
                    <td>{$row["date_paid"]}</td>
                    <td>{$row["commission_paid"]}</td>
                </tr>
                </form>
EOD;

        }
        print <<<EOD
            </table>

EOD;

    } else {
        print "Results unavailable";
    }

?>
</fieldset>
