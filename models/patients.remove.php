<?php

	if( !__issetPOST( array( 'id' ) ) ) {
		__redirect( '/pacientes?error=borrar-paciente' );
	}
	
	$id = __validateID( $_POST['id'] );
	if( !$id ) {
		__redirect( '/pacientes?error=borrar-paciente' );
	}

	$rowsAffected = DB::delete(
		'
			DELETE FROM
				pacientes
			WHERE
				id = ?
		',
		array( $id )
	);

	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected != 1 ) {
		__redirect( '/pacientes?error=borrar-paciente' );
	}
	
	__redirect( '/pacientes?exito=borrar-paciente' );
	
?>
