<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Inventario_model extends CI_Model
{
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function consulta_stock($noPersonal)
    {
        $sql = "SELECT `nombre`,`total_stock`,`minimo_stock` FROM `material` WHERE `total_stock`<=`minimo_stock` AND `responsable`=".$noPersonal;
        $query = $this->db->query($sql);
        /*$this->db->select('nombre, total_stock, minimo_stock');
        $this->db->from('material');
        //$this->db->join('usuario','material.responsable = usuario.noPersonal');
        $this->db->where('total_stock','minimo_stock');
        $this->db->where('responsable', $noPersonal);
        $query = $this->db->get();*/

        //return $query->result_array();
        return $query->result_array();
    }

}

