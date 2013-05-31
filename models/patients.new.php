<?php

	if( __issetPOST( array( 'lastName', 'firstName', 'gender', 'dni', 'birthDate', 'phone', 'insuranceID', 'insuranceNumber' ) ) ) {
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
		$insuranceID = __sanitizeValue( $_POST['insuranceID'] );
		$insuranceNumber = __sanitizeValue( $_POST['insuranceNumber'] );
		
		if( !$lastName || !$firstName || !$gender || !$dni || !$birthDate || !$phone || !$insuranceID || !$insuranceNumber ) {
			__redirect( '/pacientes/crear?error=crear-paciente' );
		}
		
		$insertId = $g_db->insert( 
			'
				INSERT INTO
					pacientes
				VALUES
					( null, ?, ?, ?, ?, ?, ?, ?, ? )
			',
			array( $lastName, $firstName, $gender, $dni, $birthDate, $phone, $insuranceID, $insuranceNumber )
		);
		die;
		if( !$insertId ) {
			__redirect( '/pacientes/crear?error=crear-paciente' );
		}
		
		__redirect( '/pacientes?id=' . $insertId );
	}

// PIDO LA LISTA DE OBRAS SOCIALES
	$insurances = q_getAllInsurances();

// TODAS ESTAS SON VARIABLES QUE DEBEN USARSE EN LA VIEW //
	$username = __getUsername();
	
// VENGO DE UN $_POST PERO HUBO PROBLEMAS
	if( __GETField( 'error' ) ) {
		$createError = true;
	} else {
		$createError = false;
	}
	
// LOAD THE VIEW
	__render( 
		'patients.new', 
		array(
			'username' => $username,
			'createError' => $createError,
			'insurances' => $insurances
		)
	);
	
?>