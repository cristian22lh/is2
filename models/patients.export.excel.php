<?php

	if( !__AmI( 5.3 ) ) {
		__redirect( '/404' );
	}
	
	global $PWD;
	require_once $PWD . '/models/_patients.export.php';

	// get the appointments
	$patients = m_getPatients();
	
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
	$phpExcelSheet->setTitle( 'Listado de pacientes' );

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

	if( $patients->rowCount() ) {
		$phpExcelSheet->getColumnDimension( 'A' )->setAutoSize( true );
		$phpExcelSheet->getColumnDimension( 'F' )->setAutoSize( true );
		$phpExcelSheet->getStyle( 'A1:F1' )->applyFromArray( $styleForFieldNames );
		$phpExcelSheet->setCellValue( 'A1', 'Nombre completo' );
		$phpExcelSheet->setCellValue( 'B1', 'DNI' );
		$phpExcelSheet->setCellValue( 'C1', 'Fecha de nacimiento' );
		$phpExcelSheet->setCellValue( 'D1', 'Télefono' );
		$phpExcelSheet->setCellValue( 'E1', 'Número de afiliado' );
		$phpExcelSheet->setCellValue( 'F1', 'Obra social' );
		
	} else {
		$phpExcelSheet->setCellValue( 'A1', 'SIN DATOS DISPONIBLES' );
	}

	$cellIndex = 2;
	foreach( $patients as $patient ) {
		$phpExcelSheet->setCellValue( 'A' . $cellIndex, $patient['apellidos'] . ', ' . $patient['nombres'] );
		$phpExcelSheet->setCellValue( 'B' . $cellIndex, __formatDNI( $patient['dni'] ) );
		$phpExcelSheet->setCellValue( 'C' . $cellIndex, __dateISOToLocale( $patient['fechaNacimiento'] ) );
		$phpExcelSheet->setCellValue( 'D' . $cellIndex, $patient['telefono'] );
		$phpExcelSheet->setCellValue( 'E' . $cellIndex, $patient['nroAfiliado'] );
		$phpExcelSheet->setCellValue( 'F' . $cellIndex, $patient['obraSocialNombre'] );
		$cellIndex++;
	}

	__echoPHPExcel( $phpExcel, m_getFilename() );
	
?>