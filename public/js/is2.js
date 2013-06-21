/**
* BINARY TREE
*/
var BinaryTree = function() {};
BinaryTree.prototype = {
	add: function( key, data ) {
		if( !this.key ) {
			this.key = key;
			// es un array por el tema de los repetidos
			this.data = [ data ];
			this.left = null;
			this.right = null;
			
		} else if( this.key > key ) {
			if( !this.left ) { 
				this.left = new BinaryTree();
			}
			this.left.add( key, data );
			
		} else if( this.key < key ) {
			if( !this.right ) {
				this.right = new BinaryTree();
			}
			this.right.add( key, data );
			
		} else {
			// repetidos cuentan
			this.data.push( data );
		}
	},
	walkAsc: function( callback ) {
		if( this.key ) {
			this.walkAsc.call( this.left, callback );
			while( this.data.length ) {
				callback( this.key, this.data.shift() );
			}
			this.walkAsc.call( this.right, callback );
		}
	},
	walkDesc: function( callback ) {
		if( this.key ) {
			this.walkDesc.call( this.right, callback );
			while( this.data.length ) {
				callback( this.key, this.data.shift() );
			}
			this.walkDesc.call( this.left, callback );
		}
	}
};

/**
* MAIN JS
*/
var IS2 = IS2 || {};
	
IS2.initDatepickers = function( setDefaultValue ) {
	var $elems = $( '.datepicker' ).datepicker( {
		format: 'dd/mm/yyyy',
		language: 'es'
	} );
	if( setDefaultValue ) {
		$elems.datepicker( 'setValue', new Date() );
	}
};

IS2.initTimepickers = function( config ) {
	$( '.timepicker' ).timepicker( $.extend( {
		showInputs: false,
		showMeridian: false
	}, config ) );	
};

IS2.prevStateDict = [
	'is2-appointment-state',
	'is2-patient-state'
];

IS2.cleanPrevState = function( skip ) {
	IS2.prevStateDict.forEach( function( name ) {
		if( skip !== name ) {
			localStorage.removeItem( name );
		}
	} );
};

IS2.loadPrevState = function( name, callback, $form ) {
	if( !$form ) {
		$form = $( 'form' );
	}
	var prevState = JSON.parse( localStorage.getItem( name ) );
	if( prevState ) {
		if( window.location.search.indexOf( 'error' ) >= 0 ) {
			for( var fieldName in prevState ) {
				$( '[name=' + fieldName + ']' ).val( prevState[fieldName] );
			}
		}
		this.cleanPrevState();
		callback && callback( prevState );
	}
};

IS2.savePrevState = function( name, skip, $form ) {
	var prevState = {};
	( $form || $( 'form' ) ).find( 'input, select, textarea' ).each( function( e ) {
		var $el = $( this ),
			fieldName = $el.attr( 'name' );
		if( fieldName && fieldName !== skip ) {
			prevState[fieldName] = $el.val().replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
		}
	} );
	window.localStorage.setItem( name, JSON.stringify( prevState ) );
};

IS2.showNewRecord = function( $el ) {
	
	var $document = $( document ),
		$popoverTemplate = $( '.is2-popover' ),
		$popoverClose,
		$popover,
		closePopupTimeout;
	
	$el.addClass( 'is2-record-new' ).popover( {
		trigger: 'manual',
		placement: 'bottom',
		html: true,
		content: $popoverTemplate.prop( 'outerHTML' )
	} );

	$popover = $el.data( 'popover').tip();
	$popover.css( 'visibility', 'hidden' );
	$el.popover( 'show' );
	$popover.css( 'top', '+=10' ).hide().css( 'visibility', 'visible' ).fadeIn( 'fast' ).animate( { top: '-=15' } );

	$popoverClose = $popover.find( '.is2-popover-close' );
	$popoverClose.on( 'click', function( e ) {
		e.stopPropagation();
		$el.popover( 'hide' ).removeClass( 'is2-record-new' ).off( 'click', arguments.callee );
		window.clearTimeout( closePopupTimeout );
	} );
	$document.on( 'click', function( e ) {
		e.stopPropagation();
		var $el = $( e.target );
		while( $el.length && !$el.hasClass( 'popover' ) ) { 
			$el = $el.parent();
		}
		if( !$el.length ) {
			$popoverClose.click();
			$document.off( 'click', arguments.callee )
		}
	} );
	closePopupTimeout = window.setTimeout( function() {
		$popoverClose.click();
	}, 5000 );
};

