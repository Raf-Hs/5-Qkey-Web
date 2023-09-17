$(document).ready(function () {

    $("#btn-graf-calif-todos").click(function(){
        $("#cargando").show();
        $("#modal-grafica-titulo").html("Calificaciones de TODOS los alumnos");
      
        $.ajax({
            "url"       : appData.uri_ws + "backend/grafcalif/",
            "dataType"  : "json"
              
        })
        .done(function(obj){
            if(obj.resultado){
                Highcharts.chart({
                    chart: {
                        type: 'spline',
                        renderTo: 'div-grafica',
                        scrollablePlotArea: {
                            minWidth: 600,
                            scrollPositionX: 1
                        }
                    },
                    title: {
                        text: 'Calificaciones de alumnos',
                        align: 'left'
                    },
                    xAxis: {
                        type: 'category',
                        min: 0,
                        max: 4,
                        categories:[1, 2, 3, 4, 5]
                    },
                    yAxis: {
                        min: 0,
                        max: 10,
                        title: {
                            text: 'Calificación'
                        },
                        minorGridLineWidth: 0,
                        gridLineWidth: 0,
                        alternateGridColor: null,
                        plotBands: [{ // Light air
                            from: 0.0,
                            to: 8,
                            color: 'rgba(213, 68, 79, 0.3)',
                            label: {
                                text: 'No acreditado',
                                style: {
                                    color: '#606060'
                                }
                            }
                        }, { // Light breeze
                            from: 8.0,
                            to: 8.5,
                            color: 'rgba(211, 181, 68, 0.3)',
                            label: {
                                text: 'Satisfactorio',
                                style: {
                                    color: '#606060'
                                }
                            }
                        }, { // Gentle breeze
                            from: 8.5,
                            to: 9.5,
                            color: 'rgba(14, 133, 238, 0.3)',
                            label: {
                                text: 'Destacado',
                                style: {
                                    color: '#606060'
                                }
                            }
                        }, { // Moderate breeze
                            from: 9.6,
                            to: 10,
                            color: 'rgba(90, 213, 68, 0.3)',
                            label: {
                                text: 'Autonomo',
                                style: {
                                    color: '#606060'
                                }
                            }
                        }]
                    },
                    tooltip: {
                        valueSuffix: ' m/s'
                    },
                    plotOptions: {
                        spline: {
                            lineWidth: 4,
                            states: {
                                hover: {
                                    lineWidth: 5
                                }
                            },
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    series: obj.series,
                    navigation: {
                        menuItemStyle: {
                            fontSize: '10px'
                        }
                    }
                });
            }
            else {
                alert("warning", obj.resultado);
            }
            $("#cargando").fadeOut();
        })
        .fail(error_ajax);
   
    });

    $("#btn-graf-edad").click(function(){
        $("#cargando").show();
        $("#div-grafica").html();
        $("#modal-grafica-titulo").html("Alumnos por sexo y rango de edad");

        $.ajax({
            "url"       : appData.uri_ws + "backend/grafedad/",
            "dataType"  : "json"
        })
        .done(function(obj){

        // Rangos de edad
            var categories = [
                "0-9", "10-19", "20-29", "30-39", "40-49", "50-59", "60-69", "70-79", "80-89", "90-99", "100+"
            ];

            Highcharts.chart({
                chart: {
                    type: 'bar',
                    renderTo: 'div-grafica'
                },
                title: {
                    text: 'Alumnos por rango de sexo y edad',
                    align: 'left'
                },
                subtitle: {
                    text: 'Datos de prueba: curso de AWI4',
                    align: 'left'
                },
                accessibility: {
                    point: {
                        valueDescriptionFormat: '{index}. Age {xDescription}, {value}.'
                    }
                },
                xAxis: [{
                    categories: categories,
                    reversed: false,
                    labels: {
                        step: 1
                    },
                    accessibility: {
                        description: 'Edad (Masculino)'
                    }
                }, { // mirror axis on right side
                    opposite: true,
                    reversed: false,
                    categories: categories,
                    linkedTo: 0,
                    labels: {
                        step: 1
                    },
                    accessibility: {
                        description: 'Edad (Femenino)'
                    }
                }],
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        formatter: function () {
                            return Math.abs(this.value);
                        }
                    },
                    accessibility: {
                        description: 'Alumnos',
                        rangeDescription: 'Rango: 0 a 9'
                    }
                },

                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },

                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + ', edad ' + this.point.category + '</b><br/>' +
                            'Alumnos: ' + Highcharts.numberFormat(Math.abs(this.point.y), 1);
                    }
                },

                series: obj.series
            });
            $("#cargando").fadeOut();
        })
        .fail(error_ajax)
    });    

    $("#btn-graf-periodo").click(function(){
        $("#cargando").show();
        $("#div-grafica").html("");
        $("#modal-grafica-titulo").html("Grado de evaluación por periodo");

        // AJAX
        $.ajax({
            "url"       : appData.uri_ws + "backend/grafperiodo/",
            "dataType"  : "json"
        })
        .done(function(obj){
            Highcharts.chart({
                chart: {
                    type: 'streamgraph',
                    renderTo: 'div-grafica'
                },
                colors:["#CC0A5C", "#0A77CC", "#0ACC74", "#C9CC0A"],
                title: {
                    text: 'Evaluaciones por periodo'
                },
                xAxis: {
                    categories: [1, 2, 3, 4, 5],
                    title: {
                        text: '<strong>Periodos</strong>'
                    }
                },
                yAxis: {
                    visible: false,
                    title: {
                        text: '<strong>Alumnos evaluados</strong>'
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    }
                },
                series: obj.series
            });
            $("#cargando").fadeOut();
        })
        .fail(error_ajax)

    });
});

