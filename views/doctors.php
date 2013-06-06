<?php t_startHead( 'Médicos' ); ?>
	<style>
		.is2-doctor-presentation {
			display: inline-block;
			width: 300px;
			padding: 5px;
			margin: 0 0 20px 0;
			white-space: nowrap;
			border-radius: 10px;
			cursor: pointer;
			transition: all 300ms ease-in-out;
		}
		.is2-doctor-presentation img {
			border-radius: 50px;
			display: inline-block;
			margin: 0 10px 0 0;
			vertical-align: middle;
		}
		.is2-doctor-presentation-name {
			display: inline-block;
			vertical-align: bottom;
		
		}
		.is2-doctor-presentation-name h3 {
			display: block;
			font-size: 20px;
			white-space: pre-wrap;
			width: 210px;
			word-wrap: break-word;
			transition: all 300ms linear;
		}
		.is2-doctor-presentation-name p {
			transition: all 300ms linear; 
		}
		
		/* animation effect */
		@keyframes moveFromBottom {
		    from {
			opacity: 0;
			transform: translateY(200%);
		    }
		    to {
			opacity: 1;
			transform: translateY(0%);
		    }
		}
		@keyframes moveFromTop {
		    from {
			opacity: 0;
			transform: translateY(-200%);
		    }
		    to {
			opacity: 1;
			transform: translateY(0%);
		    }
		}
		
		.is2-doctor-presentation:hover {
			background: #5BC0DE;
			box-shadow: 0 2px 0 #32a2c3;
		}
		.is2-doctor-presentation:hover img {
			box-shadow: 0 -2px 0 #555;
		}
		.is2-doctor-presentation:hover .is2-doctor-presentation-name h3 {
			opacity: 1;
			color: #fff;
			animation: moveFromTop 300ms ease-in-out;
			text-shadow: 0 -1px 0 #555;
		}
		.is2-doctor-presentation:hover .is2-doctor-presentation-name p {
			opacity: 1;
			animation: moveFromBottom 300ms ease-in-out;
			color: #fff;
			text-shadow: 0 -1px 0 #555;
		}
		
		/* modal */
		#is2-modal-doctor {
			background: #fff;
			padding: 0;
			width: 850px;
			height: 495px;
			z-index: 100000;
			overflow: hidden;
		}
		#is2-modal-doctor .modal-body {
			line-height: 0;
			overflow: hidden;
			padding: 0;
			position: absolute;
			right: 4px;
			top: 5px;
		}
		.is2-modal-details-body {
			height: 495px;
			overflow: hidden;
		}
		.is2-modal-details-body h3 {
			margin: 5px 0 0 0;
		}
		
		.is2-modal-doctor-information {
			float: left;
			width: 200px;
			padding: 30px;
			height: 100%;
			text-align: center;
			text-shadow: 0 -1px 0 #555;
			border-right: 1px solid #58CAF5;
		}
		.is2-modal-doctor-information img {
			border-radius: 50px;
			display: block;
			margin: 0 auto;
			box-shadow: 0 -2px 0 #555;
		}
		
		.is2-modal-doctor-availability {
			border-left: 1px solid #0C688A;
			float: left;
			width: 300px;
			padding: 20px 10px;
			height: 100%;
			border-right: 1px solid #ddd;
		}
		.is2-doctor-insurances {
			float: left;
			width: 250px;
			padding: 20px 0 20px 10px;
			height: 100%;
		}
		.is2-doctor-insurances-grid {
			overflow-y: scroll;
			height: 390px;
		}
		
		.is2-input-grid td {
			padding: 5px 0;
		}
		.is2-grid-header {
			background: #fbfbfb;
			border-radius: 0;
			border-top: 1px solid #ddd;
			color: #555;
			text-shadow: 0 1px 0 #fff;
		}
		.is2-grid-header th:first-child,
		.is2-doctor-availability-grid td:first-child {
			width: 60px;
		}
		.is2-grid-header th:nth-child( 2 ) {
			width: 75px;
		}
		.is2-grid-header th:nth-child( 3 ) {
			width: 70px;
		}
		.is2-doctor-availability-grid td:last-child,
		.is2-doctor-insurances-grid td:last-child {
			width: 28px;
		}
		.is2-doctor-availability-grid td {
			text-align: center
		}
		.bootstrap-timepicker-widget td {
			border: 0;
		}
		
		.record-removed * {
			text-decoration: line-through;
		}
		.record-removed .btn {
			visibility: hidden;
		}
	</style>

