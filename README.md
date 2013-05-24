is2
===

Ingeniera de software 2 - Proyecto

Configuración
============

Para andar el pryecto se necesita tener los servicios PHP, MySQL y Apache funcionando. Yo recomiendo [WampServer](http://sourceforge.net/projects/wampserver/?source=directory)
Con WampServer va a aparecer al lado del reloj de Window su iconito, donde desde ahi le vamos a meter mano para hacer andar la aplicación.

httpd.conf
-------------
Hay que congiurar el archivo `httpd.conf` de la aplicación Apache, esto se abre desde el icono del WampServer haciendole click izquierdo, opcion Apache -> httpd.conf

Ubicar esta línea (yo la tengo en la linea numero 116)
`#LoadModule rewrite_module modules/mod_rewrite.so`
Solo hay que quitarle el numeral al principio de la línea

Ubicar la linea (178)
DocumentRoot "c:\wamp\bla..." 
Aca lo que hay que hacer poner como direccion donde va a estar ubicado los archivos que hacen la aplicacion, es decir, todo este repositorio.

Y tambien hay que hacer lo mismo con la linea (205)
<Directory "c:\wamp\bla...">

mysql credenciales
-------------------------
Corran el archivo mysql.credenciales.bat, esto les creara un archivo .ini necesario para que PHP pueda acceder a la base de datos, si estan usando WampServer, las credenciales son:
	* usuario: `root`
	* clave: `` (nada)
	
creando la base de datos y sus tablas
------------------------------------------------
para crear la base de datos que usara la aplicacion con sus respectivas tablas tiene que correr el siguiente comando desde la consola

`mysql -u %usuario% -p%clave% < _init_db.sql

* Tiene que reemplazar el %usuario% por el usuario de como se accede a la base de datos, por ejemplo root y si no hay password omitan el -p
* Sepan que deben estar ubicado desde la consola en la carpeta donde tiene el archivo `_init_db.sql` para que lo encuentre mysql

Por ejemplo le quedaria algo como esto:

`mysql -u root -p123456 < _init_db.sql


Listo ya estamos.
Pongan desde su navegador la direccion `localhost` ó 127.0.0.1, van a tener que ver la pantalla de login de la aplicacion.

Los usuarios son dos:
	* root
	* admin
	
Ambos sus password son 123456
	




