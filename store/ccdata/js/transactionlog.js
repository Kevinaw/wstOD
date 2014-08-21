var oTable;
var refCodeCol = 6;			// col where the ref. code can be found

$(document).ready( function() {

	$("#sortable tbody").click( function( event ) {

		// remove all class tags and add new class tag to the parent row
		$(oTable.fnSettings().aoData).each( function () {
			$(this.nTr).removeClass('row_selected');
		} );
		$(event.target.parentNode).addClass('row_selected');

		ShowDetailView();
		
	} );

	$("input:checkbox").click( function( event ) {
		
		EnableOperButtons();
	
	} );

	$("input:checkbox:#selall").click( function( event ) {

		$("input:checkbox:not(#selall)").attr('checked', this.checked);
		EnableOperButtons();

	} );

	// key down events (multiple if key stays pressed down )
	$( document ).keydown( function( event ) {

		var show = $('#colorbox:visible').get().length > 0;

		switch( event.keyCode ) {

			case 38:						// arrow up
				SelectedRowUp();
				if( show ) { ShowDetailView(); }
				break;

			case 40:						// arrow down
				SelectedRowDown();
				if( show ) { ShowDetailView(); }
				break;
		}
		
	} );

	// key up events, always single events
	$( document ).keyup( function( event ) {

		switch( event.keyCode ) {

			case 13:						// return
				ShowDetailView();
				break;					

			case 27:						// escape
				break;

			case 33:						// previous page
				DoPage( 'previous' );
				break;
				
			case 34:						// next page
				DoPage( 'next' );
				break;
			}
	} );

	// Init the table
	oTable = $('#sortable').dataTable( { "bStateSave": true,
										 "bJQueryUI": true,
										 "sPaginationType": "full_numbers",
										 "aoColumns": [
											{ "bSortable": false},
									        { "bSortable": true, "sClass": "amount" },
									        { "sClass": "lines" },
									        { "sClass": "status" },
									        null, null,null
									     ],
									     "aaSorting": [[3, 'desc']],
									     "oLanguage": {
									     	"sLengthMenu": 'Display <select>'+
									     	'<option value="10">10</option>'+
											'<option value="15">15</option>'+
											'<option value="20">20</option>'+
											'<option value="25">25</option>'+
											'<option value="50">50</option>'+
											'<option value="-1">All</option>'+
											'</select> records'
											}
									   } );
	// set first row selected
	$("#sortable tbody tr:first").addClass('row_selected');

	// Add to logout popup
	$('#logout').colorbox({ inline:true,
							href:"#logout_message" } );
	
	// add tooltips to the status column post-init, use legend div to find text
	$("div.legend").hide();
	$("td.status", oTable.fnGetNodes() ).tooltip( {
		"delay": 0,
		"track": true,
		"fade": 250,
		"bodyHandler" : function () {
			var text = $("div.legend dd."+ this.innerHTML.toLowerCase() ).text();
			if( ! text ) text = $("div.legend dd.other").text();
			return text; }
 	} );

	// connect printer, use live, because the element only exists when the details are loaded
	$('#printdetail').live( 'click',  function( event ) {
		$( '#detailscontainer' ).printElement();	
	} );
	
	//connect mailer
	$('#emaildetail').live( 'click', function( event ) {
		$('#emailer').show();
	});
	
	EnableOperButtons();
} );


function GetSelectedRow( oTableLocal )
{
	var aReturn = new Array();
	var aTrs = oTableLocal.fnGetNodes();

	for ( var i = 0; i < aTrs.length; i++ )
	{
		if ( $(aTrs[i]).hasClass('row_selected') )
		{
			aReturn.push( aTrs[i] );
		}
	}
	return aReturn;
}


function GetCellContents ( cellindex ) {

	var anSelected = GetSelectedRow( oTable );
	var iRow = oTable.fnGetPosition( anSelected[0] );
	var aData = oTable.fnGetData( iRow );

	return aData[cellindex];
}


// used by colorbox
function ShowDetailView ( ) {
	var code  = GetCellContents( refCodeCol );
	if( code ) {
		$.fn.colorbox({	href:location.href.replace(/(#|\?).*$/, "") + "?ajx=1&item=" + code,
						maxWidth:"700px"
		});
	}
}


function SelectedRowUp( ) {
	
	if( $( "#sortable tbody tr.row_selected").length == 0 ) {

		$("#sortable tbody tr:last").addClass('row_selected');
		
	} else {	
		
		$("#sortable tbody tr.row_selected")
			.filter(":not('#sortable tbody tr:first')")
			.removeClass('row_selected')
			.prev().addClass('row_selected');
	}
}


function SelectedRowDown( ) {

	if( $( "#sortable tbody tr.row_selected").length == 0 ) {

		$("#sortable tbody tr:first").addClass('row_selected');
		
	} else {	

		$("#sortable tbody tr.row_selected")
			.filter(":not('#sortable tbody tr:last')")
			.removeClass('row_selected')
			.next().addClass('row_selected');
	}
}


function DoPage ( direction ) {

	// remove selection or we may get more than 1 row selected
	$("#sortable tbody tr.row_selected").removeClass('row_selected');
	
	var selector = direction == 'next' ? 'span.next' : 'span.previous'; 
	$("div.dataTables_paginate " + selector).trigger('click');	
}


function EnableOperButtons ( ) {
	
	if( $( "input:checkbox:not(#selall)" ).is(":checked") ) {
		$("input.oper").attr('disabled', false);
	} else 	{
		$("input.oper").attr('disabled', true);
	}		
}