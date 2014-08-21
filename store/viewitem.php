<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* This page handles GET requests for an item and POST
* requests updates information of the cart. It returns the original page.
* If the GET parameters are missing the store front is shown.
*
* @version $Revision: 2975 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require 'config.inc.php';

// some input validation
if( isset( $_GET[ 'productid' ]) && is_numeric($_GET[ 'productid' ]) ) {

	$productid = $_GET[ 'productid' ];

} else {

	// may be there is some left from the form
	if( isset( $_POST[ 'productid' ]) && is_numeric( $_POST[ 'productid' ] ) ) {

		$productid = $_POST[ 'productid' ];

	} else {

		echo( _T( "Missing or invalid product ID." ) );
		exit();

	}
}

if( isset( $_GET[ 'cartid' ] ) && ! $myPage->cart->existsProduct( $_GET[ 'cartid' ] ) ) {
		echo( _T( "Invalid cart line item ID." ) );
		exit();
}


// check if the product (still) exists, if not redirect to the store home
if( ! $myPage->existsProduct( $productid ) ) {

	// show store front
	$myPage->setCartMessage(  _T( "You have been redirected to this page because the product that you were looking for was not found." ) );
	include( 'index.inc.php');
	exit(0);

}

include getLangIncludePath( 'product.inc.php' );

ob_end_flush();

if( $myPage->sdrive_stats ) {
	include_once 'statsreporter.php';
	$sr = new StatsReporter( $myPage );
	$sr->NotifyProdView( $productid );
}

?>
