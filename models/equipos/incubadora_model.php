<?php

class Incubadora_model extends CI_Model
{       
    function __construct()
    {
        parent :: __construct();
        $this->load->database();
    }
    
     function get_temperaturas($fecha)
     {
       
        $sql = "SELECT fecha, temp_exterior, temp_interior FROM incubadora WHERE fecha BETWEEN '".$fecha['de']."' AND '".$fecha['hasta']."' ORDER BY fecha ASC";        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 0)
        {
            return FALSE;
        }else
        {
            $fe="";
            $te="";
            $ti="";
            foreach ($query->result() as $row)
            {
                $fe .= "'".$row->fecha."', ";                
                $te .= $row->temp_exterior.", ";
                if ($row->temp_interior != 0){
                    $ti .= $row->temp_interior.", ";
                }else{
                    $ti .= "null, ";
                }
            }                               
            $temps = array(
                             'fecha'    => $fe,
                             'te'       => $te,
                             'ti'       => $ti
                            );
               
            return $temps;
        }             
     } 
}
/*Termina archivo banco_model.php 
 * en: models/equipos/
 */
