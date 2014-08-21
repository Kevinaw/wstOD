<?php /** @version $Revision: 4296$ */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><?php
        $checkout_step1 = '1';
        $checkout_step2 = '0';
        $checkout_step3 = '0';
      
        $pageID = 3;
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
      ?>" /><meta name="generator" content="CoffeeCup Shopping Cart Creator, <?php  echo $myPage->getConfig('sccversion'); ?>" /><meta http-equiv="generator" content="CoffeeCup Shopping Cart Creator (www.coffeecup.com)" /><meta name="revised" content="<?php  echo $myPage->getConfig('timestamp'); ?>" /><link rel="stylesheet" type="text/css" media="all" href="css/default.css" /><link rel="stylesheet" type="text/css" media="screen" href="css/colorbox.css" /><!-- styler.css must be the last one. --><link rel="stylesheet" type="text/css" media="all" href="css/styler.css" /><!-- Remember that shop header must include css/default_ie.css in an IE 7 conditional comment --><!-- Remember that shop header must include jquery.js --><?php echo $myPage->getConfig('shophtmlheader');?><script type="text/javascript" src="js/external_links.js">/**/</script></head><body id="scs_cart_page"><div id="scs_header_area_wrapper"><div id="scs_header_area_inner_wrapper"><div id="scs_header_area"><div id="scs_header_wrapper"><div id="scs_header_inner_wrapper"><div id="scs_header"><?php
    
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
      ?></h2></div></div></div><div id="scs_content_wrapper"><div id="scs_content_inner_wrapper"><div id="scs_content"><div class="scs_printthispage_link_area"><div class="scs_printthispage_link_wrapper"><a class="scs_printthispage_link" href="#" onclick="window.print()">Print This Page</a></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div><?php
    
    if ( 
    $myPage->getCartMessage() ) 
    { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages"><div id="scs_cartmessages_content"><?php echo $myPage->getCartMessage(); ?></div></div></div><?php } else { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages" style="display:none"><div id="scs_cartmessages_content">&#160;</div></div></div><?php } ?><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><?php
    
    if ( 
    $currentpage_content ) 
    { ?><div id="scs_staticcontent_wrapper"><div id="scs_staticcontent"><div id="scs_staticcontent_content"><?php
        echo $currentpage_content;
      ?></div></div></div><?php } ?><?php } ?><?php
    
    if ( 
    strval($myPage->getCartCount()) =='0' ) 
    { ?><p id="scs_cart_no_items">There are no items in your cart.</p><?php } else { ?><div id="scs_cart_form_wrapper"><form action="<?php echo $myPage->getUrl(); ?>" method="post" class="cart"><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><div class="scs_cart_updatebutton_area"><div class="scs_cart_updatebutton_wrapper"><p id="scs_cart_update_text">You must update the cart after making changes.<input type="submit" name="recalculate" value="Update Cart" class="scs_cart_updatebutton" /></p></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div><?php } ?><table id="scs_cart"><tr class="scs_cart_headlines"><td class="scs_cart_headline_product" colspan="2">Product</td><td class="scs_cart_headline_options">Options</td><td class="scs_cart_headline_qty">Qty</td><td class="scs_cart_headline_price">Price</td><td class="scs_cart_headline_subtotal">Subtotal</td></tr><?php

    foreach($myPage->getCartProducts() as  
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

    
      

      $product_quantity = $myPage->cart->getUnitsOfProduct($fooCartId);
      $product_subtotal = $myPage->getCartSubtotalPriceProduct($fooCartId);
      $product_optionsselected =  $myPage->cart->getOptionsAsText($fooCartId);
      $product_optionshref = 'viewitem.php?groupid='.$fooGroupId.'&amp;productid='.$fooProductId.'&amp;cartid='.$fooCartId;
    ?><tr class="scs_cart_contents"><td class="scs_cart_product_container" colspan="2"><div class="scs_cart_product_image_wrapper"><div class="scs_cart_product_image_container"><img class="scs_cart_product_image" src="<?php
        echo $product_imagesmall;
      ?>" alt="<?php
        echo $product_name;
      ?> Image" /></div></div><div class="scs_cart_product_info_container"><div class="scs_cart_product_text_wrapper"><?php
    
    if ( 
    $product_name ) 
    { ?><span class="scs_cart_product_title"><?php
        echo $product_name;
      ?></span><?php } ?><?php
    
    if ( 
    $product_shortdescr ) 
    { ?><br /><span class="scs_cart_product_shortdescription"><?php
        echo $product_shortdescr;
      ?></span><?php } ?><span class="scs_sdkworkaround">&#160;</span></div><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><div class="scs_cart_product_deletebutton_wrapper"><input type="submit" class="scs_cart_product_deletebutton" name="delete[<?php
        echo $product_cartid;
      ?>]" value="Delete" /></div><?php } ?></div></td><?php
    
    if ( 
    $product_optionsselected ) 
    { ?><td class="scs_cart_options"><a href="<?php
        echo $product_optionshref;
      ?>"><?php
        echo $product_optionsselected;
      ?></a></td><?php } else { ?><td class="scs_cart_options"><span class="scs_sdkworkaround">&#160;</span></td><?php } ?><td class="scs_cart_quantity"><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><?php
    
    if ( 
    $product_quantitytype!='default_quantity' ) 
    { ?><div class="scs_cart_quantity_input_wrapper"><input id="product_quantity_<?php
        echo $product_cartid;
      ?>" name="qty[<?php
        echo $product_cartid;
      ?>]" type="text" value="<?php
        echo $product_quantity;
      ?>" /></div><?php } else { ?><div class="scs_cart_quantity_static_value"><?php
        echo $product_quantity;
      ?></div><?php } ?><?php } else { ?><div class="scs_cart_quantity_static_value"><?php
        echo $product_quantity;
      ?></div><?php } ?></td><td class="scs_cart_price" id="product_price_<?php
        echo $product_cartid;
      ?>"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_yourprice;
      ?></td><td class="scs_cart_product_subtotal" id="product_subtotal_<?php
        echo $product_cartid;
      ?>"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php
        echo $product_subtotal;
      ?></td></tr><?php } ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Subtotal:</td><td class="scs_cart_subtotals_value" id="cart_subtotal"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo $myPage->getCartSubTotal(); ?></td></tr><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><?php
    
    if ( 
    strval(count($myPage->getExtraShipping()))!='1' ) 
    { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label"><label for="extrashipid">Shipping Method:</label></td><td class="scs_cart_subtotals_option_value"><select id="extrashipid" name="extrashipping"><option value="-1">Choose One</option><?php

    foreach($myPage->getExtraShipping() as  $shipping_key => $shipping )
    {
    ?><?php
    $shipping_description = $shipping['description'];
    $shipping_amount = $shipping['amount'];
    $shipping_type = $shipping['type'];
    
    $shipping_value =$shipping['id'] . ( $myPage->getExtraShippingIndex() == $shipping['id'] ? '" selected="selected' : '');

    ?><option value="<?php
        echo $shipping_value;
      ?>" ><?php
        echo $shipping_description;
      ?></option><?php } ?></select></td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Shipping Total:</td><td class="scs_cart_subtotals_value" id="cart_shipping_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo ( $myPage->getCartShippingHandlingTotal() ); ?></td></tr><?php } else { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Shipping &amp; Handling:</td><td class="scs_cart_subtotals_value" id="cart_shipping_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo ( $myPage->getCartShippingHandlingTotal() ); ?></td></tr><?php } ?><?php } else { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Shipping &amp; Handling:</td><td class="scs_cart_subtotals_value" id="cart_shipping_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo ( $myPage->getCartShippingHandlingTotal() ); ?></td></tr><?php } ?><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><?php
    
    if ( 
    strval(count($myPage->getTaxLocations()))!='1' ) 
    { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label"><label for="taxlocid">Shipping Destination:</label></td><td class="scs_cart_subtotals_option_value"><select id="taxlocid" name="taxlocation"><option value="-1">Choose One</option><?php

    foreach($myPage->getTaxLocations() as  $location_key => $location )
    {
    ?><?php
    $location_name = $location;
    $location_value = $location_key . ( $myPage->cart->getTaxLocationId() == $location_key ? '" selected="selected' : '');
    ?><option value="<?php
        echo $location_value;
      ?>"><?php
        echo $location_name;
      ?></option><?php } ?></select></td><td class="scs_cart_subtotals_label">&#160;</td><?php
    
    if ( 
    strval($myPage->getCartTaxTotal())!='0.00' ) 
    { ?><td class="scs_cart_subtotals_label" colspan="2" id="cart_taxes_total_label">Estimated Taxes:</td><td class="scs_cart_subtotals_value" id="cart_taxes_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo $myPage->getCartTaxTotal(); ?></td><?php } else { ?><td class="scs_cart_subtotals_label" colspan="2" id="cart_taxes_total_label">&#160;</td><td class="scs_cart_subtotals_value" id="cart_taxes_total">&#160;</td><?php } ?></tr><?php } else { ?><?php
    
    if ( 
    strval($myPage->getCartTaxTotal())!='0.00' ) 
    { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Taxes:</td><td class="scs_cart_subtotals_value" id="cart_taxes_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo $myPage->getCartTaxTotal(); ?></td></tr><?php } ?><?php } ?><?php } else { ?><?php
    
    if ( 
    strval($myPage->getCartTaxTotal())!='0.00' ) 
    { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Taxes:</td><td class="scs_cart_subtotals_value" id="cart_taxes_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo $myPage->getCartTaxTotal(); ?></td></tr><?php } ?><?php } ?><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><tr class="scs_cart_total"><?php
    
    if ( 
    $myPage->getConfig('creditcardscount')!='0' ) 
    { ?><td class="scs_cart_subtotals_option_label">Acceptable Credit&#160;Cards:</td><td class="scs_cart_subtotals_option_value"><?php

    foreach($myPage->getCreditCards() as  
          $card )
    {
    ?><?php
    $card_path = $card['path'];
    ?><img class="scs_creditcard_image" src="<?php
        echo $card_path;
      ?>" alt="card" /><?php } ?></td><?php } else { ?><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><?php } ?><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_total_label" colspan="2">Total:</td><td class="scs_cart_total_value" id="cart_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo $myPage->getCartGrandTotal(); ?></td></tr><?php } else { ?><tr class="scs_cart_total"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_total_label" colspan="2">Total:</td><td class="scs_cart_total_value" id="cart_total"><?php  echo $myPage->getConfig('currencysymbol'); ?><?php echo $myPage->getCartGrandTotal(); ?></td></tr><?php } ?></table><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><div class="scs_checkout_buttons_container_wrapper"><div class="scs_checkout_buttons_container"><span class="scs_sdkworkaround">&#160;</span><?php
    
    if ( 
    $myPage->hasCheckoutMethod('PayPal') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('paypalimage'); ?>" alt="Proceed to Checkout with Paypal" name="paypalcheckout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('PayPalWPS') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('paypalwpsimage'); ?>" alt="Proceed to Checkout with Paypal" name="paypalwpscheckout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('Google') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('googleimage'); ?>" alt="Proceed to Checkout with Google" name="googlecheckout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('AuthorizeNetSIM') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('authorizeimage'); ?>" name="anscheckout" value="Credit Card" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('2CO') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('twocoimage'); ?>" name="2cocheckout" value="Credit Card Checkout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('WorldPay') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('worldpayimage'); ?>" name="worldpaycheckout" value="Credit Card Checkout" /><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div><?php } ?><?php
    
    if ( 
    $checkout_step2 ) 
    { ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('PayPal') ) 
    { ?><div class="scs_checkout_buttons_container_wrapper"><div class="scs_checkout_buttons_container"><input class="scs_checkout_button" type="submit" name="confirmpp" value="Confirm Payment with Paypal" /><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div><?php } ?><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></form></div><?php } ?></div></div></div></div></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div><div id="scs_footer_area_wrapper"><div id="scs_footer_area_inner_wrapper"><div id="scs_footer_area"><div id="scs_footer_wrapper"><div id="scs_footer_inner_wrapper"><div id="scs_footer"><div class="scs_flat_navmenu"><?php
    
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