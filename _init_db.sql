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

INSERT INTO usuarios VALUES( null, "admin", SHA( 123456 ) ), ( null, "root", SHA( 123456 ) );
--##########
--##########
DROP TABLE IF EXISTS turnos;
CREATE TABLE turnos(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	fecha DATE,
	hora TIME,
	idMedico INTEGER,
	idPaciente INTEGER,
	estado ENUM( 'confirmado', 'cancelado', 'esperando' )
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
	idEspecialidad INTEGER,
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
	idObraSocial INTEGER,
	nroAfiliado VARCHAR( 255 )
) ENGINE=InnoDB;
	
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
DROP TABLE IF EXISTS obraSociales;
CREATE TABLE obraSociales(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombreCorto VARCHAR( 255 ),
	nombreCompleto TEXT
) ENGINE=InnoDB;
	
INSERT INTO obraSociales VALUES
	( null, 'LIBRE', 'LIBRE' ),
	( null, 'IOMA', 'IOMA' ),
	( null, 'PAMI', 'PAMI' )
;