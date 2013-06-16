<?php

	if( !( $keyword = trim( __GETField( 'keyword' ) ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$whereClause = array();
	$replacements = array();
	$whereOperator = ' OR ';
	// is a dni or tel
	if( ( $m = preg_replace( '/^[^\d]+$/', '', $keyword ) ) && is_numeric( $m ) ) {
		$whereClause[] = ' p.dni = ? ';
		$replacements[] = $m;
		$whereClause[] = ' p.telefono = ? ';
		$replacements[] = $m;
	
	// search by apellidos and names
	} else {
		$fullname = explode( ',', $keyword );
		// too much commas
		if( count( $fullname ) > 2 ) {
			__echoJSON( array( 'success' => false ) );
		}
		$whereClause[] = ' p.apellidos LIKE ? ';
		$replacements[] = '%' . trim( $fullname[0] ) . '%';
		if( isset( $fullname[1] ) ) {
			$whereOperator = ' AND ';
			$whereClause[] = ' p.nombres LIKE ? ';
			$replacements[] = '%' . trim( $fullname[1] ) . '%';
		}
	}

	$patients = DB::select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.dni, p.telefono, p.direccion,
				os.nombreCorto AS obraSocialNombre
			FROM
				pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
			WHERE
			' .
				implode( $whereOperator, $whereClause ) .
			'
			ORDER BY
				p.apellidos ASC, p.nombres ASC
			LIMIT
				50
		',
		$replacements
	);
	
	$patients = $patients->fetchAll();
	
	__echoJSON( array( 
		'success' => true,
		'data' => $patients
	) );
	
?>