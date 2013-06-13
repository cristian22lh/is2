<?php

	if( !__issetPOST( array( 'id' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$id = __validateID( $_POST['id'] );
	if( !$id ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$rowsAffected = DB::update(
		'
			UPDATE
				obrasSociales
			SET
				estado = IF( estado = "habilitada", "deshabilitada", "habilitada" )
			WHERE
				id = ?
		',
		array( $id )
	);
		
	if( !$rowsAffected ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => array(
			'id' => $id
		)
	) );
	
?>