<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Web service for PayPall Instant Payment Notifications
*
* 'Silent Post' feature must be set in the Merchant Interface of Auth.Net
*
* @author Cees de Gruijter
* @category SCC Hosted
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

define( 'IPN_LABEL', 'PayPal IPN - ' );

$pageClassName = 'DownloadPage';
require 'config.inc.php';
require 'checkoutpp.cls.php';

$checkout = new Checkout( $myPage );

if( empty( $_POST ) ) {
	echo '<html><body>Command not recognized.</body></html>';
	writeErrorLog( IPN_LABEL . 'Received empty PayPal IPN message.' );
	exit();
}

if( ! $checkout->verifyIPN() ) {
	writeErrorLog( IPN_LABEL . 'Could not verify source of IPN message:', $_POST );
	exit();
}

if( isset( $_POST['custom'] ) && isset( $_POST['payment_status'] ) ) {
	if( UpdateTransactionLog( $_POST['custom'], array( 'status' => $_POST['payment_status'] ) ) ) {
		writeErrorLog( IPN_LABEL . 'Processed:', $_POST );
	}
} else {
	writeErrorLog( IPN_LABEL . 'Missing fields in IPN message:', $_POST );

}


/*******************************/


function UpdateTransactionLog( $route, $data ) {

	global $myPage;

	if( empty( $route) ) {
		return true;
		writeErrorLog( IPN_LABEL . 'Empty CartRef files in IPN message:', $_POST );
	}

	if( ! $myPage->saveTransactionData ( $data, $route, true ) ) {
		writeErrorLog( IPN_LABEL . 'Error storing data during Order update:', $myPage->getDataMessage() );
		return false;		// won't store, but now something doesn't work as it should
	}

	return true;
}