<?php t_endHead(); ?>
<?php t_startBody( $username, 'doctors'  ); ?>
	
		<?php t_startWrapper(); ?>
		
		<div class="is2-pagetitle clearfix">
			<h3>Médicos</h3>
			<a class="btn pull-right btn-warning" href="/medicos/crear"><i class="icon-plus"></i> Crear un nuevo médico</a>
		</div>
		
		<div class="is2-doctors-grid">
		<?php foreach( $doctors as $doctor ): ?>
			<div class="is2-doctor-presentation" data-doctor-id="<?php echo $doctor['id']; ?>">
				<img src="/img/<?php echo $doctor['avatar']; ?>">
				<div class="is2-doctor-presentation-name">
					<h3><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></h3>
					<p><?php echo $doctor['especialidad']; ?></p>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		
		<a class="is2-modal-doctor-trigger" href="#is2-modal-doctor" data-toggle="modal" style="display:none"></a>
		<div id="is2-modal-doctor" class="modal hide fade">
			<div class="is2-modal-wrapper">
				<div class="progress progress-striped active is2-modal-preloader">
					<div class="bar"></div>
				</div>
				<div class="is2-modal-details-header">
					<div class="modal-body">
						<button class="btn btn-link is2-modal-close" data-dismiss="modal">
							<i class="icon-remove-sign"></i>
						</button>
					</div>
				</div>
				<div class="is2-modal-details-body">
					<div class="is2-modal-doctor-information btn-info">
						<img src="" class="is2-modal-doctor-avatar">
						<h3><span class="is2-modal-doctor-field" data-field-name="apellidos"></span>, <span class="is2-modal-doctor-field" data-field-name="nombres"></span></h3>
						<p class="is2-modal-doctor-field" data-field-name="especialidad"></p>
						<div class="is2-modal-doctor-information-misc">
							<p>Matricula: <strong class="is2-modal-doctor-field" data-field-name="matricula"></strong></p>
						</div>
					</div>
					
					<div class="is2-modal-doctor-availability">
						<h3>Horarios</h3>
						<table class="table is2-grid-header">
							<tr>
								<th>Dia</th>
								<th>Hora de ingreso</th>
								<th>Hora de egreso</th>
								<th></th>
							</tr>
						</table>
						<table class="table is2-doctor-availability-grid">
							<tr class="is2-doctor-availability-record">
								<td class="is2-field" data-field-name="diaNombre"></td>
								<td class="is2-field" data-field-name="horaIngreso"></td>
								<td class="is2-field" data-field-name="horaEgreso"></td>
								<td>
									<a class="btn btn-mini btn-danger is2-doctor-availability-record-remove" href="#" data-toggle="modal" title="Borrar"><i class="icon-remove-sign icon-white"></i></a>
								</td>
							</tr>
						</table>
						<form class="is2-doctor-availability-form">
							<table class="table is2-input-grid">
								<tr>
									<td class="control-group is2-doctor-availability-day">
										<input type="text" class="input-mini is2-doctor-availability-day" name="diaNombre" placeholder="Día">
									</td>
									<td class="control-group is2-doctor-availability-in">
										<div class="bootstrap-timepicker">
											<input type="text" class="input-mini timepicker is2-doctor-availability-in" name="horaIngreso" placeholder="Hora de ingreso">
										</div>
									</td>
									<td class="control-group is2-doctor-availability-out">
										<div class="bootstrap-timepicker">
											<input type="text" class="input-mini timepicker is2-doctor-availability-out" name="horaEgreso" placeholder="Hora de egreso">
										</div>
									</td>
									<td>
										<button class="btn btn-info is2-doctor-availability-trigger" title="Agregar nuevo horario">Agregar</button>
									</td>
								</tr>
							</table>
						</form>
						<div class="is2-doctor-availability-popover alert alert-error is2-popover">
							El médico ya posee un horario registrado con estos mismo parametros
						</div>
					</div>
					
					<form class="is2-doctor-insurances">
						<h3>Obras sociales</h3>
						<div class="is2-doctor-insurances-grid">
						<?php foreach( $insurances as $insurance ): ?>
							<label class="checkbox" data-insurance-id="<?php echo $insurance['id']; ?>">
								<span class="is2-field" data-field-name="nombreCorto"><?php echo $insurance['nombreCorto']; ?></span>
								<span class="is2-field" data-field-name="nombreCompleto"><?php echo $insurance['nombreCompleto']; ?></span>
								<input type="checkbox" name="insurancesList[]" value="<?php echo $insurance['id']; ?>">
							</label>
						<?php endforeach; ?>
						</div>
						<button class="btn btn-info is2-doctor-insurances-trigger" title="Actualizar obras sociales admitidas por el medico">Actualizar</button>
					</form>
				</div>
			</div>
		</div>

		<?php t_endWrapper(); ?>
	
<?php t_endBody(); ?>