IS2.emptyFieldMsg = '<div class="alert alert-error is2-popover-msg is2-patient-empty">Este campo no puede estar vacio</div>';
IS2.lookForEmptyFields = function( $theForm, notShowPopover, notFind ) {
	
	var $fields = !notFind ? $theForm.find( 'input:not( [type=hidden] ), textarea' ) : $theForm, $field,
		$groupControl,
		isError = false,
		i = 0, l = $fields.length;
	
	for( ; i < l; i++ ) {
		$field = $fields.eq( i );
		// clean any prevous popover setup
		if( !notShowPopover ) {
			$field.popover( 'destroy' );
		}
		$groupControl = IS2.findGroupControl( $field );

		if( !$field.val().trim() ) {
			if( !notShowPopover ) {
				$field.popover( { content: IS2.emptyFieldMsg, html: true, trigger: 'manual', placement: $field.attr( 'data-placement' ) || 'right' } ).popover( 'show' );
			}
			$groupControl.addClass( 'error' );
			isError = true;
		} else {
			$groupControl.removeClass( 'error' );
		}
	}
	
	return isError;
};

IS2.findGroupControl = function( $groupControl ) {
	while( ( $groupControl = $groupControl.parent() ).length && !$groupControl.hasClass( 'control-group' ) );
	return $groupControl;
};

IS2.showCrudMsg = function( $msg, offset, delay ) {
	
	var height = $msg.css( 'visibility', 'hidden' ).show().outerHeight(),
		diff = height * ( offset || 1 );

	$msg.css( 'visibility', 'visible' ).css( 'top', height * -1 ).show().animate( { top: '+=' + (  diff - 3 ) }, { complete: function() {
		$msg.delay( delay || 2000 ).animate( { top: '-=' + diff } );
	} } );	
};

// fix dismiss alert
$(function() {
	$( '[data-dismiss="alert"]' ).on( 'click', function( e ) {
		e.preventDefault();
		e.stopPropagation();
		var $alert = $( this );
		while( ( $alert = $alert.parent() ).length && !$alert.hasClass( 'alert' ) );
		$alert.stop().hide();
	} );
});


/**
* CRUD
*/
IS2.CRUD = function( baseClass, identifierAttr ) {
	this.Remove.parent = this;
	
	this.isWaiting = false;
	
	this.baseClass = baseClass;
	this.identifierAttr = identifierAttr;
	this.currentID = null;
	
	this.$theGrid = $( '.is2-grid-wrapper' );
	this.$CRUDMsgs = $( '.is2-crud-messages' );
};

