<?php
	
	require './models/_appointments.export.php';

	$appointments = m_getAppointments();

	__render(
		'appointments.print',
		array(
			'appointments' => $appointments,
			'autoPrint' => true
		)
	);
	
?>