<script>
(function() {

// *** modal functionality *** //
	var $triggerModal = $( '.is2-modal-doctor-trigger' );
	var $doctorModal = $( '#is2-modal-doctor' );
	$doctorModal.on( 'hidden', function( e ) {
		e.stopPropagation();
		window.location.hash = '';
		$doctorModal.removeAttr( 'data-doctor-id' );
	
	} ).css( 'left', $( window ).outerWidth() /2 - 850 / 2 ).css( 'margin-left', 0 );
	var cleanAllInputs = function() {
		$availabilityForm.find( 'input' ).val( '' );
	};
	var $doctorModalPreloader = $( '.is2-modal-preloader' );
	var $doctorModalPreloaderBar = $doctorModalPreloader.find( '.bar' );
	var showPreloader = function() {
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );
	};
	var hidePreloader = function() {
		$doctorModalPreloaderBar.css( 'width', '100%' );
		window.setTimeout( function() {
			$doctorModalPreloader.fadeOut( 'fast' );
		}, 500 );
	};
	var isWaiting = false;
	
	var getDoctorID = function() {
		return $doctorModal.attr( 'data-doctor-id' );
	};
	
	var $doctorFields = $( '.is2-modal-doctor-field' );
	var $doctorAvatar = $( '.is2-modal-doctor-avatar' );
	
	var $doctorAvailabilitiesWrapper = $( '.is2-doctor-availability-grid' );
	var $doctorAvailabilitiesRecord = $( '.is2-doctor-availability-record' ).clone();
	$( '.is2-doctor-availability-record' ).remove();
	
	var $doctorInsurancesWrapper = $( '.is2-doctor-insurances-grid' );
	
	var showAvailabilities = function( data, appendOnly ) {
		if( !appendOnly ) {
			$doctorAvailabilitiesWrapper.empty();
		}
		var recordData, $record, $fields, $field,
			i, l;
		while( data.length ) {
			recordData = data.shift();
			$record = $doctorAvailabilitiesRecord.clone();
			
			$fields = $record.find( '.is2-field' );
			for( i = 0, l = $fields.length; i < l; i++ ) {
				$field = $fields.eq( i );
				$field.html( recordData[$field.attr( 'data-field-name' )] );
			}
			$record.attr( 'data-availability-id', data.id ).attr( 'data-availability-day', data.dia ).find( '.is2-doctor-availability-record-remove' ).attr( 'data-availability-id', data.id );
			
			$doctorAvailabilitiesWrapper.append( $record );
		}
	};
	
	var showDoctorDetails = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		if( !dataResponse.success ) {
			return;
		}
		
		var data = dataResponse.data,
			doctorData = data.doctor,
			availabilities = data.availabilities,
			insurances = data.insurances;
			
		var i = 0, l = $doctorFields.length, $field;
		for( ; i < l; i++ ) {
			$field = $doctorFields.eq( i );
			$field.html( doctorData[$field.attr( 'data-field-name' )] );
		}
		$doctorAvatar.attr( 'src', '/img/' + doctorData['avatar'] );
		
		showAvailabilities( availabilities );
		
		var insurancesCollection = [], $insuranceChecked;
		while( insurances.length ) {
			insurance = insurances.shift();
			$insuranceChecked = $doctorInsurancesWrapper.find( 'label[data-insurance-id=' + insurance.id + ']' );
			$insuranceChecked.find( 'input' ).click();
			insurancesCollection.push( $insuranceChecked );
		}
		$doctorInsurancesWrapper.children().first().before( insurancesCollection );
	};
	
	$( '.is2-doctor-presentation' ).on( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		
		cleanAllInputs();
		// show modal
		$triggerModal.click();
		showPreloader();
		isWaiting = true;

		var doctorID = $( this ).attr( 'data-doctor-id' );
		$doctorModal.attr( 'data-doctor-id', doctorID );
		window.location.hash = 'id=' + doctorID;
		// get doctor availabilities and insurances support
		$.ajax( {
			url: '/medicos/' + doctorID,
			dataType: 'json',
			type: 'GET',
			success: showDoctorDetails,
			error: showDoctorDetails
		} );
	} );
	
	// crear nuevo horario funcionalidad
	var DAYSNAME = [ 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo' ];
	$( '.is2-doctor-availability-day' ).typeahead( {
		source: DAYSNAME,
		items: 3
	} ).attr( 'autocomplete', 'off' );
	IS2.initTimepickers();
	
	var isWaiting = false;
	
	var $dayName = $( 'input.is2-doctor-availability-day' );
	var $dayNameGroupControl = $( '.control-group.is2-doctor-availability-day' );
	
	var $timeEntryIn = $( 'input.is2-doctor-availability-in' );
	var $timeEntryInGroupControl = $( '.control-group.is2-doctor-availability-in' );
	var $timeEntryOut = $( 'input.is2-doctor-availability-out' );
	var $timeEntryOutGroupControl = $( '.control-group.is2-doctor-availability-out' );
	var timeRegex = /^(?:[0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
	var isTimeValid = function( $input, $groupControl ) {
		var time = $input.val().trim().match( timeRegex );
		if( !time ) {
			$groupControl.addClass( 'error' );
			return false;
		}
		$groupControl.removeClass( 'error' );
		return time;
	};
	
	var createdAvailability = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		cleanAllInputs();
		if( !dataResponse.success ) {
			// duplicated entry
			$availabilityForm.popover( 'show' );
			return;
		}
		hidePopover( $availabilityForm );

		showAvailabilities( [ dataResponse.data ], true );
		
		$( '.is2-doctor-availability-record:last' ).effect( 'highlight', null, 1500 );
	};
	
	var hidePopover = function( $el ) {
		$el.data( 'popover' ).tip().hide();
	};
	
	var $availabilityForm = $( '.is2-doctor-availability-form' );
	$availabilityForm.popover( {
		html: true,
		content: $( '.is2-doctor-availability-popover' ).prop( 'outerHTML' ),
		trigger: 'manual'
	
	// create mode
	} ).on( 'submit', function( e ) {
		e.stopPropagation();
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		hidePopover( $availabilityForm );
		
		if( IS2.lookForEmptyFields( $availabilityForm, true ) ) {
			$dayNameGroupControl.addClass( 'error' );
			return;
		}
		
		var dayName = $dayName.val().trim().toLowerCase(),
			dayIndex = DAYSNAME.indexOf( dayName );
		if( dayIndex < 0 ) {
			$dayNameGroupControl.addClass( 'error' );
			return;
		}
		dayIndex++;
		$dayNameGroupControl.removeClass( 'error' );
		
		var timeEntryIn;		
		if( !( timeEntryIn = isTimeValid( $timeEntryIn, $timeEntryInGroupControl ) ) ) {
			return;
		}
		timeEntryIn = timeEntryIn[0]
		
		var timeEntryOut;
		if( !( timeEntryOut = isTimeValid( $timeEntryOut, $timeEntryOutGroupControl ) ) ) {
			return;
		}
		timeEntryOut = timeEntryOut[0];

		var d1 = timeEntryIn.split( ':' ),
			d2 = timeEntryOut.split( ':' );
			
		if( d1[0] >= d2[0] && d1[1] >= d2[1] ) {
			$timeEntryInGroupControl.addClass( 'error' );
			$timeEntryOutGroupControl.addClass( 'error' );
			return;
		}
		$timeEntryInGroupControl.removeClass( 'error' );
		$timeEntryOutGroupControl.removeClass( 'error' );

		isWaiting = true;
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );

		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/crear-horario',
			data: {
				dayIndex: dayIndex,
				timeEntryIn: timeEntryIn,
				timeEntryOut: timeEntryOut
			},
			dataType: 'json',
			type: 'POST',
			success: createdAvailability,
			error: createdAvailability
		} );
	} );
	
	// *** remover un horario *** //
	var removedAvailability = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		if( !dataResponse.success ) {
			return;
		}
		var appointmentID = dataResponse.data;
		$( '.is2-doctor-availability-record[data-availability-id=' + appointmentID + ']' ).addClass( 'record-removed' );
	};
	
	$doctorModal.delegate( '.is2-doctor-availability-record-remove', 'click', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		hidePopover( $availabilityForm );
		
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );
		isWaiting = true;
		
		var availabilityID = $( this ).attr( 'data-availability-id' );
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/borrar-horario',
			type: 'POST',
			dataType: 'json',
			data: {
				id: availabilityID
			},
			success: removedAvailability,
			error: removedAvailability
		} );
	} );
	
// *** obra sociales functionality *** //
	var $insuranceForm = $( '.is2-doctor-insurances-form' );
	$insuranceForm.on( 'submit', function( e ) {
		e.preventDefault();


	} );
	
// *** change hash listener *** //
	var $window = $( window );
	$window.on( 'hashchange', function( e ) {
		var hash = window.location.hash,
			doctorID = hash.match( /id=(\d+)/ );
			
		if( doctorID ) {
			doctorID = doctorID[1];
			$( '.is2-doctor-presentation[data-doctor-id=' + doctorID + ']' ).click();
			
		} else {
			$doctorModal.find( '.is2-modal-close' ).click();
		}
		
	} );
	
	window.setTimeout( function() {
		$window.trigger( 'hashchange' );
	}, 300 );
	
})();
</script>