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

?>