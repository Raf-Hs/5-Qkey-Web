<?php
class Galumnos extends CI_Controller{

    public function index(){
        $this->load->view("header_page_view", array(
            "titulo"  => "Gestionar Alumnos",
            "css"     => array("cargando"),
            "js"      => array(
                "../highcharts/highcharts",
                "../highcharts/modules/streamgraph",
                "../highcharts/modules/annotations",
                "../highcharts/modules/series-label",
                "../highcharts/modules/exporting",
                "../highcharts/modules/export-data",
                "../highcharts/modules/accesibility",
                "galumnos", 
                "mensajes",
                "hightcharts-lang-es",
                 "graficas"
                 )
        ));
        $this->load->view("galumnos_view");
        $this->load->view("footer_page_view");

    }


}
?>