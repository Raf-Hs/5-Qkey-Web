$(document).ready(function () {
    $("#cargando").fadeOut("slow");
    cargaalumnos();

    $("#btn-confirmar-baja").click( function(){
        $("#cargando").show();

        $.ajax({
            "url"      : appData.uri_ws + "backend3/borraalumno/",
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

  $("#btn-confirmar-editar").click( function(){
        $("#cargando").show();

        $.ajax({
            "url"      : appData.uri_ws + "backend3/actualizaalumno/",
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




    $(".form-control, .form-select").click(borra_mensajes);  //  $(".form-control, .form-select").click()
}); // Fin del $.ready()

// FUNCIONES EXTERNAS

function cargaalumnos() {
  $("#tabla-alumnos")
    .find("thead")
    .hide();

  $.ajax({
    "url": appData.uri_ws + "backend3/alumnos/",
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
              '<td>' + a.correo + '</td>' +
              '<td>' + a.contrasenia + '</td>' +
              '<td class="text-center">' + a.tipo + '</td>' +
              '<td>' + a.nombre + '</td>' +
              '<td>' + a.apellidos + '</td>' +
              '<td>' + a.direccion + '</td>' +
              '<td>' + a.telefono + '</td>' +
              '<td>' + a.token + '</td>' +
              '<td class="text-center">' +
              '<button class="btn btn-sm btn-primary me-2" onclick="appData.id=\'' + a.id + '\';" title="Editar alumno"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#modal-editar"></i></button>' +
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



