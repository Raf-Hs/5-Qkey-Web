<?php
class Alta extends CI_Controller{

    public function index(){
 if (!$this->session->has_userdata("tipo_usuario") || $this->session->userdata("tipo_usuario") != 1) {
            // Redireccionar al login si no hay tipo de usuario en sesión o no es de tipo 3
            redirect('login');
        }

        $this->load->view("header_page_view", array(
            "titulo"  => "Alta / WS",
            "css"     => array("cargando"),
            "js"      => array(
                "../highcharts/highcharts",
                "../highcharts/modules/streamgraph",
                "../highcharts/modules/annotations",
                "../highcharts/modules/series-label",
                "../highcharts/modules/exporting",
                "../highcharts/modules/export-data",
                "../highcharts/modules/accesibility",
                "alta", 
                "mensajes",
                "hightcharts-lang-es",
                 "graficas"
                 )
        ));
        $this->load->view("alta_view");
        $this->load->view("footer_page_view");

    }


}
?>