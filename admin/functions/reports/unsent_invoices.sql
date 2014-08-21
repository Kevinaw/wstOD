<?php

$settings["total_row"]=true;

$sql=array();
$sql[]=<<<EOD
    create temporary table unsent_invoices as 
    select concat('<form action=\'invoice/edit.php\' target=_blank method=post><input type=\'hidden\' name=\'id\' value=\'',invoice.id,'\'><input type=\'submit\' value=\'Edit ',invoice.id,'\'></form>') as id,
        occurred as invoice_date,
        sent,
        round(sum(quantity*unit_price),2) as subtotal,
        round(sum(quantity*unit_price*tax_rate),2) as taxes,
        round(sum(quantity*unit_price*(1+tax_rate)),2) as total 
    from invoice 
    left join invoice_items on invoice.id=invoice_items.invoice_id  
    where sent is null 
    group by 1 
    union 
    select 'Total',now(),null,
        round(sum(quantity*unit_price),2) as subtotal,
        round(sum(quantity*unit_price*tax_rate),2) as taxes,
        round(sum(quantity*unit_price*(1+tax_rate)),2) as total 
    from invoice 
    left join invoice_items on invoice.id=invoice_items.invoice_id  
    where sent is null      
EOD;

$sql[]=<<<EOD
    select * from unsent_invoices 
    order by 2
EOD;

?>