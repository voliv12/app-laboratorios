<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Usuarios_model extends CI_Model
{

    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function buscar_en_BD($noPersonal, $clave)
    {
        $this->db->select('*');
        $this->db->where('noPersonal', $noPersonal);
        $this->db->where('password', $clave);
        $query = $this->db->get('usuario');

        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            return $query->row();
        }
     }
}
