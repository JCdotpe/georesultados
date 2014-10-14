<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModelLocalResumen extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDatosLocales($idCodigo) {
        $this->db->where('pc_c_2_Rfinal_resul','1');
        $this->db->where('codigo_de_local', $idCodigo);
        $sql = $this->db->get('Local_Resumen');
        return $this->convert_utf8->convert_result($sql);
        //return $sql->result();
    }

    public function getIESearch($params) {


        if (isset($params['searchColegio']) and $params['searchColegio'] != "") {
            $likeColegio = " AND nombres_IIEE like '%" . $params['searchColegio'] . "%' ";
        } else {
            $likeColegio = " ";
        }

        if (isset($params['searchCodigo']) and $params['searchCodigo'] != "") {
            $filterCodigo = " AND codigo_de_local = '" . $params['searchCodigo'] . "' ";
        } else {
            $filterCodigo = " ";
        }

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
                                    1=1 AND pc_c_2_Rfinal_resul ='1' " . $likeColegio . $filterCodigo . $filterDepa . $filterProv . $filterDist);
        return $this->convert_utf8->convert_result($sql);

        //return $sql;
        //return $sql->result();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */