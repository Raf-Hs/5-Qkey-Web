<?php
class Login extends CI_Controller {

    public function index() {
        $this->load->view("header_page_view", array(
            "titulo" => "Login",
            "css" => array("cargando"),
            "js" => array(
                "login.min",
                "mensajes",
                "graficas"
            )
        ));
        $this->load->view("login_view");
        $this->load->view("footer_page_view");
    }

  public function logout() {
        // Destruir todas las variables de sesi�n
        $this->session->sess_destroy();

        // Redireccionar a la p�gina de inicio de sesi�n
        redirect('login');
    }


  }
?>
