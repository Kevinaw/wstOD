<?php

$settings["total_row"]=false;

$sql=array();
$sql[]=<<<EOD
    create temporary table tmp_report as 
    select year(occurred) as `Year`,
        case when date_paid is null then 'Unpaid' else 'Paid' end as status,
        round(sum(quantity*unit_price),2) as subtotal,
        round(sum(quantity*unit_price*tax_rate),2) as taxes,
        round(sum(quantity*unit_price*(1+tax_rate)),2) as total 
    from invoice 
    left join invoice_items on invoice.id=invoice_items.invoice_id  
    group by 1,2 
EOD;

$sql[]=<<<EOD
    select * from tmp_report  
    order by 1,2
EOD;

?>