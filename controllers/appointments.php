<?php
	
	// defaults variales que son usadas en la view
	$username = __getUsername();
	$currentDate = date( 'd/m/Y' );
	
	// debo tomar todos las rows con fecha actual + 7 dias
	$turnos = $db->exec( 
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