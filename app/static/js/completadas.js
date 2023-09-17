$(document).ready(function () {
    $("#cargando").fadeOut("slow");
    const firebaseConfig = {
        apiKey: "AIzaSyBIjrkTntl3MwDrJMNW-4crHk_JMJIjNI8",
        authDomain: "test-5583c.firebaseapp.com",
        databaseURL: "https://test-5583c-default-rtdb.firebaseio.com",
        projectId: "test-5583c",
        storageBucket: "test-5583c.appspot.com",
        messagingSenderId: "279991078256",
        appId: "1:279991078256:web:321bf87e20c232a52913b5",
        measurementId: "G-FDKEEQ4DBP"
    };
    firebase.initializeApp(firebaseConfig);

    var db = firebase.firestore();
    var asistenciasCollection = db.collection("Asistencia");
    var maestrosCollection = db.collection("Maestros");

    function formatDate(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleString();
    }

    var propertiesOrder = [
        "id",
        "laboratorio",
        "materia",
        "id_ma",
        "id_gr",
        "horaE",
        "horaS",
        "horaRE",
        "horaRS",
        "codigo",
        "asistencias"
    ];

     var tableHeader = document.getElementById("tableHeader");
    propertiesOrder.forEach((prop) => {
        var th = document.createElement("th");
        th.textContent = formatHeader(prop);
        th.style.textAlign = "center"; // Centrar el encabezado
        tableHeader.appendChild(th);
    });
function formatHeader(header) {
    const headerMappings = {
        "id_ma": "Maestro",
        "id_gr": "Grupo"
    };

    if (header in headerMappings) {
        return headerMappings[header];
    } else {
        return header
            .split('_')
            .map(word => {
                if (word === "id" && header === "id_gr") {
                    return "Grupo";  // Cambia "id_gr" por "Grupo"
                } else if (word === "gr" && header === "id_gr") {
                    return "T" + word.toUpperCase() + "07"; // Grupo 1 => T207
                } else if (word === "gr" && header === "id_gr") {
                    return "T" + word.toUpperCase() + "08"; // Grupo 2 => T208
                }
                return word.charAt(0).toUpperCase() + word.slice(1);
            })
            .join(' ');
    }
}


   maestrosCollection.get().then((maestrosSnapshot) => {
    var currentDate = new Date(); // Obtiene la fecha actual

    var asistenciasPromises = [];

    maestrosSnapshot.forEach((maestroDoc) => {
        var userData = maestroDoc.data();

        // Convierte las fechas de los documentos a objetos Date para comparar
        var horaE = new Date(userData.horaE);
        var horaS = new Date(userData.horaS);

        // Comprueba si la fecha actual está entre horaE y horaS
        if (currentDate >= horaE ) {
            var asistenciasPromise = asistenciasCollection.doc(maestroDoc.id).get().then((asistenciaDoc) => {
                if (asistenciaDoc.exists) {
                    var registros = asistenciaDoc.data().registros || [];
                    userData.asistencias = registros.length;
                    userData.porcentajeAsistencias = (userData.asistencias / 30) * 100;
                } else {
                    userData.asistencias = 0;
                    userData.porcentajeAsistencias = 0;
                }
                return userData;
            });

            asistenciasPromises.push(asistenciasPromise);
        }
    });
Promise.all(asistenciasPromises).then((rows) => {
    var userDataTable = document.getElementById("userData");

    rows.forEach((userData) => {
        var row = userDataTable.insertRow();
        propertiesOrder.forEach((prop) => {
            var cell = row.insertCell();
		cell.style.textAlign = "center";
            if (prop === "asistencias") {
                cell.innerHTML = userData[prop];
            } else if (prop === "porcentajeAsistencias") {
                cell.innerHTML = userData[prop].toFixed(2) + "%";
            } else {
                cell.innerHTML = userData[prop];
            }
        });
    });

    var maestrosData = rows.map((userData) => {
        // Modificación en esta parte para generar la cadena deseada
        var horaE = new Date(userData.horaE);
        var formattedHoraE = horaE.getHours() + ":" + (horaE.getMinutes() < 10 ? '0' : '') + horaE.getMinutes();
        var xAxisLabel ="Lab "+ userData.laboratorio + " - " + userData.materia + " - " + formattedHoraE;
        return {
            id: xAxisLabel,
            y: userData.porcentajeAsistencias,
            remaining: 100 - userData.porcentajeAsistencias
        };
    });

    Highcharts.chart("barChartContainer", {
        chart: {
            type: "column"
        },
        title: {
            text: "Asistencia de Clases concluidas"
        },
        xAxis: {
            categories: maestrosData.map((data) => data.id),
            crosshair: true,
            labels: {
                formatter: function () {
                    return this.value; // Mostrar la cadena generada
                }
            }
        },
        plotOptions: {
            column: {
                stacking: "percent"
            }
        },
        series: [{
            name: "Porcentaje Faltante",
            data: maestrosData.map((data) => data.remaining),
            color: "#d13434"
        }, {
            name: "Porcentaje Asistencias",
            data: maestrosData.map((data) => data.y)
        }]
    });
}).catch((error) => {
    console.log("Error processing data: ", error);
});   }).catch((error) => {
        console.log("Error getting documents from 'Maestros': ", error);
    });
});