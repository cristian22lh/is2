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
			border-bottom: 2px solid #ccc;
		}
		tbody tr:not( .is2-empty-row ):nth-child( even ) {
			background: #f1f1f1;
		}
		td {
			padding: 10px 5px;
			text-align: center;
			font-size: 16px;
			border-top: 1px solid #ccc;
			text-transform: capitalize;
		}
		td:nth-child( 3 ),
		td:nth-child( 4 ) {
			text-align: left;
		}
		
		tr.is2-empty-row:first-of-type {
			display: none;
		}
		tr.is2-empty-row td {
			background: #aaa;
		}

		</style>
	</head>
	<body>
			<table>
				<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Médico</th>
							<th>Paciente</th>
						</tr>
				</thead>
				<tbody>
				<?php $previousAppointmentDate = null; ?>
				<?php foreach( $appointments as $appointment ): ?>
				
					<?php if( $previousAppointmentDate != $appointment['fecha'] ): ?>
					<tr class="is2-empty-row">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php endif; ?>
					
					<tr>
						<td><?php echo __dateISOToLocale( $appointment['fecha'] ); ?></td>
						<td><?php echo __trimTime( $appointment['hora'] ); ?></td>
						<td><?php echo $appointment['medicoApellidos'] . ', ' . $appointment['medicoNombres']; ?></td>
						<td><?php echo $appointment['pacienteApellidos'] . ', ' . $appointment['pacienteNombres']; ?></td>
					</tr>
					
					<?php $previousAppointmentDate = $appointment['fecha']; ?>

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