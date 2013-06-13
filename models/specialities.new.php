<?php

	if( !__issetPOST( array( 'name' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$name = __sanitizeValue( $_POST['name'] );
	if( !$name ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$insertId = DB::insert(
		'
			INSERT INTO
				especialidades
			VALUES
				( null, ? )
		',
		array( strtolower( $name ) )
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