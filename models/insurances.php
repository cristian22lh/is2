<?php

// ESTAS VARIABLES SON LAS QUE SE USAN EL VIEW
	$username = __getUsername();
	
	$insurances = q_getAllInsurances();
	
	$createSuccess = false;
	$editSuccess = false;
	if( __issetGETField( 'exito', 'crear-obra-social' ) ) {
		$createSuccess = true;
	} else if( __issetGETField( 'exito', 'editar-obra-social' ) ) {
		$editSuccess = true;
	}

// LOAD THE VIEW
	__render( 
		'insurances', 
		array(
			'username' => $username,
			'createSuccess' => $createSuccess,
			'editSuccess' => $editSuccess,
			'insurances' => $insurances
		)
	);

?>