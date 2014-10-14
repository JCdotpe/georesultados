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


    public function getSearchIE() {
        $_REQUEST['searchColegio'] = $_GET['searchColegio'];
        $_REQUEST['searchCodigo'] = $_GET['searchCodigo'];
        $_REQUEST['depa'] = $_GET['depa'];
        $_REQUEST['prov'] = $_GET['prov'];
        $_REQUEST['dist'] = $_GET['dist'];
        
        $datos['datos_Resumen'] = $this->modeloResumen->getIESearch($_REQUEST);

        //print_r($datos['datos_Resumen']);exit;
        $this->load->view("front/recargarDatos", $datos);
//        $datos['contenido'] = "front/recargarDatos";
//        $this->load->view('plantilla/plantilla', $datos);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */