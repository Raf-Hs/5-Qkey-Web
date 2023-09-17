$(document).ready(function () {
    $("#cargando").fadeOut("slow");
    cargaalumnos();

    $("#btn-confirmar-baja").click( function(){
        $("#cargando").show();

        $.ajax({
            "url"      : appData.uri_ws + "backend4/borraalumno/",
            "dataType" : "json",
            "type"     : "post",
            "data"     : {
                "id" : appData.id
            }
        })
        .done(function(obj){
            if(obj.resultado){
                $("#tr-" + appData.id).remove();
            }
            $("#cargando").fadeOut();
            alert(obj.resultado ? "info" : "danger", obj.mensaje); 
            if($("#tabla-alumnos")
                    .find("tbody")
                    .find("tr")
                    .length == 0){  // Si ya no hay renglones en el "tbody"
                $("#tabla-alumnos")
                    .find("thead")
                    .hide(); 
                setTimeout( function(){
                    alert("warning", "No hay alumnos");
                }, 5000);
            } 
        })
        .fail(error_ajax)
    }); // FIN del $("#btn-confirmar-baja").click( )

   
    $("#form-alumno").submit(function(e){
        e.preventDefault();
        borra_mensajes();
       if ($("#id").val() == "") {
  error_formulario("id", "El ID es requerido");
  return false;    
}
else if ($("#apellidos").val() == "") {
  error_formulario("apellidos", "Los apellidos son requeridos");
  return false;    
}
else if ($("#nombre").val() == "") {
  error_formulario("nombre", "El nombre es requerido");
  return false;    
}

        //Cerrar manualmente una modal
        $("#modal-editar").modal("hide");

        $("#cargando").show();

       
        $.ajax({
            "url"       : appData.uri_ws + "backend4/actualizaalumno",
            "dataType"  : "json",
            "type"      : "post",
           "data": {
  "accion": appData.accion,
  "id": $("#id").val(),
  "nombre": $("#nombre").val(),
  "apellidos": $("#apellidos").val(),
  "direccion": $("#direccion").val(),
  "telefono": $("#telefono").val(),
  "correo": $("#correo").val(),
  "contrasenia": $("#contrasenia").val(),
  "token": $("#token").val(),
  "tipo": $("#tipo").val(),
}

       })
        .done( function(obj){
            if(obj.resultado){
               cargaalumnos(); 
            }
            $("#cargando").fadeOut();
            alert(obj.resultado ? "info" : "warning", obj.mensaje);
        })
        .fail(error_ajax);

        return true;
    }); // FIN del $("#form-alumno").submit()

    $(".form-control, .form-select").click(borra_mensajes);  


$("#classroom-select").change(function () {
        var selectedClassroom = $(this).val();

        // Call the appropriate function based on the selected classroom
        if (selectedClassroom === "T207") {
            cargaalumnos();
        } else if (selectedClassroom === "T208") {
            cargaalumnos1();
        }
    });

}); // Fin del $.ready()

// FUNCIONES EXTERNAS

function cargaalumnos() {
  $("#tabla-alumnos")
    .find("thead")
    .hide();

  $.ajax({
    "url": appData.uri_ws + "backend4/alumnos/",
    "dataType": "json"
  })
    .done(function (obj) {
      if (obj.resultado) {
        $("#tabla-alumnos")
          .find("thead")
          .show();

        $("#tabla-alumnos")
          .find("tbody")
          .html("");

        $.each(obj.alumnos, function (i, a) {
          $("#tabla-alumnos")
            .find("tbody")
            .append(
              '<tr id="tr-' + a.id + '">' +
              '<td class="text-center">' + a.id + '</td>' +
       '<td class="text-center">' + a.matricula + '</td>' + 
            '<td class="text-center">' + a.nombre_grupo + '</td>' +
              '<td class="text-center">' + a.correo + '</td>' +
              '<td ">' + a.contrasenia.substring(0, 5) + '</td>' +
              '<td class="text-center">' + a.tipo + '</td>' +
              '<td class="text-center">' + a.nombre + '</td>' +
              '<td class="text-center">' + a.apellidos + '</td>' +
      
	    '<td class="text-center">' + a.direccion + '</td>' +
             '<td class="text-center">' + a.telefono + '</td>' + 
            '<td class="text-center">' + a.token + '</td>' +

              '<td class="text-center">' +
              '<button class="btn btn-sm btn-primary me-2" onclick="click_editar(\'' + a.id + '\')" title="Editar alumno"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#modal-editar"></i></button>' +
              '<button class="btn btn-sm btn-danger me-2" onclick="appData.id=\'' + a.id + '\';" title="Borrar alumno"><i class="fas fa-trash" data-bs-toggle="modal" data-bs-target="#modal-baja"></i></button>' +
              '</td>' +
              '</tr>'
            );
        });

        if ($("#mensaje").find(".alert").length == 0) {
          alert("info", obj.mensaje);
        }
      } else {
        alert("warning", obj.mensaje);
      }
    })
    .fail(error_ajax);
}


