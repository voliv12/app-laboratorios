<?php

class Destilador_model extends CI_Model
{       
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }

    function get_tabla_destilador()
    {     
        $this->db->from('destilador');
        $this->db->order_by("fecha", "desc");
        $query = $this->db->get(); 
        return $query->result_array();
    }   

    function agregar_destilador($data_insert)
     {        
         $this->db->insert('destilador', $data_insert);    
     }
     
     function eliminar_destilador($id)
     {
         $this->db->where('id', $id);
         $this->db->delete('destilador'); 
     }
     
     function actualizar_destilador($data_update)
     {
        $data = array(
                        $data_update['column'] => $data_update['value']
                     );
        
        $this->db->where('id', $data_update['id']);
        $this->db->update('destilador', $data); 
     }
     
     function get_litros_hr($graficar)
     {
        if($graficar['agua'] == "destilada"){
            $litros = "litros_hora";
        }else{
            $litros = "enfri_por_hor";
        }
        
        $sql = "SELECT fecha, ".$litros." FROM destilador WHERE fecha BETWEEN '".$graficar['de']."' AND '".$graficar['hasta']."' ORDER BY fecha ASC";        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            $fe="";
            $lt="";
            foreach ($query->result() as $row)
            {
                $fe .= "'".$row->fecha."', ";                
                $lt .= $row->$litros.", ";
                /*if ($row->nivel_final != 0){
                    $nf .= $row->nivel_final.", ";
                }else{
                    $nf .= "null, ";
                }*/
            }                               
            $lts_hr = array(
                             'fecha'    => $fe,
                             'ni'       => $lt                             
                            );
               
            return $lts_hr;
        }             
     } 
}
/*Termina archivo destilador_model.php 
 * en: models/equipos/
 */
