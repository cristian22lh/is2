<?php

// ESTAS VARIABLES SON LAS QUE SE USAN EL VIEW
	$username = __getUsername();
	
	$insurances = $db->select(
		'
			SELECT
				*
			FROM
				obrasSociales
			ORDER BY
				nombreCorto
		'
	);
	
	$createSuccess = false;
	$createError = false;
	$editSuccess = false;
	$editError = false;
	$removeSuccess = false;
	$removeError = false;
	if( __issetGETField( 'exito', 'crear-obra-social' ) ) {
		$createSuccess = true;
	} else if( __issetGETField( 'error', 'crear-obra-social' ) ) {
		$createError = true;
	
	} else if( __issetGETField( 'exito', 'editar-obra-social' ) ) {
		$editSuccess = true;
	} else if( __issetGETField( 'error', 'editar-obra-social' ) ) {
		$editError = true;
	
	} else if( __issetGETField( 'exito', 'borrar-obra-social' ) ) {
		$removeSuccess = true;
	} else if( __issetGETField( 'error', 'borrar-obra-social' ) ) {
		$removeError = true;
	}

	// render
	require './views/insurances.php';

?>
