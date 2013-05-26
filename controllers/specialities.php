<?php

// ESTAS VARIABLES SON LAS QUE SE USAN EL VIEW
	$username = __getUsername();
	
	$specialities = $db->select(
		'
			SELECT
				*
			FROM
				especialidades
			ORDER BY
				nombre
		'
	);
	
	$createSuccess = false;
	$createError = false;
	$editSuccess = false;
	$editError = false;
	$removeSuccess = false;
	$removeError = false;
	if( __issetGETField( 'exito', 'crear-especialidad' ) ) {
		$createSuccess = true;
	} else if( __issetGETField( 'error', 'crear-especialidad' ) ) {
		$createError = true;
	
	} else if( __issetGETField( 'exito', 'editar-especialidad' ) ) {
		$editSuccess = true;
	} else if( __issetGETField( 'error', 'editar-especialidad' ) ) {
		$editError = true;
	
	} else if( __issetGETField( 'exito', 'borrar-especialidad' ) ) {
		$removeSuccess = true;
	} else if( __issetGETField( 'error', 'borrar-especialidad' ) ) {
		$removeError = true;
	}

	// render
	require './views/specialities.php';

?>
