<?php

	if( !__issetPOST( array( 'abbr', 'full' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$shortName = __sanitizeValue( $_POST['abbr'] );
	$fullName = __sanitizeValue( $_POST['full'] );
	if( !$shortName ) {
		__echoJSON( array( 'success' => false ) );
	}
	$id = Router::seg( 2 );
	
	$rowsAffected = DB::update(
		'
			UPDATE
				obrasSociales
			SET
				nombreCorto = ?,
				nombreCompleto = ?
			WHERE
				id = ?
		',
		array( strtolower( $shortName ), $fullName, $id )
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