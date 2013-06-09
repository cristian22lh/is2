<?php

/* {{{ CUANDO SE CREAR UN NUEVO MEDICO */
	if( __issetPOST( array( 'apellidos', 'nombres', 'especialidad', 'telefono1', 'telefono2', 'direccion', 'matriculaProvincial', 'matriculaNacional' ) ) ) {
		$lastName = __sanitizeValue( $_POST['apellidos'] );
		$firstName = __sanitizeValue( $_POST['nombres'] );
		$specialityID = __validateID( $_POST['especialidad'] );
		$tel1 = __cleanTel( $_POST['telefono1'] );
		$tel2 = __cleanTel( $_POST['telefono2'] );
		$address = __sanitizeValue( $_POST['direccion'] );
		$matProv = __sanitizeValue( $_POST['matriculaProvincial'] );
		$matNac = __sanitizeValue( $_POST['matriculaNacional'] );
		
		// check only the required fields
		$errors = array();
		if( !$lastName ) {
			$errors[] = 'lastName';
		}
		if( !$firstName ) {
			$errors[] = 'firstName';
		}
		if( !$specialityID ) {
			$errors[] = 'speciality';
		}
		
		if( count( $errors ) ) {
			__redirect( '/medicos/crear?error=crear-medico&campos=' . base64_encode( implode( '|', $errors ) ) );
		}

		$insertId = DB::insert( 
			'
				INSERT INTO
					medicos
				VALUES
					( null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
			',
			array( $specialityID, $lastName, $firstName, $tel1, $tel2, $address, $matProv, $matNac, 'default-mini.png', 'default.png' )
		);
		
		if( !$insertId ) {
			__redirect( '/medicos/crear?error=crear-medico&campos=' . base64_encode( implode( '|', DB::getErrorList() ) ) );
		}
		
		__redirect( '/medicos?exito=crear-medico#id=' . $insertId );
	}
/* }}} */

/* {{{ */
	$username = __getUsername();
	
	$specialities = q_getAllSpecialities();
	
// VENGO DE UN $_POST PERO HUBO PROBLEMAS
	if( __GETField( 'error' ) ) {
		$createError = true;
	} else {
		$createError = false;
	}
	
	__render( 
		'doctors.new', 
		array(
			'username' => $username,
			'specialities' => $specialities,
			'createError' => $createError
		)
	);
/* }}} */

?>
