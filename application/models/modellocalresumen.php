<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModelLocalResumen extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDatosLocales($idCodigo) {
        $this->db->where('codigo_de_local', $idCodigo);
        $sql = $this->db->get('Local_Resumen');
        return $sql->result();
    }

    public function getIESearch($params) {
        if(isset($params['searchColegio']) and $params['searchColegio'] !=""){
            $likeColegio = " AND nombres_IIEE like '%" . $params['searchColegio'] . "%'";
        }else{
            $likeColegio = " ";
        }
        $sql = $this->db->query("SELECT 
                                * 
                                FROM 
                                    Local_Resumen 
                                WHERE 
                                    1=1 ".$likeColegio);
        return $sql->result();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */