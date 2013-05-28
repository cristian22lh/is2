<!DOCTYPE html>
<html lang="es">
	<head>
		<?php t_headTag( 'Pacientes' ); ?>
		<style>
			label {
				cursor: default;
			}
			table {
				position: relative;
			}
			tr:not( :first-child ) {
				border-top: 10px solid #eee;
			}
			th {
				text-align: center !important;
			}
			td {
				height: 35px;
				vertical-align: top !important;
				text-align: center !important;
			}
			td span {
				overflow: hidden;
				text-overflow: ellipsis;
				display: inline-block;
			}
			td:nth-child( 1 ) span,
			td:nth-child( 2 ) span {
				width: 100px;
			}
			td:nth-child( 7 ) span {
				width: 100px;
				font-size: 12px;
			}
			td:nth-child( 8 ) span {
				width: 100px;
				text-transform: uppercase;
			}
			td:nth-child( 9 ) span {
				width: 150px;
				font-size: 12px;
			}
			.is2-grid-actions {
				position: absolute;
				width: 99.8%;
				left: 0;
				background: #eee;
				border-top: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
				padding: 2px 0 2px 2px;
				text-align: left;
			}
			
			.pagination {
				margin: 20px 0 0 0;
			}
		</style>
	</head>
	<body>
		<?php t_headerTag( $username, 'patients' ); ?>
	
		<div class="container">
			<?php if( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El paciente junto con sus turnos asociados han sido borrados satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido borrar al paciente! Vuelva a intentarlo.
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>No existe paciente con tal identificador cargado en el sistema.</strong>
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes</h3>
				<a class="btn pull-right" href="/pacientes/crear"><i class="icon-plus"></i> Crear un nuevo paciente</a>
			</div>
			
			<div class="pagination pagination-centered">
				<ul>
			<?php foreach( range( 'A', 'Z' ) as $char ): ?>
					<li>
						<a href="/pacientes/listar-por-letra/<?php echo $char; ?>"><?php echo $char; ?></a>
					</li>
			<?php endforeach; ?>
				</ul>
			</div>
			
			<?php if( count( $patients ) ): ?>
			<table class="table table-striped is2-grid">
				<thead>
					<tr>
						<th>Apellidos</th>
						<th>Nombres</th>
						<th>Sexo</th>
						<th>DNI</th>
						<th>Fecha de nacimiento</th>
						<th>Teléfono</th>
						<th>Correo electrónico</th>
						<th>Obra social</th>
						<th>Número de afiliado</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $patients as $patient ): ?>
					<tr data-patient-id="<?php echo $patient['id']; ?>">
						<td>
							<span title="<?php echo $patient['apellidos']; ?>"><?php echo $patient['apellidos']; ?></span>
							<div class="is2-grid-actions">
								<a class="btn btn-mini" href="/pacientes/editar/<?php echo $patient['id']; ?>">Editar</a>
								<a class="btn btn-mini btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-patient-id="<?php echo $patient['id']; ?>">Borrar</a>
							</div>
						</td>
						<td>
							<span title="<?php echo $patient['nombres']; ?>"><?php echo $patient['nombres']; ?></span>
						</td>
						<td><?php echo $patient['sexo']; ?></td>
						<td><?php echo $patient['dni']; ?></td>
						<td><?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?></td>
						<td><?php echo $patient['telefono']; ?></td>
						<td>
							<span title="<?php echo $patient['email']; ?>"><?php echo $patient['email']; ?></span>
						</td>
						<td>
							<span title="<?php echo $patient['obraSocialNombre']; ?>"><?php echo $patient['obraSocialNombre']; ?></span>
						<td>
							<span title="<?php echo $patient['nroAfiliado']; ?>"><?php echo $patient['nroAfiliado']; ?></span>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php else: ?>
			<div class="alert alert-error">
				No se han encontrado pacientes según el criterio de búsqueda específicado
			</div>
			<?php endif; ?>

		</div>
		
		<!-- los modals -->
		<form method="post" action="/pacientes/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar este paciente del sistema?</strong> Sepa que también se eleminarán sus turnos asociados.</span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<?php t_footerTag(); ?>
	</body>
</html>
<script>
(function() {
	$( '.is2-grid' ).delegate( 'span', 'mouseover', function( e ) {
		$( this ).tooltip( 'show' );
	} );
	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove' ).find( 'input[name="id"]' ).val( $( this ).attr( 'data-patient-id' ) );
	} );
})();
</script>