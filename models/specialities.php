<?php

// ESTAS VARIABLES SON LAS QUE SE USAN EL VIEW
	$username = __getUsername();
	
	$specialities = q_getAllSpecialities();
	
	$createSuccess = false;
	$editSuccess = false;
	if( __issetGETField( 'exito-crear' ) ) {
		$createSuccess = true;
	} else if( __issetGETField( 'exito-editar' ) ) {
		$editSuccess = true;
	}
	
// LOAD THE VIEW
	__render( 
		'specialities', 
		array(
			'username' => $username,
			'createSuccess' => $createSuccess,
			'editSuccess' => $editSuccess,
			'specialities' => $specialities
		)
	);

?>