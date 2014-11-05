<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModelLocalResumen extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDatosLocales($idCodigo) {
        $this->db->where('pc_c_2_Rfinal_resul', '1');
        $this->db->where('codigo_de_local', $idCodigo);
        $sql = $this->db->get('Local_Resumen');
        return $this->convert_utf8->convert_result($sql);
    }

    public function getListSchoolPhotos($idCodigo) {
        $sql = " SELECT * FROM P9_F_Resumen WHERE id_local = '" . $idCodigo . "'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getIESearch($params) {


        if ((isset($params['searchColegio']) and $params['searchColegio'] != "") and (isset($params['searchCodigo']) and $params['searchCodigo'] != "")) {
            $likeColegio = " AND codigo_de_local = '" . $params['searchCodigo'] . "'";
        } else if (isset($params['searchColegio']) and $params['searchColegio'] != "" and $params['searchCodigo'] == "") {
            $likeColegio = " AND nombres_IIEE like '%" . $params['searchColegio'] . "%' ";
        } else if (isset($params['searchCodigo']) and $params['searchCodigo'] != "" and $params['searchColegio'] == "") {
            $likeColegio = " AND codigo_de_local = '" . $params['searchCodigo'] . "' ";
        } else {
            $likeColegio = " ";
        }

//        if (isset($params['searchCodigo']) and $params['searchCodigo'] != "") {
//            $filterCodigo = " AND codigo_de_local = '" . $params['searchCodigo'] . "' ";
//        } else {
//            $filterCodigo = " ";
//        }

        if (isset($params['depa']) and $params['depa'] != "") {
            $filterDepa = " AND cod_dpto ='" . $params['depa'] . "' ";
        } else {
            $filterDepa = " ";
        }

        if (isset($params['prov']) and $params['prov'] != "") {
            $filterProv = " AND cod_prov ='" . $params['prov'] . "' ";
        } else {
            $filterProv = " ";
        }

        if (isset($params['dist']) and $params['dist'] != "") {
            $filterDist = " AND cod_dist ='" . $params['dist'] . "' ";
        } else {
            $filterDist = " ";
        }

        $sql = $this->db->query("SELECT 
                                * 
                                FROM 
                                    Local_Resumen 
                                WHERE 
                                    1=1 AND pc_c_2_Rfinal_resul ='1' " . $likeColegio . $filterDepa . $filterProv . $filterDist);
        return $this->convert_utf8->convert_result($sql);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */