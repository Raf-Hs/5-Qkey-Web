<?php

class Backend3 extends CI_Controller{

 public function __construct()
{
    parent::__construct();
    $this->load->model("alumnos3_model");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, OPTIONS");
}

public function index(){
    echo "Acceso no permitido";
}

public function alumnos(){
    // invoca funcion del modelo
    $data = $this->alumnos3_model->get_alumnos();

    //Construccion del objeto SOAP
    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " maestr@s" : "No hay maestr@s";
    $obj["alumnos"] = $data;

    echo json_encode($obj);
}

public function actualizaalumno(){

       if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }

    $obj["resultado"] = $this->alumnos3_model->update_alumno($id);
    $obj["mensaje"] = $obj["resultado"] ? "Maestro activ@" : "Imposible eliminar maestr@: $id";

    echo json_encode($obj);
}

public function borraalumno(){

    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }

    $obj["resultado"] = $this->alumnos3_model->delete_alumno($id);
    $obj["mensaje"] = $obj["resultado"] ? "Maestr@ eliminad@" : "Imposible eliminar maestr@: $id";

    echo json_encode($obj);
}

public function alumno(){
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }
    $row = $this->alumnos3_model->get_alumno($id);

    $obj["resultado"] = $row != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Maestr@ recuperad@" : "No existe maestr@ $id";
    $obj["alumno"] = $row;
    // Visualizacion JSON del objeto
    echo json_encode($obj);
}


  
  
 
}
?>