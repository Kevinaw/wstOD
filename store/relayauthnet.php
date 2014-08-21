<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Auth.Net relay response page.
 *
 * This page is the web service functionality for Auth.Net + presentation to the buyer
 *
 * Auth.Net works as a relay-proxy and does not send header info back to the site.
 * As long as we don't store transactions in the cart, it is difficult to relate this
 * page with the actual cart contents that was paid. For the time being, include a button
 * that brings the client back to the shop and empty the cart when that happens.
 *
 * @version $Revision:2472 $
 * @author Cees de Gruijter
 * @category SCC PRO
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */


require './serviceans.php';


// pass the contents of the message template to the page
$msgfile = getLangIncludePath( 'resultauthnet.inc.php' );

ob_start();						// output buffering
include $msgfile;
$myPage->setCartMessage(ob_get_contents());
ob_end_clean();

// Problem: Auth.Net behaves as a proxy and for html links to work, we need full url's
// which the templates don't have. Since it is only this 1 template, we can read it into
// a buffer and replace the things we need.

$templateFile = getLangIncludePath( 'cart_authnet_1.inc.php' );

ob_start();						// output buffering
include $templateFile;
$template = ob_get_contents();
ob_end_clean();

FixUrls ( $template );

echo $template;

ob_end_flush();
exit();


/*******************************/


function FixUrls( &$source ) {

	global $myPage;

	$url = $myPage->getFullUrl(false, false, true);

	// change form tags (action uses path to document root, thus change the lot)
	$source = preg_replace( '|action="[^"]+|' , 'action="' . $url, $source );

	// strip the script name from url
	$url = substr( $url, 0, strrpos( $url, '/' ) + 1 );

	// change stuff in the header
	$source = str_replace( 'src="ccdata', 'src="'   . $url . 'ccdata' , $source );
	$source = str_replace( 'href="css'  , 'href="'  . $url . 'css' , $source );
	$source = str_replace( 'src="js'    , 'src="'    . $url . 'js' , $source );

	// change the <a > tags
	$source = preg_replace( '|<a href="([^/"]+)"|', ' <a href="' . $url . "$1\"" , $source );

}


// simple response screen that has no dependencies
function FallbackScreen ( ) {

	global $myPage, $Amount, $testMode, $ResponseText, $ResponseReasonCode, $ResponseReasonText;

?>	<html>
	<head>
	<title><?php echo _T('Transaction Receipt Page'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
	<body bgcolor="#FFFFFF">
<?php if( $testMode ) { ?>
<table align="center" width="60%">
	<tr>
		<th>
		  <font size="5" color="red" face="arial">TEST MODE</font>
		</th>
	</tr>
	<tr>
		<th valign="top">
		    <font size="1" color="black" face="arial">
			<?php echo _T('This transaction will <u>-NOT-</u> be processed because your account is in Test Mode.'); ?>
			</font>
		</th>
    </tr>
</table>
<?php } ?>
	<br>
	<br>
	<table align="center" width="60%">
	<tr>
		<th><font size="3" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">
			<?php echo $myPage->getConfigS('shopname'); ?></font>
		</th>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		<th><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">
			<?php echo $ResponseText; ?></font>
		</th>
	</tr>
	</table>
	<br>
	<br>
	<table align="center" width="60%">
	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		  <b><?php echo _T('Amount:'); ?></b>
		</font></td>
		<td align="left"><font size="2" color="black" face="arial">
		    <?php echo $myPage->curSign .  $Amount; ?>
		</font></td>
	</tr>

	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		<b><?php echo _T('Transaction ID:'); ?></b>
		</font></td>
		<td align="left"><font size="2" color="black" face="arial">
			<?php echo $TransID == "0" ? _T("Not Applicable.") : $TransID; ?>
		</font></td>
	</tr>

	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		<b><?php echo _T('Authorization Code:'); ?></b>
		</font></td>
		<td align="left"><font size="2" color="black" face="arial">
			<?php echo $AuthCode == "000000" ? _T("Not Applicable.") : $AuthCode ?>
			</font></td>
	</tr>
	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		<b><?php echo _T('Response Reason:'); ?></b></font></td>
		<td align="left">
		  <font size="2" color="black" face="arial">
		  <?php echo $ResponseReasonCode . '&nbsp;' . $ResponseReasonText; ?>
		  </font></td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<?php '<a href="' . $myPage->getConfigS('home') . '">' . _T('Take me back to the shop') . '</a>'; ?>
		</td>
    </tr>
	</table>
	</body>
	</html>
<?php
}
 ?>