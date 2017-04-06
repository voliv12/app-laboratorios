<?php
Class Mantenimiento extends CI_controller{
        
        function __construct()
        {
            parent::__construct();

            /* Standard Libraries */
            $this->load->database();
            $this->load->helper('url');
            /* ------------------ */    

            $this->load->library('grocery_CRUD');    
        }                     
    
        function _example_output($output = null)
        {            
            $datos_plantilla['titulo'] = "Mantenimiento de equipos"; 
            $datos_plantilla['contenido'] = $this->load->view('equipos/mantenimiento_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
               
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();

                //$crud->where('tipo_utensilio','Material');

                $crud->set_table('mantenimiento_equipo');                               
                $crud->set_subject('mantenimiento');
                $crud->fields('equipo', 'periodo', 'fecha_mantenimiento', 'observaciones');
                $crud->display_as('periodo', 'Periodo cada');
                $crud->required_fields('equipo','periodo','fecha_mantenimiento');                       
                $crud->set_relation('equipo','equipo','descripcion');
                
                $crud->callback_column('periodo',array($this,'mes')); 
                $crud->callback_add_field('periodo',array($this,'field_periodo'));
                $crud->callback_insert(array($this,'suma_meses'));

                $output = $crud->render();

                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }
        
    function field_periodo()
    {
        return '<select name="periodo" style="width:60px">
                  <option>1</option>
                  <option>3</option>
                  <option>6</option>
                  <option>12</option>
                </select> Mes(es).';
    }
    
    function mes($value, $row)
    {
        return $value.' mes(es)';
    }
    
    function suma_meses($post_array)
    {                       
        //Invierto la fecha               
        $fecha = implode("/", array_reverse( preg_split("/\D/", $post_array['fecha_mantenimiento']) ) );       
          
        $meses = $post_array['periodo'];
        
        $post_array['fecha_mantenimiento'] = $fecha;
        $post_array['proximo_mantenimiento'] = date("Y/m/d", strtotime("$fecha +$meses month"));
        
        return $this->db->insert('mantenimiento_equipo',$post_array);
    }   
        
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
