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
        // Función para formatear la fecha
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
        th.textContent = prop;
        tableHeader.appendChild(th);
    });
   var asistenciasPromises = [];
    var today = new Date();
    var formattedToday = today.toISOString().split('T')[0];

    maestrosCollection.where("horaE", ">=", formattedToday + " 00:00:00")
                     .where("horaE", "<=", formattedToday + " 23:59:59")
                     .get()
                     .then((maestrosSnapshot) => {
        maestrosSnapshot.forEach((maestroDoc) => {
            var userData = maestroDoc.data();
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
        });Promise.all(asistenciasPromises).then((rows) => {
    var userDataTable = document.getElementById("userData");

    rows.forEach((userData) => {
        var row = userDataTable.insertRow();
        propertiesOrder.forEach((prop) => {
            var cell = row.insertCell();
            if (prop === "asistencias") {
                cell.innerHTML = userData[prop];
            } else if (prop === "porcentajeAsistencias") {
                cell.innerHTML = userData[prop].toFixed(2) + "%";
            } else if (prop.includes("hora")) {
                cell.innerHTML = formatDate(userData[prop]);
            } else {
                cell.innerHTML = userData[prop];
            }
        });
    });

    var maestrosData = rows.map((userData) => {
    return {
        id: userData.id, // Cambia "nombre" por "id"
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
        categories: maestrosData.map((data) => data.name),
        crosshair: true
    },
    xAxis: {
    categories: maestrosData.map((data) => data.id), // Usa el arreglo de IDs
    crosshair: true,
    labels: {
        formatter: function () {
            return "Clase " + this.value; // Personaliza el formato de las etiquetas
        }
    }
},    plotOptions: {
        column: {
            stacking: "percent"
        }
    },
    series: [{
        name: "Porcentaje Faltante", // Cambiamos el orden de las series
        data: maestrosData.map((data) => data.remaining),
        color: "#d13434" // Cambiar a un tono más suave de rojo
    }, {
        name: "Porcentaje Asistencias", // Cambiamos el orden de las series
        data: maestrosData.map((data) => data.y)
    }]
});
}).catch((error) => {
    console.log("Error processing data: ", error);
});    }).catch((error) => {
        console.log("Error getting documents from 'Maestros': ", error);
    });
});