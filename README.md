is2
===
**Ingeniera de software 2 - Proyecto**

Configuración
============
Para andar el proyecto se necesita tener los servicios **PHP**, **MySQL** y **Apache** funcionando. Yo recomiendo [WampServer](http://sourceforge.net/projects/wampserver/?source=directory)

**WampServer** va a aparecer al lado del reloj de Window su iconito, donde desde ahi le vamos a meter mano para hacer andar la aplicación.

httpd.conf
-------------
Hay que congiurar el archivo `httpd.conf` de la aplicación Apache, este se abre desde el icono del WampServer haciendole click izquierdo, opcion `Apache` -> `httpd.conf`

Tiene que tener los siguientes modulos cargados
```
LoadModule deflate_module modules/mod_deflate.so
LoadModule expires_module modules/mod_expires.so
LoadModule headers_module modules/mod_headers.so
LoadModule rewrite_module modules/mod_rewrite.so
```

En **linux** la tiene mas facil, pongan la consola, loguesenen como **root**, tiren el siguiente comando y listo!
```
# a2enmod deflate expires headers rewrite
```

Ademas obviamente el modulo necesario para cargar PHP, la mia es
`LoadModule php5_module "c:/wamp/bin/php/php5.4.3/php5apache2_2.dll`

En **linux**, como root hacen (y si estan usando **Ubuntu**):
```
# apt-get install libapache-mod-php5
```

Listo ahora, hay que decirle a Apache que en la URL `localhost:8080` va a cargar nuestra aplicacion, para eso al final del `htppd.conf` ponemos

```
Listen 8080
<VirtualHost *:8080>
    ServerName www.example.org
    DocumentRoot "C:\Documents and Settings\arcollector\Desktop\is2"

  <Directory "C:\Documents and Settings\arcollector\Desktop\is2">
        Options -Indexes FollowSymLinks -MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
  </Directory>

  ErrorLog "C:\Documents and Settings\arcollector\Desktop\is2\error_efin.log"
  LogLevel warn
  CustomLog "C:\Documents and Settings\arcollector\Desktop\is2\access.log" combined

</VirtualHost>
```

Deben cambiar `C:\Documents and Settings\arcollector\Desktop\is2` por la direccion donde tengan puesto este repositiorio.

mod_xsendfile.so (opcional)
--------------------------
Esto no es necesario, pero si muy recomendable. **mod_xsendfile.so** es un modulo no oficial para Apache que se usa para el tema de la descarga de archivos, delegando este proceso a este modulo y liberando PHP de esta funcion.

Se lo bajan de [aca](https://github.com/nmaier/mod_xsendfile), busquen el `mod_xsendfile.so` para su version de Apache que estan usando y coloquen este archivo en la carpeta de modulos de Apache, ahora lo que tiene que hacer cargar este modulo desde el `httpd.conf`, lo hacen de la siguiente manera:
`LoadModule xsendfile_module modules/mod_xsendfile.so`

Ahora en su `<VirtualHost>` ponen el siguiente codigo:
```
<Directory "/">
    Options -Indexes -FollowSymLinks -MultiViews
    AllowOverride All
    Order allow,deny
    XSendFile On
    XSendFilePath "C:/Windows/TEMP"
</Directory>
```
En Linux, deberian poner `/tmp` en la directiva `XSendFilePath`

PHP
-----
Necesitan una version mayor ó igual a la **5.3**

Ademas de los modulos habilitados en el `php.ini`
```
extension=php_mbstring.dll
extension=php_gd2.dll
extension=php_pdo_mysql.dll
```
En Linux la extension seria `.so`

MySQL credenciales
-------------------------
Corran el archivo `mysql.credenciales.bat` si estan en Window ó `mysql.credenciales.sh` si estan Linux, este les creara un archivo llamdo `mysql.ini` necesario para que la aplicacion mediante PHP pueda acceder a la base de datos, si estan usando WampServer, MySQL viene con estas credenciales:

* usuario: `root`
* clave: ` ` (nada)
	
Creando la base de datos y sus tablas
------------------------------------------------
Para crear la base de datos que usara la aplicacion con sus respectivas tablas tiene que correr el siguiente comando desde la consola

`mysql --local-infile -u %usuario% -p%clave% < _init_db.sql`

**ES PROBABLE QUE EL COMANDO mysql NO SEA RECONOCIDO**
Para este caso y si estan con WampServer, mysql esta (en mi caso) aca
	`C:\wamp\bin\mysql\mysql5.5.8\bin\mysql` 

* Tiene que reemplazar el `%usuario%` y `%clave%` por los datos de usuario y contraseña que se usan para acceder a la base de datos, por ejemplo **root** como usuario y si **no hay password** omitan el `-p`
* Sepan que deben estar ubicado desde la consola en la carpeta donde esta el archivo `_init_db.sql`

Por ejemplo le quedaria algo como esto:

`mysql --local-infile -u root -p123456 < _init_db.sql`

*Listo ya estamos!*

Pongan desde su navegador la direccion `localhost` ó `127.0.0.1`, van a tener que ver la pantalla de login de la aplicacion.

Los usuarios son dos:

1. root
2. admin
	
Para ambos sus password son **123456**

DEBUG
======
Para debuggear la aplicacion tienen que:

1. Usar Firefox
2. Tenerle instalado el plugin [FireBug](https://addons.mozilla.org/es/firefox/addon/firebug/)
3. Tener instalado el addon para FireBug, [FirePHP](https://addons.mozilla.org/en-US/firefox/addon/firephp/)
3. Listo

Para tirarle mensajes a FirePHP y que estos se vean en la consola de FireBug, deben llamar a la funcion `__log` en donde mas lo quieran en su codigo PHP.
