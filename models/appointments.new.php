<?php

	if( __issetPOST( array( 'fecha', 'hora', 'idMedico', 'idPaciente' ) ) ) {
		$date = __toISODate( $_POST['fecha'] );
		$time = __toISOTime( $_POST['hora'] );
		$doctorID = __validateID( $_POST['idMedico'] );
		$patientID = __validateID( $_POST['idPaciente'] );
		
		if( !$date || !$time || !$doctorID || !$patientID ) {
			__redirect( '/turnos/crear?error=crear-turno' );
		}
		
		// internamente la base de datos hara las siguientes comprobaciones
		// 1) si el doctor atiende en el dia, hora y fecha especificados
		// 2) el turno no puede ser mayor a 7 dias delante del dia actual y 
		//	tampoco una fecha anterior a la actual
		// 3) que el medico soporte la obra social del paciente
		// 4) que no exista una un turno YA registrado con la misma fecha, hora y idMedico
		// 5) TODO: checkear medicos licencia
		$insertId = $g_db->insert(
			'
				INSERT INTO 
					turnos
				VALUES
					( null, ?, ?, ?, ?, ? )
			',
			array( $date, $time, $doctorID, $patientID, 'esperando' )
		);
		
		if( !$insertId ) {
			__redirect( '/turnos/crear?error=crear-turno' );
		}
		
		__redirect( '/turnos?id=' . $insertId );
	}

// PIDO LA LISTA DE DOCTORES
	$doctors = q_getAllDoctors();

// TODAS ESTAS SON VARIABLES QUE DEBEN USARSE EN LA VIEW //
	$username = __getUsername();
	
// VENGO DE UN $_POST PERO HUBO PROBLEMAS
	if( __GETField( 'error' ) ) {
		$createError = true;
	} else {
		$createError = false;
	}
	
	$wantedDate = ( $wantedDate = __GETField( 'fecha' ) ) && __toISODate( $wantedDate ) ? $wantedDate : false;
	
// LOAD THE VIEW
	__render( 
		'appointments.new', 
		array(
			'username' => $username,
			'createError' => $createError,
			'doctors' => $doctors,
			'wantedDate' => $wantedDate
		)
	);
	
?>