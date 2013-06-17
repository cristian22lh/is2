<?php

	if( !__AmI( 5.3 ) ) {
		__redirect( '/404' );
	}
	
	global $PWD;
	require_once $PWD . '/models/_appointments.export.php';

	// get the appointments
	$appointments = m_getAppointments();
	
	// start creating the excel data
	$phpExcel = __getPHPExcelInstance();
	$phpExcelSheet = $phpExcel->getActiveSheet();

	// global style
	$phpExcelSheet->getDefaultStyle()->applyFromArray( array(
		'font' => array(
			'size' => 13,
			'name' => 'Tahoma'
		)
	) );
	
	// el title de la solapa
	$phpExcelSheet->setTitle( 'Listado de turnos' );

	$phpExcelSheet->getStyle( 'A1:E1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		
	$styleForFieldNames = array(
		'font' => array(
			'color' => array(
				'rgb' => 'ffffff'
			),
			'bold' => true
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => '34D5E3'
			)
		)
	);
	$styleForAppointmentBar = array(
		'fill' => array( 
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array( 
				'rgb' => 'f1f1f1'
			)
		)
	);
	$styleForAppointmentConfirmed = array(
		'fill' => array( 
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array( 
				'rgb' => 'A0DA8F'
			)
		)
	);
	$styleForAppointmentCancelled = array(
		'fill' => array( 
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array( 
				'rgb' => 'F89406'
			)
		)
	);
	$BACKGROUNDS = array(
		'confirmado' => $styleForAppointmentConfirmed,
		'cancelado' => $styleForAppointmentCancelled,
		'esperando' => array()
	);

	if( $appointments->rowCount() ) {
		$phpExcelSheet->getColumnDimension( 'C' )->setAutoSize( true );
		$phpExcelSheet->getColumnDimension( 'D' )->setAutoSize( true );
		$phpExcelSheet->getColumnDimension( 'E' )->setAutoSize( true );
		$phpExcelSheet->getStyle( 'A1:E1' )->applyFromArray( $styleForFieldNames );
		$phpExcelSheet->setCellValue( 'A1', 'Dia' );
		$phpExcelSheet->setCellValue( 'B1', 'Hora' );
		$phpExcelSheet->setCellValue( 'C1', 'Médico' );
		$phpExcelSheet->setCellValue( 'D1', 'Obra social' );
		$phpExcelSheet->setCellValue( 'E1', 'Paciente' );
		
	} else {
		$phpExcelSheet->setCellValue( 'A1', 'SIN DATOS DISPONIBLES' );
	}

	$cellIndex = 2;
	$previousAppointmentDate = null;
	foreach( $appointments as $appointment ) {
	
		if( $previousAppointmentDate && $previousAppointmentDate != $appointment['fecha'] ) {
			$phpExcelSheet->getRowDimension( $phpExcelSheet->getCell( $phpExcelSheet->getStyle( 'A' . $cellIndex . ':E' . $cellIndex )->applyFromArray( $styleForAppointmentBar )->getActiveCell() )->getRow() )->setRowHeight( 5 );
			$cellIndex++;
		}
		
		// set background for the row
		$phpExcelSheet->getStyle( 'A' . $cellIndex . ':E' . $cellIndex )->applyFromArray( $BACKGROUNDS[$appointment['estado']] );
	
		$phpExcelSheet->setCellValue( 'A' . $cellIndex, __dateISOToLocale( $appointment['fecha'] ) );
		$phpExcelSheet->setCellValue( 'B' . $cellIndex, __trimTime( $appointment['hora'] ) );
		$phpExcelSheet->setCellValue( 'C' . $cellIndex, $appointment['medicoApellidos'] . ', ' . $appointment['medicoNombres'] );
		$phpExcelSheet->setCellValue( 'D' . $cellIndex, $appointment['nombreObraSocial'] );
		$phpExcelSheet->setCellValue( 'E' . $cellIndex, $appointment['pacienteApellidos'] . ', ' . $appointment['pacienteNombres'] . ' (' . __formatDNI( $appointment['pacienteDNI'] ) . ')' );
		$cellIndex++;
		
		$previousAppointmentDate = $appointment['fecha'];
	}

	__echoPHPExcel( $phpExcel, m_getFilename() );
	
?>