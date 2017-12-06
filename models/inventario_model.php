<?php
//require_once APPPATH.'models/Generic_Dataset_Model.php';

class Inventario_model extends CI_Model
{
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function consulta_stock($noPersonal, $tabla)
    {
        $sql = "SELECT `nombre`,`total_stock`,`minimo_stock` FROM `".$tabla."` WHERE `total_stock`<=`minimo_stock` AND `responsable`=".$noPersonal;
        $query = $this->db->query($sql);

        return $query->result_array();
    }

}

