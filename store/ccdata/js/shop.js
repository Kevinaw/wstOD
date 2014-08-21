var scc_jquery = jQuery;
jQuery.noConflict(true);

function showError ( message ) {
	if( ! message ) {
		scc_jquery("#scs_cartmessages").css('display','none') ;
	} else {
		scc_jquery("#scs_cartmessages_content").html( message );
		scc_jquery("#scs_cartmessages").css('display','block') ;
		
		// Animates to ensure the visibility of the error message
		scc_jquery('html, body').animate( {scrollTop: scc_jquery("#scs_cartmessages").offset().top - 10 }, 500);
		
	}
}

// Returns the version of Internet Explorer or a -1 (indicating the use of another browser).
function getInternetExplorerVersion()
{
	var rv = -1; // Return value assumes failure.
	if (navigator.appName == 'Microsoft Internet Explorer')
	{
		var ua = navigator.userAgent;
		var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		if (re.exec(ua) != null)
		  rv = parseFloat( RegExp.$1 );
	}
	return rv;
}


function checkIE6Version()
{
	var ver = getInternetExplorerVersion();

	if ( ver > -1 )
	{
		if ( ver < 7.0 )
		{			
			return true;
		}
	}
	return false;
}

// Show the visual hint for the user to wait for the ajax to be finished
function show_spinner(){
    scc_jquery('img#ajax_waiting_spinner').css('display', 'block');
}
 
// Hides the visual hint once the ajax query has been processed
function hide_spinner(){
    scc_jquery('img#ajax_waiting_spinner').css('display', 'none');
}

function updateCartValues ( ) {

	// clone the form data and add the format=json
	var fc = scc_jquery("form.cart").clone( true );
	scc_jquery( "#extrashipid", fc ).val( scc_jquery("#extrashipid").val() ) 
	scc_jquery( "#taxlocid", fc ).val( scc_jquery("#taxlocid").val() ) 
	fc.append('<input type="hidden" name="format" value="json">')
	  .append('<input type="hidden" name="method" value="update">');
	  
	// Shows the spinner as visual hint to the user that something is being processed.
	show_spinner();

	//  do the async request and update the fields
	scc_jquery.post( scc_jquery("form.cart").attr("action"),
					 fc.serialize(),
					 function( data ) {
						// update the cart
						showError( data.message );
						scc_jquery("#cart_total").html( data.currencysymbol + data.total );
						scc_jquery("#cart_subtotal").html( data.currencysymbol + data.subtotal )
						scc_jquery("#cart_shipping_total").html( data.currencysymbol +  data.shippingtotal )
						
						// Hides the taxes in case they are empty
						if( data.taxes == '0.00' ) {
							scc_jquery("#cart_taxes_total_label").html( '' )
							scc_jquery("#cart_taxes_total").html( '' )
						} else {
							scc_jquery("#cart_taxes_total_label").html( 'Estimated Taxes:' )
							scc_jquery("#cart_taxes_total").html( data.currencysymbol + data.taxes )
						}
						
						for( var li in data.lineitems ) {
							var sel = "#product_subtotal_" + data.lineitems[li].cid;
							scc_jquery( sel ).html( data.currencysymbol + data.lineitems[li].subtotal )
						}
						
						// Hides the spinner as visual hint to the user that something is being processed.
						hide_spinner();
					 },
					 "json" );	
}


// for the cart and product pages
scc_jquery(document).ready(
	
	function() {
		
		// Adds to the dom the spinner element. It will be hided until an ajax request is handled
		//scc_jquery(function(){
		//	var spinner = scc_jquery('<img id="ajax_waiting_spinner" src="ccdata/images/spinner.gif" />');
		//	spinner.css({ display: 'none', position: 'fixed', top:'50%', left:'50%' });
		//	scc_jquery('body').append(spinner);
		//});

 		// get fresh data after changes
		scc_jquery("#extrashipid, #taxlocid, div.scs_cart_quantity_input_wrapper>input").bind("change",
			function(e) { updateCartValues(); }
		);
		
		// add some validation on input fields for cart page
		scc_jquery("form.cart input[type='text']").bind("keyup",
			function(e) {
				// validate all input fields
				var elms = scc_jquery("form.cart input[type='text']");
				var valid = true;
				for( i = 0; i < elms.length; i++ ) {
					valid = (elms[i].value.search(/[^0-9 ]/) == -1);
					if( ! valid ) {
						showError("Only numbers are allowed in the Quantity field(s).");
						scc_jquery("form.cart input[type='submit']").attr("disabled","disabled");
						break;
					}
				}
				if( valid ) {
					showError("");
				}
			}
		);

		// quantity validation for product page
		scc_jquery("input[name='quantity']").bind("keyup",
			function(e) {
				if( this.value.search(/[^0-9 ]/) != -1) {
					showError("Only numbers are allowed in a Quantity field.");
					scc_jquery("input.scs_addtocart[type='submit']").attr("disabled","disabled");
				} else {
					showError("");
					scc_jquery("input.scs_addtocart[type='submit']").attr("disabled","");
				}
			}
		);
		
		// Checks if the IE6 is running
		if( checkIE6Version() )
		{
			scc_jquery("body").prepend("<div id=\"iesix\"><p>Hey! You appear to be using Internet Explorer 6. You really should <a href=\"http://www.coffeecup.com/browserupgrade/\">upgrade to a newer browser</a>, your experience on the Web will be much better.</p></div>");
		}

		// Add target blank for browser that don't support 'rel' attribute
		scc_jquery("a[href][rel=external]").attr('target', '_blank');
 
		// Applies colorbox to the images
	 	scc_jquery("a.colorbox_scc").colorbox_scc({transition:"elastic", width:"75%", height:"75%"});
	
	}
 );