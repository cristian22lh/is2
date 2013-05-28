<?php

// PONER AQUI AQUELLAS QUERIES QUE SON USADAS MAS DE UNA
// VEZ POR LOS DIFERENTES MODELOS

	function q_getAllDoctors() {
		global $db;
		return $db->select(
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
	
	function q_checkDoctorAvailability( $replacements ) {
		global $db;
		return $db->select( 
			'
				SELECT
					id
				FROM
					horarios
				WHERE
					idMedico = ? AND ? >= horaIngreso AND ? <= horaEgreso AND dia = ?
			',
			$replacements
		);
	}
	
	function q_getAllInsurances() {
		global $db;
		return $db->select(
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
	
	function q_getPatients( $whereCluase, $replacements ) {
		global $db;
		return $db->select(
			'
				SELECT
					p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.email, p.telefono, p.nroAfiliado,
					os.nombreCorto AS obraSocialNombre
				FROM
					pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
				WHERE ' .
					implode( ' AND ', $whereCluase ) .
				'
				ORDER BY
					p.apellidos
			',
			$replacements
		);
	}

?>