<?php

	global $PWD;
	require_once $PWD . '/models/_appointments.export.php';
	
	// create the context
	$sessionID = session_name();
	$context = stream_context_create( array(
		'http' => array(
			'header' => 'Cookie: ' . $sessionID . '=' . $_COOKIE[$sessionID]
		)
	) );
	
	// instanciete
	$dompdf = __getDOMPDFInstance();
	
	// retrive the appointments HTML when user goes to /turnos/exportar/imprimir
	// DOMPDF will be use that markup to generate the PDF file
	session_write_close();
	$dompdf->load_html( utf8_decode( file_get_contents( 'http://' . $_SERVER['HTTP_HOST'] . '/turnos/exportar/imprimir' . __getGETComplete(), false, $context ) ) );
	
	__echoDOMPDF( $dompdf, m_getFilename() );

?>