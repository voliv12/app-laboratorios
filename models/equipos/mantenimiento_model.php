<?php

class Mantenimiento_model extends CI_Model
{       
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function get_tabla_mantenimiento()
    {     
        $vacio = "NULL";
        $this->db->select('periodo, fecha_inicial, fecha_mantenimiento');
        $this->db->where('fecha_mantenimiento = ', $vacio);
        $query = $this->db->get('mantenimiento_equipo');
        return $query->result_array();        
    }         
}
/*Termina archivo mantenimiento_model.php 
 * en: models/equipos/
 */
