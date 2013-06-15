<?php

	function m_getAppointments() {

		$fields = explode( '|', base64_decode( __GETField( 'campos' ) ) );
		$whereClause = array();
		$pat = '/^\s*(?:(?:t\.fecha|t\.hora)\s*(?:>=|<=|=)\s*\?|\(\s*(m\.id\s*=\s*\?)(?:\s+OR\s+\1)*\s*\)|\(\s*(p\.dni\s*=\s*\?)(?:\s+OR\s+\1)*\s*\)|t\.estado\s*=\s*\?|\(\s*(?:(?:m|p)\.(?:nombres|apellidos)\s+LIKE\s+\?\s*){4}|1\s*=\s*1)/';
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
					t.id, t.fecha, t.hora, t.estado,
					m.id AS idMedico, m.nombres AS medicoNombres, m.apellidos AS medicoApellidos, m.avatarMini AS medicoAvatar,
					p.id AS idPaciente, p.nombres AS pacienteNombres, p.apellidos AS pacienteApellidos, p.dni AS pacienteDNI,
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

	}
	
	function m_getFilename() {
		return 'Listado de turnos';
	}

?>