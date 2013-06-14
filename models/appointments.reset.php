<?php
	
	$id = Router::seg( 2 );
	
	$rowsAffected = DB::update(
		'
			UPDATE 
				turnos 
			SET 
				estado = ? 
			WHERE id = ?
		',
		array( 'esperando', $id )
	);
	
	// hubo un error en la query, por ejemplo
	// $id no es un entero, o este correponde
	// a un turno que no existe, etc
	if( $rowsAffected != 1 ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 'success' => true, 'data' => array( 'id' => $id ) ) );

?>