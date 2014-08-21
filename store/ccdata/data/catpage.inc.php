<?php /** @version $Revision: 4296$ */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><?php
        $pageID = 2;
      ?><html xmlns="http://www.w3.org/1999/xhtml"><?php
        $currentpage = $myPage->getPage($pageID);
      
    
    $currentpage_id = $currentpage['id'];
    $currentpage_name = $currentpage['name'];
    $currentpage_pagehref = $currentpage['pagehref'];
    $currentpage_metadescription = $currentpage['metadescription'];
    $currentpage_metakeywords = $currentpage['metakeywords'];
    $currentpage_type = $currentpage['type'];
    $currentpage_content = $currentpage['content'];
    $currentpage_headertext = $currentpage['headertext'];
    ?><head><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><title><?php  echo $myPage->getConfig('shopname'); ?><?php
    
    if ( 
    $currentpage_name ) 
    { ?> - <?php
        echo $currentpage_name;
      ?><?php } ?></title><?php } else { ?><?php
    
    if ( 
    $currentpage_name ) 
    { ?><title><?php
        echo $currentpage_name;
      ?></title><?php } ?><?php } ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="description" content="<?php
        echo $currentpage_metadescription;
      ?>" /><meta name="keywords" content="<?php
        echo $currentpage_metakeywords;
      ?>" /><meta name="generator" content="CoffeeCup Shopping Cart Creator, <?php  echo $myPage->getConfig('sccversion'); ?>" /><meta http-equiv="generator" content="CoffeeCup Shopping Cart Creator (www.coffeecup.com)" /><meta name="revised" content="<?php  echo $myPage->getConfig('timestamp'); ?>" /><link rel="stylesheet" type="text/css" media="all" href="css/default.css" /><link rel="stylesheet" type="text/css" media="screen" href="css/colorbox.css" /><!-- styler.css must be the last one. --><link rel="stylesheet" type="text/css" media="all" href="css/styler.css" /><!-- Remember that shop header must include css/default_ie.css in an IE 7 conditional comment --><!-- Remember that shop header must include jquery.js --><?php echo $myPage->getConfig('shophtmlheader');?><script type="text/javascript" src="js/external_links.js">/**/</script></head><body id="scs_categories_page"><div id="scs_header_area_wrapper"><div id="scs_header_area_inner_wrapper"><div id="scs_header_area"><div id="scs_header_wrapper"><div id="scs_header_inner_wrapper"><div id="scs_header"><?php
    
    if ( 
    $myPage->getConfig('shoplogo') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('websitehref') ) 
    { ?><a href="<?php  echo $myPage->getConfig('websitehref'); ?>"><img id="scs_shoplogo" src="<?php  echo $myPage->getConfig('shoplogo'); ?>" alt="<?php  echo $myPage->getConfig('shopname'); ?>" /></a><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><?php  echo $myPage->getConfig('shopname'); ?></h1><?php } ?><?php } else { ?><img id="scs_shoplogo" src="<?php  echo $myPage->getConfig('shoplogo'); ?>" alt="<?php  echo $myPage->getConfig('shopname'); ?>" /><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><?php  echo $myPage->getConfig('shopname'); ?></h1><?php } ?><?php } ?><?php } else { ?><?php
    
    if ( 
    $myPage->getConfig('websitehref') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><a href="<?php  echo $myPage->getConfig('websitehref'); ?>"><?php  echo $myPage->getConfig('shopname'); ?></a></h1><?php } ?><?php } else { ?><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><?php  echo $myPage->getConfig('shopname'); ?></h1><?php } ?><?php } ?><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div></div></div></div><div id="scs_central_area_wrapper"><div id="scs_central_area_inner_wrapper"><div id="scs_central_area"><div id="scs_navbar_wrapper"><div id="scs_navbar_inner_wrapper"><div id="scs_navbar"><div id="scs_navmenu_wrapper"><div id="scs_navmenu_inner_wrapper"><div class="scs_layout_menu_horizontal"><ul id="scs_navmenu"><?php

    foreach($myPage->getPages() as  
          $page )
    {
    ?><?php
    
    $page_id = $page['id'];
    $page_name = $page['name'];
    $page_pagehref = $page['pagehref'];
    $page_metadescription = $page['metadescription'];
    $page_metakeywords = $page['metakeywords'];
    $page_type = $page['type'];
    $page_content = $page['content'];
    $page_headertext = $page['headertext'];
    ?><?php
    
    if ( 
    $page_type =='home' ) 
    { ?><li class="scs_home_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $myPage->getConfig('pagescount') =='0' ) 
    { ?><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><?php } else { ?><?php
    
    if ( 
     !  (  $myPage->getConfig('staticpageshome') )  ) 
    { ?><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><?php } else { ?><div class="scs_navmenu_item_with_submenu"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

    foreach($myPage->getPages('staticpage') as  
          $stpage )
    {
    ?><?php
    
    $stpage_id = $stpage['id'];
    $stpage_name = $stpage['name'];
    $stpage_pagehref = $stpage['pagehref'];
    $stpage_metadescription = $stpage['metadescription'];
    $stpage_metakeywords = $stpage['metakeywords'];
    $stpage_type = $stpage['type'];
    $stpage_content = $stpage['content'];
    $stpage_headertext = $stpage['headertext'];
    ?><?php
    
    if ( 
    $stpage_type =='staticpage' ) 
    { ?><li><div class="scs_navsubmenu_item_inner_wrapper"><a href="<?php
        echo $stpage_pagehref;
      ?>"><span class="scs_navsubmenu_item_icon_wrapper"><span class="scs_navsubmenu_item_content_wrapper"><?php
        echo $stpage_name;
      ?></span></span></a></div></li><?php } ?><?php } ?></ul></div></div></div><?php } ?><?php } ?></div></li><?php } ?><?php
    
    if ( 
    $page_type =='shophome' ) 
    { ?><li class="scs_shophome_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $myPage->getConfig('pagescount') =='0' ) 
    { ?><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><?php } else { ?><?php
    
    if ( 
    $myPage->getConfig('staticpageshome') ) 
    { ?><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><?php } else { ?><div class="scs_navmenu_item_with_submenu"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

    foreach($myPage->getPages('staticpage') as  
          $stpage )
    {
    ?><?php
    
    $stpage_id = $stpage['id'];
    $stpage_name = $stpage['name'];
    $stpage_pagehref = $stpage['pagehref'];
    $stpage_metadescription = $stpage['metadescription'];
    $stpage_metakeywords = $stpage['metakeywords'];
    $stpage_type = $stpage['type'];
    $stpage_content = $stpage['content'];
    $stpage_headertext = $stpage['headertext'];
    ?><?php
    
    if ( 
    $stpage_type =='staticpage' ) 
    { ?><li><div class="scs_navsubmenu_item_inner_wrapper"><a href="<?php
        echo $stpage_pagehref;
      ?>"><span class="scs_navsubmenu_item_icon_wrapper"><span class="scs_navsubmenu_item_content_wrapper"><?php
        echo $stpage_name;
      ?></span></span></a></div></li><?php } ?><?php } ?></ul></div></div></div><?php } ?><?php } ?></div></li><?php } ?><?php
    
    if ( 
    $page_type =='cart' ) 
    { ?><li class="scs_cart_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?></div></li><?php } ?><?php
    
    if ( 
    $page_type =='category' ) 
    { ?><li class="scs_categories_item"><div class="scs_navmenu_item_inner_wrapper"><div class="scs_navmenu_item_with_submenu"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } ?><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

    foreach($myPage->getGroups() as  
          $group )
    {
    ?><?php
        $group_id = $group['groupid'];
        $group_products =& $myPage->getProductsByGroup($group_id);
      
    $group_name = $group['name'];
    $group_metakeywords = $group['metakeywords'];
    $group_metadescription = $group['metadescription'];

    $group_pagehref =  $group['pagehref'];
    $group_productscount = strval( count( $group_products ) );
    $group_iteration = 0;
    
    $group_parentid = $group['parentid'];
    $group_parentname = $group['parentname'];
    $group_parenthref = $group['parenthref'];
    $group_image = $group['image'];
    $group_imageisset = $group['imageisset'];
    $group_tileimage = $group['tileimage'];
    $group_image = $group['image'];
    $group_content = $group['content'];

    $group_subgroupsids = $group['subgroupsIds'];
    $group_subgroupscount =  strval( count( $group_subgroupsids ) );
    
  ?><?php
    
    if ( 
    $group_name ) 
    { ?><?php
    
    if ( 
    $group_parentid!='-1' ) 
    { ?><!-- nothing to do --><?php } else { ?><li><div class="scs_navsubmenu_item_inner_wrapper"><?php
    
    if ( 
    $group_subgroupscount!='0' ) 
    { ?><div class="scs_navsubmenu_item_with_submenu"><a href="<?php
        echo $group_pagehref;
      ?>"><span class="scs_navsubmenu_item_icon_wrapper"><span class="scs_navsubmenu_item_content_wrapper"><?php
        echo $group_name;
      ?></span></span></a><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

    foreach($myPage->getSubGroups($group_id) as  
          $subgrp )
    {
    ?><?php
        $subgrp_id = $subgrp['groupid'];
        $subgrp_products =& $myPage->getProductsByGroup($subgrp_id);
      
    $subgrp_name = $subgrp['name'];
    $subgrp_metakeywords = $subgrp['metakeywords'];
    $subgrp_metadescription = $subgrp['metadescription'];

    $subgrp_pagehref =  $subgrp['pagehref'];
    $subgrp_productscount = strval( count( $subgrp_products ) );
    $subgrp_iteration = 0;
    
    $subgrp_parentid = $subgrp['parentid'];
    $subgrp_parentname = $subgrp['parentname'];
    $subgrp_parenthref = $subgrp['parenthref'];
    $subgrp_image = $subgrp['image'];
    $subgrp_imageisset = $subgrp['imageisset'];
    $subgrp_tileimage = $subgrp['tileimage'];
    $subgrp_image = $subgrp['image'];
    $subgrp_content = $subgrp['content'];

    $subgrp_subgroupsids = $subgrp['subgroupsIds'];
    $subgrp_subgroupscount =  strval( count( $subgrp_subgroupsids ) );
    
  ?><?php
    
    if ( 
    $subgrp_name ) 
    { ?><li><div class="scs_navsubmenu_item_inner_wrapper"><a href="<?php
        echo $subgrp_pagehref;
      ?>" ><span class="scs_navsubmenu_item_icon_wrapper"><span class="scs_navsubmenu_item_content_wrapper"><?php
        echo $subgrp_name;
      ?></span></span></a></div></li><?php } ?><?php } ?></ul></div></div></div><?php } else { ?><a href="<?php
        echo $group_pagehref;
      ?>"><span class="scs_navsubmenu_item_icon_wrapper"><span class="scs_navsubmenu_item_content_wrapper"><?php
        echo $group_name;
      ?></span></span></a><?php } ?></div></li><?php } ?><?php } ?><?php } ?></ul></div></div></div></div></li><?php } ?><?php } ?></ul></div></div></div><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><?php
    
    if ( 
     !  (  $myPage->getConfig('cataloghtml') )  ) 
    { ?><div id="scs_search_wrapper" class="scs_layout_search_normal"><div id="scs_search_inner_wrapper"><div id="scs_search"><form action="<?php echo $myPage->getUrl(); ?>" method="post"><p><input class="scs_search_input" type="text" name="search_words" value="search" onfocus="if(this.value=='search') this.value=''" /><input class="scs_search_go" type="submit" value="" title="Search" /><input type="hidden" name="method" value="search" /></p></form></div></div></div><?php } else { ?><div id="scs_search_wrapper" class="scs_layout_search_normal scs_search_cataloghtml"><div id="scs_search_inner_wrapper"><div id="scs_search"><form action="<?php echo $myPage->getUrl(); ?>" method="post"><p><input class="scs_search_input" type="text" name="search_words" value="search" onfocus="if(this.value=='search') this.value=''" /><input class="scs_search_go" type="submit" value="" title="Search" /><input type="hidden" name="method" value="search" /></p></form></div></div></div><?php } ?><?php } ?><?php
    
    if ( 
    $myPage->getConfig('showaddcart') ) 
    { ?><div id="scs_cartsummary_wrapper"><div id="scs_cartsummary"><?php
    
    if ( 
    strval($myPage->getCartCount()) =='0' ) 
    { ?><span style="visibility:hidden;"><span class="scs_viewyourcart_link_wrapper"><a class="scs_viewyourcart_link" href="<?php  echo $myPage->getConfig('viewcarthref'); ?>">View Your Cart</a></span></span><div id="scs_cartsummary_content"><p>There are no items in your cart.</p></div><?php } else { ?><div id="scs_cartsummary_content"><p>You have <?php echo $myPage->getCartCount(); ?> items in your cart</p></div><span class="scs_viewyourcart_link_wrapper"><a class="scs_viewyourcart_link" href="<?php  echo $myPage->getConfig('viewcarthref'); ?>">View Your Cart</a></span><?php } ?></div></div><?php } else { ?><span id="scs_cartsummary_catalog"><div id="scs_cartsummary_wrapper"><div id="scs_cartsummary"><?php
    
    if ( 
    strval($myPage->getCartCount()) =='0' ) 
    { ?><span style="visibility:hidden;"><span class="scs_viewyourcart_link_wrapper"><a class="scs_viewyourcart_link" href="<?php  echo $myPage->getConfig('viewcarthref'); ?>">View Your Cart</a></span></span><div id="scs_cartsummary_content"><p>There are no items in your cart.</p></div><?php } else { ?><div id="scs_cartsummary_content"><p>You have <?php echo $myPage->getCartCount(); ?> items in your cart</p></div><span class="scs_viewyourcart_link_wrapper"><a class="scs_viewyourcart_link" href="<?php  echo $myPage->getConfig('viewcarthref'); ?>">View Your Cart</a></span><?php } ?></div></div></span><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div><div id="scs_content_area_wrapper"><div id="scs_content_area_inner_wrapper"><div id="scs_content_area"><div id="scs_subheader_wrapper"><div id="scs_subheader_inner_wrapper"><div id="scs_subheader"><h2 id="scs_subheader_title"><?php
        echo $currentpage_headertext;
      ?></h2></div></div></div><div id="scs_content_wrapper"><div id="scs_content_inner_wrapper"><div id="scs_content"><?php
    
    if ( 
    $myPage->getCartMessage() ) 
    { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages"><div id="scs_cartmessages_content"><?php echo $myPage->getCartMessage(); ?></div></div></div><?php } else { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages" style="display:none"><div id="scs_cartmessages_content">&#160;</div></div></div><?php } ?><?php
    
    if ( 
    $currentpage_content ) 
    { ?><div id="scs_staticcontent_wrapper"><div id="scs_staticcontent"><div id="scs_staticcontent_content"><?php
        echo $currentpage_content;
      ?></div></div></div><?php } ?><div id="scs_categorieslist"><?php

    foreach($myPage->getCategoryGroups() as  
          $group )
    {
    ?><?php
        $group = $myPage->getGroup($group);
        $group_id = $group['groupid'];
        $group_products =& $myPage->getCategoryProducts($group_id);
      
    $group_name = $group['name'];
    $group_metakeywords = $group['metakeywords'];
    $group_metadescription = $group['metadescription'];

    $group_pagehref =  $group['pagehref'];
    $group_productscount = strval( count( $group_products ) );
    $group_iteration = 0;
    
    $group_parentid = $group['parentid'];
    $group_parentname = $group['parentname'];
    $group_parenthref = $group['parenthref'];
    $group_image = $group['image'];
    $group_imageisset = $group['imageisset'];
    $group_tileimage = $group['tileimage'];
    $group_image = $group['image'];
    $group_content = $group['content'];

    $group_subgroupsids = $group['subgroupsIds'];
    $group_subgroupscount =  strval( count( $group_subgroupsids ) );
    
  ?><?php
    
    if ( 
    $group_parentid =='-1' ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('showcategorycategorydetails') ) 
    { ?><div class="scs_category_section_header_wrapper"><div class="scs_category_section_header"><div class="scs_categorieslist_item_inner_wrapper"><a class="scs_categorieslist_link" href="<?php
        echo $group_pagehref;
      ?>"><?php
        echo $group_name;
      ?></a></div></div></div><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><div class="scs_categorydetails_wrapper"><div class="scs_categorydetails"><?php
    
    if ( 
    $group_imageisset ) 
    { ?><img class="scs_categorydetails_image" src="<?php
        echo $group_image;
      ?>" alt="<?php
        echo $group_name;
      ?> Image" /><?php } ?><?php
    
    if ( 
    $group_content ) 
    { ?><div class="scs_categorydetails_content"><?php
        echo $group_content;
      ?></div><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div><?php } ?><?php } ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('showcategorysubcategory') ) 
    { ?><?php
    
    if ( 
    $group_subgroupscount!='0' ) 
    { ?><div class="scs_category_section_header_wrapper"><div class="scs_category_section_header"><div class="scs_categorieslist_item_sublevel"><div class="scs_categorieslist_link_sublevel_wrapper"><div class="scs_categorieslist_link_sublevel"><a class="scs_categorieslist_link" href="<?php
        echo $group_pagehref;
      ?>">Categories in <?php
        echo $group_name;
      ?></a></div></div></div></div></div><div id="scs_subcategory_tiles"><?php

    foreach($myPage->getSubGroups($group_id) as  
          $subgrp )
    {
    ?><?php
        $subgrp_id = $subgrp['groupid'];
        $subgrp_products =& $myPage->getProductsByGroup($subgrp_id);
      
    $subgrp_name = $subgrp['name'];
    $subgrp_metakeywords = $subgrp['metakeywords'];
    $subgrp_metadescription = $subgrp['metadescription'];

    $subgrp_pagehref =  $subgrp['pagehref'];
    $subgrp_productscount = strval( count( $subgrp_products ) );
    $subgrp_iteration = 0;
    
    $subgrp_parentid = $subgrp['parentid'];
    $subgrp_parentname = $subgrp['parentname'];
    $subgrp_parenthref = $subgrp['parenthref'];
    $subgrp_image = $subgrp['image'];
    $subgrp_imageisset = $subgrp['imageisset'];
    $subgrp_tileimage = $subgrp['tileimage'];
    $subgrp_image = $subgrp['image'];
    $subgrp_content = $subgrp['content'];

    $subgrp_subgroupsids = $subgrp['subgroupsIds'];
    $subgrp_subgroupscount =  strval( count( $subgrp_subgroupsids ) );
    
  ?><div class="scs_subcategory_tiles_item"><div class="scs_subcategory_tiles_item_title"><?php
    
    if ( 
    $subgrp_name ) 
    { ?><a href="<?php
        echo $subgrp_pagehref;
      ?>"><?php
        echo $subgrp_name;
      ?></a><?php } else { ?>&#160;<?php } ?></div><?php
    
    if ( 
    $subgrp_imageisset ) 
    { ?><div class="scs_subcategory_thumbnail_wrapper"><a class="scs_subcategory_thumbnail_link" href="<?php
        echo $subgrp_pagehref;
      ?>"><img class="scs_subcategory_thumbnail_image" src="<?php
        echo $subgrp_tileimage;
      ?>" alt="<?php
        echo $subgrp_name;
      ?> Image" /></a></div><?php } ?></div><?php } ?><span class="scs_sdkworkaround">&#160;</span></div><?php } ?><?php } ?><?php } ?><?php
    
    if ( 
    $myPage->getConfig('showcategoryproducts') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><div class="scs_category_section_header_wrapper"><div class="scs_category_section_header"><div class="scs_categorieslist_item_sublevel"><div class="scs_categorieslist_link_sublevel_wrapper"><div class="scs_categorieslist_link_sublevel"><a class="scs_categorieslist_link" href="<?php
        echo $group_pagehref;
      ?>">Products in <?php
        echo $group_name;
      ?></a></div></div></div></div></div><?php } ?><div class="scs_productlist"><?php

    foreach($group_products as  
          $product )
    {
    ?><?php
        $fooProduct = & $myPage->getProduct($product['productid']);
        $product_group = & $myPage->getGroup( $product['groupid'] );
        $fooCartId = $product['cartid'];
        $product_cartid = $fooCartId;
      

      
      $fooProductId = $fooProduct['productid'];
      $fooGroupId =  $fooProduct['groupid'];
      $fooOption1 = 'option1Sel_'.$fooProductId;
      $fooOption2 = 'option2Sel_'.$fooProductId;
      $fooQuantity = 'quantitySel_'.$fooProductId;
      $product_id = $fooProductId;
      $product_groupid =  $fooGroupId;
      $product_name =  $fooProduct['name'];
      $product_shortdescr =  $fooProduct['shortdescription'];
      $product_longdescr =  $fooProduct['longdescription'];

      $product_metakeywords =  $fooProduct['metakeywords'];
      $product_metadescription =  $fooProduct['metadescription'];

      $product_isstarred = $fooProduct['isstarred'];
      $product_showincategory = $fooProduct['showincategory'];
      $product_refcode =$fooProduct['refcode'];
      $product_yourprice =$fooProduct['yourprice'];
      $product_ispercent = $fooProduct['ispercentage'];
      $product_price = $fooProduct['retailprice'];
      $product_discount = $fooProduct['discount'];
      $product_tax = $fooProduct['tax'];
      $product_shipping = $fooProduct['shipping'];
      $product_handling = $fooProduct['handling'];
      $product_quantitytype =$fooProduct['typequantity'];
      $product_quantitydefault = $fooProduct['quantity'];
      $product_quantitymin = $fooProduct['minrangequantity'];
      $product_quantitymax = $fooProduct['maxrangequantity'];
      $product_imagefull = $fooProduct['main_full'];
      $product_imagesmall = $fooProduct['main_small'];
      $product_imagethumbscount = strval( count( $fooProduct['thumbs'] ) );
      $product_imagethumbs = $fooProduct['thumbs'];

      $product_options = $fooProduct['options'];
      $product_forceoptions = $fooProduct['forceoptions'];

      $product_pagehref = $fooProduct['pagehref'];
      $product_weight = $fooProduct['weight'];
      $product_weightdigits = $fooProduct['weightdigits'];
      $product_weightunit = $fooProduct['weightunits'];
      $product_showweight = $fooProduct['showweight'];

      $product_iteration = 0;
      $product_quantityid = $fooQuantity;

      $product_stock = $fooProduct['stock'];
      $product_showstock = $fooProduct['showstock'];

    
      ?><div class="scs_productlist_item"><div class="scs_thumbnail_wrapper"><a href="<?php
        echo $product_pagehref;
      ?>"><img class="scs_thumbnail_image" src="<?php
        echo $product_imagesmall;
      ?>" alt="<?php
        echo $product_name;
      ?> Image" /></a></div><div class="scs_buy_info_wrapper"><?php
    
    if ( 
    $myPage->getConfig('showprice') ) 
    { ?><div class="scs_prices_wrapper"><?php
    
    if ( 
    $product_price == $product_yourprice ) 
    { ?><div class="scs_price"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_yourprice;
      ?></div><?php } else { ?><div class="scs_price_discounted"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_yourprice;
      ?></div><div class="scs_price_list"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_price;
      ?></div><?php } ?></div><?php } ?><?php
    
    if ( 
    $myPage->getConfig('showaddcart') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><?php
    
    if ( 
    $product_stock!='0' ) 
    { ?><?php
    
    if ( 
    $product_forceoptions ) 
    { ?><div class="scs_viewdetails_wrapper"><form action="<?php
        echo $product_pagehref;
      ?>" class="buylink"><p><input type="hidden" name="productid" value="<?php
        echo $product_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $product_groupid;
      ?>" /><input type="submit" value="View Details" class="scs_viewdetails"/></p></form></div><?php } else { ?><div class="scs_addtocart_wrapper"><form action="<?php echo $myPage->getUrl(); ?>" method="post" class="buylink"><p><input type="hidden" name="method" value="add" /><input type="hidden" name="productid" value="<?php
        echo $product_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $product_groupid;
      ?>" /><input type="submit" value="Add to Cart" class="scs_addtocart" /></p></form></div><?php } ?><?php } else { ?><div class="scs_stocksold_wrapper"><div class="scs_stocksold"><span class="scs_sdkworkaround">&#160;</span></div></div><?php } ?><?php } else { ?><?php
    
    if ( 
    $product_forceoptions ) 
    { ?><div class="scs_viewdetails_wrapper"><form action="<?php
        echo $product_pagehref;
      ?>" class="buylink"><p><input type="hidden" name="productid" value="<?php
        echo $product_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $product_groupid;
      ?>" /><input type="submit" value="View Details" class="scs_viewdetails"/></p></form></div><?php } else { ?><div class="scs_addtocart_wrapper"><form action="<?php echo $myPage->getUrl(); ?>" method="post" class="buylink"><p><input type="hidden" name="method" value="add" /><input type="hidden" name="productid" value="<?php
        echo $product_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $product_groupid;
      ?>" /><input type="submit" value="Add to Cart" class="scs_addtocart" /></p></form></div><?php } ?><?php } ?><?php } else { ?><span class="scs_sdkworkaround">&#160;</span><?php } ?></div><div class="scs_product_text_wrapper"><p><?php
    
    if ( 
    $product_name ) 
    { ?><a href="<?php
        echo $product_pagehref;
      ?>" class="scs_product_title_link"><?php
        echo $product_name;
      ?></a><?php } ?><?php
    
    if ( 
    $product_shortdescr ) 
    { ?><br /><span class="scs_product_shortdescription"><?php
        echo $product_shortdescr;
      ?></span><?php } ?></p></div></div><?php } ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><!-- Loop through the prods of the subcategories --><?php

    foreach($myPage->getSubGroups($group_id) as  
          $subgrp )
    {
    ?><?php
        $subgrp_id = $subgrp['groupid'];
        $subgrp_products =& $myPage->getProductsByGroup($subgrp_id);
      
    $subgrp_name = $subgrp['name'];
    $subgrp_metakeywords = $subgrp['metakeywords'];
    $subgrp_metadescription = $subgrp['metadescription'];

    $subgrp_pagehref =  $subgrp['pagehref'];
    $subgrp_productscount = strval( count( $subgrp_products ) );
    $subgrp_iteration = 0;
    
    $subgrp_parentid = $subgrp['parentid'];
    $subgrp_parentname = $subgrp['parentname'];
    $subgrp_parenthref = $subgrp['parenthref'];
    $subgrp_image = $subgrp['image'];
    $subgrp_imageisset = $subgrp['imageisset'];
    $subgrp_tileimage = $subgrp['tileimage'];
    $subgrp_image = $subgrp['image'];
    $subgrp_content = $subgrp['content'];

    $subgrp_subgroupsids = $subgrp['subgroupsIds'];
    $subgrp_subgroupscount =  strval( count( $subgrp_subgroupsids ) );
    
  ?><?php

    foreach($subgrp_products as  
          $subproduct )
    {
    ?><?php
        $fooProduct = & $myPage->getProduct($subproduct['productid']);
        $subproduct_group = & $myPage->getGroup( $subproduct['groupid'] );
        $fooCartId = $subproduct['cartid'];
        $subproduct_cartid = $fooCartId;
      

      
      $fooProductId = $fooProduct['productid'];
      $fooGroupId =  $fooProduct['groupid'];
      $fooOption1 = 'option1Sel_'.$fooProductId;
      $fooOption2 = 'option2Sel_'.$fooProductId;
      $fooQuantity = 'quantitySel_'.$fooProductId;
      $subproduct_id = $fooProductId;
      $subproduct_groupid =  $fooGroupId;
      $subproduct_name =  $fooProduct['name'];
      $subproduct_shortdescr =  $fooProduct['shortdescription'];
      $subproduct_longdescr =  $fooProduct['longdescription'];

      $subproduct_metakeywords =  $fooProduct['metakeywords'];
      $subproduct_metadescription =  $fooProduct['metadescription'];

      $subproduct_isstarred = $fooProduct['isstarred'];
      $subproduct_showincategory = $fooProduct['showincategory'];
      $subproduct_refcode =$fooProduct['refcode'];
      $subproduct_yourprice =$fooProduct['yourprice'];
      $subproduct_ispercent = $fooProduct['ispercentage'];
      $subproduct_price = $fooProduct['retailprice'];
      $subproduct_discount = $fooProduct['discount'];
      $subproduct_tax = $fooProduct['tax'];
      $subproduct_shipping = $fooProduct['shipping'];
      $subproduct_handling = $fooProduct['handling'];
      $subproduct_quantitytype =$fooProduct['typequantity'];
      $subproduct_quantitydefault = $fooProduct['quantity'];
      $subproduct_quantitymin = $fooProduct['minrangequantity'];
      $subproduct_quantitymax = $fooProduct['maxrangequantity'];
      $subproduct_imagefull = $fooProduct['main_full'];
      $subproduct_imagesmall = $fooProduct['main_small'];
      $subproduct_imagethumbscount = strval( count( $fooProduct['thumbs'] ) );
      $subproduct_imagethumbs = $fooProduct['thumbs'];

      $subproduct_options = $fooProduct['options'];
      $subproduct_forceoptions = $fooProduct['forceoptions'];

      $subproduct_pagehref = $fooProduct['pagehref'];
      $subproduct_weight = $fooProduct['weight'];
      $subproduct_weightdigits = $fooProduct['weightdigits'];
      $subproduct_weightunit = $fooProduct['weightunits'];
      $subproduct_showweight = $fooProduct['showweight'];

      $subproduct_iteration = 0;
      $subproduct_quantityid = $fooQuantity;

      $subproduct_stock = $fooProduct['stock'];
      $subproduct_showstock = $fooProduct['showstock'];

    
      ?><?php
    
    if ( 
    $subproduct_showincategory ) 
    { ?><div class="scs_productlist_item"><div class="scs_thumbnail_wrapper"><a href="<?php
        echo $subproduct_pagehref;
      ?>"><img class="scs_thumbnail_image" src="<?php
        echo $subproduct_imagesmall;
      ?>" alt="<?php
        echo $subproduct_name;
      ?> Image" /></a></div><div class="scs_buy_info_wrapper"><?php
    
    if ( 
    $myPage->getConfig('showprice') ) 
    { ?><div class="scs_prices_wrapper"><?php
    
    if ( 
    $subproduct_price == $subproduct_yourprice ) 
    { ?><div class="scs_price"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $subproduct_yourprice;
      ?></div><?php } else { ?><div class="scs_price_discounted"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $subproduct_yourprice;
      ?></div><div class="scs_price_list"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $subproduct_price;
      ?></div><?php } ?></div><?php } ?><?php
    
    if ( 
    $myPage->getConfig('showaddcart') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><?php
    
    if ( 
    $subproduct_stock!='0' ) 
    { ?><?php
    
    if ( 
    $subproduct_forceoptions ) 
    { ?><div class="scs_viewdetails_wrapper"><form action="<?php
        echo $subproduct_pagehref;
      ?>" class="buylink"><p><input type="hidden" name="productid" value="<?php
        echo $subproduct_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $subproduct_groupid;
      ?>" /><input type="submit" value="View Details" class="scs_viewdetails"/></p></form></div><?php } else { ?><div class="scs_addtocart_wrapper"><form action="<?php echo $myPage->getUrl(); ?>" method="post" class="buylink"><p><input type="hidden" name="method" value="add" /><input type="hidden" name="productid" value="<?php
        echo $subproduct_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $subproduct_groupid;
      ?>" /><input type="submit" value="Add to Cart" class="scs_addtocart" /></p></form></div><?php } ?><?php } else { ?><div class="scs_stocksold_wrapper"><div class="scs_stocksold"><span class="scs_sdkworkaround">&#160;</span></div></div><?php } ?><?php } else { ?><?php
    
    if ( 
    $subproduct_forceoptions ) 
    { ?><div class="scs_addtocart_wrapper"><form action="<?php
        echo $subproduct_pagehref;
      ?>" class="buylink"><p><input type="hidden" name="productid" value="<?php
        echo $subproduct_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $subproduct_groupid;
      ?>" /><input type="submit" value="View Details" class="scs_viewdetails"/></p></form></div><?php } else { ?><div class="scs_addtocart_wrapper"><form action="<?php echo $myPage->getUrl(); ?>" method="post" class="buylink"><p><input type="hidden" name="method" value="add" /><input type="hidden" name="productid" value="<?php
        echo $subproduct_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $subproduct_groupid;
      ?>" /><input type="submit" value="Add to Cart" class="scs_addtocart" /></p></form></div><?php } ?><?php } ?><?php } else { ?><span class="scs_sdkworkaround">&#160;</span><?php } ?></div><div class="scs_product_text_wrapper"><p><?php
    
    if ( 
    $subproduct_name ) 
    { ?><a href="<?php
        echo $subproduct_pagehref;
      ?>" class="scs_product_title_link"><?php
        echo $subproduct_name;
      ?></a><?php } ?><?php
    
    if ( 
    $subproduct_shortdescr ) 
    { ?><br /><span class="scs_product_shortdescription"><?php
        echo $subproduct_shortdescr;
      ?></span><?php } ?></p></div></div><?php } ?><?php } ?><?php } ?><?php } ?><span class="scs_sdkworkaround">&#160;</span></div><?php } ?><?php } ?><?php } ?></div></div></div></div></div></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div><div id="scs_footer_area_wrapper"><div id="scs_footer_area_inner_wrapper"><div id="scs_footer_area"><div id="scs_footer_wrapper"><div id="scs_footer_inner_wrapper"><div id="scs_footer"><div class="scs_flat_navmenu"><?php
    
    if ( 
    $myPage->getConfig('websitehref') ) 
    { ?><?php

    foreach($myPage->getPages() as  
          $firstpage )
    {
    ?><?php
    
    $firstpage_id = $firstpage['id'];
    $firstpage_name = $firstpage['name'];
    $firstpage_pagehref = $firstpage['pagehref'];
    $firstpage_metadescription = $firstpage['metadescription'];
    $firstpage_metakeywords = $firstpage['metakeywords'];
    $firstpage_type = $firstpage['type'];
    $firstpage_content = $firstpage['content'];
    $firstpage_headertext = $firstpage['headertext'];
    ?><?php
    
    if ( 
    $firstpage_type =='home' ) 
    { ?><a href="<?php  echo $myPage->getConfig('websitehref'); ?>"><?php
        echo $firstpage_name;
      ?></a><?php } ?><?php } ?><?php

    foreach($myPage->getPages() as  
          $page )
    {
    ?><?php
    
    $page_id = $page['id'];
    $page_name = $page['name'];
    $page_pagehref = $page['pagehref'];
    $page_metadescription = $page['metadescription'];
    $page_metakeywords = $page['metakeywords'];
    $page_type = $page['type'];
    $page_content = $page['content'];
    $page_headertext = $page['headertext'];
    ?><?php
    
    if ( 
    $page_type!='home' ) 
    { ?>&#160;|&#160;<a href="<?php
        echo $page_pagehref;
      ?>"><?php
        echo $page_name;
      ?></a><?php } ?><?php } ?><?php } else { ?><?php

    foreach($myPage->getPages() as  
          $firstpage )
    {
    ?><?php
    
    $firstpage_id = $firstpage['id'];
    $firstpage_name = $firstpage['name'];
    $firstpage_pagehref = $firstpage['pagehref'];
    $firstpage_metadescription = $firstpage['metadescription'];
    $firstpage_metakeywords = $firstpage['metakeywords'];
    $firstpage_type = $firstpage['type'];
    $firstpage_content = $firstpage['content'];
    $firstpage_headertext = $firstpage['headertext'];
    ?><?php
    
    if ( 
    $firstpage_type =='shophome' ) 
    { ?><a href="<?php
        echo $firstpage_pagehref;
      ?>"><?php
        echo $firstpage_name;
      ?></a><?php } ?><?php } ?><?php

    foreach($myPage->getPages() as  
          $page )
    {
    ?><?php
    
    $page_id = $page['id'];
    $page_name = $page['name'];
    $page_pagehref = $page['pagehref'];
    $page_metadescription = $page['metadescription'];
    $page_metakeywords = $page['metakeywords'];
    $page_type = $page['type'];
    $page_content = $page['content'];
    $page_headertext = $page['headertext'];
    ?><?php
    
    if ( 
    $page_type!='shophome' ) 
    { ?><?php
    
    if ( 
    $page_type!='home' ) 
    { ?>&#160;|&#160;<a href="<?php
        echo $page_pagehref;
      ?>"><?php
        echo $page_name;
      ?></a><?php } ?><?php } ?><?php } ?><?php } ?></div><?php
    
    if ( 
    $myPage->getConfig('shopfooter') ) 
    { ?><div id="scs_footercontent_wrapper"><div id="scs_footercontent"><div id="scs_footercontent_content"><?php  echo $myPage->getConfig('shopfooter'); ?></div></div></div><?php } ?><?php
    
    if ( 
    $myPage->getConfig('copyright') ) 
    { ?><p class="scs_branding"><?php  echo $myPage->getConfig('copyright'); ?></p><?php } ?></div></div></div></div></div><!-- Image to be displayed for the ajax requests --><img id="ajax_waiting_spinner" alt="spinner" src="ccdata/images/spinner.gif" style="display: none; position: fixed; top: 50%; left: 50%; "/></div></body></html>