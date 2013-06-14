<?php
	
	// primero pido los turnos
	$fields = explode( '|', base64_decode( __GETField( 'campos' ) ) );
	$whereClause = array();
	$pat = '/^\s*(?:(?:t\.fecha|t\.hora)\s*(?:>=|<=|=)\s*\?|\(\s*(m\.id\s*=\s*\?)(?:\s*OR\s*\1)*\s*\)|\(\s*(p\.dni\s*=\s*\?)(?:\s*OR\s*\1)*\s*\)|\s*t\.estado\s*=\s*\?|\(\s*m\.nombres\s*LIKE\s*\?\s*OR\s*m\.apellidos\s*LIKE\s*\?\s*OR\s*p\.apellidos\s*LIKE\s*\?\s*OR\s*p\.nombres\s*LIKE\s*\?|\s*1\s*=\s*1)/';
	foreach( $fields as $field ) {
		if( !preg_match( $pat, $field ) ) {
			__redirect( '/404' );
		}
		$whereClause[] = $field;
	}
	$replacements = explode( '|', base64_decode( __GETField( 'valores' ) ) );
	
	$appointments = DB::select(
		'
			SELECT 
				t.id, t.fecha, t.hora, t.estado,
				m.id AS idMedico, m.nombres AS medicoNombres, m.apellidos AS medicoApellidos, m.avatarMini AS medicoAvatar,
				p.id AS idPaciente, p.nombres AS pacienteNombres, p.apellidos AS pacienteApellidos,
				os.nombreCorto AS nombreObraSocial
			FROM turnos AS t 
				INNER JOIN medicos AS m 
					ON m.id = t.idMedico 
				INNER JOIN pacientes AS p 
					ON p.id = t.idPaciente
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
			WHERE
		' .
			implode( ' AND ', $whereClause ) .
		'
			ORDER BY
				fecha ASC, hora ASC
		',
		$replacements
	);
	
	$phpExcel = __getPHPExcelInstance();
	$phpExcelSheet = $phpExcel->getActiveSheet();

	// global style
	$phpExcelSheet->getDefaultStyle()->applyFromArray( array(
		'font' => array(
			'size' => 15,
			'name' => 'Tahoma'
		)
	) );
	
	// el title de la solapa
	$phpExcelSheet->setTitle( 'Listado de turnos' );

	$phpExcelSheet->getStyle( 'A:F' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
		
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

	if( $appointments->rowCount() ) {
		$phpExcelSheet->getColumnDimension( 'C' )->setAutoSize( true );
		$phpExcelSheet->getColumnDimension( 'D' )->setAutoSize( true );
		$phpExcelSheet->getStyle( 'A1:E1' )->applyFromArray( $styleForFieldNames );
		$phpExcelSheet->setCellValue( 'A1', 'Dia' );
		$phpExcelSheet->setCellValue( 'B1', 'Hora' );
		$phpExcelSheet->setCellValue( 'C1', 'Paciente' );
		$phpExcelSheet->setCellValue( 'D1', 'Obra social' );
		$phpExcelSheet->setCellValue( 'E1', 'Médico' );
		
	} else {
		$phpExcelSheet->setCellValue( 'A1', 'SIN DATOS DISPONIBLES' );
	}

	$cellIndex = 2;
	$previousAppointmentDate = null;
	foreach( $appointments as $appointment ) {
	
		if( $previousAppointmentDate != $appointment['fecha'] ) {
			$phpExcelSheet->getRowDimension( $phpExcelSheet->getCell( $phpExcelSheet->getStyle( 'A' . $cellIndex . ':E' . $cellIndex++ )->applyFromArray( $styleForAppointmentBar )->getActiveCell() )->getRow() )->setRowHeight( 5 );	
		}
		
		if( $appointment['estado'] == 'confirmado' ) {
			$phpExcelSheet->getStyle( 'A' . $cellIndex . ':E' . $cellIndex )->applyFromArray( $styleForAppointmentConfirmed );
		} else if( $appointment['estado'] == 'cancelado' ) {
			$phpExcelSheet->getStyle( 'A' . $cellIndex . ':E' . $cellIndex )->applyFromArray( $styleForAppointmentCancelled );
		}
	
		$phpExcelSheet->setCellValue( 'A' . $cellIndex, __dateISOToLocale( $appointment['fecha'] ) );
		$phpExcelSheet->setCellValue( 'B' . $cellIndex, __trimTime( $appointment['hora'] ) );
		$phpExcelSheet->setCellValue( 'C' . $cellIndex, $appointment['pacienteApellidos'] . ', ' . $appointment['pacienteNombres'] );
		$phpExcelSheet->setCellValue( 'D' . $cellIndex, $appointment['nombreObraSocial'] );
		$phpExcelSheet->setCellValue( 'E' . $cellIndex++, $appointment['medicoApellidos'] . ', ' . $appointment['medicoNombres'] );
		
		$previousAppointmentDate = $appointment['fecha'];
	}

	__echoExcel( $phpExcel );
	
?>