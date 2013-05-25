<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Aplicacion - Turnos</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<script src="js/jquery-2.0.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			body {
				background-color: #eee;
			}
			.container {
				width: 940px;
				margin: 0 auto;
				background-color: #fff;
				padding: 20px;
				border-radius: 5px;
				clear: both;
				box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
			}
			header {
				width: 980px;
				margin: 0 auto;
			}
			.is2-welcome {
				float: right;
				text-align: right;
				margin: 10px 0;
				padding-right: 14px;
			}
			.table td {
				vertical-align: middle;
				text-transform: capitalize;
			}
		</style>
	</head>
	<body>
	
		<header>
			<div class="alert alert-info is2-welcome">
				Hola, <strong><?php echo $username; ?>!</strong>
				<a href="/logout" class="btn btn-info btn-mini">Salir</a>
			</div>
		</header>
	
		<div class="container">
			<h3>Turnos</h3>
			<div class="alert">
				Se muestran los turnos desde dia presente (<strong><?php echo $currentDate; ?></strong>) hasta los próximos 7 días.
			</div>
			
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Dia</th>
						<th>Hora</th>
						<th>Medico</th>
						<th>Paciente</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $turnos as $turno ): ?>
					<tr>
						<td><?php echo date( 'd/m/Y', strtotime( $turno['fecha'] ) ); ?></td>
						<td><?php echo substr( $turno['hora'], 0, 5 ); ?></td>
						<td><?php echo $turno['medicoApellidos'] . ', ' .  $turno['medicoNombres']; ?></td>
						<td><?php echo $turno['pacienteApellidos'] . ', ' .  $turno['pacienteNombres']; ?></td>
						<td>
						<?php if( $turno['estado'] == 'confirmado' ): ?>
							<button class="btn btn-success disabled"><i class="icon-ok"></i> Confirmado</button>
						<?php elseif( $turno['estado'] == 'cancelado' ): ?>
							<button class="btn btn-warning disabled"><i class="icon-exclamation-sign"></i> Cancelado</button>
						<?php else: ?>
							<button class="btn">Confirmar</button>
							<button class="btn">Cancelar</button>
							<button class="btn btn-inverse">Borrar</button>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			

		</div> <!-- /container -->
</html>