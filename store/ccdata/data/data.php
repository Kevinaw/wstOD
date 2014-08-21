<?php
    
  $config['sccversion'] = 'Version 3.9, Build 4296';
  $config['timestamp'] = '11/04/2012 5:36:48 PM';
  $config['sync_marker'] = '1334187408';
  $config['home'] = 'index.php';
  $config['viewcarthref'] = 'cart.php';
  $config['categorypagehref'] = 'category.php';
  $config['shopname'] = 'Oildirectory Store';
  $config['shoplogo'] = 'ccdata/images/logo.jpg';
  $config['websitehref'] = 'http://www.oildirectory.com';
  $config['shopfooter'] = '
      
    ';
  $config['shopcurrency'] = 'CAD';
  $config['currencysymbol'] = 'C$';
  $config['groupscount'] = '2';
  $config['pagescount'] = '0';
  $config['creditcardscount'] = '4';
  $config['shopkeywords'] = '';
  $config['shopdescription'] = '';
  $config['shophtmlheader'] = '
      
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/default_ie.css" /><![endif]-->
<script type="text/javascript" src="ccdata/js/jquery.js"></script>
<script type="text/javascript" src="js/colorbox.js"></script>
<script type="text/javascript" src="ccdata/js/shop.js"></script>
<!-- Start of the header content definition by the user -->

