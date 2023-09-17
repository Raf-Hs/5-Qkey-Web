$(document).ready(function () {
    $("#cargando").fadeOut("slow");
    cargaclases();

    $("#btn-confirmar-baja").click(function () {
        $("#cargando").show();

        $.ajax({
            "url": appData.uri_ws + "backend/borraclase/",
            "dataType": "json",
            "type": "post",
            "data": {
                "id": appData.matricula // Cambio de "matricula" a "id"
            }
        })
        .done(function (obj) {
            if (obj.resultado) {
                $("#tr-" + appData.matricula).remove();
            }
            $("#cargando").fadeOut();
            alert(obj.resultado ? "info" : "danger", obj.mensaje);
            if ($("#tabla-clases")
                .find("tbody")
                .find("tr")
                .length == 0) {
                $("#tabla-clases")
                    .find("thead")
                    .hide();
                setTimeout(function () {
                    alert("warning", "No hay clases");
                }, 5000);
            }
        })
        .fail(error_ajax);
    });

    $("#btn-agregar").click(function () {
        borra_mensajes();
        appData.accion = "alta";
        appData.matricula = "";
        $("#modal-editar-accion").html("Agregar");

        // Aquí puedes ajustar los campos de entrada para reflejar la tabla "clase"
        // Por ejemplo:
        $("#maestro").val("").prop("disabled", false);
        $("#grupo").val("");
        $("#materia").val("");
        $("#laboratorio").val("");
        //...
    });

  $("#btn-guardar").click(function () {
        // Aquí debes agregar el código necesario para manejar el evento click del botón
        // Por ejemplo, si deseas enviar el formulario con Ajax, puedes hacer lo siguiente:

        $("#cargando").show();

        $.ajax({
            "url": appData.uri_ws + "backend/actualizaclase",
            "dataType": "json",
            "type": "post",
            "data": {
                "accion": appData.accion,
                "id": appData.matricula,
                "maestro": $("#maestro").val(),
                "grupo": $("#grupo").val(),
                "materia": $("#materia").val(),
                "laboratorio": $("#laboratorio").val(),
                "horaE": $("#horaE").val(),
                "horaS": $("#horaS").val(),
                "codigo": $("#codigo").val()
            }
        })
        .done(function (obj) {
            if (obj.resultado) {
                cargaclases();
            }
            $("#cargando").fadeOut();
            alert(obj.resultado ? "info" : "warning", obj.mensaje);
        })
        .fail(error_ajax);
    });
    $("#form-clase").submit(function (e) {
        e.preventDefault();
        borra_mensajes();

        // Aquí también debes ajustar los campos de entrada para reflejar la tabla "clase"
        // Por ejemplo:
        if ($("#maestro").val() == "") {
            error_formulario("maestro", "El campo maestro es requerido");
            return false;
        } else if ($("#grupo").val() == "") {
            error_formulario("grupo", "El campo grupo es requerido");
            return false;
        } else if ($("#materia").val() == "") {
            error_formulario("materia", "El campo materia es requerido");
            return false;
        }
        //...

        //Cerrar manualmente una modal
        $("#modal-editar").modal("hide");

        $("#cargando").show();

        // Aquí debes ajustar los datos enviados al backend para reflejar la tabla "clase"
        // Por ejemplo:
        $.ajax({
            "url": appData.uri_ws + "backend/actualizaclase",
            "dataType": "json",
            "type": "post",
            "data": {
                "accion": appData.accion,
                "id": appData.matricula, // Cambio de "matricula" a "id"
                "maestro": $("#maestro").val(),
                "grupo": $("#grupo").val(),
                "materia": $("#materia").val(),
                "laboratorio": $("#laboratorio").val(),
                //...
            }
        })
        .done(function (obj) {
            if (obj.resultado) {
                cargaclases();
            }
            $("#cargando").fadeOut();
            alert(obj.resultado ? "info" : "warning", obj.mensaje);
        })
        .fail(error_ajax);

        return true;
    });

    $(".form-control, .form-select").click(borra_mensajes);

});

// Resto del código con las funciones relacionadas con "clases" en lugar de "alumnos"
//...
function cargaclases(idAlumno) {
    $("#tabla-clases")
        .find("thead")
        .hide();

var sessionData = JSON.parse(localStorage.getItem("sessionData"));
    var idAlumno = sessionData ? sessionData.id : null;


    $.ajax({
        "url": appData.uri_ws + "backend/clases_alumno/" + idAlumno,
        "dataType": "json"
    })
    .done(function (obj) {
        if (obj.resultado) {
            $("#tabla-clases")
            .find("thead")
            .show();

            $("#tabla-clases")
                .find("tbody")
                .html("");

            $.each(obj.clases, function (i, c) {
                // Ajusta la forma en que se agregan las filas a la tabla "clases"
                // Por ejemplo:
                $("#tabla-clases")
                    .find("tbody")
                    .append(
                        '<tr id="tr-' + c.id + '">' +
                        '<td class="text-center">' + c.id + '</td>' +
                        '<td class="text-center">' + c.maestro + '</td>' +
                        '<td class="text-center">' + c.grupo + '</td>' +
                        '<td class="text-center">' + c.materia + '</td>' +
                        '<td class="text-center">' + c.laboratorio + '</td>' +
                        '<td class="text-center">' + c.horaE + '</td>' +
                        '<td class="text-center">' + c.horaS + '</td>' +
                        '<td class="text-center">' + c.codigo + '</td>' +
                                               '</tr>'
                    );
            });

            if ($("#mensaje").find(".alert").length == 0)
                alert("info", obj.mensaje);
        } else {
            alert("warning", obj.mensaje);
        }
    })
    .fail(error_ajax);
}

function click_editar(id) {
    borra_mensajes();
    appData.accion = "cambio";
    appData.matricula = id;
    $("#modal-editar-accion").html("Editar");

    $("#cargando").show();

    $.ajax({
        "url": appData.uri_ws + "backend/clase",
        "dataType": "json",
        "type": "post",
        "data": {
            "id": id
        }
    })
    .done(function (obj) {
        $("#cargando").hide();
        if (obj.resultado) {
            // Ajusta la forma en que se muestran los datos en el formulario para editar clase
            // Por ejemplo:
            $("#maestro")
                .val(obj.clase.maestro);
            $("#grupo").val(obj.clase.grupo);
            $("#materia").val(obj.clase.materia);
            $("#laboratorio").val(obj.clase.laboratorio);
            $("#horaE").val(obj.clase.horaE.substring(11, 16)); // Extraer solo la hora y minutos
            $("#horaS").val(obj.clase.horaS.substring(11, 16)); // Extraer solo la hora y minutos
            $("#codigo").val(obj.clase.codigo);
            //...
        } else {
            alert("danger", obj.mensaje);
        }
    })
    .fail(error_ajax);
}