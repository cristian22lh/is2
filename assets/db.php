<?php

	class DB {
	
		private $db;
		private $typesDict = array(
			'integer' => 'i',
			'string' => 's',
			'double' => 'd'
		);
		
	// *** PUBLIC METHODS *** //
		function __construct() {
		
			if( file_exists( './mysql.ini' ) ) {
				$credenciales = parse_ini_file( './mysql.ini' );
			} else {
				$credenciales = array(
					'usuario' => 'root',
					'clave' => ''
				);
			}

			$this->db = new mysqli( 'localhost', $credenciales['usuario'], $credenciales['clave'], 'is2' );
			if( $this->db->connect_errno ) {
			    die( 'Failed to connect to MySQL: ' . $this->db->connect_error );
			}

		}
		
		function select( $query, $replacements = array() ) {

			$res = array();
			
			if( $stmt = $this->db->prepare( $query ) ) {

				$this->_executeQuery( $stmt, $replacements );

				// debo conseguir el nombre de las columnas
				$metadata = $stmt->result_metadata();
				$columns = array();
				while( $field = $metadata->fetch_field() ) {
					$columns[] = $field->name;
				}
				// ahora por cada nombre de columna
				// creo una variable con ese nombre de columna
				foreach( $columns as $field ) {
				    $values[] = &${$field};
				}
				
				// internamente hace un $stmt->bind_result
				$this->_bindResult( $stmt, $values );
			       
				// lito, solo queda iterar cada fila y guardarla en $res
				$res = array();
				$i = 0;
				// pido la fila actual y la proceso
				while( $stmt->fetch() ) {
					foreach( $columns as $field ) {
						$res[$i][$field] = $$field;
					}
					$i++;
				}
				
				$stmt->close();
			}
			
			return $res;
		}
		
		function update( $query, $replacements ) {
		
			$rowsAffected = 0;
			
			if( $stmt = $this->db->prepare( $query ) ) {
				
				$this->_executeQuery( $stmt, $replacements );
				
				$rowsAffected = $stmt->affected_rows;
				
				$stmt->close();
			}
			
			return $rowsAffected;
		}
		
		function delete( $query, $replacements ) {
			return $this->update( $query, $replacements );
		}
		
		function insert( $query, $replacements ) {
		
			$insertId = null;
			
			if( $stmt = $this->db->prepare( $query ) ) {
				
				$this->_executeQuery( $stmt, $replacements );
				
				$insertId = $stmt->insert_id;
				
				$stmt->close();
			}
			
			return $insertId;
		}
		
	// *** PRIVATE METHODS *** //
		private function _executeQuery( $stmt, $replacements ) {
			// capaz que no hay tokens a reemplezar
			if( count( $replacements ) ) {
				// internamente aca se hace un $stmt->bind_param()
				$this->_bindParams( $stmt, $this->_addParams( $replacements ) );
			}
			
			// ejecutamos la consultado
			$stmt->execute();
		}
	
		private function _addParams( $replacements ) {
			$types = '';
			$this->values = array();
			
			for( $i = 0, $l = count( $replacements ); $i < $l; $i++ ) {
				$types .= $this->_gettype( $replacements[$i] );
				$this->values[] = &$replacements[$i];
			}

			// esto sera el argumento para $stmt->bind_param();
			return array_merge( array( $types ), $this->values );
		}
		
		private function _gettype( $value ) {
			$type = gettype( $value );
			
			if( isset( $this->typesDict[$type] ) ) {
				return $this->typesDict[$type];
			}
			
			die( 'Invalid data type' );
		}
		
		private function _bindParams( &$stmt, &$args ) {
			call_user_func_array( array( $stmt, 'bind_param' ), $args );
		}
		
		private function _bindResult( &$stmt, &$args ) {
			call_user_func_array( array( $stmt, 'bind_result' ) , $args );
		}
	}
	
?>