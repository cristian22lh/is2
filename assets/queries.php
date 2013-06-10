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

	function q_getDoctorAvailabilities( $doctorID, $availabilityID = null ) {
		$replacements = array();
		$replacements[] = $doctorID;
		if( $availabilityID ) {
			$replacements[] = $availabilityID;
		}
	
		return DB::select(
			'
				SELECT
					*
				FROM
					horarios
				WHERE
					idMedico = ?
			' .
				( $availabilityID ? ' AND id = ? ' : '' ) .
			'
				ORDER BY
					dia, horaIngreso, horaEgreso
			'
			,
			$replacements
		);
	}
	
	function q_getDoctorInsurances( $doctorID ) {
		return DB::select(
			'
				SELECT
					os.id, os.nombreCorto, os.nombreCompleto
				FROM
					medicosObrasSociales AS mos
					INNER JOIN obrasSociales AS os
						ON os.id = mos.idObraSocial
				WHERE
					mos.idMedico = ?
				ORDER BY
					os.nombreCorto
			',
			array( $doctorID )
		);
	}
	
	function q_getAllSpecialities() {
		return DB::select(
			'
				SELECT
					*
				FROM
					especialidades
				ORDER BY
					nombre
			'
		);
	}

?>