<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Stuff that comes in handy and/or is common to all pages.
*
* @version $Revision: 2930 $
* @author Cees de Gruijter
* @category SCC PRO
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/


// write to error log in store folder
// $text1 or 2 are flattened if they are simple arrays.
// $text1 and $text2 are concatenated with a space
function writeErrorLog ( $text1, $text2 = false ) {

	global $absPath;
	global $errorLoggingType;
	
	$log = '';
	$prefix = '';
	$postfix = '';
	
	if( $errorLoggingType == 3 ) {

		if( ! file_exists( $absPath . 'ccdata/store' ) ) {

			// don't log if the target folder doesn't exist
			return;	

		} else {
			
			// create empty log with some access protection if it doesn't exist yet 
			$log = $absPath . 'ccdata/store/cart_error.log.php';
			if( ! file_exists( $log ) )		@error_log( "<?php echo 'Access denied.'; exit(); ?>\n", 3, $log );
			
			// in a file, we need to add a timestamp and a new line
			$prefix = date( 'r');
			$postfix = "\n";
		}
	} else {
		
		// in the hosted environment, we should add a userid to the log
		global $sdrive_config;
		$prefix = 'sdrive_account=' . $sdrive_config['sdrive_account_id'];
	}

	if( empty( $text1 ) ) $text1 = 'Error logger was called with empty text.';

	$text = '';
	foreach( func_get_args() as $arg ) {

		$text .= ' ';

		if( is_array( $arg ) ) {

			foreach( $arg as $key => $value ) {

				if( is_array( $value ) ) $value = implode( ',', $value );

				$text .= '[' . $key . '] ' . $value . '   ';
			}

		} else {

			$text .= $arg;
		}
	}

	// if it fails, it should fail silently
	@error_log( $prefix . ': ' . trim( $text ) . $postfix, $errorLoggingType, $log );
}


// GetText-like translator
function _T( $text, $vars = false ) {

	global $myPage;
	static $lang = false;

	// load language table if necessary
	if( ! $lang ) {
		$file = getLangIncludePath( 'language.dat.php' );
		if( file_exists( $file ) ) {
			$handle = fopen( $file, "r");
			$sdat = fread( $handle, filesize( $file ) );
			fclose( $handle );
			$lang = unserialize( $sdat );
		}
	}

	if( ! empty( $lang ) && isset($lang[$text]) ) {
		$translated = $lang[$text];
	} else {
		$translated =  $text;
	}

	// replace %s markers with values in vars
	if( $vars ) {

		foreach( $vars as $var ) {

			$pos = strpos( $translated, '%s' );

			if( $pos !== false ) {
				$translated = substr( $translated, 0, $pos )
							. $var
							. substr( $translated, $pos + 2 );
			}
		}
	}

	return $translated;
}


// return path to file in correct language or safe fallback if file does not (yet) exist
function getLangIncludePath ( $filename ) {

	global $myPage;
	
	if( empty( $filename ) ) return false;

	$filename = ltrim( $filename, '/ ');
	$path = false;
	$lng = $myPage->getConfigS( 'lang' );

	if( $lng && $lng != 'en' ) {
		$path = $lng . '/' . $filename;
	}

	// use fopen to check file existence in include path
	if( $path !== false ) {

		$handle = @fopen( $path, 'r', 1 );

		if( $handle ) {
			fclose( $handle );
			return $path;
		}
	}

	return $filename ;
}



/* by setting $divider to 100, eg 1000 -> 10,00
 * WARNING: input may not contain decimals of cents when working with cents!
 */
function formatMoney ( $amount, $divider = 1 ) {
	if (is_float($amount) && $divider == 100) {
		$amount = round($amount);
	}
	$amount = moneyToFloat($amount);
	if (!$amount) return '';
	else $amount = $amount / $divider;
	return formatAmount($amount, 2);
}


function intToMoney ( $amount, $divider = 100 ) {
	formatAmount( (float)$amount / $divider, 2);
	if (!$amount)
		return '';
	else
		return formatAmount( (float)$amount / $divider, 2);
}


// split (almost) any money format into whole units and cents
function moneyToFloat ( $input ) {
	$re = '/^((?:[,.\s]?\d{1,3})+?)(?:[.,](\d\d))?$/';
	if (preg_match($re, trim($input), $match)) {
		$money = str_replace(array(',','.',''), '', $match[1])
        	   . '.' . (!isset($match[2]) || $match[2] == '' ? '00' : $match[2]);
	} else $money = '';
	return $money;
}


function moneyToInt ( $input ) {
	return moneyToFloat($input) * 100;
}


function formatAmount ( $number, $dec_places, $lng = 'en' ) {
	switch ($lng) {
	case 'en':
		$r = number_format($number, $dec_places, '.', ',');
		break;
	case 'nl':
	case 'es':
		$r = number_format($number, $dec_places, ',', '.');
		break;
	case 'fr':
		$r = number_format($number, $dec_places, ',', ' ');
		break;
	default:
		die("No definition found for language '{$lng}' in formatAmount.");
    }
	return $r;
}


function formatDateTime ( $udate, $lng, $fmt = '' ) {
	switch ($lng) {
	case 'nl':
		setlocale(LC_TIME, 'nl_NL');
		break;
	case 'es':
		setlocale(LC_TIME, 'es_ES');
		break;
	case 'en':
	default:
	setlocale(LC_TIME, 'en_eng');
	}
	if ($fmt)
		return strftime($fmt, $udate);
	else
		return strftime("%A, %d-%B-%Y %T", $udate);
}


// html safe encoding to a certain max length
function maxLenEncode( $string, $maxlength = -1 ) {

	$string = htmlspecialchars( $string, ENT_NOQUOTES );

	if( $maxlength > 0 && strlen( $string ) > $maxlength ) {

		$string = substr( $string, 0, $maxlength );

		if( false !== ($p = strrpos( $string, '&') ) ) {

			$string = substr( $string, 0, $p );

		}
	}

	return $string;
}


?>
