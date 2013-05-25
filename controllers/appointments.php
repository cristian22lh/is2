<?php
	
// TODAS ESTAS SON VARIABLES QUE DEBEN USARSE EN LA VIEW //
	$username = __getUsername();
	$currentDate = date( 'd/m/Y' );
	
	$confirmSuccess = false;
	$confirmError = false;
	$cancelSuccess = false;
	$cancelError = false;
	$removeSuccess = false;
	$removeError = false;
	$resetSuccess = false;
	$resetError = false;
	// aca veo si vengo de un confirmar-turno, el cual fue ok
	// con esto mostrare los respectivos mensajes de exito...
	if( __issetGETField( 'exito', 'confirmar-turno' ) ) {
		$confirmSuccess = true;
	// ... o de error
	} else if( __issetGETField( 'error', 'confirmar-turno' ) ) {
		$confirmError = true;
	
	} else if( __issetGETField( 'exito', 'cancelar-turno' ) ) {
		$cancelSuccess = true;
	} else if( __issetGETField( 'error', 'cancelar-turno' ) ) {
		$cancelError = true;
	
	} else if( __issetGETField( 'exito', 'borrar-turno' ) ) {
		$removeSuccess = true;
	} else if( __issetGETField( 'error', 'borrar-turno' ) ) {
		$removeError = true;
	
	} else if( __issetGETField( 'exito', 'reiniciar-turno' ) ) {
		$resetSuccess = true;
	} else if( __issetGETField( 'error', 'reiniciar-turno' ) ) {
		$resetError = true;
	}
	
	// debo tomar todos las rows con fecha actual + 7 dias
	$turnos = $db->select( 
		'
			SELECT 
				t.id, t.fecha, t.hora, t.estado,
				m.nombres AS medicoNombres, m.apellidos AS medicoApellidos,
				p.nombres AS pacienteNombres, p.apellidos AS pacienteApellidos
			FROM turnos AS t 
				INNER JOIN medicos AS m 
					ON m.id = t.idMedico 
				INNER JOIN pacientes AS p 
					ON p.id = t.idPaciente 
			WHERE fecha >= ? AND fecha <= ?
		',
		array( date( 'Y-m-d' ), date( 'Y-m-d', strtotime( '+7 days' ) ) )
	);
	
	// render
	require './views/appointments.php';

?>