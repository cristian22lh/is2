SET NAMES 'utf8';

DROP DATABASE IF EXISTS is2;
CREATE DATABASE is2 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE is2;
--##########
--##########
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	usuario VARCHAR( 255 ) UNIQUE,
	clave CHAR( 40 )
);

INSERT INTO usuarios VALUES( null, 'admin', SHA( 123456 ) ), ( null, 'root', SHA( 123456 ) );
--##########
--##########
DROP TABLE IF EXISTS turnos;
CREATE TABLE turnos(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	fecha DATE,
	hora TIME,
	idMedico INTEGER NULL,
	idPaciente INTEGER NULL ,
	estado ENUM( 'confirmado', 'cancelado', 'esperando' ),
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
--##########
--##########
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
--##########
--##########
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
	( null, 6, '16:00:00', '18:00:00', 4 ),
	( null, 7, '08:00:00', '13:00:00', 1 ),
	( null, 8, '09:00:00', '14:00:00', 2 )
;
--##########
--##########
DROP TABLE IF EXISTS pacientes;
CREATE TABLE pacientes(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	apellidos VARCHAR( 100 ),
	nombres VARCHAR( 100 ),
	sexo ENUM( 'F', 'M' ),
	dni VARCHAR( 20 ) UNIQUE,
	fechaNacimiento DATE,
	telefono VARCHAR( 100 ),
	email VARCHAR( 255 ),
	idObraSocial INTEGER NULL,
	nroAfiliado VARCHAR( 255 ) NULL
) ENGINE=InnoDB;

--## REFERS TO TO FILE patients.sql TO POPULATE THIS TABLE WITH 1000 PATIENTS
INSERT INTO pacientes VALUES
	( null, 'Ivan', 'Gómez', 'M', 1, '1947-10-10', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 1, MD5( RAND() ) ),
	( null, 'Damián', 'Antúnez', 'M', 2, '1949-03-30', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 2, MD5( RAND() ) ),
	( null, 'Federico', 'López', 'M', 3, '1951-11-01', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 2, MD5( RAND() ) ),
	( null, 'Fabián', 'Meléndez', 'M', 4, '1951-01-12', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 1, MD5( RAND() ) ),
	( null, 'José', 'Fagúndez', 'M', 5, '1945-06-24', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 1, MD5( RAND() ) ),
	( null, 'María Clara', 'Cortéz', 'F', 6, '1951-04-05', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 2, MD5( RAND() ) ),
	( null, 'Maria Laura', 'Valdéz', 'F', 7, '1950-12-12', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 2, MD5( RAND() ) ),
	( null, 'Marina', 'Chávez', 'F', 8, '1947-05-24', CONCAT( 4, FLOOR( RAND() * 1000000 ) ), CONCAT( SUBSTRING(MD5( RAND() ) FROM 1 FOR 6 ), '@gmail.com' ), 3, MD5( RAND() ) )
;

--##########
--##########
DROP TABLE IF EXISTS obrasSociales;
CREATE TABLE obrasSociales(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombreCorto VARCHAR( 255 ) UNIQUE,
	nombreCompleto TEXT
) ENGINE=InnoDB;
	
INSERT INTO obrasSociales VALUES
	( null, 'LIBRE', 'LIBRE' ),
	( null, 'IOMA', 'IOMA' ),
	( null, 'PAMI', 'PAMI' ),
	( null, 'OSDE', 'OSDE Binario' ),
	( null, 'CIMESA', 'CIMESA' ),
	( null, 'MEDITAR', 'MEDITAR' ),
	( null, 'FUSAL', 'FUSAL' ),
	( null, 'SERVESALUD', 'SERVESALUD' ),
	( null, 'FERMALINK', 'FERMALINK' ),
	( null, 'ASET', 'ASET' )
;
--##########
--##########
DROP TABLE IF EXISTS especialidades;
CREATE TABLE especialidades(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR( 255 ) UNIQUE
) ENGINE=InnoDB;

INSERT INTO especialidades VALUES
	( null, '---' ),
	( null, 'Otorrinolaringología' ),
	( null, 'Odontología' ),
	( null, 'Nefrología' ),
	( null, 'Endocrinología' ),
	( null, 'Urología' ),
	( null, 'Oftalmología' ),
	( null, 'Pediatría' ),
	( null, 'Psiquiatría' )
;
--##########
--##########
--## AHORA LAS REFERENCES
--##########
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

ALTER TABLE horarios
	ADD CONSTRAINT horarios_idMedico
	FOREIGN KEY( idMedico )
		REFERENCES medicos( id )
		ON DELETE CASCADE
;

ALTER TABLE pacientes
	ADD CONSTRAINT pacientes_idObraSocial
	FOREIGN KEY( idObraSocial )
		REFERENCES obrasSociales( id )
		ON DELETE SET NULL
;
--## Cuando se borrar una obra social los pacientes que estaban vinculados
--## a esa obra social deben pasarse todos a la obra social LIBRE (la de ID = 1 )
CREATE TRIGGER pacientes_reestablecerObraSocial
	AFTER DELETE ON obrasSociales
	FOR EACH ROW
		UPDATE 
			pacientes 
		SET 
			idObraSocial = 1,
			nroAfiliado = NULL
		WHERE 
			idObraSocial IS NULL;
;

ALTER TABLE medicos
	ADD CONSTRAINT medicos_idEspecialidad
	FOREIGN KEY( idEspecialidad )
		REFERENCES especialidades( id )
		ON DELETE SET NULL
;
--## Cuando borro una especialidad la cual este asociado a un medico
--## este debe pasar a la especialiad por defecto ( la de ID = 1 )
CREATE TRIGGER medicos_reestablecerEspecialidad
	AFTER DELETE ON especialidades
	FOR EACH ROW
		UPDATE 
			medicos 
		SET 
			idEspecialidad = 1
		WHERE 
			idEspecialidad IS NULL;
;
