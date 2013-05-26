<?php

	if( __issetPOST( array( 'fecha', 'hora', 'idMedico', 'idPaciente' ) ) ) {
		$fecha = __toISODate( $_POST['fecha'] );
		$hora = __toISOTime( $_POST['hora'] );
		$idMedico = __validateID( $_POST['idMedico'] );
		$idPaciente = __validateID( $_POST['idPaciente'] );
		
		if( !$fecha || !$hora || !$idMedico || !$idPaciente ) {
			__redirect( '/turnos/crear?error=crear-turno' );
		}
		
		$insertId = $db->insert(
			'
				INSERT INTO 
					turnos
				VALUES
					( null, ?, ?, ?, ?, ? )
			',
			array( $fecha, $hora, $idMedico, $idPaciente, 'esperando' )
		);
		
		if( !$insertId ) {
			__redirect( '/turnos/crear?error=crear-turno' );
		}
		
		__redirect( '/turnos?id=' . $insertId );
	}


// PIDO LA LISTA DE DOCTORES
	$doctors = $db->select(
		'
			SELECT
				*
			FROM 
				medicos
			ORDER BY
				apellidos, nombres
		'
	);

// TODAS ESTAS SON VARIABLES QUE DEBEN USARSE EN LA VIEW //
	$username = __getUsername();
	
// VENGO DE UN $_POST PERO HUBO PROBLEMAS
	if( __GETField( 'error' ) ) {
		$createError = true;
	} else {
		$createError = false;
	}

	// render
	require './views/appointments.new.php';
	
?>