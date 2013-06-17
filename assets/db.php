<?php

	class DB {
	
		private static $db;
		
		private static $errorsDict = array(
			// errores para crear turno
			'PROCEDURE is2.medico_no_antiende_fecha_hora_requerido does not exist' => 'turnos_medico_no_atiende',
			'/^.*turnos_medico_ocupado.*$/' => 'turnos_medico_ocupado',
			'/^.*turnos_paciente_ya_tiene_turno.*$/' => 'turnos_paciente_ya_tiene_turno',
			'PROCEDURE is2.medico_esta_con_licencia does not exist' => 'turnos_medico_con_licencia',
			'PROCEDURE is2.medico_no_soporta_obra_social_paciente does not exist' => 'turnos_obra_social_incompatibe',
			'PROCEDURE is2.obra_social_deshabilitada does not exist' => 'turnos_obra_social_deshabilitada',
			
			// errores para crear licencia
			'PROCEDURE is2.licencia_medico_tiene_turnos does not exist' => 'licencia-medico-tiene-turnos',
			'PROCEDURE is2.licencia_medico_ya_esta_con_licencia does not exist' => 'licencia-ya-existe',
			'PROCEDURE is2.licencia_en_pasado does not exist' => 'licencia-en-pasado'
		);
		private static $errorsCode = array(
			'1062' => 'duplicado',
			'1054' => 'columna desconocida',
			'1064' => 'error en el diseño de la query',
			'1451' => 'clave foreana restriccion'
		);
		private static $errorsList = array();
		
	// *** PUBLIC METHODS *** //
		static function init() {
		
			if( file_exists( './mysql.ini' ) ) {
				$credenciales = parse_ini_file( './mysql.ini' );
			} else {
				$credenciales = array(
					'usuario' => 'root',
					'clave' => ''
				);
			}
			
			try {
				self::$db = new PDO( 'mysql:host=localhost;dbname=is2', $credenciales['usuario'], $credenciales['clave'] );
				self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				
			} catch( PDOException $e ) {
				die( 'Failed to connect to MySQL: ' . $e->getMessage() );
			}

			self::$db->exec( 'SET NAMES utf8' );
		}
		
		static function select( $query, $replacements = array() ) {
			
			self::_log( $query, $replacements );

			$stmt = null;
			
			try {
				$stmt = self::$db->prepare( $query );
				$stmt->execute( $replacements );
				$stmt->setFetchMode( PDO::FETCH_ASSOC );
			
			} catch( PDOException $e ) {
				
				self::_err( $e );
			}

			return $stmt;
		}
		
		static function update( $query, $replacements ) {

			self::_log( $query, $replacements );

			$rowsAffected = -1;
			
			try {
				$stmt = self::$db->prepare( $query );
				$stmt->execute( $replacements );
				$rowsAffected = $stmt->rowCount();
				
			} catch( PDOException $e ) {
				self::_err( $e );
			}
			
			return $rowsAffected;
		}
		
		static function delete( $query, $replacements ) {
			return self::update( $query, $replacements );
		}
		
		static function insert( $query, $replacements ) {
		
			self::_log( $query, $replacements );
		
			$insertId = null;
			
			try {
				$stmt = self::$db->prepare( $query );
				$stmt->execute( $replacements );
				$insertId = self::$db->lastInsertId();
				
			} catch( PDOException $e ) {
				self::_err( $e );
			}
			
			return $insertId;
		}
		
		static function batch( $queries ) {
			self::$db->beginTransaction();
			
			foreach( $queries as $type => $data ) {
				$exitCode = call_user_func_array( array( 'DB', $type ), array( $data['query'], $data['replacements'] ) );
				if( ( is_integer( $exitCode ) && $exitCode < 0 ) || is_null( $exitCode ) ) {
					self::$db->rollBack();
					return false;
				}
			}
			
			self::$db->commit();
			return true;
		}
		
		static function getErrorList() {
			return self::$errorsList;
		}
		
		private static function _log( $query, $replacements ) {
			__log( 'executing the query: ' );
			__log( $query );
			__log( 'with the params: ' );
			__log( $replacements );
		}
		
		private static function _err( $PDOError ) {
			__err( $PDOError->getMessage() );
			
			$errorString =  $PDOError->errorInfo[2];
			$errorNro = $PDOError->errorInfo[1];
			$theError = null;
			
			foreach( self::$errorsDict as $errorStringMap => $errorMeaning ) {
				if( $errorString == $errorStringMap || @preg_match( $errorStringMap, $errorString ) ) {
					$theError = $errorMeaning;
					break;
				}
			}
		
			if( !$theError ) {
				// check for error code
				if( isset( self::$errorsCode[$errorNro] ) ) {
					$theError = self::$errorsCode[$errorNro];
				// an error that has not mapping
				} else {
					$theError = $errorNro;
				}
			}
			
			self::$errorsList[] = $theError;
		}
	}
	
?>