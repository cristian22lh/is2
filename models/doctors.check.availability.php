<?php

	if( !__issetPOST( array( 'date', 'time', 'doctorID' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$date = __toISODate( $_POST['date'] );
	$time = __toISOTime( $_POST['time'] );
	$doctorID = __validateID( $_POST['doctorID'] );
	
	if( !$date || !$time || !$doctorID ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	// debo saber cual es dia en donde case $date
	$day = date( 'N', strtotime( $date ) );
	$res = q_checkDoctorAvailability( array( $doctorID, $time, $time, $day ) );
	// el doctor no antiende tal dia
	if( !count( $res ) ) {
		__echoJSON( array( 'success' => false, 'type' => 'range' ) );
	}
	
	// ahora debp fijarme que no tenga ya un turno para ese ida
	$res = $g_db->select(
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
	
	// ya hay un turno registrado para esa fecha
	if( count( $res ) ) {
		__echoJSON( array( 'success' => false, 'type' => 'exists' ) );
	}
	
	__echoJSON( array( 'success' => true ) );
	
?>