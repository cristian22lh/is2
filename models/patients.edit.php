<?php

	// get last seg from /pacientes/122/editar
	$patientID = $g_router->seg( 2 );

	if( __issetPOST( array( 'lastName', 'firstName', 'gender', 'dni', 'birthDate', 'phone', 'email', 'insuranceID', 'insuranceNumber' ) ) ) {
		$lastName = __sanitizeValue( $_POST['lastName'] );
		$firstName = __sanitizeValue( $_POST['firstName'] );
		$gender = __validateGender( $_POST['gender'] );
		$dni = __cleanDNI( $_POST['dni'] );
		$birthDate = __toISODate( $_POST['birthDate'] );
		// la fecha de nacimiento no puede ser mayor al dia presente
		if( strtotime( $birthDate ) > strtotime( 'today +1 day' ) ) {
			$birthDate = false;
		}
		$phone = __sanitizeValue( $_POST['phone'] );
		$email = __validateEmail( $_POST['email'] );
		$insuranceID = __sanitizeValue( $_POST['insuranceID'] );
		$insuranceNumber = __sanitizeValue( $_POST['insuranceNumber'] );
		
		if( !$lastName || !$firstName || !$gender || !$dni || !$birthDate || !$phone || !$email || !$insuranceID || !$insuranceNumber ) {
			__redirect( '/pacientes/editar/' . $patientID .'?error=editar-paciente' );
		}
		
		$rowsAffected = $g_db->update( 
			'
				UPDATE
					pacientes
				SET
					apellidos = ?,
					nombres = ?,
					sexo = ?,
					dni = ?,
					fechaNacimiento = ?,
					telefono = ?,
					email = ?,
					idObraSocial = ?,
					nroAfiliado = ?
				WHERE
					id = ?
			',
			array( $lastName, $firstName, $gender, $dni, $birthDate, $phone, $email, $insuranceID, $insuranceNumber, $patientID )
		);

		// puede pasar que submitee el form tal cual esta, no pasa nada, y por el < 0
		if( $rowsAffected < 0 ) {
			__redirect( '/pacientes/editar/' . $patientID . '?error=editar-paciente' );
		}
		
		__redirect( '/pacientes/editar/' . $patientID . '?exito=editar-paciente' );
	}

// DEBO PEDIR EL PACIENTE QUE ESTA EN LA URL
	$patients = q_getPatients( array( ' p.id = ? ' ), array( $patientID ) );
	if( !count( $patients ) ) {
		__redirect( '/pacientes?error=editar-paciente' );
	}
	$patient = $patients[0];

// PIDO LA LISTA DE OBRAS SOCIALES
	$insurances = q_getAllInsurances();

// TODAS ESTAS SON VARIABLES QUE DEBEN USARSE EN LA VIEW //
	$username = __getUsername();
	
	if( __GETField( 'error' ) ) {
		$editError = true;
	} else {
		$editError = false;
	}
	
	$editSuccess = false;
	$editError = false;
	if( __issetGETField( 'exito', 'editar-paciente' ) ) {
		$editSuccess = true;
	} else if( __issetGETField( 'error', 'editar-paciente' ) ) {
		$editError = true;
	}

// LOAD THE VIEW
	__render( 
		'patients.edit', 
		array(
			'username' => $username,
			'editSuccess' => $editSuccess,
			'editError' => $editError,
			'insurances' => $insurances,
			'patient' => $patient
		)
	);
	
?>