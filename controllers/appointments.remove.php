<?php
	
	// no se puede acceder a esta pagina sin el $_POST
	if( !__issetPOST( array( 'id' ) ) ) {
		__redirect( '/turnos?error=borrar-turno' );
	
	} else {
		// id del turno
		$id = $_POST['id'];
		
		$rowsAffected = $db->delete(
			'DELETE FROM turnos WHERE id = ?',
			array( $id )
		);
		
		// hubo un error en la query, por ejemplo
		// $id no es un entero, o este correponde
		// a un turno que no existe, etc
		if( $rowsAffected != 1 ) {
			__redirect( '/turnos?error=borrar-turno' );
		
		} else {
			__redirect( '/turnos?exito=borrar-turno' );
		}
	}

?>