<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Page with the cart.
 *
 * POST handles the following keys:
 * 	  Key                   Corresponding Data
 * 	- recalculate			key 'qty' contains array (cartid, #)
 * 	- delete				contains array with (cartid, 'delete')
 * 	- checkout				no data
 *
 * Updated cart is returned.
 *
 * This page has no GET requests, only the plain cart page.
 *
 * @version $Revision: 2820 $
 * @author Cees de Gruijter
 * @category SCC Hosted
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */

// hack so we can return from Auth.Net relay without security warning ( <a..> instead of form post )
if( isset($_GET['emptycart']) ) $_POST['emptycart'] = 1;


// hack so we can return from PP WPS and empty cart (session only available after page object is created)
if( isset( $_SESSION['emptycart'] ) ) {
	$_POST['emptycart'] = 1;
	unset( $_SESSION['emptycart'] );
}

require 'config.inc.php';

// see if another url left us a message
if( isset( $_SESSION['cart_warning'] ) ) {

	$myPage->setCartMessage( $_SESSION['cart_warning'] );
	unset( $_SESSION['cart_warning'] );

}

// show cart
if( isset( $_POST['format'] )  && $_POST['format'] == 'json' ) {
	include 'cart.json.php';
} else {
	include getLangIncludePath( 'cart.inc.php' );	
}

ob_end_flush();

?>