<?php

	$doctorID = Router::seg( 2 );
	
	$doctorData = DB::select(
		'
			SELECT
				m.id, m.apellidos, m.nombres, m.avatar, m.matricula,
				e.nombre AS especialidad
			FROM
				medicos AS m
				INNER JOIN especialidades AS e
					ON e.id = m.idEspecialidad
			WHERE
				m.id = ?
			ORDER BY
				m.apellidos ASC, m.nombres ASC
		',
		array( $doctorID )
	);
	
	if( !count( $doctorData ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$doctor = $doctorData[0];
	
	$availabilities = q_getDoctorAvailabilities( $doctorID );
	for( $i = 0, $l = count( $availabilities ); $i < $l; $i++) {
		$availability = &$availabilities[$i];
		$availability['diaNombre'] = __getDayName( $availability['dia'] );
		$availability['horaEgreso'] = __trimTime( $availability['horaEgreso'] );
		$availability['horaIngreso'] = __trimTime( $availability['horaIngreso'] );
	}
	
	$insurances = q_getDoctorInsurances( $doctorID );
	
	__echoJSON( array( 
		'success' => true,
		'data' => array(
			'doctor' => $doctor,
			'availabilities' => $availabilities,
			'insurances' => $insurances
		)
	) );
	
?>