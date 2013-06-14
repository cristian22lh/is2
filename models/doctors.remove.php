<?php

	$id = Router::seg( 2 );

	$rowsAffected = DB::delete(
		'
			DELETE FROM
				medicos
			WHERE
				id = ?
		',
		array( $id )
	);

	// error si borrar un paciente con turnos
	if( $rowsAffected != 1 ) {
		__redirect( '/medicos?error=borrar-medico' );
	}
	
	__redirect( '/medicos?exito=borrar-medico' );
	
?>