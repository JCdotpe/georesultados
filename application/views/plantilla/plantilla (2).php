<?php

if (isset($contenido) and $contenido == "front/index") {
    $this->load->view('plantilla/header_index');
    $this->load->view($contenido);
    $this->load->view('plantilla/footer_index');
} else {
    $this->load->view('plantilla/header');
    $this->load->view($contenido);
    $this->load->view('plantilla/footer');
}

/* End of file plantilla.php */
/* Location: ./application/views/plantilla.php */
