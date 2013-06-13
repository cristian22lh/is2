<?php

	if( !__issetPOST( array( 'id' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$id = __validateID( $_POST['id'] );
	if( !$id ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$rowsAffected = DB::delete(
		'
			DELETE FROM
				obrasSociales
			WHERE
				id = ?
		',
		array( $id )
	);

	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected != 1 ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array(
		'success' => true,
		'data' => array(
			'id' => $id
		)
	) );
	
?>