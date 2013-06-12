<?php

	if( !__issetPOST( array( 'id', 'abbr', 'full' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$shortName = __sanitizeValue( $_POST['abbr'] );
	$fullName = __sanitizeValue( $_POST['full'] );
	$id = __validateID( $_POST['id'] );
	if( !$shortName || !$id ) {
		__echoJSON( array( 'success' => false ) );
	}
	
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