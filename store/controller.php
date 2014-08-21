<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Required POST parameters:
 *  	method, value can be: add, update, remove
 * or one of the following:
 * 		recalculate
 * 		delete
 * 		emptycart
 * 		checkout
 * 		confirmpp
 * 		paypalcheckout
 * 		googlecheckout
 *
 *  Optional parameters:
 * - item_id
 * - group_id
 * - any other form field that is appropriate in a certain context
 *
 * Upon successful cart update, the user is redirected to the cart
 * (see NAVIGATION comment)
 *
 * @version $Revision: 2737 $
 * @author Cees de Gruijter
 * @category SCC PRO
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */

// load static functions to manipulate cart
require 'cartcontrol.inc.php';

if( $myPage->message != '' ) {
	$myPage->setCartMessage( $myPage->message );
	return;
}

// remove any pending authorisation with PayPal, it is invalidated by changes to the cart
if( isset($_SESSION[PAYMENT]) ) {
	unset( $_SESSION[PAYMENT] );
	$myPage->resArray = array();
}

// cleanup any cart message that shouldn't be there
if( isset( $_SESSION['cart_warning'] ) ) {
	unset( $_SESSION['cart_warning'] );
}

// what do we need to do?

if( isset($_POST['method']) ) {
	$method = $_POST['method'];
} else if( isset($_POST['recalculate']) ) {
	$method = 'update';
} else if( isset($_POST['delete']) ) {
	$method = 'remove';
} else if( isset($_POST['emptycart']) ) {
	$method = 'emptycart';
} else if( isset($_POST['paypalcheckout']) || isset($_POST['paypalcheckout_x']) ) {
	$method = 'cc_paypalcheckout';
} else if( isset($_POST['paypalwpscheckout']) || isset($_POST['paypalwpscheckout_x']) ) {
	$method = 'cc_paypalwpscheckout';
} else if( isset($_POST['paypaldirect']) || isset($_POST['paypaldirect_x']) ) {
	$method = 'cc_paypaldirect';
} else if( isset($_POST['googlecheckout']) || isset($_POST['googlecheckout_x']) ) {
	$method = 'cc_googlecheckout';
} else if( isset($_POST['anscheckout']) || isset($_POST['anscheckout_x']) ) {
	$method = 'cc_anscheckout';
} else if( isset($_POST['2cocheckout']) || isset($_POST['2cocheckout_x']) ) {
	$method = 'cc_2checkout';
} else if( isset($_POST['worldpaycheckout']) || isset($_POST['worldpaycheckout_x']) ) {
	$method = 'cc_worldpay';
} else if( isset($_POST['confirmpp']) ) {
	$method = 'confirmpp';
} else {
	$method = false;
}


$errorMsg = false;

if( $method ) {
	switch( $method ) {
		case 'emptycart':
			$errorMsg = $myPage->emptyCart();
			break;

		case 'add':
		case 'update':
		case 'remove':
			$mytask = 'cart_' . $method;
			$errorMsg = $mytask( $cids );
			break;

		case 'cc_googlecheckout':
		case 'cc_paypalcheckout':
		case 'cc_paypalwpscheckout':
		case 'cc_paypaldirect':
		case 'cc_anscheckout':
		case 'cc_2checkout':
		case 'cc_worldpay':

			if( count( $myPage->cart->Prods ) > 0 ) {

				// Check if the location and shipping is properly establish
				$errorMsg = CheckShippingLocation();
				if( $errorMsg )	{
					break;
				}

				// double check that the requested articles haven't been sold in the mean time
				// and store the order in the log if possible before redirecting
				if( CheckAvailability( $errorMsg ) && SaveOrder( $method ) ) {

					$tmp = $myPage->getConfig( $method, true );
					header('Location: ' . $myPage->getConfig( $method, true ) );
					exit(0);
				}

			} else
				cart_update();	// does nothing that can cause problems

			break;

		case 'confirmpp':		// usually handled by the page that does 'connectpp'

			header('Location: ' . $myPage->getConfig('cc_confirmpayment', true));
			exit(0);
			break;

		case 'search':

			if( isset( $_POST['search_words'] ) && trim( $_POST['search_words'] ) != '' ) {
				header('Location: ' . $myPage->getConfig( 'cc_search', $_POST['search_words'] ) );
				exit(0);
			} else {
				$errorMsg = _T( "Please first type words to search for and then click on \"Search\"." );
			}
			break;

		default:
			echo( _T('Could not recognize task in Post request') . ' (' . $method . ').');
			writeErrorLog( __FILE__  . ' - Method in Post request not recognized:', $method);
			exit();
	}

	if( $errorMsg ) {
		$myPage->setCartMessage( $errorMsg );
	} else {

		$myPage->saveCart();

		// NAVIGATION: stop output buffering and redirect to cart if needed
		if( stristr( strtolower( $_SERVER['PHP_SELF'] ), 'cart.php' ) === false &&
			$myPage->getConfigS( 'navigate_stayonpage' ) == false )
		{
			if( ob_get_level() != 0 ) ob_end_clean();
			header( 'Location: cart.php' );
			exit();
		}
	}
}


// return true when products are available
function CheckAvailability( &$msg ) {

	global $myPage;
	global $absPath;

	if( ! $myPage->getConfigS( 'track_stock' ) ) {
		return true;		// won't check, but not out-of-stock either
	}

	$prod_descr = '';
	if( ! $myPage->verifyAvailability( $prod_descr ) ) {
		$msg = sprintf( _T("We are very sorry, but the last \"%s\" has just been sold."), $prod_descr );
		return false;
	}

	return true;
}

// Return an error message in case the Location or the Shipping is not established
function CheckShippingLocation() {

	global $myPage;
	$msg = '';

	// do this after the location, because location is used for weight based shipping costs
	if( isset( $_POST['extrashipping'] ) ) {

		if( $_POST['extrashipping'] == -1 && count($myPage->getExtraShipping() ) > 1 )
		{
			$msg = $msg . _T('Please choose a shipping method.<br />');
		}
	}

	if( isset($_POST['taxlocation']) ) {
		if( $_POST['taxlocation'] == -1 && count($myPage->getTaxLocations()) > 1 )
		{
			$msg = $msg . _T('Please choose a shipping destination.<br />');
		}

	}

	if( $msg != '' )
		return $msg;
	else
		return false;
}




function SaveOrder ( $gateway = '') {

	global $absPath;
	global $myPage;
	global $errorMsg;

	if( ! $myPage->getConfigS( 'transaction_log' )  ) {
		return true;		// won't store, but not really an error either
	}

	$cart =& $myPage->cart->exportCart();

	$cart[ 'gateway' ] = $gateway;
	$cart[ 'status' ] = 'Sending';

	// some follow up actions might need to be blocked if in test mode
	$cart[ 'testmode' ] = $myPage->getConfigS( $myPage->getGatewayName( $gateway ), 'TEST_MODE' );

	if( isset( $_SESSION[ ORDERREFKEY ] ) ) {
		$route = $_SESSION[ ORDERREFKEY ];
	} else {
		$route = false;
	}

	$updateStockBeforeTrans = $myPage->getConfigS( 'track_stock' ) == 'before';
	if( ! $myPage->saveTransactionData( $cart, $route, false, $updateStockBeforeTrans ) ) {
		$errorMsg = 'Error while storing data: ' . $myPage->getDataMessage();
		return false;		// won't store, but now something doesn't work as it should
	}

	$_SESSION[ ORDERREFKEY ] = $route;

	return true;			// success
}

?>
