<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Entry point for the web shop.
*
* @version $Revision: 2244 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require 'config.inc.php';

// show index
include getLangIncludePath( 'index.inc.php' );

ob_end_flush();
?>