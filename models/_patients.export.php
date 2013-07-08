<?php

	function m_getPatients() {

		$fields = explode( '|', base64_decode( __GETField( 'campos' ) ) );
		$whereClause = array();
		$pat = '/\(\s*(p\.(?:apellidos|nombres)\s+LIKE\s+\?)(?:\s+OR\s+\1)*\s*\)|p\.fechaNacimiento\s*(?:>|<)=\s*?|\(\s*(os\.id\s*=\s*\?)(?:\s+OR\s+\1)*\s*\)|\(\s*(os\.id\s*=\s*\?)(?:\s+OR\s+\1)*\s*\)|\(\s*(p\.(?:dni|nroAfiliado)\s*=\s*\?)(?:\s+OR\s+\1)*\s*\)|p\.fechaNacimiento\s*=\s*\?|p\.dni\s*=\s*?\s+OR\s+p\.telefono|p\.apellidos\s+LIKE\s+\?|p\.nombres\s+LIKE\s+\?|\(\s*p\.nombres\s+LIKE\s+\?\s+OR\s+p\.apellidos\s+LIKE\s+\?\s+OR\s+os\.nombreCorto\s+LIKE\s+\?\s*\)|p\.id\s*=\s*\?|p\.apellidos\s+LIKE\s+\?/';
		$tokens = 0;
		foreach( $fields as $field ) {
			if( !preg_match( $pat, $field ) ) {
				__redirect( '/404' );
			}
			$tokens += substr_count( $field, '?' );
			
			$whereClause[] = $field;
		}
		$replacements = explode( '|', base64_decode( __GETField( 'valores' ) ) );
		if( $tokens != count( $replacements ) ) {
			__redirect( '/404' );
		}
		
		return DB::select(
			'
				SELECT
					p.id, p.apellidos, p.nombres, p.dni, p.fechaNacimiento, p.telefono, p.nroAfiliado, 
					os.nombreCorto AS obraSocialNombre 
				FROM pacientes AS p 
					INNER JOIN obrasSociales AS os 
						ON os.id = p.idObraSocial 
				WHERE
			' .
				implode( ' AND ', $whereClause ) .
			'
				ORDER BY
					p.apellidos ASC, p.nombres ASC
			',
			$replacements
		);

	}
	
	function m_getFilename() {
		return 'Listado de pacientes';
	}

?>