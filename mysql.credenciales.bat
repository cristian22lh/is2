SETLOCAL
ECHO OFF

ECHO.
ECHO Vamos a crear un archivo que contendra las credenciales para acceder a la base de datos MySQL mediante PHP
ECHO.

SET /P usuario=Ingrese usuario MySQL (si deja en blanco se toma "root" como usuario): 
IF NOT DEFINED usuario SET usuario="root"
SET /P clave=Ingrese password MySQL (si deja en blanco se toma ""): 
IF NOT DEFINED clave SET clave=""

ECHO [CREDENCIALES] > mysql.ini
ECHO usuario = %usuario% >> mysql.ini
ECHO clave = %clave% >> mysql.ini

ENDLOCAL