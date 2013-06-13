<?php

	if( !__issetPOST( array( 'name' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$name = __sanitizeValue( $_POST['name'] );
	if( !$name ) {
		__echoJSON( array( 'success' => false ) );
	}
	$id = Router::seg( 2 );
	
	$rowsAffected = DB::update(
		'
			UPDATE
				especialidades
			SET
				nombre = ?
			WHERE
				id = ?
		',
		array( strtolower( $name ), $id )
	);

	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected < 0 ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => array(
			'id' => $id
		)
	) );
	
?>