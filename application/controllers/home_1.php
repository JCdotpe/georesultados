<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('modellocalresumen', 'modeloResumen');
    }

    public function index() {
        $datos['titulo'] = "Resultados Georeferenciados";
        $datos['contenido'] = "front/index";
        $this->load->view('plantilla/plantilla', $datos);
    }

    public function getBubble() {
        $idCodigo = $_GET['idCodigo'];
        $locales = $this->modeloResumen->getDatosLocales($idCodigo);
        echo json_encode($locales);
    }

    public function general() {
//        $datos['titulo'] = "Caracteristicas generales del local escolar";
//        $datos['contenido'] = "datos/general";
//        $this->load->view('plantilla/plantilla', $datos);
        $this->load->view('datos/general');
    }

    public function infraestructura() {
//        $datos['titulo']= "Infraestructura del local escolar";
//        $datos['contenido'] = "datos/infraestructura";
//        $this->load->view('plantilla/plantilla',$datos);
//        $datos['contenido'] = "datos/infraestructura";
        $this->load->view('datos/infraestructura');
    }

    public function tabs() {
        $datos['titulo'] = "Tabs de navegación";
        $datos['contenido'] = "datos/tabs";
        $this->load->view('plantilla/plantilla', $datos);
//        $this->load->view('datos/tabs');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */