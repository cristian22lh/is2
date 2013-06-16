<?php
	
	$id = Router::seg( 2 );
	
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