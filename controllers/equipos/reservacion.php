<?php
Class Reservacion extends CI_controller{
        
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
            $datos_plantilla['titulo'] = "Reservación de equipos"; 
            $datos_plantilla['contenido'] = $this->load->view('equipos/reservacion_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
               
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();

                //$crud->where('tipo_utensilio','Material');

                $crud->set_table('reservacion');                               
                $crud->set_subject('Reservación');
                $crud->required_fields('fecha','usuario','equipo','hora_inicio','hora_termino');
                //$crud->set_rules('costo','Costo','numeric');            

                $crud->set_relation('equipo','equipo','descripcion');                
                $crud->set_relation('usuario','usuario','nombre');                
                
                $crud->callback_add_field('hora_inicio',array($this,'hora_i'));
                $crud->callback_add_field('hora_termino',array($this,'hora_t'));              
                $crud->callback_before_insert(array($this,'validar_horario'));
                
                $output = $crud->render();

                $this->_example_output($output);
                
               
                
            }else
            {
                redirect('login');
            }        
        }
        
        function hora_i()
        {                       
            return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="hora_inicio" style="width:50px"> (hh:mm) 0-23 hrs.';  
        }
        
        function hora_t()
        {                       
            return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="hora_termino" style="width:50px"> (hh:mm) 0-23 hrs.';  
        }
        
        function validar_horario($post_array)
        {                        
            if(!strtotime($post_array['hora_inicio'])){
                return FALSE;               
            }
            
            if(strtotime($post_array['hora_inicio']) >= strtotime( $post_array['hora_termino'])){
                return FALSE;
            }
            
            $fecha_invertida = implode("/", array_reverse( preg_split("/\D/", $post_array['fecha']) ) );                                    
            
            $this->db->select('*');
            $this->db->where('equipo', $post_array['equipo']);
            $this->db->where('fecha', $fecha_invertida);
            $this->db->where('hora_inicio <=', $post_array['hora_inicio']);
            $this->db->where('hora_termino >=', $post_array['hora_inicio']);            
            $query = $this->db->get('reservacion');                                   
            if ($query->num_rows() != 0){
                return FALSE;
            }
            
            $this->db->select('*');
            $this->db->where('equipo', $post_array['equipo']);
            $this->db->where('fecha', $fecha_invertida);
            $this->db->where('hora_inicio <=', $post_array['hora_termino']);
            $this->db->where('hora_termino >=', $post_array['hora_termino']);            
            $query = $this->db->get('reservacion');                                   
            if ($query->num_rows() != 0){
                return FALSE;
            }
            
            $this->db->select('*');
            $this->db->where('equipo', $post_array['equipo']);
            $this->db->where('fecha', $fecha_invertida);
            $this->db->where('hora_inicio >=', $post_array['hora_inicio']);
            $this->db->where('hora_termino <=', $post_array['hora_termino']);            
            $query = $this->db->get('reservacion');                                   
            if ($query->num_rows() != 0){
                return FALSE;
            }             
        }
        
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
