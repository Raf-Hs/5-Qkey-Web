<?php
class Inicio extends CI_Controller{

    public function index(){
        $this->load->view("header_page_view", array(
            "titulo"  => " Clases Publicas",
            "css"     => array("cargando"),
            "js"      => array(
                "../highcharts/highcharts",
                "../highcharts/modules/streamgraph",
                "../highcharts/modules/annotations",
                "../highcharts/modules/series-label",
                "../highcharts/modules/exporting",
                "../highcharts/modules/export-data",
                "../highcharts/modules/accesibility",
                "inicio", 
                "mensajes",
                "hightcharts-lang-es",
                 "graficas"
                 )
        ));
        $this->load->view("inicio_view");
        $this->load->view("footer_page_view");

    }


}
?>