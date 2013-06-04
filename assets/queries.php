<?php

// PONER AQUI AQUELLAS QUERIES QUE SON USADAS MAS DE UNA
// VEZ POR LOS DIFERENTES MODELOS

	function q_getAllDoctors() {
		return DB::select(
			'
				SELECT
					*
				FROM 
					medicos
				ORDER BY
					apellidos, nombres
			'
		);
	}
	
	function q_getAllInsurances() {
		return DB::select(
			'
				SELECT
					*
				FROM
					obrasSociales
				ORDER BY
					nombreCorto
			'
		);
	}
	
	function q_getPatients( $whereCluase, $replacements, $orderByClause = array(), $offset = 0 ) {
	
		if( $offset ) {
			$offset = $offset * 30;
		}
		$replacements[] = $offset;
		
		return DB::select(
			'
				SELECT
					p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.telefono, p.nroAfiliado,
					os.nombreCorto AS obraSocialNombre
				FROM
					pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
				WHERE ' .
					implode( ' AND ', $whereCluase ) .
			
				( count( $orderByClause ) ? ' ORDER BY ' . implode( ', ', $orderByClause ) : ''  ) .
				
				' LIMIT ?, 31 '
				
			, $replacements
		);
	}

?>