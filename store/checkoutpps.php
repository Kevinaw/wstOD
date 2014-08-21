<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Connection with PayPal Website Payments Standard.
*
* $_GET['tx'] is set when returning from PayPal and contains the transaction token.
* Set in WPS preferences: autoreturn=true and the Payment Data Transfer = ON to get payment notifications
* Get "Identity Token" from that same config page
*
* PayPal user agreement states: return page must make clear to the buyer that the payment has been made and
* that the transaction has been completed. Also, tell him that payment transaction details will be emailed.
* Example: "Thank you for your payment. Your transaction has been completed, and a receipt for your
* purchase has been emailed to you. You may log into your account at www.sandbox.paypal.com/us
* to view details of this transaction".
*
* @version $Revision: 1874 $
* @author Cees de Gruijter
* @category SCC Pro
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

$pageClassName = 'DownloadPage';
require 'config.inc.php';
require 'checkoutpps.cls.php';

define( 'PPS_LABEL', 'PP Standard' );

$checkout = new Checkout( $myPage );

if( isset( $_GET['cancel'] ) ) {

	// go back to the cart
	header("Location: cart.php");
	exit();

} else if( isset( $_GET['merchant_return_link'] ) ) {

	// User clicks on "return to shop" in the PayPal screen after payment and auto return is not configured.
	// Don't update the transaction log because that may already have been done by IPN

	// go back to the cart and empty it
	$_SESSION['emptycart'] = 1;
	header("Location: cart.php?emptycart");

	exit();

} else if( isset( $_GET['tx'] ) ) {

	$transid = $_GET['tx'];

	// validate transaction id
	if( ! preg_match( '/^[\d\w]{17,19}$/', $_GET['tx'] ) ) {
		writeErrorLog( __FILE__ . ' - Recieved strange transaction id:', $_GET['tx'] );
		exit();
	}

	// user has completed a payment transaction, get more info and display result
	$checkout->getPaymentDataTransfer( $_GET['tx'] );

	if( $myPage->message != '' ||
		$checkout->resArray['ACK'] != 'SUCCESS' ||
		isset( $checkout->resArray['error'] ) ) {

		include getLangIncludePath( 'cart_authnet_1.inc.php' );

	} else if( $checkout->resArray['ACK'] == 'SUCCESS' ) {

		updateTransactionLog( $checkout );

		$myPage->emptyCart();

		showWPSResult( $checkout );

		exit();
	}

} else {

	showGoWPSForm( $checkout );
}

ob_end_flush();
exit();


function updateTransactionLog ( $checkout ) {

	global $myPage;

	// update stocks and transaction log
	if( isset( $_SESSION[ ORDERREFKEY ] ) ) {

		$trans_data[ 'status' ] = urldecode( $checkout->resArray[ 'payment_status' ] );

		if( isset( $checkout->resArray['txn_id'] ) ) {
			$trans_data[ 'gatewayref' ] = $checkout->resArray[ 'txn_id' ];
		}

		if( isset( $checkout->resArray['memo'] ) ) {
			// data a user may add in WSP
			$trans_data['memo'] = urldecode( $checkout->resArray['memo'] );
		}

		// use the reference that we send to PP if we can find it
		if( isset( $checkout->resArray['custom'] ) ) {
			$route = urldecode( $checkout->resArray['custom'] );
		} else {
			$route = $_SESSION[ ORDERREFKEY ];
		}

		if( ! $myPage->saveTransactionData ( $trans_data, $route) ) {
			writeErrorLog( PPS_LABEL . 'Error storing data during New Order: ' . $myPage->getDataMessage() );
			return false;		// won't store, but now something doesn't work as it should
		}
	}
}


// variable $myPage MUST be defined/available for the includes to work!!!
function showGoWPSForm ( $checkout ) {

	global $myPage;

	// pass the contents of the message template to the page
	// the include file will also put the cart contents into hidden variables
	$msgfile = getLangIncludePath( 'goppwps.inc.php' );

	ob_start();						// output buffering
	include $msgfile;
	$myPage->setCartMessage( ob_get_contents() );
	ob_end_clean();

	include getLangIncludePath( 'cart_authnet_1.inc.php' );
}


function showWPSResult ( $checkout ) {

	global $myPage;

	$ResponseText = _T( "Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com to view details of this transaction." );

	// pass the contents of the message template to the page
	// the include file will also put the cart contents into hidden variables
	$msgfile = getLangIncludePath( 'resultppwps.inc.php' );

	ob_start();						// output buffering
	include $msgfile;
	$myPage->setCartMessage( ob_get_contents() );
	ob_end_clean();

	include getLangIncludePath( 'cart_authnet_1.inc.php' );
}

// variable $myPage MUST be defined/available for the includes to work!!!

/******** Displays error parameters. ********/
function showError ( ) {
	global $myPage;
	global $checkout;
?>

<html>
<head>
<title><?php _T('PayPal WPS Response'); ?></title>
<style>
td{vertical-align:top;}
td.header{font-size:1.1em;font-weight:bolder;}
</style>
</head>

<body alink=#0000FF vlink=#0000FF>

<center>

<table width="700" cellspacing="10">
<tr>
		<td colspan="2" class="header"><?php _T('PayPal WPS has returned an error!'); ?></td>
	</tr>
<?php  //it will print if any URL errors
	if(isset($_SESSION['curl_error_no'])) {
			$errorCode = $_SESSION['curl_error_no'] ;
			$errorMessage = $_SESSION['curl_error_msg'] ;
			session_unset();
?>

<tr>
		<td><?php _T('Error Number:'); ?></td>
		<td><?php echo $errorCode ?></td>
	</tr>
	<tr>
		<td><?php _T('Error Message:'); ?></td>
		<td><?php echo $errorMessage; ?></td>
	</tr>

<?php } else {

/* If there is no URL Errors, Construct the HTML page with
   Response Error parameters.
   */
?>
<tr>
		<td><?php _T('Ack:'); ?></td>
		<td><?php echo $checkout->resArray['ACK']; ?></td>
	</tr>
	<tr>
		<td><?php _T('Message:'); ?></td>
		<td><?php echo $checkout->resArray['MESSAGE']; ?></td>
	</tr>
	<tr>
		<td><?php _T('Post:'); ?></td>
		<td><pre><?php echo str_replace(array('<','>'), array('&lt;','&gt;'), $checkout->resArray['POST']); ?></pre></td>
	</tr>
<?php }// end else ?>
 </table>
</center>
<br>
<a class="home" id="CallsLink" href="<?php echo $myPage->getConfigS('home'); ?>"><font color="blue">&lt;&lt; <?php _T('home'); ?></font></a>
</body>
</html>
<?php } ?>