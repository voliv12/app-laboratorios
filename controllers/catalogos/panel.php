<?php

Class Panel extends CI_controller{
    
    function index()
    {
        if ($this->session->userdata('logged_in') == TRUE)
        {
        $datos_plantilla['titulo'] = "Actualización de Catálogos"; 
        $datos_plantilla['contenido'] = $this->load->view('catalogos/principal', array(), true);
        $this->load->view('plantilla_view', $datos_plantilla); 
        }else
        {
            redirect('login');
        }
    }
    
}

?>
