$(document).ready(function () {
    $("#cargando").fadeOut("slow");
    cargaalumnos();

    $("#btn-confirmar-baja").click( function(){
        $("#cargando").show();

        $.ajax({
            "url"      : appData.uri_ws + "backend1/borraalumno/",
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

    $("#btn-agregar").click(function(){
        borra_mensajes();
        appData.accion = "alta";
        appData.id = "";
        $("#modal-editar-accion").html("Agregar");

        $("#id")
            .val("")
            .prop("disabled", false);
$("#id_ma").val("");
$("#id_gr").val("");
$("#materia").val("");
$("#laboratorio").val("");
$("#horaE").val("");
$("#horaS").val("");
$("#codigo").val("");
  
}); // FIN del $("#btn-agregar").click()

    $("#form-clase").submit(function(e){
        e.preventDefault();
        borra_mensajes();
    
        //Cerrar manualmente una modal
        $("#modal-editar").modal("hide");

        $("#cargando").show();


        $.ajax({
            "url"       : appData.uri_ws + "backend1/actualizaalumno",
            "dataType"  : "json",
            "type"      : "post",
           "data": {
  "accion": appData.accion,
"id": $("#id").val(),
  "id_ma": $("#id_ma").val(),
  "id_gr": $("#id_gr").val(),
  "materia": $("#materia").val(),
  "laboratorio": $("#laboratorio").val(),
  "horaE": $("#horaE").val(),
  "horaS": $("#horaS").val(),
  "codigo": $("#codigo").val()
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
    }); // FIN del $("#form-clase").submit()

    $(".form-control, .form-select").click(borra_mensajes);  //  $(".form-control, .form-select").click()
}); // Fin del $.ready()

// FUNCIONES EXTERNAS

function cargaalumnos() {
  $("#tabla-clase")
    .find("thead")
    .hide();

  $.ajax({
    url: appData.uri_ws + "backend1/alumnos/",
    dataType: "json",
  })
    .done(function (obj) {
      if (obj && obj.resultado && Array.isArray(obj.alumnos)) {
        $("#tabla-clase")
          .find("thead")
          .show();

        $("#tabla-clase")
          .find("tbody")
          .html("");

        var clasesPorDia = {}; // Objeto para contar clases por día
        var laboratoriosPorDia = {}; // Objeto para contar laboratorios por día

        $.each(obj.alumnos, function (i, a) {
          // Asegurarse de que las propiedades necesarias estén presentes en el objeto
          if (
            a.hasOwnProperty("horaE") &&
            a.hasOwnProperty("horaS") &&
            a.hasOwnProperty("laboratorio")
          ) {
            var fechaInicio = new Date(a.horaE);
            var fechaFin = new Date(a.horaS);

            // Utilizar la fecha de inicio como clave para contar las clases por día
            var diaClase = fechaInicio.toDateString();

            // Incrementar contador de clases para ese día
            if (clasesPorDia[diaClase]) {
              clasesPorDia[diaClase]++;
            } else {
              clasesPorDia[diaClase] = 1;
            }

            // Incrementar contador de laboratorios para ese día
            if (laboratoriosPorDia[diaClase]) {
              if (laboratoriosPorDia[diaClase][a.laboratorio]) {
                laboratoriosPorDia[diaClase][a.laboratorio]++;
              } else {
                laboratoriosPorDia[diaClase][a.laboratorio] = 1;
              }
            } else {
              laboratoriosPorDia[diaClase] = { [a.laboratorio]: 1 };
            }

            // Generar la fila de la tabla con los datos de la clase
            $("#tabla-clase")
              .find("tbody")
              .append(
                '<tr id="tr-' +
                  a.id +
                  '">' +
                  '<td class="text-center">' +
                  a.id +
                  "</td>" +
                  '<td>' +
                  a.nombreMaestro +
                  "</td>" +
                  '<td>' +
                  a.nombreGrupo +
                  "</td>" +
                  '<td class="text-center">' +
                  a.materia +
                  "</td>" +
                  '<td>' +
                  a.laboratorio +
                  "</td>" +
                  '<td>' +
                  a.horaE +
                  "</td>" +
                  '<td>' +
                  a.horaS +
                  "</td>" +
                
                 "</tr>"
              );
          }
        });
var fechasOrdenadas = Object.keys(clasesPorDia).sort(function(a, b) {
  return new Date(a) - new Date(b);
});
      var datosGrafico = fechasOrdenadas.map(function(dia) {
  return {
    name: dia,
    y: clasesPorDia[dia],
  };
});
        // Aquí comienza la modificación para cargar la gráfica dinámica
  var chartOptions = {
  chart: {
    type: "column",
  },
  title: {
    text: "Cantidad de Clases por Día",
  },
  xAxis: {
    type: "category",
    title: {
      text: "Fecha",
    },
    labels: {
      formatter: function () {
        return Highcharts.dateFormat('%e %b', new Date(this.value));
      },
    },
    dateTimeLabelFormats: {
      day: {
        // Personaliza el formato para días
        main: '%e %b', // Formato principal (día y mes)
        range: false, // No mostrar rango en el eje x
      },
    },
  },
  yAxis: {
    title: {
      text: "Cantidad de Clases",
    },
  },
  series: [
    {
      name: "Clases",
      data: datosGrafico,
      dataLabels: {
        enabled: true,
        rotation: -90,
        color: "#FFFFFF",
        align: "right",
        format: "{point.y}",
        y: 10,
        style: {
          fontSize: "13px",
          fontFamily: "Verdana, sans-serif",
        },
      },
    },
  ],
};        if (Highcharts.charts[0]) {
          // Si la gráfica ya existe, solo actualiza los datos
          Highcharts.charts[0].series[0].setData(datosGrafico);
        } else {
          // Si la gráfica no existe, crea una nueva
          Highcharts.chart("grafica1", chartOptions);
        }
        // Fin de la modificación de la gráfica dinámica

        if ($("#mensaje").find(".alert").length === 0) {
          alert("info", obj.mensaje);
        }
      } else {
        alert("warning", "No se recibieron datos válidos");
      }
    })
    .fail(function (xhr, textStatus, error) {
      console.log(xhr, textStatus, error);
      alert("danger", "Error en la solicitud AJAX");
    });
}

function click_editar(id) {
  borra_mensajes();
  appData.accion = "cambio";
  appData.id = id;
  $("#modal-editar-accion").html("Editar");

  $("#cargando").show();

  $.ajax({
    url: appData.uri_ws + "backend1/alumno",
    dataType: "json",
    type: "post",
    data: {
      id: id
    }
  })
    .done(function (obj) {
      $("#cargando").hide();
    if (obj.resultado) {
  if (obj.hasOwnProperty("alumno") && typeof obj.alumno === "object") {
    $("#id")
      .val(obj.alumno.id)
      .prop("disabled", true);
    $("#id_ma").val(obj.alumno.id_ma);
    $("#id_gr").val(obj.alumno.id_gr);
    $("#materia").val(obj.alumno.materia);
    $("#laboratorio").val(obj.alumno.laboratorio);
    $("#horaE").val(obj.alumno.horaE);
    $("#horaS").val(obj.alumno.horaS);
    $("#codigo").val(obj.alumno.codigo);
  } else {
    alert("danger", "Datos de alumno no encontrados o inválidos en la respuesta.");
  }
} else {
  alert("danger", obj.mensaje);
}
    })
    .fail(error_ajax);
}