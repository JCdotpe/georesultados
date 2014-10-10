<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModelLocalResumen extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDatosLocales($idCodigo) {
        $this->db->where('id_local', $idCodigo);
        $sql = $this->db->get('LOCAL_RESUMEN');
        return $sql->result();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */