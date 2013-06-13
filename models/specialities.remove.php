<?php
	
	$id = Router::seg( 2 );
	
	$rowsAffected = DB::delete(
		'
			DELETE FROM
				especialidades
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