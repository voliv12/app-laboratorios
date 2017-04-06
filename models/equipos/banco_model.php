<?php

class Banco_model extends CI_Model
{
    var $ni = NULL;
    
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function get_tabla_banco()
    {     
        $this->db->from('banco');
        $this->db->order_by("fecha", "desc");
        $query = $this->db->get(); 
        return $query->result_array();
    }   

    function agregar_banco($data_insert)
     {        
         $this->db->insert('banco', $data_insert);    
     }
     
     function eliminar_banco($id)
     {
         $this->db->where('id', $id);
         $this->db->delete('banco'); 
     }
     
     function actualizar_banco($data_update)
     {
        $data = array(
                        $data_update['column'] => $data_update['value']
                     );
        
        $this->db->where('id', $data_update['id']);
        $this->db->update('banco', $data); 
     }
     
     function get_niveles($fecha)
     {
       
        $sql = "SELECT fecha, nivel_inicial, nivel_final FROM banco WHERE fecha BETWEEN '".$fecha['de']."' AND '".$fecha['hasta']."' ORDER BY fecha ASC";        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            $fe="";
            $ni="";
            $nf="";
            foreach ($query->result() as $row)
            {
                $fe .= "'".$row->fecha."', ";                
                $ni .= $row->nivel_inicial.", ";
                if ($row->nivel_final != 0){
                    $nf .= $row->nivel_final.", ";
                }else{
                    $nf .= "null, ";
                }
            }                               
            $niveles = array(
                             'fecha'    => $fe,
                             'ni'       => $ni,
                             'nf'       => $nf
                            );
               
            return $niveles;
        }             
     } 
}
/*Termina archivo banco_model.php 
 * en: models/equipos/
 */
