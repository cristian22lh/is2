<?php

// TENER EN CUENTA QUE ESTO SOLO DEVUELVE UN SOLO PACIENTE, NO VARIOS!!!

	if( !__issetPOST( array( 'dni' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}

	$dni = __cleanDNI( $_POST['dni'] );
	if( !$dni ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$patients = $db->select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.email, p.telefono, p.nroAfiliado,
				os.nombreCorto AS obraSocialNombre
			FROM
				pacientes AS p
			INNER JOIN obrasSociales AS os
				ON os.id = p.idObraSocial
			WHERE
				dni = ?
		',
		array( $dni )
	);
	
	if( count( $patients ) ) {
		$patient = $patients[0];
		$patient['nombreCompleto'] = $patient['apellidos'] . ', ' . $patient['nombres'];
		$patient['edad'] = date_diff( date_create( $patient['fechaNacimiento'] ), date_create() )->format( '%Y' );
	
	} else {
		$patient = null;
	}
	
	__echoJSON( array( 'success' => true, 'data' => $patient ) );
	
?>