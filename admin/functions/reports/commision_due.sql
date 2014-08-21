<?php

$settings["total_row"]=true;

$sql=array();
$sql[]=<<<EOD
    create temporary table commission_due as 
    select concat('<form action=\'invoice/edit.php\' target=_blank method=post><input type=\'hidden\' name=\'id\' value=\'',invoice.id,'\'><input type=\'submit\' value=\'Edit ',invoice.id,'\'></form>') as id,
        occurred as invoice_date,
        sent, round(sum(quantity*unit_price),2)  as subtotal,
        round(sum(quantity*unit_price*tax_rate),2) as taxes,
        round(sum(quantity*unit_price*(1+tax_rate)),2) as total,
        salesperson.name  
    from invoice 
    left join invoice_items on invoice.id=invoice_items.invoice_id 
    left join listings on invoice.listing_id=listings.id 
    join salesperson on salesperson.id=listings.salesperson_id    
    where date_paid is not null and commission_paid is null and salesperson.commissioned 
    group by 1
    union 
    select concat('Total for ',salesperson.name),
        null,
        null,round(sum(quantity*unit_price),2) as subtotal,
        round(sum(quantity*unit_price*tax_rate),2) as taxes,
        round(sum(quantity*unit_price*(1+tax_rate)),2) as total,
        salesperson.name  
    from invoice 
    left join invoice_items on invoice.id=invoice_items.invoice_id 
    left join listings on invoice.listing_id=listings.id 
    join salesperson on salesperson.id=listings.salesperson_id    
    where date_paid is not null and commission_paid is null and salesperson.commissioned 
    group by 1
EOD;
$sql[]=<<<EOD
    select * from commission_due 
    order by 1;
EOD;
?>