function cargaalumnos1() {
  $("#tabla-alumnos")
    .find("thead")
    .hide();

  $.ajax({
    "url": appData.uri_ws + "backend4/alumnos1/",
    "dataType": "json"
  })
    .done(function (obj) {
      if (obj.resultado) {
        $("#tabla-alumnos")
          .find("thead")
          .show();

        $("#tabla-alumnos")
          .find("tbody")
          .html("");

        $.each(obj.alumnos, function (i, a) {
          $("#tabla-alumnos")
            .find("tbody")
            .append(
              '<tr id="tr-' + a.id + '">' +
              '<td class="text-center">' + a.id + '</td>' +
		'<td class="text-center">' + a.matricula + '</td>' + 
            '<td class="text-center">' + a.nombre_grupo + '</td>' +
              '<td class="text-center">' + a.correo + '</td>' +
              '<td >' + a.contrasenia.substring(0, 5) + '</td>' +
              '<td class="text-center">' + a.tipo + '</td>' +
              '<td class="text-center">' + a.nombre + '</td>' +
              '<td class="text-center">' + a.apellidos + '</td>' +
             
	    '<td class="text-center">' + a.direccion + '</td>' +
             '<td class="text-center">' + a.telefono + '</td>' + 
            '<td class="text-center">' + a.token + '</td>' +

              '<td class="text-center">' +
              '<button class="btn btn-sm btn-primary me-2" onclick="click_editar(\'' + a.id + '\')" title="Editar alumno"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#modal-editar"></i></button>' +
              '<button class="btn btn-sm btn-danger me-2" onclick="appData.id=\'' + a.id + '\';" title="Borrar alumno"><i class="fas fa-trash" data-bs-toggle="modal" data-bs-target="#modal-baja"></i></button>' +
              '</td>' +
              '</tr>'
            );
        });

        if ($("#mensaje").find(".alert").length == 0) {
          alert("info", obj.mensaje);
        }
      } else {
        alert("warning", obj.mensaje);
      }
    })
    .fail(error_ajax);
}


function click_editar(id) {
  borra_mensajes();
  appData.accion = "cambio";
  appData.id = id;
  $("#modal-editar-accion").html("Editar");

  $("#cargando").show();

  $.ajax({
    "url": appData.uri_ws + "backend4/alumno",
    "dataType": "json",
    "type": "post",
    "data": {
      "id": id
    }
  })
    .done(function (obj) {
      $("#cargando").hide();
      if (obj.resultado) {
        $("#id")
          .val(obj.alumno.id).prop("disabled", true);
        $("#nombre").val(obj.alumno.nombre);
        $("#apellidos").val(obj.alumno.apellidos);
        $("#direccion").val(obj.alumno.direccion);
        $("#telefono").val(obj.alumno.telefono);
        $("#correo").val(obj.alumno.correo);
        $("#contrasenia").val(obj.alumno.contrasenia);
        $("#token").val(obj.alumno.token);
        $("#tipo").val(obj.alumno.tipo); 
      } else {
        alert("danger", obj.mensaje);
      }
    })
    .fail(error_ajax);
}

