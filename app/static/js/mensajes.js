function error_formulario( campo, mensaje ) {
	$( "#group-" + campo ).append( $( "<div>", {
		"class" : "invalid-feedback",
		"text"  : mensaje
	}));
	$( "#" + campo )
		.addClass( "is-invalid" )
		.focus();
}

function borra_mensajes() {
	$( ".is-invalid" ).removeClass( "is-invalid" );
	$( ".invalid-feedback" ).remove();
}

function error_ajax() {
	alert( "danger", "Error en AJAX" );
}

function alert( tipo, mensaje ) {
	switch( tipo ) {
		case "success":
			icono = "fa-check-circle";
			break;

		case "primary":
		case "secondary":
		case "light":
		case "dark":
		case "info":
			icono = "fa-info-circle";
			break;

		case "warning":
			icono = "fa-exclamation-triangle";
			break;

		case "danger":
			icono = "fa-ban";
			break;

	}
	$( "#mensaje" ).append( '<div class="alert alert-' + 
			tipo + 
			' alert-dismissible fade show" role="alert"><i class="fas ' +
			icono + 
			' fa-2x"></i> ' +
			mensaje + '.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>' );

	setTimeout( function() {
		$( ".alert-dismissible" ).fadeOut( 1000, function(){
			$(this).remove();
		});
	}, 7000 );
}

function fecha_fancy(sFecha){

	const ames = ["ene", "feb", "mar", "abr", 
				  "may", "jun", "jul", "ago", 
				  "sep", "oct", "nov", "dic"];

    // recibe fecha en formato yyyy-mm-dd
    aFecha = sFecha.split("-");

    return  aFecha[2] + "-" + ames[ aFecha[1] -1 ]+ "-" + aFecha[0];
}