<?php
Class Ctrl_equipos extends CI_controller{
  
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
        $datos_plantilla['titulo'] = "Bitácora de equipos";        
        $datos_plantilla['contenido'] = $this->load->view('bitacoras/ctrl_equipos_view.php',$output, TRUE);
        $this->load->view('plantilla_view', $datos_plantilla);

    }

    function control()
    {
         if ($this->session->userdata('logged_in') == TRUE)
        {
            $crud = new grocery_CRUD();                     
            $crud->set_table('bitacora_equipo');
            $crud->set_subject('bitácora');
            $crud->set_relation('equipo','equipo','descripcion');
            $crud->set_relation('usuario','usuario','nombre');            
            $crud->set_rules('equipo', 'Equipo', 'required');            
            $crud->set_rules('fecha', 'Fecha', 'required');                       
            $crud->set_rules('inicio', 'Inicio', 'required');
            $crud->set_rules('termino', 'Termino', 'required');            
            $crud->set_rules('usuario', 'Utilizado por', 'required');   
            $crud->display_as('usuario', 'Utilizado por');
            
            $crud->callback_add_field('inicio',array($this,'field_inicio'));
            $crud->callback_add_field('termino',array($this,'field_termino'));
            $crud->callback_column('inicio',array($this,'text_horas'));
            $crud->callback_column('termino',array($this,'text_horas'));
            $crud->callback_before_insert(array($this,'valida_horas'));
            //$crud->callback_column('nivel_inicial',array($this,'centimetros')); 
            //$crud->callback_column('proceso_cada',array($this,'dias')); 
            //$crud->callback_add_field('proceso_cada',array($this,'field_proceso'));
            //$crud->callback_insert(array($this,'suma_dias'));
                      
            $output = $crud->render();         
            
            $this->_example_output($output);
        }else
        {
            redirect('login');
        }    
    }
    
    function field_inicio()
    {                       
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="inicio" style="width:50px"> (hh:mm) 0-23 hrs.';  
    }
    
    function field_termino()
    {                       
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="termino" style="width:50px"> (hh:mm) 0-23 hrs.';  
    }
    
     function valida_horas($post_array)
    {
         if(!strtotime($post_array['inicio'])){
            return FALSE;            
        }        
        
        if(!strtotime($post_array['termino'])){
            return FALSE;               
        }
        
        if($post_array['termino'] < $post_array['inicio']){
            return FALSE;
        }
     }
     
     function text_horas($value, $row)
    {
        return $value.' hrs.';
    }
    
}

/*
 * terminar el archivo ctrl_aseo.php
 */
   
   