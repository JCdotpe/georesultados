<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('modellocalresumen', 'modeloResumen');
    }

    public function index() {
        $datos['titulo'] = "Censo de Infraestructura Educativa 2013";
        $datos['contenido'] = "front/index";
        $this->load->view('plantilla/plantilla', $datos);
    }

    public function getBubble() {
        
        $idCodigo = $_GET['idCodigo'];
        $locales = $this->modeloResumen->getDatosLocales($idCodigo);
        
        //$convertido = $this->convert_utf8->convert_result($this->modeloResumen->getDatosLocales($idCodigo));
        echo json_encode($locales);
    }

//    public function getSearchIE() {
//        $datos['searchwordPost'] = $this->input->post('searchword');
//        $datos['result_IE'] = $this->modeloResumen->getIESearch($datos['searchwordPost']);
//        $this->load->view('front/dataSearch', $datos);
//    }
    
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
    public function getSearchIE() {
        $datos['datosEnviar'] = $_REQUEST;
        $this->load->view("front/recargarDatos",$datos);
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */