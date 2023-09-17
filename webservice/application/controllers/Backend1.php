<?php

class Backend1 extends CI_Controller{

 public function __construct()
{
    parent::__construct();
    $this->load->model("alumnos_model");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, OPTIONS");
}

public function index(){
    echo "Acceso no permitido";
}

public function alumnos(){
    // invoca funcion del modelo
    $data = $this->alumnos_model->get_alumnos();

    //Construccion del objeto SOAP
    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " clases" : "No hay clases";
    $obj["alumnos"] = $data;

    echo json_encode($obj);
}
public function actualizaalumno(){

    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
       $accion = $input->accion;
       $id = $input->id;
	$id_ma = $input->id_ma;
	$id_gr = $input->id_gr;
	$materia = $input->materia;
	$laboratorio = $input->laboratorio;
	$horaE = $input->horaE;
	$horaS = $input->horaS;
	$codigo = $input->codigo;
    } else {
        $accion = $this->input->post("accion");
     $id = $this->input->post("id");
$id_ma = $this->input->post("id_ma");
$id_gr = $this->input->post("id_gr");
$materia = $this->input->post("materia");
$laboratorio = $this->input->post("laboratorio");
$horaE = $this->input->post("horaE");
$horaS = $this->input->post("horaS");
$codigo = $this->input->post("codigo");
}

    $data = array(
       "id" => $id,
    "id_ma" => $id_ma,
    "id_gr" => $id_gr,
    "materia" => $materia,
    "laboratorio" => $laboratorio,
    "horaE" => $horaE,
    "horaS" => $horaS,
    "codigo" => $codigo
    );

    if ($accion == "alta") {

        $row = $this->alumnos_model->get_alumno($id);
        if ($row != NULL) {
            $obj = array(
                "resultado" => false,
                "mensaje" => "ID duplicado"
            );
        } else {
            $obj["resultado"] = $this->alumnos_model->insert_alumno($data);;
            $obj["mensaje"] = $obj["resultado"] ? "Clase insertad@" : "Imposible insertar clase";
        }
    } else if ($accion == "cambio") {
        $obj["resultado"] = $this->alumnos_model->update_alumno($data);
        $obj["mensaje"] = $obj["resultado"] ? "Clase actualizad@" : "Imposible actualizar clase";
    }
    echo json_encode($obj);
}

public function borraalumno(){

    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }

    $obj["resultado"] = $this->alumnos_model->delete_alumno($id);
    $obj["mensaje"] = $obj["resultado"] ? "Clase eliminad@" : "Imposible eliminar clase: $id";

    echo json_encode($obj);
}

public function alumno(){
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }
    $row = $this->alumnos_model->get_alumno($id);

    $obj["resultado"] = $row != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Clases recuperadas" : "No existe clase $id";
    $obj["alumno"] = $row;
    // Visualizacion JSON del objeto
    echo json_encode($obj);
}


  
  
 
}
?>