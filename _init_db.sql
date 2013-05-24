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
