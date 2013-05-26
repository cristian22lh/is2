<?php

// ESTA PARTE ES CUANDO SE ESTA FILTRANDO LAS COLUMANS DE LA GRID
	$orderByClause = array();
	$isOrderByTime = false;
	$isOrderByDate = false;
	// usada para mostrar turnos segun su estado
	$statusValue = false;
	// me fijo si la grid esta siendo ordenado por algun tipo de orden
	if( __issetGETField( 'fecha', 'desc' ) ) {
		$orderByClause[] = 't.fecha DESC';
		$isOrderByDate = true;

	} else if( __issetGETField( 'hora', 'desc' ) ) {
		$orderByClause[]  = 't.hora DESC';
		$isOrderByTime = true;

	} else if( __issetGETField( 'medico', 'asc' ) ) {
		$orderByClause[] = 'm.apellidos ASC';
	} else if( __issetGETField( 'medico', 'desc' ) ) {
		$orderByClause[] = 'm.apellidos DESC';
		
	} else if( __issetGETField( 'paciente', 'asc' ) ) {
		$orderByClause[] = 'm.apellidos ASC';
	} else if( __issetGETField( 'paciente', 'desc' ) ) {
		$orderByClause[] = 'p.apellidos DESC';
	
	} else if( __issetGETField( 'estado', 'confirmados' ) ) {
		$statusValue = 'confirmados';
	} else if( __issetGETField( 'estado', 'cancelados' ) ) {
		$statusValue = 'cancelados';
	}
	// siempre se debe ordernar por hora SOLO SI NO SE ESTA ORDENANDO
	if( !$isOrderByDate && !count( $orderByClause ) ) {
		$orderByClause[] = ' t.fecha ASC ';
	}
	// siempre se debe ordernar por ahora
	if( !$isOrderByTime ) {
		$orderByClause[] = ' t.hora ASC ';
	}
	
// ACA CONSTRUYO EL WHERE DE MI QUERY
	$replacements = array();
	$whereClause = array( ' 1=1 ' );
	// ESTO ES CUANDO EL USUARIO HA HECHO CLICK EN EL BOTON BUSCAR
	if( ( $search = __GETField( 'search' ) ) ) {
		$isSearch = true;
	
		$searchParts = explode( '|', base64_decode( $search ) );
		if( count( $searchParts ) != 5 ) {
			__redirect( '/turnos?error=buscar-turno' );
		}
		// la primera parte es la feha
		$dateRange = explode( '@', $searchParts[0] );
		// no pasa nada si se mete mano en estos datos
		if( isset( $dateRange[0] ) && $dateRange[0] ) {
			$whereClause[] = ' t.fecha >= ? ';
			$replacements[] = $dateRange[0];
		}
		if( isset( $dateRange[1] ) && $dateRange[1] ) {
			$whereClause[] = ' t.fecha <= ? ';
			$replacements[] = $dateRange[1];
		}
		// la segunda parte el time range
		$timeRange = explode( '@', $searchParts[1] );
		if( isset( $timeRange[0] ) && $timeRange[0] ) {
			$whereClause[] = ' t.hora >= ? ';
			$replacements[] = $timeRange[0];
		}
		if( isset( $timeRange[1] ) && $timeRange[1] ) {
			$whereClause[] = ' t.hora <= ? ';
			$replacements[] = $timeRange[1];
		}
		// la tercera parte es una lista de doctores
		$doctorsLists = explode( '-', $searchParts[2] );
		// hago el OR clause
		$doctorsOrClause = array();
		foreach( $doctorsLists as $doctorID ) {
			if( $doctorID ) {
				$doctorsOrClause[] = ' m.id = ? ';
				$replacements[] = $doctorID;
			}
		}
		if( count( $doctorsOrClause ) > 0 ) {
			$whereClause[] = ' ( ' . implode( ' OR ', $doctorsOrClause ) . ' ) ';
		}
		// la cuarta parte es una lista de pacientes de DNIs
		$patientsDNI = explode( '-', $searchParts[3] );
		// hago el OR clause
		$patientsOrClause = array();
		foreach( $patientsDNI as $dni ) {
			if( $dni ) {
				$patientsOrClause[] = ' p.dni = ? ';
				$replacements[] = $dni;
			}
		}
		if( count( $patientsOrClause ) > 0 ) {
			$whereClause[]	= ' ( ' . implode( ' OR ', $patientsOrClause ) . ' ) ';
		}
		// la quinta parte el estado del turno
		// esto se hace afuera de este if porque
		// puede haber cloflicto cuando tambien se quire filtar la grid
		if( $searchParts[4] ) {
			$statusValue = $searchParts[4];
		};
		
	// ESTE ES EL NORMAL WHERE CUANDO SE ESTA ACCEDIENDO DIRECTAMENTE A /turnos
	// OSEA NO SE HA HECHO UNA BUSQUEDA
	} else {
		$isSearch = false;
	
		$whereClause[] = ' t.fecha >= ? ';
		$replacements[] = date( 'Y-m-d' );
		$whereClause[] = ' t.fecha <= ? ';
		// debo tomar todos las rows con fecha actual + 7 dias
		$replacements[] = date( 'Y-m-d', strtotime( '+7 days' ) );
	}
	
	// SE PUEDE FILTAR LOS TURNOS MEDIANTE LA COLUMNA "ACCIONES" O MEDINATE UNA BUSQUEDA
	if( $statusValue == 'confirmados' ) {
		$whereClause[] = ' t.estado = ? ';
		$replacements[] = 'confirmado';
	} else if( $statusValue == 'cancelados' ) {
		$whereClause[] = ' t.estado = ? ';
		$replacements[] = 'cancelado';
	}

	$appointments = $db->select( 
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
			WHERE ' .
				implode( ' AND ', $whereClause ) .
				
			'ORDER BY ' .
				implode( ' , ', $orderByClause )
		,
		$replacements
	);

// PIDO LOS MEDICOS, ESTOS ES DEBIDO A QUE LA BUSQUEDA DESPLIEGA UNA
// LISTA QUE CONTIENE TODOS LOS MEDICOS EN EL SISTEMA
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
	
	$confirmSuccess = false;
	$confirmError = false;
	$cancelSuccess = false;
	$cancelError = false;
	$removeSuccess = false;
	$removeError = false;
	$resetSuccess = false;
	$resetError = false;
	$searchError = false;
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
	
	} else if( __issetGETField( 'error', 'buscar-turno' ) ) {
		$searchError = true;
		$isSearch = true;
	}
	
	// esto es usado para mostrar un mensaje sobre que
	// los turnos que esta viendo son los desde dia presente
	// hasta los siguiete 7 dias (solo pasa si no se ha hecho una busqueda)
	$currentDate = !$isSearch ? date( 'd/m/Y' ) : false;
	
	// render
	require './views/appointments.php';

?>