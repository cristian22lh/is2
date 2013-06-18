<?php

	class MyCustomSessionHandler {
	
		function __construct() {}
		
		function __destruct() {
			session_write_close();
		}
		
		function open( $path, $name ) {
			return true;
		}
		
		function close() {
			return true;
		}
		
		function read( $sessionID ) {
	
			$res = DB::select(
				'
					SELECT
						sesionData
					FROM
						sesiones
					WHERE
						id = ?
				',
				array( $sessionID )
			);

			if( $res->rowCount() == 1 ) {
				$sessionData = $res->fetch();
				return $sessionData['sesionData'];
			}

			return '';
		}
		
		function write( $sessionID, $sessionData ) {

			$res = DB::select(
				'
					SELECT
						fechaCreacion
					FROM
						sesiones
					WHERE
						id = ?
				',
				array( $sessionID )
			);
			
			if( $res->rowCount() == 1 ) {
				$creationDate = $res->fetch();
				$valuesClause = ' ( ?, ?, NOW(), ? ) ';
				$replacements = array( $sessionID, $creationDate['fechaCreacion'], $sessionData );
			} else {
				$creationDate = null;
				$valuesClause = ' ( ?, NOW(), NOW(), ? ) ';
				$replacements = array( $sessionID, $sessionData );
			}
		
			$insertId = DB::insert(
				'
					REPLACE INTO
						sesiones
					VALUES
				' .
					$valuesClause
				,
				$replacements
			);
			
			return $insertId > 1;
		}
		
		function destroy( $sessionID ) {
		
			$rowsAffected = DB::delete(
				'
					DELETE FROM
						sesiones
					WHERE
						id = ?
				',
				array( $sessionID )
			);
			
			return $rowsAffected >= 0;
		}
		
		function gc( $ttl ) {
		
			$rowsAffected = DB::delete(
				'
					DELETE FROM
						sesiones
					WHERE
						fechaUltimoAcceso = ?
				',
				array( time() - $ttl )
			);
			
			return $rowsAffected >= 0;
		}
		
	}

?>