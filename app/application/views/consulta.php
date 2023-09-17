<?php
$servername = "dtai.uteq.edu.mx";
$username = "rafher207";
$password = "2022171029";
$dbname = "bd_awos_rafher207";

$conn = new mysqli($servername, $username, $password, $dbname);

$data = "SELECT c.laboratorio, SUM(a.total_alumnos) AS total_alumnos, COUNT(DISTINCT a.id) AS cantidad_grupos,
SUM(a.total_alumnos) / COUNT(DISTINCT a.id) AS promedio_alumnos_por_grupo
FROM (
SELECT laboratorio, id_ma AS id, COUNT(*) AS total_alumnos
FROM clase
GROUP BY laboratorio, id_ma
) AS a
JOIN clase AS c ON a.id = c.id_ma
GROUP BY c.laboratorio";
$result = $conn->query($data);



if ($result->num_rows > 0) {
    $combinedData = array();

    while ($row = $result->fetch_assoc()) {
        $data = array_map('intval', explode(',', $row['promedio_alumnos_por_grupo']));
        $combinedData = array_merge($combinedData, $data);
    }

    $combinedSeries = array(
            'name' => 'Media alumnos',
            'data' => $combinedData,
        
        );

    return json_encode($combinedSeries);
} else {
    echo "0 results";
}

$conn->close()
?>