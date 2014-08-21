<?php
    //returns some xml with the next banner reload time and the banner html
    
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
        
    $db=new Database();

    $sql="select * from banners order by rand() limit 1";
    
    $html="";
    if($data=$db->get_data($sql,array())){
        if(count($data)>1){
            $sql=<<<EOD
            update banners set views=views+1 where banners.id={$data[1]["id"]};
EOD;

            $html=<<<EOD
                <a href="/site/banners/banner_click.php?id={$data[1]["id"]}" target=_blank>
                <img style="border:1px solid silver;" border=0 src="/site/customer_images/banners/{$data[1]["path"]}" alt="{$data[1]["alternate_text"]}">
                </a>
EOD;
            $db->set_data($sql,array());
        }
    }
    
if(!isset($_REQUEST["banner_name"])) $_REQUEST["banner_name"]="ajax-banner"; 
    
header('Content-type: text/xml');
echo '<?xml version="1.0" ?>';

// print the XML response
?>
<banner>
    <content><?php echo htmlentities($html); ?></content>
    <banner_name><?php echo $_REQUEST["banner_name"]; ?></banner_name>
    <reload>30000</reload>
</banner>
    