<!DOCTYPE html>
<html lang="es">
	<head>
			<meta charset="utf-8">
			<title>Turnos - Imprimir</title>
			<style>
/*
YUI 3.7.3 (build 5687)
Copyright 2012 Yahoo! Inc. All rights reserved.
Licensed under the BSD License.
http://yuilibrary.com/license/
*/
html{color:#000;background:#FFF}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0}table{border-collapse:collapse;border-spacing:0}fieldset,img{border:0}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal}ol,ul{list-style:none}caption,th{text-align:left}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal}q:before,q:after{content:''}abbr,acronym{border:0;font-variant:normal}sup{vertical-align:text-top}sub{vertical-align:text-bottom}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit}input,textarea,select{*font-size:100%}legend{color:#000}

		body {
			font: 12px Ubuntu, Helvetica;
		}

		table {
			table-layout: fixed;
			border-collapse: collapse;
			width: 100%;
		}
		th {
			background: #777;
			padding: 10px 5px;
			color: #fff;
			font-weight: 600;
			font-size: 18px;
			text-align: center;
			border-bottom: 1px solid #555;
		}
		tbody tr:nth-child( even ) {
			background: #f1f1f1;
		}
		td {
			padding: 10px 5px;
			text-align: center;
			font-size: 16px;
			border-top: 1px solid #aaa;
			text-transform: capitalize;
			vertical-align: middle;
		}
		td:nth-child( 1 ),
		td:nth-child( 6 ) {
			text-align: left;
		}
		
		@media print {
			.is2-print-button {
				display: none;
			}
		}
		.is2-print-button {
			position: fixed;
			top: 5px;
			left: 5px;
			opacity: .5;
			transition: all 300ms linear;
		}
		.is2-print-button:hover {
			opacity: 1;
		}
		.is2-print-button-trigger {
			padding: 2px 7px 5px 3px;
			background: #f1f1f1;
			border: 0;
			font-weight: 600;
			font-size: 12px;
			border-radius: 5px;
			box-shadow: 0 0 10px #000;
			line-height: 2;
			color: #777;
			text-shadow: 0 -1px 0 #fff;
			cursor: pointer;
		}
		.is2-print-button-trigger > * {
			vertical-align: middle;
			margin: 0 5px;
		}

		</style>
	</head>
	<body>
	
			<div class="is2-print-button">
				<button class="is2-print-button-trigger">
					<img src="/img/icon-printer.png">
					Imprimir
				</button>
			</div>
		
			<table>
				<thead>
						<tr>
							<th>Nombre completo</th>
							<th>DNI</th>
							<th>Fecha de nacimiento</th>
							<th>Télefono</th>
							<th>Número de afiliado</th>
							<th>Obra social</th>
						</tr>
				</thead>
				<tbody>
				<?php foreach( $patients as $patient ): ?>
					<tr>
						<td><?php echo $patient['apellidos'] . ', ' . $patient['nombres']; ?></td>
						<td><?php echo __formatDNI( $patient['dni'] ); ?></td>
						<td><?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?></td>
						<td><?php echo $patient['telefono']; ?></td>
						<td><?php echo $patient['nroAfiliado']; ?></td>
						<td><?php echo $patient['obraSocialNombre']; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
	</body>
</html>
<?php if( $autoPrint ): ?>
<script>
	print();
</script>
<?php endif; ?>
<script>
	document.querySelector( '.is2-print-button-trigger' ).addEventListener( 'click', function( e ) { print(); } );
</script>