<?php

	$whereCluase = array();
	$replacements = array();

// ESTE ES CUANDO VENGO DE CREAR UN TURNO
	if( ( $newPatient = __GETField( 'id' ) ) && __validateID( $newPatient ) ) {
		$whereCluase[] = ' p.id = ? ';
		$replacements[] = $newPatient;
		
	} else {
		$whereCluase[] = ' 1 = 1 ';
	}

// ESTAS VARIABLES SON LAS QUE SE USAN EL VIEW
	$username = __getUsername();
	
	$patients = $db->select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.email, p.telefono, p.nroAfiliado,
				os.nombreCorto AS obraSocialNombre
			FROM
				pacientes AS p
			INNER JOIN obrasSociales AS os
				ON os.id = p.idObraSocial
			WHERE ' .
				implode( ' AND ', $whereCluase ) .
			'
			ORDER BY
				p.apellidos
		',
		$replacements
	);
	
	$removeSuccess = false;
	$removeError = false;
	if( __issetGETField( 'exito', 'borrar-paciente' ) ) {
		$removeSuccess = true;
	// ... o de error
	} else if( __issetGETField( 'error', 'borrar-paciente' ) ) {
		$removeError = true;
	}

// LOAD THE VIEW
	__render( 
		'patients', 
		array(
			'username' => $username,
			'patients' => $patients,
			'removeSuccess' => $removeSuccess,
			'removeError' => $removeError
		)
	);

?>