IS2.CRUD.prototype = {
	
	Remove: function( parent ) {
		this.parent = parent;
		
		this.parent.$theGrid.delegate( '.is2-trigger-remove', 'click', $.proxy( this.onclick, this ) );
		
		this.$theForm = $( '#is2-modal-remove' );
		this.$theForm.on( 'submit', $.proxy( this.onsubmit, this ) ).on( 'hidden', $.proxy( this.parent.onhidden, this ) );
		
		this.$preloader = this.$theForm.find( '.is2-preloader' );
		this.$closeFormButton = this.$theForm.find( '.is2-close-button' );
		
		this.$msgError = this.$theForm.find( '.is2-remove-error' );
		// este no esta dentro de $theForm
		this.$msgSuccess = $( '.is2-remove-success' );
	},
	
	Edit: function( parent ) {
		this.parent = parent;
		
		this.parent.$theGrid.delegate( '.is2-trigger-edit', 'click', $.proxy( this.onclick, this ) );
		
		this.$theForm = $( '.is2-modal-edit' );
		this.$fields = this.$theForm.find( '.is2-field' );
		this.$requiredFields = this.$theForm.find( '.is2-field[data-field-required="true"]' );
		this.$editElems = this.$theForm.find( '.is2-edit' );
		this.$createElems = this.$theForm.find( '.is2-create' );
		
		this.$preloader = this.$theForm.find( '.is2-preloader' );
		
		this.$msgError = this.$theForm.find( '.is2-edit-error' );
	},
	
	Create: function( parent ) {
		this.parent = parent;
		
		$( '.is2-trigger-create' ).on( 'click', $.proxy( this.onclick, this ) );
		
		this.$theForm = $( '.is2-modal-create' );
		this.$fields = this.$theForm.find( '.is2-field' );
		this.$requiredFields = this.$theForm.find( '.is2-field[data-field-required="true"]' );
		this.$editElems = this.$theForm.find( '.is2-edit' );
		this.$createElems = this.$theForm.find( '.is2-create' );
		
		this.$preloader = this.$theForm.find( '.is2-preloader' );
		
		this.$msgError = this.$theForm.find( '.is2-create-error' );
	},
	
/**
* helpers
*/
	showPreloader: function( $el ) {
		$el.css( 'visibility', 'visible' );
	},
	
	hidePreloader: function( $el ) {
		$el.css( 'visibility', 'hidden' );
	},
	
	onhidden: function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	},
	
	lookForCRUD: function() {
		var theID,
			$row;
		
		if( ( theID = window.location.search.match( /id=(\d+)/ ) ) && ( $row = $( 'tr[' + this.identifierAttr + '=' + theID[1] + ']' ) ).length ) {
			this.$CRUDMsgs[0].scrollIntoView();
			
			this.$theGrid.scrollTo( $row, 1000, { onAfter: this._highlightRecord }	);
		}
	},
	
	/**
	* scope loosed
	*/
	_highlightRecord: function( $row, data ) {
		var $prevRow = $row.prev();
		if( !$prevRow.length ) {
			$prevRow = $row;
		}
		
		$row.addClass( 'is2-record-new' );
		$prevRow[0].scrollIntoView();
		
		window.setTimeout( function() {
			$row.removeClass( 'is2-record-new' );
		}, 3000 );
	},
};

IS2.CRUD.prototype.Remove.prototype = {
	
	onclick: function( e ) {
		var theID = $( e.target ).attr( this.parent.identifierAttr ),
			$row = $( 'tr[' + this.parent.identifierAttr + '=' + theID + ']' );
			
		this.$msgError.stop().hide();
		$row.addClass( 'is2-record-new' );
		
		this.parent.currentID = theID;
	},
	
	onsubmit: function( e ) {
		e.preventDefault();
		if( this.parent.isWaiting ) {
			return;
		}
		
		this.parent.isWaiting = true;
		this.parent.showPreloader( this.$preloader );
		
		$.ajax( {
			url: '/' + this.parent.baseClass + '/' + this.parent.currentID + '/borrar',
			dataType: 'json',
			type: 'POST',
			success: this.reponse,
			error: this.reponse,
			context: this
		} );
	},
	
	reponse: function( dataResponse ) {
		this.parent.isWaiting = false;
		this.parent.hidePreloader( this.$preloader );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( this.$msgError, 0, 6000 );
			
		} else {
			$( 'tr[' + this.parent.identifierAttr + '=' + dataResponse.data.id + ']' ).addClass( 'is2-record-removed' ).find( 'a, button' ).css( 'visibility', 'hidden' );
			
			this.$closeFormButton.click();
			
			IS2.showCrudMsg( this.$msgSuccess );
		}
	}
};

