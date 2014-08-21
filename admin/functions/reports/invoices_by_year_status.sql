<?php

$settings["total_row"]=false;

$sql=array();
$sql[]=<<<EOD
    create temporary table tmp_report as 
    select year(occurred) as `Year`,
        month(occurred) as `Month`,
        round(sum(case when date_paid is null then quantity*unit_price*(1+tax_rate) else 0 end),2) as UnPaid,
        round(sum(case when date_paid is not null then quantity*unit_price*(1+tax_rate) else 0 end),2) as Paid,
        round(sum(case when commission_paid is null and salesperson.commissioned then quantity*unit_price*(1+tax_rate) else 0 end),2) as `Commission Unpaid`,
        round(sum(case when commission_paid is not null and salesperson.commissioned then quantity*unit_price*(1+tax_rate) else 0 end),2) as `Commission Paid` 
    from invoice 
    left join invoice_items on invoice.id=invoice_items.invoice_id
    left join listings on invoice.listing_id=listings.id 
    left join salesperson on listings.salesperson_id=salesperson.id    
    group by 1,2 
    union 
    select 'Total',null,
        round(sum(case when date_paid is null then quantity*unit_price*(1+tax_rate) else 0 end),2) as UnPaid,
        round(sum(case when date_paid is not null then quantity*unit_price*(1+tax_rate) else 0 end),2) as Paid,
        round(sum(case when commission_paid is null and salesperson.commissioned then quantity*unit_price*(1+tax_rate) else 0 end),2) as `Commission Unpaid`,
        round(sum(case when commission_paid is not null and salesperson.commissioned then quantity*unit_price*(1+tax_rate) else 0 end),2) as `Commission Paid`  
    from invoice 
    left join listings on invoice.listing_id=listings.id 
    left join salesperson on listings.salesperson_id=salesperson.id and salesperson.commissioned   
    left join invoice_items on invoice.id=invoice_items.invoice_id  
EOD;

$sql[]=<<<EOD
    select * from tmp_report  
    order by 1,2
EOD;

?>