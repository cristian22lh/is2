SET NAMES 'utf8';

DROP DATABASE IF EXISTS is2;
CREATE DATABASE is2 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE is2;
/**
*
*/
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	usuario VARCHAR( 255 ),
	clave CHAR( 40 ),
	UNIQUE INDEX( usuario )
);

INSERT INTO usuarios VALUES( null, 'admin', SHA( 123456 ) ), ( null, 'root', SHA( 123456 ) );
/**
*
*/
DROP TABLE IF EXISTS turnos;
CREATE TABLE turnos(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	fecha DATE,
	hora TIME,
	idMedico INTEGER NULL,
	idPaciente INTEGER NULL,
	estado ENUM( 'confirmado', 'cancelado', 'esperando' ) DEFAULT 'esperando',
	UNIQUE INDEX( fecha,  hora, idMedico )
) ENGINE=InnoDB;

INSERT INTO turnos VALUES
( null, CURRENT_DATE(), '15:30:00', 1, 1, 'esperando' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 1 DAY ), '15:30:00', 2, 2, 'cancelado' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 2 DAY ), '18:00:00', 3, 3, 'esperando' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 3 DAY ), '13:15:00', 4, 4, 'confirmado' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 4 DAY ), '09:40:00', 5, 5, 'esperando' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 5 DAY ), '18:15:00', 6, 6, 'cancelado' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 6 DAY ), '19:00:00', 7, 7, 'cancelado' ),
( null, DATE_ADD( CURRENT_DATE(), INTERVAL 7 DAY ), '11:45:00', 8, 8, 'confirmado' )
;
/**
*
*/
DROP TABLE IF EXISTS medicos;
CREATE TABLE medicos(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idEspecialidad INTEGER NULL,
	apellidos VARCHAR( 100 ),
	nombres VARCHAR( 100 ),
	matricula VARCHAR( 20 )
) ENGINE=InnoDB;

INSERT INTO medicos VALUES
	( null, 1, 'Marcelo', 'Rodríguez', '122434/21' ),
	( null, 2, 'Fernando', 'Benavídez', '122434/21' ),
	( null, 3, 'Carlos', 'Fernández', '122434/21' ),
	( null, 4, 'Miguel', 'Méndez', '122434/21' ),
	( null, 5, 'Cristián', 'González', '122434/21' ),
	( null, 6, 'Mónica', 'Pérez', '122434/21' ),
	( null, 7, 'Patricia', 'Velásquez', '122434/21' ),
	( null, 8, 'María Marta', 'Suárez', '122434/21' )
;
/**
*
*/
DROP TABLE IF EXISTS horarios;
CREATE TABLE horarios(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idMedico INTEGER NULL,
	horaIngreso TIME,
	horaEgreso TIME,
	dia ENUM( '1', '2', '3', '4', '5', '6', '7' )
) ENGINE=InnoDB;

INSERT INTO horarios VALUES
	( null, 1, '11:00:00', '17:00:00', 1 ),
	( null, 2, '12:00:00', '15:00:00', 2 ),
	( null, 3, '08:00:00', '20:00:00', 3 ),
	( null, 4, '15:00:00', '20:00:00', 5 ),
	( null, 5, '15:00:00', '19:00:00', 6 ),
	( null, 6, '16:00:00', '19:00:00', 4 ),
	( null, 7, '08:00:00', '13:00:00', 1 ),
	( null, 8, '09:00:00', '14:00:00', 7 )
;
/**
*
*/
DROP TABLE IF EXISTS medicosObrasSociales;
CREATE TABLE medicosObrasSociales(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idMedico INTEGER NULL,
	idObraSocial INTEGER NULL
) ENGINE=InnoDB;

INSERT INTO medicosObrasSociales VALUES
	( null, 1, 1 ),
	( null, 2, 1 ),
	( null, 3, 1 ),
	( null, 4, 1 ),
	( null, 5, 1 ),
	( null, 6, 1 ),
	( null, 7, 1 ),
	( null, 8, 1 ),
	( null, 1, 2 ),
	( null, 2, 2 ),
	( null, 3, 2 ),
	( null, 4, 2 ),
	( null, 5, 2 ),
	( null, 6, 2 ),
	( null, 7, 2 ),
	( null, 8, 2 )
;
/**
*
*/
DROP TABLE IF EXISTS pacientes;
CREATE TABLE pacientes(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	apellidos VARCHAR( 100 ),
	nombres VARCHAR( 100 ),
	sexo ENUM( 'F', 'M' ),
	dni VARCHAR( 20 ),
	fechaNacimiento DATE,
	telefono VARCHAR( 100 ),
	idObraSocial INTEGER NULL,
	nroAfiliado VARCHAR( 255 ) NULL,
	UNIQUE INDEX( dni )
) ENGINE=InnoDB;

