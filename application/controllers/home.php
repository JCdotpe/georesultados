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
        echo json_encode($locales);
    }
    public function getSearchIE() {
        $_REQUEST['searchColegio'] = trim($_GET['searchColegio']);
        $_REQUEST['searchCodigo'] = $_GET['searchCodigo'];
        $_REQUEST['depa'] = $_GET['depa'];
        $_REQUEST['prov'] = $_GET['prov'];
        $_REQUEST['dist'] = $_GET['dist'];
        $datos['datos_Resumen'] = $this->modeloResumen->getIESearch($_REQUEST);
        $this->load->view("front/recargarDatos", $datos);
    }
    
    public function listImagen() {
        $datos['titulo'] = "Lista de imagenes";
        $datos['contenido'] = "front/listimagen";
        $this->load->view('plantilla/plantilla', $datos);
    }
    
    public function list2() {
        $datos['titulo'] = "Lista de imagenes";
        $datos['contenido'] = "front/list2";
        //$datos['ruta'] = "C:/CarlosLevano/01/";
        $this->load->view('plantilla/plantilla', $datos);
    }
    

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */