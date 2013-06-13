<?php
	
	require './models/_insurances.enable.disable.php';

	m_changeInsuranceStatus( m_getInsuranceID(), 'deshabilitada' );
	
?>