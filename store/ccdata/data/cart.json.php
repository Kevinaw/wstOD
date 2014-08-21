<?php
/** @version $Revision: 3913$ */ 

// PHP4 doesn't have the json module
if( !function_exists('json_encode') )
{
  function json_encode ( $a=false )
  {
    if( is_null($a) ) return 'null';
    if( $a === false ) return 'false';
    if( $a === true ) return 'true';
    if( is_scalar($a) ) {
	
      if( is_float($a) ) {
        // Always use "." for floats.
        return floatval( str_replace(",", ".", strval($a)) );
      }

      if( is_string($a) ) {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace( $jsonReplaces[0], $jsonReplaces[1], $a ) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for( $i = 0, reset($a); $i < count($a); $i++, next($a) ) {
      if( key($a) !== $i ) {
        $isList = false;
        break;
      }
    }

    $result = array();
    if( $isList ) {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    } else {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}


foreach( $myPage->getCartProducts() as $prd ) {
	
	$product = $myPage->getProduct( $prd['productid'] );
	
	$data['lineitems'][] = array( 'cid' => $prd['cartid'],
								  'qty'=> $myPage->cart->getUnitsOfProduct( $prd['cartid'] ),
								  'unitprice' => $product['yourprice'],
								  'subtotal' => $myPage->getCartSubtotalPriceProduct( $prd['cartid'] ) );
}
$data['message'] = $myPage->getCartMessage() ? $myPage->getCartMessage() : '';
$data['subtotal'] = $myPage->getCartSubTotal();
$data['total'] = $myPage->getCartGrandTotal();
$data['shippingtotal'] = $myPage->getCartShippingHandlingTotal();
$data['shippingmethod'] = $myPage->getExtraShippingIndex();
$data['shippingdest'] = $myPage->cart->getTaxLocationId();
$data['taxes'] = $myPage->getCartTaxTotal();
$data['currencysymbol'] = $myPage->getConfig('currencysymbol');

echo json_encode( $data );

?>