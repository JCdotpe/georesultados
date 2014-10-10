<?php

if (isset($contenido) and $contenido == "front/index") {
    $this->load->view('plantilla/header');
    $this->load->view($contenido);
    $this->load->view('plantilla/footer');
} else {
    $this->load->view('plantilla/header_2');
    $this->load->view($contenido);
    $this->load->view('plantilla/footer_2');
}

/* End of file plantilla.php */
/* Location: ./application/views/plantilla.php */