IS2.CRUD.prototype.Edit.prototype = {
	
	onclick: function( e ) {
		var theID = $( e.target ).attr( this.parent.identifierAttr ),
			$row = $( 'tr[' + this.parent.identifierAttr + '=' + theID + ']' ),
			$field, i = 0, l = this.$fields.length;
		
		$row.addClass( 'is2-record-new' );
		
		this.$editElems.show();
		this.$createElems.hide();
		
		for( ; i < l; i++ ) {
			$field = this.$fields.eq( i );
			$field.val( $row.find( '[data-field-name=' + $field.attr( 'name' ) + ']' ).html() );
		}
		
		this.parent.currentID = theID;
		
		IS2.CRUD._CreateEdit.bindForm( this );
	},
	
	getAjaxURL: function() {
		return '/' + this.parent.baseClass + '/' + this.parent.currentID + '/editar';
	},
	
	getSuccessURL: function() {
		return '/' + this.parent.baseClass + '?exito-editar';
	}
	
};

IS2.CRUD.prototype.Create.prototype = {
	
	onclick: function( e ) {
		this.$editElems.hide();
		this.$createElems.show();
		
		this.$fields.val( '' );
		
		IS2.CRUD._CreateEdit.bindForm( this );
	},
	
	getAjaxURL: function() {
		return '/' + this.parent.baseClass + '/crear';
	},
	
	getSuccessURL: function() {
		return '/' + this.parent.baseClass + '?exito-crear';
	}
	
};

IS2.CRUD._CreateEdit = {
	
	bindForm: function( self ) {
		self.$theForm.off( 'submit' ).off( 'hidden' ).off( 'keypress' );
		self.$theForm.on( 'submit', $.proxy( this.onsubmit, self ) ).on( 'hidden', self.parent.onhidden ).on( 'keypress', $.proxy( this.onkeypress, self ) );
	},
	
	onsubmit: function( e ) {
		e.preventDefault();
		if( this.parent.isWaiting ) {
			return;
		}
		
		if( IS2.lookForEmptyFields( this.$requiredFields, true, true ) ) {
			return;
		}
		
		this.parent.isWaiting = true;
		this.parent.showPreloader( this.$preloader );
		
		var data = {}, $field,
			i = 0, l = this.$fields.length;
			
		for( ; i < l; i++ ) {
			$field = this.$fields.eq( i );
			data[$field.attr( 'name' )] = $field.val();
		}
		
		$.ajax( {
			url: this.getAjaxURL(),
			dataType: 'json',
			type: 'POST',
			data: data,
			success: IS2.CRUD._CreateEdit.response,
			error: IS2.CRUD._CreateEdit.response,
			context: this
		} );
	},
	
	response: function( dataResponse ) {
		this.parent.isWaiting = false;
		this.parent.hidePreloader( this.$preloader );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( this.$msgError, 0, 6000 );
			// TODO: control group
		
		} else {
			window.location = this.getSuccessURL() + '&id=' + dataResponse.data.id;		
		}
	},
	
	onkeypress: function( e ) {
		if( e.keyCode === 13 ) {
			e.preventDefault();
			this.$theForm.trigger( 'submit' );
		}
	}
};

IS2.markChosenOrder = function( groupSelector, $el ) {
	$( groupSelector + ' i' ).hide();
	$el.find( 'i' ).show();
};

IS2.getFormFields = function( $theForm ) {
	var $fields = $theForm.find( '[name]' ), $field,
		i = 0, l = $fields.length,
		attr, prevAttr = null, val, t = [], data = {};

	for( ; i < l; i++ ) {
		$field = $fields.eq( i );
		attr = $field.attr( 'name' );
		val = $field.val().trim();
		if( prevAttr && prevAttr !== attr ) {
			data[prevAttr.replace( '[]', '' )] = t;
			t = [];
			prevAttr = null;
		}
		if( attr.indexOf( '[]' ) > 0 ) {
			prevAttr = attr;
			if( $field.prop( 'checked' ) ) {
				t.push( val );
			}
		} else {
			if( $field.is( '[type="radio"]' ) && !$field.prop( 'checked' ) ) {
				continue;
			}
			data[attr] = val;
		}
	}
	return data;
}; 

IS2.getISODate = function( value ) {
	value = value.split( '/' );
	return value.length === 3 ? value[2] + '-' + value[1] + '-' + value[0] : '';
};

IS2.getISOTime = function( value ) {
	value = value.split( ':' );
	return value.length === 3 ? value[0] + ':' + value[1] + ':00' : '';
};