<!DOCTYPE html>
<html lang="es">
	<head>
		<?php t_headTag( 'Turnos - Crear' ); ?>
		<style>
			label {
				pointer: default;
			}
		</style>
	</head>
	<body>
		<?php t_headerTag( $username, 'appointments' ); ?>
	
		<div class="container">
			<div class="is2-pagetitle clearfix">
				<h3>Turnos - Crear</h3>
				<a class="btn pull-right" href="/turnos"><i class="icon-arrow-left"></i> Listar turnos</a>
			</div>
			
			<form class="form-horizontal" method="post" action="">
				<div class="control-group">
					<label class="control-label">Apellidos</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Apellidos">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombres</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Nombres">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Sexo</label>
					<div class="controls">
						<select type="text" class="input-mini">
							<option value="f">F</option>
							<option value="m">M</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">DNI</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Número de DNI">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Fecha de nacimiento</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker" placeholder="Fecha de nacimiento">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Teléfono</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker" placeholder="Teléfono">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Correo electrónico</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Correo electrónico">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Obra social</label>
					<div class="controls">
						<select type="text" class="input-xlarge">
							<option value="f">IOMA</option>
							<option value="m">PAMI</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Número de afiliado</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Número de afiliado">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn">Crear turno</button>
					</div>
				</div>
			</form>
		</div>
		
		<?php t_footerTag(); ?>
	</body>
</html>
<script>
(function() {

})();
</script>