function click_grafica(matricula, nomalumno){
    $("#cargando").show();
    $("#div-grafica").html("");
    $("#modal-grafica-titulo").html("Caliicaciones de " + nomalumno);

    // AJAX
    $.ajax({
        "url"       : appData.uri_ws + "backend/grafcalifalumno/",
        "dataType"  : "json",
        "type"      : "post",
        "data"      : {
            "matricula" : matricula
        }
          
    })
    .done(function(obj){
        if(obj.resultado){
            Highcharts.chart({
                chart: {
                    type: 'spline',
                    renderTo: 'div-grafica',
                    scrollablePlotArea: {
                        minWidth: 600,
                        scrollPositionX: 1
                    }
                },
                title: {
                    text: 'Calificaciones de ' + nomalumno,
                    align: 'left'
                },
                xAxis: {
                    type: 'category',
                    min: 0,
                    max: 4,
                    categories:[1, 2, 3, 4, 5]
                },
                yAxis: {
                    min: 0,
                    max: 10,
                    title: {
                        text: 'Calificación'
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [{ // Light air
                        from: 0.0,
                        to: 8,
                        color: 'rgba(213, 68, 79, 0.3)',
                        label: {
                            text: 'No acreditado',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Light breeze
                        from: 8.0,
                        to: 8.5,
                        color: 'rgba(211, 181, 68, 0.3)',
                        label: {
                            text: 'Satisfactorio',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Gentle breeze
                        from: 8.5,
                        to: 9.5,
                        color: 'rgba(14, 133, 238, 0.3)',
                        label: {
                            text: 'Destacado',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Moderate breeze
                        from: 9.6,
                        to: 10,
                        color: 'rgba(90, 213, 68, 0.3)',
                        label: {
                            text: 'Autonomo',
                            style: {
                                color: '#606060'
                            }
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: ' m/s'
                },
                plotOptions: {
                    spline: {
                        lineWidth: 4,
                        states: {
                            hover: {
                                lineWidth: 5
                            }
                        },
                        marker: {
                            enabled: false
                        }
                    }
                },
                series: obj.series,
                navigation: {
                    menuItemStyle: {
                        fontSize: '10px'
                    }
                }
            });
        }
        else {
            alert("warning", obj.resultado);
        }
        $("#cargando").fadeOut();
    })
    .fail(error_ajax);

   

}