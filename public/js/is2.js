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