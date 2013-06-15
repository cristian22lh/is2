<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Error 404 - Página no encontrada</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/is2.css" rel="stylesheet">
		<style>
			.container {
				margin-top: 50px;
				padding: 50px 50px;
			}
			strong {
				margin: 0 5px;
			}
			i {
				margin: 0 10px 0 0;
			}
			h1 > strong {
				color: red;
				font-size: 30px;
			}
			p > span > strong {
				color: blue;
			}
		</style>
    </head>
    <body>
		<div class="hero-unit center container">
			<h1>Página no encontrada <strong>Error 404</strong></h1>
			<br>
			<p>La página que usted ha solicitado <span><strong><?php echo $targetPage ? '(' . $targetPage . ')' : ''; ?></strong></span> no existe en el sistema, trate de contactar al administrador ó intentelo de vuelta volviendo hacia atrás, capaz que se soluciona.</p>
			<p><strong>Si lo desea, clickee sobre este gran botón para volver a la página principal.</strong></p>
			<a href="/" class="btn btn-large btn-info">
				<i class="icon-home icon-white"></i> Ir a la página principal
			</a>
		</div>
		<!-- By ConnerT HTML & CSS Enthusiast --> 
	</body>
</html>