LOAD DATA LOCAL INFILE "./_1000_patients.sql" INTO TABLE pacientes;
/**
*
*/
DROP TABLE IF EXISTS obrasSociales;
CREATE TABLE obrasSociales(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombreCorto VARCHAR( 255 ),
	nombreCompleto TEXT,
	UNIQUE INDEX( nombreCorto )
) ENGINE=InnoDB;
	
INSERT INTO obrasSociales VALUES
	( null, 'LIBRE', 'LIBRE' ),
	( null, 'IOMA', 'IOMA' ),
	( null, 'PAMI', 'PAMI' )
;
LOAD DATA LOCAL INFILE "./_200_insurances.sql" INTO TABLE obrasSociales;
/**
*
*/
DROP TABLE IF EXISTS especialidades;
CREATE TABLE especialidades(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR( 255 ),
	UNIQUE INDEX( nombre )
) ENGINE=InnoDB;

INSERT INTO especialidades VALUES
	( null, 'Sin asignar' ),
	( null, 'Otorrinolaringología' ),
	( null, 'Odontología' ),
	( null, 'Nefrología' ),
	( null, 'Endocrinología' ),
	( null, 'Urología' ),
	( null, 'Oftalmología' ),
	( null, 'Pediatría' ),
	( null, 'Psiquiatría' )
;

/**
*
*/
SOURCE ./_100_appointments.sql;
/**
*
*/

/**
* AHORA LAS REFERENCES
*/
ALTER TABLE turnos
	ADD CONSTRAINT turnos_idMedico
	FOREIGN KEY( idMedico )
		REFERENCES medicos( id )
		ON DELETE CASCADE
;
		
ALTER TABLE turnos
	ADD CONSTRAINT turnos_idPaciente
	FOREIGN KEY( idPaciente )
		REFERENCES pacientes( id )
		ON DELETE CASCADE
;

DELIMITER $$
CREATE TRIGGER turnos_insertarTurno
	BEFORE INSERT ON turnos
	FOR EACH ROW
	BEGIN
		/** MIS VARIABLES */
		DECLARE dayNameIndex INTEGER;
		DECLARE daysCount INTEGER;
	
		/**
		* ESTE TRIGER SE FIJA SI TAL DIA A TAL HORARIO TAL MEDICO ATIENDE
		* NO CONFUNDIR CON ESTAR DISPONIBLE (QUE NO TENGA OTRO TURNO), 
		* EN ESTE CASO, LA CONSTRAINT UNIQUE( idMedico, fecha, hora ) 
		* DE turnos SE ENCARGARA DE ESTO
		*/
		SELECT DAYOFWEEK( NEW.fecha ) INTO dayNameIndex;
		IF ( 
			SELECT
					id
				FROM
					horarios
				WHERE
					idMedico = NEW.idMedico AND 
					NEW.hora >= horaIngreso AND NEW.hora <= horaEgreso AND 
					dia = ( SELECT CASE
						WHEN dayNameIndex = 1 THEN 7
						ELSE dayNameIndex - 1 END )
		) IS NULL THEN
			CALL medico_no_antiende_fecha_hora_requerido;
		END IF;
		
		/** UN TURNO NO PUEDE SER MAYOR AL DIA PRESENTE EN 7 DIAS HACIA DELANTE */
		SELECT DATEDIFF( NEW.fecha, CURRENT_DATE() ) INTO daysCount;
		IF daysCount > 7 THEN
			CALL turno_fecha_mayor_siete_dias;
		ELSEIF daysCount < 0 THEN
			CALL turno_fecha_negativo;
		END IF;
		
		/** HAY QUE CHECKEAR QUE EL MEDICO SOPORTE LA OBRA SOCIAL DEL PACIENTE */
		IF (
			SELECT
				p.id
			FROM 
				medicosObrasSociales AS mos
				INNER JOIN pacientes AS p
			WHERE
				mos.idMedico = NEW.idMedico AND 
				mos.idObraSocial = p.idObraSocial AND
				p.id = NEW.idPaciente
				
		) IS NULL THEN
			CALL medico_no_soporta_obra_social_paciente;
		END IF;
		
		/**
		* SI YA EXISTE UN TURNO CON EL MISMO MEDICO, FECHA Y HORA
		* LA CONSTRAINT UNIQUE( idMedico, fecha, hora ) WILL TAKE CARE OF THIS
		*/
	END;
$$
DELIMITER ;

ALTER TABLE horarios
	ADD CONSTRAINT horarios_idMedico
	FOREIGN KEY( idMedico )
		REFERENCES medicos( id )
		ON DELETE RESTRICT
;

ALTER TABLE pacientes
	ADD CONSTRAINT pacientes_idObraSocial
	FOREIGN KEY( idObraSocial )
		REFERENCES obrasSociales( id )
		ON DELETE RESTRICT
;

ALTER TABLE medicos
	ADD CONSTRAINT medicos_idEspecialidad
	FOREIGN KEY( idEspecialidad )
		REFERENCES especialidades( id )
		ON DELETE RESTRICT
;
