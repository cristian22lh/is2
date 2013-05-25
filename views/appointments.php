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
			.table td:not( :last-child ) {
				vertical-align: middle;
				text-transform: capitalize;
			}
			.modal-backdrop, .modal-backdrop.fade.in {
				background-color: #f1f1f1;
				opacity: .4;
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
			<?php if( $confirmSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido confirmado satisfactoriamente!
			</div>
			<?php elseif( $confirmError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido confirmar el turno! Vuelva a intentarlo.
			</div>
			<?php elseif( $cancelSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido cancelado satisfactoriamente!
			</div>
			<?php elseif( $cancelError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido cancelar el turno! Vuelva a intentarlo.
			</div>
			<?php elseif( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido borrado satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido borar el turno! Vuelva a intentarlo.
			</div>
			<?php endif; ?>
		
			<h3>Turnos</h3>
			<div class="alert">
				Se muestran los turnos desde día presente (<strong><?php echo $currentDate; ?></strong>) hasta los próximos 7 días.
			</div>
			
			<table class="table table-striped is2-grid">
				<thead>
					<tr>
						<th>Dia</th>
						<th>Hora</th>
						<th>Médico</th>
						<th>Paciente</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $turnos as $turno ): ?>
					<tr data-appointment-id="<?php echo $turno['id']; ?>">
						<td><?php echo date( 'd/m/Y', strtotime( $turno['fecha'] ) ); ?></td>
						<td><?php echo substr( $turno['hora'], 0, 5 ); ?></td>
						<td><?php echo $turno['medicoApellidos'] . ', ' .  $turno['medicoNombres']; ?></td>
						<td><?php echo $turno['pacienteApellidos'] . ', ' .  $turno['pacienteNombres']; ?></td>
						<td>
						<?php if( $turno['estado'] == 'confirmado' ): ?>
							<button class="btn btn-success disabled"><i class="icon-ok"></i> Confirmado</button>
							<button class="btn btn-mini btn-link">Deshacer acción</button>
						<?php elseif( $turno['estado'] == 'cancelado' ): ?>
							<button class="btn btn-warning disabled"><i class="icon-exclamation-sign"></i> Cancelado</button>
							<button class="btn btn-mini btn-link">Deshacer acción</button>
						<?php else: ?>
							<a class="btn is2-trigger-confirm" href="#is2-modal-confirm" data-toggle="modal" data-appointment-id="<?php echo $turno['id']; ?>">Confirmar</a>
							<a class="btn is2-trigger-cancel" href="#is2-modal-cancel" data-toggle="modal" data-appointment-id="<?php echo $turno['id']; ?>">Cancelar</a>
							<a class="btn btn-inverse is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-appointment-id="<?php echo $turno['id']; ?>">Borrar</a>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

		</div> <!-- /container -->
		
		<!-- modals -->
		<form method="post" action="turnos/confirmar" id="is2-modal-confirm" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que confirmar el turno?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</a>
				<button class="btn btn-primary" type="submit">Sí</a>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="turnos/cancelar" id="is2-modal-cancel" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea cancelar el turno?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</a>
				<button class="btn btn-primary" type="submit">Sí</a>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="turnos/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar el turno?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</a>
				<button class="btn btn-primary" type="submit">Sí</a>
			</div>
			<input type="hidden" name="id">
		</form>
		
	</body>
</html>
<script>
	$( '.is2-grid' ).delegate( '.is2-trigger-confirm', 'click', function( e ) {
		// hay que poner el turno id en input hidden
		$( '#is2-modal-confirm input' ).val( $( this ).attr( 'data-appointment-id' ) );
	
	} ).delegate( '.is2-trigger-cancel', 'click', function( e ) {
		$( '#is2-modal-cancel input' ).val( $( this ).attr( 'data-appointment-id' ) );
	
	} ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove input' ).val( $( this ).attr( 'data-appointment-id' ) );
		
	} );

</script>