<!-- End of the header content definition by the user -->

    ' ;
  $config['homeheader'] = '';
  $config['hometext'] = '';
  $config['staticpageshome'] = true;
  $config['subcategorylisting'] = false;
  $config['subcategorytiles'] = false;
  $config['copyright'] = '
      Copyright &#169; <span class="scs_branding_year">2012</span> Oildirectory Store
    ';
  $config['navigate_stayonpage'] = false;

  
  $config['showstarredgroups'] = 'true';
  $config['showhomeonlyproducts'] = '1';

  $config['showhomeproducts'] = '';
  $config['showhomesubcategory'] = '';
  $config['showhomecategorydetails'] = '';

  $config['showcategorycategorydetails'] = '1';
  $config['showcategorysubcategory'] = '1';
  $config['showcategoryproducts'] = '1';
  
  
  $config['ispro'] = false;
  $config['transaction_log'] = false;
  $config['track_stock'] = '';
  // empty (=no tracking), 'before' or 'after' (gateway trans. code)
  $config['shipping_calcmethod'] = 'manual';  // 'manual' (=default) or 'weight'
  $config['shipping_weightunit'] = '';
  $config['mail'] =  array(
      'send_sales' => false,
       // only enabled when transaction_log is true
      'send_outofstock' => false, // only enabled when track_stock is true
      'from_address' => '',
      'to_sales_address' => '',
      'to_stock_address' => '',
      'subject_sales' => '',
      'subject_outofstock' => ''
      );

  $config['users'] = array(
      'stock_key' => ''
  );
  
  
  $config['showaddcart'] = '1';
  $config['showprice'] = '1';
  $config['iscatalog'] = '0';
  $config['cataloghtml'] = '0';
    
  // Possible languages defined: 
  // en' -> English; 'de' -> German; 'es' -> Spanish
  
    $config['lang'] = 'en';

    $config['PayPal'] = array(
    'enabled' => false,
    'API_USERNAME' => '',
    'API_PASSWORD' => '',
    'API_SIGNATURE' => '',
    'API_ENDPOINT' => 'https://api-3t.paypal.com/nvp',
    'USE_PROXY' => false,
    'PROXY_HOST' => '',
    'PROXY_PORT' => '',
    'PAYPAL_URL' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=',
    'VERSION' => '64.0',
    'USE_GIROPAY' => false
    );
    
  $config['Google'] = array(
	  'enabled' => false,
    'merchant_id' => '',
    'merchant_key' => '',
    'url' => "https://checkout.google.com/api/checkout/v2/merchantCheckout/Merchant/",
    'USE_PROXY' => false,
    'PROXY_HOST' => '',
    'PROXY_PORT' => ''
    );
        
 $config['AuthorizeNetSIM'] = array(
    'enabled' => false,
    'URL' => 'https://secure.authorize.net/gateway/transact.dll',
    'API_LOGIN' => '',
	  'API_KEY' => '',
 	  'TEST_MODE' => 0			// allows for testing in live environment
    );


    $config['PayPalWPS'] = array (
    'enabled' => true,
    'URL' => 'https://www.paypal.com/cgi-bin/webscr',
    'BUSINESS' => 'service@oildirectory.com',
    'PDT_TOKEN' => '',
    'USE_PROXY' => false,
    'PROXY_HOST' => '',
    'PROXY_PORT' => ''
    );

    $config['2CO'] = array(
    'enabled' => false,
    'VENDOR_NUMBER' => '',
    'SECRET' => '',
    
    // single page checkout (only intangible products)
    //'URL' => 'https://www.2checkout.com/checkout/spurchase',
    // multipage checkout
    
    'URL' => 'https://www.2checkout.com/checkout/purchase',
    'TEST_MODE' => 0			// allows for testing in live environment
    );

    $config['WorldPay'] = array(
    'enabled' => false,
    'ID' => '',
    'URL' => 'https://select-test.wp3.rbsworldpay.com/wcc/purchase',
    'URL_TEST' => 'https://select-test.wp3.rbsworldpay.com/wcc/purchase',		// use this if test mode is selected
    'SECRET' => '',
    'TEST_MODE' => 0			// allows for testing in live environment
  );


  $config['TaxLocations'] = array(
       '1' => 'International' 
    );

    $config['TaxRatesDecimals'] = 4;
    /* Type of taxes: 0 -> Apply to product amount, 1 -> Apply to product amount + shipping, 2 -> Apply to product amount + shipping + handling (NOT IN USE, USE SHIPPING ARRAY)*/
          $config['TaxRates']['Product']['1']['Merchandise'] = 50000;
       
           $config['TaxRates']['Shipping']['1'] = 50000;
        

    $config['ShippingRatesDecimals'] = 2;
    $config['ShippingRangeDecimals'] = 3;
    // format: 1 = location, Ground = method, 1.5 = upper-limit for that cost, 100000 = costs// special values: upper-limit = -1, use this value for quantities greater than defined// upper-limit = -2, method not suitable for quantities greater than defined
        $config['ShippingRates']['1']['Normal Shipping'] = array(  '500' => 0 , '1000' => 0 , '1500' => 0 , '2000' => 0 , '-1' => 0 );
      
  $pages['0'] = array(
      'type' => 'home',
      'name' => '
        Home
      ',
      'id' => '0',
      'pagehref' => 'http://www.oildirectory.com',
      'metadescription' => '',
      'metakeywords' => '',
      'content' => '',
      'headertext' => 'Home'
      );
    
  $pages['1'] = array(
      'type' => 'shophome',
      'name' => '
        Shop Home
      ',
      'id' => '1',
      'pagehref' => 'index.php',
      'metadescription' => '',
      'metakeywords' => '',
      'content' => '',
      'headertext' => 'Shop Home'
      );
    
  $pages['2'] = array(
      'type' => 'category',
      'name' => '
        Categories
      ',
      'id' => '2',
      'pagehref' => 'category.php',
      'metadescription' => '',
      'metakeywords' => '',
      'content' => '',
      'headertext' => 'Categories'
      );
    
  $pages['3'] = array(
      'type' => 'cart',
      'name' => '
        View Cart
      ',
      'id' => '3',
      'pagehref' => 'cart.php',
      'metadescription' => '',
      'metakeywords' => '',
      'content' => '',
      'headertext' => 'View Cart'
      );
    
        /* Description -> Text to show in the dropdown. Amount -> quantity to add. Show -> If we need to show it in the dropdown 
       
       Type of extrashipping: 
        -1 -> Default Shipping, use for Fixed amount (even if not visible) 
         0 -> Apply to total shipping
         1 -> Apply as percentage to total 
         2 -> Apply to each item in the cart
         3 -> Apply percentage to each item in the cart 
         4 -> Increase shipping costs with this % times the number of products
         */
    
  $extrashippings[] = array(
          'description' => 'Normal Shipping',
          'amount' => '0',
          'type' => '-1',
          'show' => true,
          'id' =>  '0'
      );
    
  $groups['0'] = array(
      'name' => 'OIldirectory.com Premium Listings',
      'metakeywords' => 'OIldirectory.com Premium Listings',
      'metadescription' => 'OIldirectory.com Premium Listings',
      'groupid' => '0',
      'pagehref' => 'viewcategory.php?groupid=0',
      'productsIds' => array(0,1,3,4,5,6,7),
      'parentid' => '-1',
      'parentname' => '',
      'parenthref' => 'viewcategory.php?groupid=-1',
      'image' => '',
      'imageisset' => '',
      'tileimage' => '',
      'content' => '',
      'subgroupsIds' => array()
    );
  
  $groups['1'] = array(
      'name' => 'Oildirectory Products',
      'metakeywords' => 'Oildirectory Products',
      'metadescription' => 'Oildirectory Products',
      'groupid' => '1',
      'pagehref' => 'viewcategory.php?groupid=1',
      'productsIds' => array(8),
      'parentid' => '-1',
      'parentname' => '',
      'parenthref' => 'viewcategory.php?groupid=-1',
      'image' => '',
      'imageisset' => '',
      'tileimage' => '',
      'content' => '',
      'subgroupsIds' => array()
    );
  
  $products['0'] =
      
      array(
      'productid' => '0',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=0',
      'name' => 'First Premium Listing',
      'shortdescription' => 'First premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.<br /></span></span>
      ',
      'metakeywords' => 'First Premium Listing',
      'metadescription' => 'First premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000000',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '6995',
      'retailprice' => '6995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'Merchandise',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_0.jpg',
      'main_small' => 'ccdata/images/smallMain_0_0.jpg',
      'thumbs' => array(
       )
      );
    
  $products['1'] =
      
      array(
      'productid' => '1',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=1',
      'name' => 'Second Premium Listing',
      'shortdescription' => 'Second premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.</span></span>
      ',
      'metakeywords' => 'Second Premium Listing',
      'metadescription' => 'Second premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000001',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '4995',
      'retailprice' => '4995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_1.jpg',
      'main_small' => 'ccdata/images/smallMain_0_1.jpg',
      'thumbs' => array(
       )
      );
    
  $products['3'] =
      
      array(
      'productid' => '3',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=3',
      'name' => 'First Additional Premium Listing',
      'shortdescription' => 'First additional premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.</span></span>
      ',
      'metakeywords' => 'First Additional Premium Listing',
      'metadescription' => 'First additional premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000003',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '2995',
      'retailprice' => '2995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_3.jpg',
      'main_small' => 'ccdata/images/smallMain_0_3.jpg',
      'thumbs' => array(
       )
      );
    
  $products['4'] =
      
      array(
      'productid' => '4',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=4',
      'name' => 'Second Additional Premium Listing',
      'shortdescription' => 'Second additional premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.</span></span>
      ',
      'metakeywords' => 'Second Additional Premium Listing',
      'metadescription' => 'Second additional premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000004',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '2995',
      'retailprice' => '2995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_4.jpg',
      'main_small' => 'ccdata/images/smallMain_0_4.jpg',
      'thumbs' => array(
       )
      );
    
  $products['5'] =
      
      array(
      'productid' => '5',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=5',
      'name' => 'Third Additional Premium Listing',
      'shortdescription' => 'Third additional premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.</span></span>
      ',
      'metakeywords' => 'Third Additional Premium Listing',
      'metadescription' => 'Third additional premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000005',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '2995',
      'retailprice' => '2995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_5.jpg',
      'main_small' => 'ccdata/images/smallMain_0_5.jpg',
      'thumbs' => array(
       )
      );
    
  $products['6'] =
      
      array(
      'productid' => '6',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=6',
      'name' => 'Fourth Additional Premium Listing',
      'shortdescription' => 'Fourth additional premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.</span></span>
      ',
      'metakeywords' => 'Fourth Additional Premium Listing',
      'metadescription' => 'Fourth additional premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000006',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '2995',
      'retailprice' => '2995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_6.jpg',
      'main_small' => 'ccdata/images/smallMain_0_6.jpg',
      'thumbs' => array(
       )
      );
    
  $products['7'] =
      
      array(
      'productid' => '7',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?productid=7',
      'name' => 'Fifth Additional Premium Listing',
      'shortdescription' => 'Fifth additional premium listing in up to 3 locations',
      'longdescription' => '
        <span><span style="font-size:14px;">Our new Premium Listing billing system lets you list your company in 3 locations and each listing includes either a banner ad or your company logo.<br />The price for the first Premium Listing is $69.95 per category in 3 locations, the price for your second Premium Listing is $49.95 per category in 3 locations and all subsequent Premium Listings are $29.95 per category in 3 locations.<br />All Premium Listings are eligible to have a banner ad or your logo on them.<br />If you have your own banner ad you can send it to me at </span><span style="font-weight:bold; font-size:14px;color:#0000FF;">web@oildirectory.com</span><span style="font-size:14px;">. It should either be in GIF or JPEG format and be 468 X 60 pixels in size.<br />Your logo should also be GIF or JPEG and be no larger than 145 X 145 pixels.<br /><br /></span><span style="font-weight:bold; font-size:14px;color:#FF0000;">If you don\'t have a banner I can build you a simple text based banner with your logo on it for no additional charge.</span></span>
      ',
      'metakeywords' => 'Fifth Additional Premium Listing',
      'metadescription' => 'Fifth additional premium listing in up to 3 locations',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000007',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '2995',
      'retailprice' => '2995',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '0',
      'handling' => '0',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_7.jpg',
      'main_small' => 'ccdata/images/smallMain_0_7.jpg',
      'thumbs' => array(
       )
      );
    
  $products['8'] =
      
      array(
      'productid' => '8',
      'groupid' => '1',
      'pagehref' => 'viewitem.php?productid=8',
      'name' => 'Personal Protection Kit',
      'shortdescription' => 'Prevent disease when traveling',
      'longdescription' => '
        <span><span style="font-size:14px;">Help prevent disease transmission anywhere. This handy kit contains 2 pairs of latex gloves, 2 surgical masks and 3 alcohol wipes in a convenient zip-lock bag that fits easily in your briefcase or purse.</span></span>
      ',
      'metakeywords' => 'Personal Protection Kit',
      'metadescription' => 'Prevent disease when traveling',
      'weight' => '0',
      'weightdigits' => 3,
      'weightunits' => 'lbs',
      'showweight' => '',
      'isstarred' => '',
      'showincategory' => '',
      'sku' => 'SKU_00000008',
      'stock' => '1',
      'showstock' => '',
      'yourprice' => '895',
      'retailprice' => '895',
      'discount' => '0',
      'ispercentage' => '0',
      'tax' => 'Merchandise',
      'shipping' => '300',
      'handling' => '200',
      'options' => array (
        
      ),
      'forceoptions' => '',
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_1_8.jpg',
      'main_small' => 'ccdata/images/smallMain_1_8.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_1_8.jpg', 'small' => 'ccdata/images/small1_1_8.jpg')  )
      );
    
 

    
  $starredproducts = array (    
            
    );

    
  $categoryproducts = array (
    
    );


    
  $creditcards = array (
      
        array( 'path' => 'ccdata/images/Visa.png' ) , 
        array( 'path' => 'ccdata/images/MasterCard.png' ) , 
        array( 'path' => 'ccdata/images/AmericanExpress.png' ) , 
        array( 'path' => 'ccdata/images/PayPal.png' )
      );
    
    ?>