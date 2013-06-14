<?php
	
	$id = Router::seg( 2 );

	$rowsAffected = DB::delete(
		'
			DELETE FROM
				pacientes
			WHERE
				id = ?
		',
		array( $id )
	);
	// error si borrar un paciente con turnos
	if( $rowsAffected != 1 ) {
		__redirect( '/pacientes?error=borrar-paciente&id=' . $id );
	}
	
	__redirect( '/pacientes?exito=borrar-paciente' );
	
?>