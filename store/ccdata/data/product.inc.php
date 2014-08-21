<?php /** @version $Revision: 4296$ */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><?php?><html xmlns="http://www.w3.org/1999/xhtml"><?php
        $fooProduct = & $myPage->getProduct( $_GET['productid']);
        $product_group = & $myPage->getGroup( $_GET['groupid'] );
        $product_cartid = $_GET['cartid'];
    

      
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

    
      ?><head><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><title><?php  echo $myPage->getConfig('shopname'); ?><?php
    
    if ( 
    $product_name ) 
    { ?> - <?php
        echo $product_name;
      ?><?php } ?></title><?php } else { ?><?php
    
    if ( 
    $product_name ) 
    { ?><title><?php
        echo $product_name;
      ?></title><?php } ?><?php } ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="description" content="<?php
        echo $product_metadescription;
      ?>" /><meta name="keywords" content="<?php
        echo $product_metakeywords;
      ?>" /><meta name="generator" content="CoffeeCup Shopping Cart Creator, <?php  echo $myPage->getConfig('sccversion'); ?>" /><meta http-equiv="generator" content="CoffeeCup Shopping Cart Creator (www.coffeecup.com)" /><meta name="revised" content="<?php  echo $myPage->getConfig('timestamp'); ?>" /><link rel="stylesheet" type="text/css" media="all" href="css/default.css" /><link rel="stylesheet" type="text/css" media="screen" href="css/colorbox.css" /><!-- styler.css must be the last one. --><link rel="stylesheet" type="text/css" media="all" href="css/styler.css" /><!-- Remember that shop header must include css/default_ie.css in an IE 7 conditional comment --><!-- Remember that shop header must include jquery.js --><?php echo $myPage->getConfig('shophtmlheader');?><script type="text/javascript" src="js/external_links.js">/**/</script></head><body id="scs_productdetails_page"><div id="scs_header_area_wrapper"><div id="scs_header_area_inner_wrapper"><div id="scs_header_area"><div id="scs_header_wrapper"><div id="scs_header_inner_wrapper"><div id="scs_header"><?php
    
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
    { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><?php
    
    if ( 
     !  (  $myPage->getConfig('staticpageshome') )  ) 
    { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><div class="scs_navmenu_item_with_submenu"><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

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
    { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><?php
    
    if ( 
    $myPage->getConfig('staticpageshome') ) 
    { ?><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><?php } else { ?><div class="scs_navmenu_item_with_submenu"><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

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
    { ?><li class="scs_cart_item"><div class="scs_navmenu_item_inner_wrapper"><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a></div></li><?php } ?><?php
    
    if ( 
    $page_type =='category' ) 
    { ?><li class="scs_categories_item"><div class="scs_navmenu_item_inner_wrapper"><div class="scs_navmenu_item_with_submenu"><a href="<?php
        echo $page_pagehref;
      ?>"><span class="scs_navmenu_item_icon_wrapper"><span class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></span></span></a><div class="scs_navsubmenu_wrapper"><div class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

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
    
    if ( 
    $product_name ) 
    { ?><?php
        echo $product_name;
      ?><?php } else { ?><span class="scs_sdkworkaround">&#160;</span><?php } ?></h2></div></div></div><div id="scs_content_wrapper"><div id="scs_content_inner_wrapper"><div id="scs_content"><?php
    
    if ( 
    $myPage->getCartMessage() ) 
    { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages"><div id="scs_cartmessages_content"><?php echo $myPage->getCartMessage(); ?></div></div></div><?php } else { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages" style="display:none"><div id="scs_cartmessages_content">&#160;</div></div></div><?php } ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><div id="scs_breadcrumbs_wrapper"><div id="scs_breadcrumbs"><span class="scs_text">You are here: </span><?php

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
    $page_type =='shophome' ) 
    { ?><a href="<?php
        echo $page_pagehref;
      ?>"><?php
        echo $page_name;
      ?></a><span class="scs_text"> &gt;&gt; </span><?php } ?><?php } ?><?php

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
    $page_type =='category' ) 
    { ?><a href="<?php
        echo $page_pagehref;
      ?>"><?php
        echo $page_name;
      ?></a><span class="scs_text"> &gt;&gt; </span><?php } ?><?php } ?><?php

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
    $group_id == $product_groupid ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><?php
    
    if ( 
    $group_parentid!='-1' ) 
    { ?><a href="<?php
        echo $group_parenthref;
      ?>"><?php
        echo $group_parentname;
      ?></a><span class="scs_text"> &gt;&gt; </span><?php } ?><?php } ?><a href="<?php
        echo $group_pagehref;
      ?>"><?php
        echo $group_name;
      ?></a><span class="scs_text"> &gt;&gt; </span><?php } ?><?php } ?><a href="<?php
        echo $product_pagehref;
      ?>"><?php
        echo $product_name;
      ?></a></div></div><?php } ?><div id="scs_productdetails"><div id="scs_productdetails_images"><a href="<?php
        echo $product_imagefull;
      ?>" id="scs_productdetails_imagefull_link" class="colorbox_scc" rel="detail-images"><img id="scs_productdetails_imagefull" src="<?php
        echo $product_imagesmall;
      ?>" alt="<?php
        echo $product_name;
      ?> Image" /></a><?php
    
    if ( 
    $product_imagethumbscount ) 
    { ?><div id="scs_productdetails_thumbnails"><?php

    foreach($product_imagethumbs as  
          $thumb )
    {
    ?><?php
    $thumb_full = $thumb['full'];
    $thumb_small = $thumb['small'];
 ?><div class="scs_thumbnail_wrapper" ><a href="<?php
        echo $thumb_full;
      ?>" class="colorbox_scc" rel="detail-images"><img class="scs_thumbnail" src="<?php
        echo $thumb_small;
      ?>" alt="Detail Image" /></a></div><?php } ?></div><?php } ?></div><div id="scs_productdetails_info_wrapper"><div id="scs_productdetails_info"><?php
    
    if ( 
    $product_longdescr ) 
    { ?><p><?php
        echo $product_longdescr;
      ?></p><?php } ?><form action="<?php echo $myPage->getUrl(); ?>" method="post"><table><?php
    
    if ( 
    $myPage->getConfig('showprice') ) 
    { ?><?php
    
    if ( 
    $product_price!= $product_yourprice ) 
    { ?><tr><td class="scs_label">List Price:</td><td class="scs_price_list"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_price;
      ?></td></tr><?php } ?><tr><td class="scs_label">Your Price:</td><td><span class="scs_yourprice"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_yourprice;
      ?></span><?php
    
    if ( 
    $product_price!= $product_yourprice ) 
    { ?><span class="scs_discount">&#160;(You save <?php
    
    if ( 
     !  (  $product_ispercent )  ) 
    { ?><?php  echo $myPage->getConfig('currencysymbol'); ?><?php } ?><?php
        echo $product_discount;
      ?><?php
    
    if ( 
    $product_ispercent ) 
    { ?>%<?php } ?>)</span><?php } ?></td></tr><?php } ?><?php

    foreach($product_options as  $option_key => $option )
    {
    ?><?php
    $option_name = 'opt_'.$option_key;
    $option_label = $option['name'];
    $option_count = strval( count( $option ) );
    $option_id = 'option'.$option_key.'Sel_'.$fooProductId;
    $option_optionsitems = $option['items'];
    ?><tr><td class="scs_label"><label for="<?php
        echo $option_name;
      ?>"><?php
        echo $option_label;
      ?>:</label></td><td class="scs_option"><?php
    
    if ( 
    $myPage->getConfig('showaddcart') ) 
    { ?><select id="<?php
        echo $option_name;
      ?>" name="<?php
        echo $option_name;
      ?>"><?php
    
    if ( 
    $product_forceoptions ) 
    { ?><option value="-1">Choose One</option><?php } ?><?php

    foreach($option_optionsitems as  $optionitem_key => $optionitem )
    {
    ?><?php
    $fooValue = $optionitem['value'];
    $fooSelect = $optionitem['selected'];
    $optionitem_label = $optionitem['label'];
    $optionitem_extraprice = formatMoney($optionitem['price'],100);
    $optionitem_value = $fooValue.( $fooSelect == 1 ? '" selected="selected' : '' );
    ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><option value="<?php
        echo $optionitem_value;
      ?>"><?php
        echo $optionitem_label;
      ?><?php
    
    if ( 
    $myPage->getConfig('showprice') ) 
    { ?><?php
    
    if ( 
    $optionitem_extraprice!='0.00' ) 
    { ?>&#160;(+<?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $optionitem_extraprice;
      ?>)<?php } ?><?php } ?></option><?php } else { ?><option value="<?php
        echo $optionitem_value;
      ?>"><?php
        echo $optionitem_label;
      ?></option><?php } ?><?php } ?></select><?php } else { ?><ul><?php

    foreach($option_optionsitems as  $optionitem_key => $optionitem )
    {
    ?><?php
    $fooValue = $optionitem['value'];
    $fooSelect = $optionitem['selected'];
    $optionitem_label = $optionitem['label'];
    $optionitem_extraprice = formatMoney($optionitem['price'],100);
    $optionitem_value = $fooValue.( $fooSelect == 1 ? '" selected="selected' : '' );
    ?><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><li class="scs_catalog_option"><?php
        echo $optionitem_label;
      ?><?php
    
    if ( 
    $myPage->getConfig('showprice') ) 
    { ?><?php
    
    if ( 
    $optionitem_extraprice!='0.00' ) 
    { ?>&#160;(+<?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $optionitem_extraprice;
      ?>)<?php } ?><?php } ?></li><?php } else { ?><li class="scs_catalog_option"><?php
        echo $optionitem_label;
      ?></li><?php } ?><?php } ?></ul><?php } ?></td></tr><?php } ?><?php
    
    if ( 
    $product_showweight ) 
    { ?><tr><td class="scs_label">Weight:</td><td class="scs_weight"><?php
        echo $product_weight;
      ?> <?php
        echo $product_weightunit;
      ?></td></tr><?php } ?><?php
    
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
    $product_showstock ) 
    { ?><tr><td class="scs_label"><label>Stock:</label></td><td class="scs_stock_number"><?php
        echo $product_stock;
      ?></td></tr><?php } ?><tr><td class="scs_label"><label>Quantity:</label></td><td class="scs_quantity"><?php
    
    if ( 
    $product_quantitytype =='default_quantity' ) 
    { ?><?php
        echo $product_quantitydefault;
      ?><?php } ?><?php
    
    if ( 
    $product_quantitytype =='range_quantity' ) 
    { ?><span class="scs_beforeinput_text">Choose from&#160;<?php
        echo $product_quantitymin;
      ?>&#160;to&#160;<?php
        echo $product_quantitymax;
      ?>: </span><input type="text" value="<?php
        echo $product_quantitymin;
      ?>" id="quantity" name="quantity" /><?php } ?><?php
    
    if ( 
    $product_quantitytype =='choose_quantity' ) 
    { ?><input type="text" value="<?php
        echo $product_quantitydefault;
      ?>" id="quantity" name="quantity" /><?php } ?></td></tr><?php } ?><?php } else { ?><tr><td class="scs_label"><label>Quantity:</label></td><td class="scs_quantity"><?php
    
    if ( 
    $product_quantitytype =='default_quantity' ) 
    { ?><?php
        echo $product_quantitydefault;
      ?><?php } ?><?php
    
    if ( 
    $product_quantitytype =='range_quantity' ) 
    { ?>Choose from&#160;<?php
        echo $product_quantitymin;
      ?>&#160;to&#160;<?php
        echo $product_quantitymax;
      ?>:<input type="text" value="<?php
        echo $product_quantitymin;
      ?>" id="quantity" name="quantity" /><?php } ?><?php
    
    if ( 
    $product_quantitytype =='choose_quantity' ) 
    { ?><input type="text" value="<?php
        echo $product_quantitydefault;
      ?>" id="quantity" name="quantity" /><?php } ?></td></tr><?php } ?><?php } else { ?><tr><td class="scs_label"><span class="scs_sdkworkaround">&#160;</span></td><td class="scs_quantity"><span class="scs_sdkworkaround">&#160;</span></td></tr><?php } ?></table><?php
    
    if ( 
    $myPage->getConfig('showaddcart') ) 
    { ?><p><input type="hidden" name="method" value="add" /><input type="hidden" name="productid" value="<?php
        echo $product_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $product_groupid;
      ?>" /><input type="hidden" name="cartid" value="<?php
        echo $product_cartid;
      ?>" /><?php
    
    if ( 
    $myPage->getConfig('ispro') ) 
    { ?><?php
    
    if ( 
    $product_stock!='0' ) 
    { ?><span class="scs_addtocart_wrapper"><input type="submit" value="Add to Cart" class="scs_addtocart" /></span><?php } else { ?><span class="scs_stocksold_wrapper"><span class="scs_stocksold"><span class="scs_sdkworkaround">&#160;</span></span></span><?php } ?><?php } else { ?><span class="scs_addtocart_wrapper"><input type="submit" value="Add to Cart" class="scs_addtocart" /></span><?php } ?></p><?php } ?></form></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div></div></div></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div><div id="scs_footer_area_wrapper"><div id="scs_footer_area_inner_wrapper"><div id="scs_footer_area"><div id="scs_footer_wrapper"><div id="scs_footer_inner_wrapper"><div id="scs_footer"><div class="scs_flat_navmenu"><?php
    
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