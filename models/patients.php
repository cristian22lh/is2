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
	
	$patients = q_getPatients( $whereCluase, $replacements );
	
	$removeSuccess = false;
	$removeError = false;
	$editError = false;
	if( __issetGETField( 'exito', 'borrar-paciente' ) ) {
		$removeSuccess = true;
	// ... o de error
	} else if( __issetGETField( 'error', 'borrar-paciente' ) ) {
		$removeError = true;
	} else if( __issetGETField( 'error', 'editar-paciente' ) ) {
		$editError = true;
	}

// LOAD THE VIEW
	__render( 
		'patients', 
		array(
			'username' => $username,
			'patients' => $patients,
			'removeSuccess' => $removeSuccess,
			'removeError' => $removeError,
			'editError' => $editError
		)
	);

?>
