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
* @copyright Copyright (c) 2009-2011 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require 'config.inc.php';

if( ! isset( $_GET['groupid'] ) ||
	! is_numeric( $_GET['groupid'] ) ||
	! $myPage->existsGroup( $_GET['groupid'] ) )
{
	// show store front
	$myPage->setCartMessage(  _T( "You have been redirected to this page because the product category that you were looking for was not found." ) );
	include( 'index.inc.php');
	exit(0);
}

include getLangIncludePath( 'group.inc.php' );

ob_end_flush();

if( $myPage->sdrive_stats  ) {
	include_once 'statsreporter.php';
	$sr = new StatsReporter( $myPage );
	$grp = $myPage->getGroup( $_GET['groupid'] );
	$sr->NotifyCategoryView(  $grp['name'] );
}

?>