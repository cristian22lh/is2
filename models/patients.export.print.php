<?php
	
	global $PWD;
	require_once $PWD . '/models/_patients.export.php';

	$patients = m_getPatients();

	__render(
		'patients.print',
		array(
			'patients' => $patients,
			'autoPrint' => true
		)
	);
	
?>