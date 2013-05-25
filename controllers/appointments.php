<?php

// PIDO LOS TURNOS DEPEDIENDO LO QUE HAYA EN $_GET 
	$orderByField = 'fecha';
	$orderByType = 'ASC';
	// siempre ordernamos por hora
	$orderByTimeType = 'ASC';
	// usada para mostrar turnos segun su estado
	$statusValue = false;
	// me fijo si la grid esta siendo ordenado por algun tipo de orden
	if( __issetGETField( 'fecha', 'desc' ) ) {
		$orderByField = 'fecha';
		$orderByType = 'DESC';
		
	// notecese que no hay $orderByField = 'hora'
	// esto es porque siempre ordenamos por hora
	// no puede faltar nunca
	} else if( __issetGETField( 'hora', 'desc' ) ) {
		$orderByTimeType = 'DESC';

	} else if( __issetGETField( 'medico', 'asc' ) ) {
		$orderByField = 'm.apellidos';
		$orderByType = 'ASC';
	} else if( __issetGETField( 'medico', 'desc' ) ) {
		$orderByField = 'm.apellidos';
		$orderByType = 'DESC';
		
	} else if( __issetGETField( 'paciente', 'asc' ) ) {
		$orderByField = 'm.apellidos';
		$orderByType = 'ASC';
	} else if( __issetGETField( 'paciente', 'desc' ) ) {
		$orderByField = 'p.apellidos';
		$orderByType = 'DESC';
	
	} else if( __issetGETField( 'estado', 'confirmados' ) ) {
		$statusValue = 'confirmado';
	} else if( __issetGETField( 'estado', 'cancelados' ) ) {
		$statusValue = 'cancelado';
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
			WHERE fecha >= ? AND fecha <= ? ' . ( $statusValue ? "AND t.estado = '$statusValue'" : '' ) . ' ' .
			'ORDER BY ' .
				"$orderByField $orderByType" . ( $orderByField != 'hora' ? ", t.hora $orderByTimeType" : '' )
		,
		array( date( 'Y-m-d' ), date( 'Y-m-d', strtotime( '+7 days' ) ) )
	);
	
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
	
	// render
	require './views/appointments.php';

?>