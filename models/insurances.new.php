<?php

	if( !__issetPOST( array( 'abbr', 'full' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$abbr = __sanitizeValue( $_POST['abbr'] );
	// full puede estar vacio
	$full = __sanitizeValue( $_POST['full'] );
	if( !$abbr ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$insertId = DB::insert(
		'
			INSERT INTO
				obrasSociales
			VALUES
				( null, ?, ?, ? )
		',
		array( strtolower( $abbr ), $full, 'habilitada' )
	);
	
	// maybe a constraint error
	if( !$insertId ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => array(
			'id' => $insertId
		)
	) );
	
?>