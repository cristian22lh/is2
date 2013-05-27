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
			td {
				height: 35px;
				vertical-align: top !important;
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
			}
			td:nth-child( 8 ) span {
				width: 100px;
				text-transform: uppercase;
			}
			td:nth-child( 9 ) span {
				width: 150px;
			}
			.is2-grid-actions {
				position: absolute;
				width: 99.8%;
				left: 0;
				background: #eee;
				border-top: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
				padding: 2px 0 2px 2px;
			}
		</style>
	</head>
	<body>
		<?php t_headerTag( $username, 'patients' ); ?>
	
		<div class="container">
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes</h3>
				<a class="btn pull-right" href="/pacientes/crear"><i class="icon-plus"></i> Crear un nuevo paciente</a>
			</div>
			
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
								<a class="btn btn-mini is2-trigger-edit" href="#is2-modal-edit" data-toggle="modal" data-patient-id="<?php echo $patient['id']; ?>">Editar</a>
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

		</div>
		
		<!-- los modals -->
		<form method="post" action="/pacientes/editar" id="is2-modal-edit" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong>Editar paciente</strong>
			</div>
			<div class="modal-body">
				<fieldset class="form-inline">
				</fieldset>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Editar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
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
	$( '.is2-grid' ).delegate( '.is2-trigger-edit', 'click', function( e ) {
		
	} );
	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		
	} );
})();
</script>