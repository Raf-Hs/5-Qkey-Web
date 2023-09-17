<?php
class BackendL extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model( "Usuarios_model" );
		$this->load->library("session"); 
       		 header("Access-Control-Allow-Origin: *");
        	header("Access-Control-Allow-Methods: GET, OPTIONS");

		$this->output->set_content_type( "application/json" );
	}
	public function index(){
		echo "<h4>Acceso no permitido</h4>";
	}

 public function cambiar_grupo_y_validar_token() {
        $token = $this->input->post("token");
        $id_grupo = $this->input->post("grupo");

        $result = $this->Usuarios_model->cambiar_grupo_y_validar_token($token, $id_grupo);

        if ($result) {
    $response = array(
        'resultado' => true,
        'mensaje' => 'Token válido para el grupo: ' . $grupo
    );
} else {
    $response = array(
        'resultado' => false,
        'mensaje' => 'Token no válido para el grupo: ' . $grupo
    );
}
        echo json_encode($response);
    }

     public function acceso() {
    $correo = $this->input->post("correo");
    $contrasenia = $this->input->post("contra");
    $row = $this->Usuarios_model->acceso_usuario($correo, $contrasenia);
    $obj["resultado"] = $row != NULL;

    if ($obj["resultado"]) {
        $obj["usuario"] = $row;
        $obj["mensaje"] = "Acceso autorizado";

        // Obtener el tipo de usuario desde el objeto $row
        $tipoUsuario = $row->tipo;

        // Establecer la sesión del tipo de usuario
        $this->session->set_userdata("tipo_usuario", $tipoUsuario);
    } else {
        $obj["mensaje"] = "Acceso no autorizado. Error en correo o contraseña";
    }

    echo json_encode($obj);
}
	public function registrausuario() {
    $nombre      = $this->input->post("nombre");
    $apellidos   = $this->input->post("apellidos");
    $correo      = $this->input->post("correo");
    $contrasenia = $this->input->post("contra");
    $direccion   = $this->input->post("direccion");
    $telefono    = $this->input->post("telefono");

    $data = array(
        "nombre"      => mb_strtoupper($nombre),
        "apellidos"   => mb_strtoupper($apellidos),
        "correo"      => $correo,
        "contrasenia" => $contrasenia,
        "direccion"   => mb_strtoupper($direccion),
        "telefono"    => mb_strtoupper($telefono)
    );

    $result = $this->Usuarios_model->insert_usuario($data);

    if ($result["resultado"]) {
        $obj = array(
            "resultado" => true,
            "mensaje"   => "Usuario registrado exitosamente",
            "id"        => $result["id"] // Incluir el ID del usuario en la respuesta
        );
    } else {
        $obj = array(
            "resultado" => false,
            "mensaje"   => "Error al registrar el usuario"
        );
    }

    echo json_encode($obj);
}	   

}
?>