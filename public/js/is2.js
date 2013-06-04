var IS2 = IS2 || {};
	
IS2.initDatepickers = function( setDefaultValue ) {
	var $elems = $( '.datepicker' ).datepicker( {
		format: 'dd/mm/yyyy',
		language: 'es'
	} );
	if( setDefaultValue ) {
		$elems.datepicker( 'setValue', new Date() );
	}
};

IS2.initTimepickers = function( config ) {
	$( '.timepicker' ).timepicker( $.extend( {
		showInputs: false,
		showMeridian: false
	}, config ) );	
};

IS2.prevStateDict = [
	'is2-appointment-state'
];

IS2.cleanPrevState = function( skip ) {
	IS2.prevStateDict.forEach( function( name ) {
		if( skip !== name ) {
			localStorage.removeItem( name );
		}
	} );
};

IS2.loadPrevState = function( name, callback ) {
	var prevState = JSON.parse( localStorage.getItem( name ) );
	if( prevState ) {
		if( window.location.search.indexOf( 'error' ) >= 0 ) {
			for( var fieldName in prevState ) {
				$( '[name=' + fieldName + ']' ).val( prevState[fieldName] );
			}
		}
		this.cleanPrevState( name );
		callback && callback( prevState );
	}
};

IS2.savePrevState = function( name, skip ) {
	var prevState = {};
	$( 'form ' ).find( 'input, select' ).each( function( e ) {
		var $el = $( this ),
			fieldName = $el.attr( 'name' );
		if( fieldName && fieldName !== skip ) {
			prevState[fieldName] = $el.val().replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
		}
	} );
	window.localStorage.setItem( name, JSON.stringify( prevState ) );
};

IS2.showNewRecord = function( $el ) {
	
	var $document = $( document ),
		$popoverTemplate = $( '.is2-record-new-popover' ),
		$popoverClose = $( '.is2-record-new-popover-close' ),
		$popover,
		closePopupTimeout;
	
	$el.addClass( 'is2-record-new' ).popover( {
		trigger: 'manual',
		placement: 'bottom',
		html: true,
		content: $popoverTemplate.prop( 'outerHTML' )
	} );

	$popover = $el.data( 'popover').tip();
	$popover.css( 'visibility', 'hidden' );
	$el.popover( 'show' );
	$popover.css( 'top', '+=10' ).hide().css( 'visibility', 'visible' ).fadeIn( 'fast' ).animate( { top: '-=15' } );

	$popoverClose.on( 'click', function( e ) {
		e.stopPropagation();
		$el.popover( 'hide' ).removeClass( 'is2-record-new' ).off( 'click', arguments.callee );
		window.clearTimeout( closePopupTimeout );
	} );
	$document.on( 'click', function( e ) {
		var $el = $( e.target );
		while( $el.length && !$el.hasClass( 'popover' ) ) { 
			$el = $el.parent();
		}
		if( !$el.length ) {
			$popoverClose.click();
			$document.off( 'click', arguments.callee )
		}
	} );
	closePopupTimeout = window.setTimeout( function() {
		$popoverClose.click();
	}, 5000 );	
	
};