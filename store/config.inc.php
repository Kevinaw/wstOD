<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Configuration file that must be included in all pages. This file determines
* what version of SCC (Base, Pro or Hosted) is installed.
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2010 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

// we don't like it when E_NOTICE is set
//error_reporting(E_ALL );
error_reporting(E_ALL ^ E_NOTICE);

// absolute paths are more efficient (if possible), so is output buffering
// note: 'Darwin' and Cygwin also contain 'win', but not at the first position
/*if( strpos( strtoupper(PHP_OS), 'WIN' ) === 0 ||
	strpos( PHP_SAPI, 'cgi' ) !== false )
{
	$absPath = './';		// script_file is sometimes unreliable in these cases
} else {
	$absPath = substr( $_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
}*/
$absPath = getcwd() . '/';

/*
 * Search include files in the order: hosted, pro, base.
 *
 * The include file must contain information on which class name to load, e.g. the $pageClassName
 * variable. This is used for a mini object factory.
 */


$errorLoggingType = 3;		// determines where writeErrorLog sends its output

set_include_path( $absPath . 'ccdata' . PATH_SEPARATOR .
				  $absPath . 'ccdata/php' . PATH_SEPARATOR .
				  $absPath . 'ccdata/data' . PATH_SEPARATOR .
				  get_include_path() );

// include the first page class file that is found.
require 'utilities.inc.php';
require 'shoppingCart.cls.php';

// Load extensions to Page class, depending the value of $pageClassName that is set
// $myPageClassName must be set by the page.cls.php file that is found first
$myPageClassName = '';
if( isset( $pageClassName ) && $pageClassName != 'Page' ) {

	$classfilename = strtolower( $pageClassName ) . '.cls.php';
	$handle = @fopen( $classfilename, 'r', 1 );
	if( $handle ) {
		fclose( $handle );
		require $classfilename;
	}
}

// load the default if nothing loaded already
if( empty( $myPageClassName ) )		require 'page.cls.php';

if( ! defined( NOPAGE ) ) {

	$myPage = new $myPageClassName();

	// the stats setting is consulted frequently, thus define a shortcut
	$myPage->sdrive_stats = false;

	// add sdrive config to page if needed
	if( isset( $sdrive_config ) ) {
		
		// $myPage->sdrive is initialized to false in ProPage
		$myPage->sdrive =& $sdrive_config;

		if( isset( $sdrive_config['sdrive_account_statalytics_enabled'] ) &&
		 	$sdrive_config['sdrive_account_statalytics_enabled'] = 'y' ) {
			$myPage->sdrive_stats = true;
		}
	}
}

if( ! empty( $_POST ) ) {

	// "$controllerClassName" must be defined in the include file
	$controllerClassName = '';
	include 'controller.cls.php';
	$ctl = new $controllerClassName();
	$ctl->Dispatch();
}

ob_start();

/*** end of global config ***/
?>