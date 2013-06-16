<?php
	
	$date = __toISODate( __GETField( 'date' ) );
	$time = __toISOTime( __GETField( 'time' ) );
	$doctorID = __validateID( __GETField( 'doctorID' ) );
	
	if( !$date || !$time || !$doctorID ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	// me fijo el medico esta de licencia para la fecha del turno requerido
	$res = DB::select(
		'
			SELECT
				id
			FROM
				licencias
			WHERE
				idMedico = ? AND ? >= fechaComienzo AND ? <= fechaFin
		',
		array( $doctorID, $date, $date )
	);
	$hasLicense = (bool) $res->rowCount();
	
	// pido los horarios del medico
	// eso siempre va estar en la respuesta
	$doctorAvailabilities = q_getDoctorAvailabilities( $doctorID );
	$doctorAvailabilities = $doctorAvailabilities->fetchAll();
	for( $i = 0, $l = count( $doctorAvailabilities ); $i < $l; $i++ ) {
		$doctorAvailability = &$doctorAvailabilities[$i];
		$doctorAvailability['horaIngreso'] = __trimTime( $doctorAvailability['horaIngreso'] );
		$doctorAvailability['horaEgreso'] = __trimTime( $doctorAvailability['horaEgreso'] );
		$doctorAvailability['diaNombre'] = __getDayName( $doctorAvailability['dia'] );
	}
	
	// debo saber cual es dia en donde case $date
	$day = date( 'N', strtotime( $date ) );
	$res = DB::select( 
		'
			SELECT
				id
			FROM
				horarios
			WHERE
				idMedico = ? AND ? >= horaIngreso AND ? <= horaEgreso AND dia = ?
		',
		array( $doctorID, $time, $time, $day )
	);
	// el doctor antiende dia querido??
	$isDoctorAvailable = (bool) $res->rowCount();
	
	// ahora debo fijarme que no tenga ya un turno para ese ida
	$res = DB::select(
		'
			SELECT
				id
			FROM
				turnos
			WHERE
				fecha = ? AND hora = ? AND idMedico = ?
		',
		array( $date, $time, $doctorID )
	);
	$hasAppointmentAlready = (bool) $res->rowCount();
	
	__echoJSON( array( 
		'success' => true,
		'data' => array( 
			'availabilities' => $doctorAvailabilities,
			'isAvailable' =>$isDoctorAvailable,
			'hasAppointmentAlready' => $hasAppointmentAlready,
			'hasLicense' => $hasLicense
		)
	) );
	
?>