<?php
class Usuarios1 extends CI_Controller{

    public function index(){

  if (!$this->session->has_userdata("tipo_usuario") || $this->session->userdata("tipo_usuario") != 1) {
            // Redireccionar al login si no hay tipo de usuario en sesi�n o no es de tipo 3
            redirect('login');
        }


        $this->load->view("header_page_view", array(
            "titulo"  => "Gestion Alumnos / WS",
            "css"     => array("cargando"),
            "js"      => array(
                "../highcharts/highcharts",
                "../highcharts/modules/streamgraph",
                "../highcharts/modules/annotations",
                "../highcharts/modules/series-label",
                "../highcharts/modules/exporting",
                "../highcharts/modules/export-data",
                "../highcharts/modules/accesibility",
                "usuarios1", 
                "mensajes",
                "hightcharts-lang-es",
                 "graficas"
                 )
        ));
        $this->load->view("usuarios1_view");
        $this->load->view("footer_page_view");

    }


}
?>