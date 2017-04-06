<?php

Class Panel_control extends CI_controller{
    
    function index()
    {
        if ($this->session->userdata('logged_in') == TRUE)
        {
        $datos_plantilla['titulo'] = "Panel de Control"; 
        $datos_plantilla['contenido'] = $this->load->view('panel', array(), true);
        $this->load->view('plantilla_view', $datos_plantilla);
        }else
        {
            redirect('login');
        }
    }
    
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
