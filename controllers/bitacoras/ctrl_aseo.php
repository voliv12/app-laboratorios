<?php
Class Ctrl_aseo extends CI_controller{
  
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
        $datos_plantilla['titulo'] = "Bitácora de aseo"; 
        $datos_plantilla['contenido'] = $this->load->view('bitacoras/ctrl_aseo_view.php',$output, TRUE);
        $this->load->view('plantilla_view', $datos_plantilla);

    }

    function control()
    {
         if ($this->session->userdata('logged_in') == TRUE)
        {
            $crud = new grocery_CRUD();                     
            $crud->set_table('bitacora_aseo');
            $crud->set_subject('bitácora');
            $crud->fields('area', 'proceso_cada', 'fecha_limpieza', 'responsable', 'observaciones');
            $crud->set_rules('area', 'Area', 'required');            
            $crud->set_rules('proceso_cada', 'Proceso cada', 'required|integer');                       
            $crud->set_rules('fecha_limpieza', 'Fecha limpieza', 'required');
            //$crud->set_rules('proxima_limpieza', 'Próxima limpieza', 'required');
            $crud->set_rules('responsable', 'Responsable', 'required');
                        
            //$crud->callback_column('nivel_inicial',array($this,'centimetros')); 
            $crud->callback_column('proceso_cada',array($this,'dias')); 
            $crud->callback_add_field('proceso_cada',array($this,'field_proceso'));
            $crud->callback_insert(array($this,'suma_dias'));
            
            $output = $crud->render();

            $this->_example_output($output);
        }else
        {
            redirect('login');
        }    
    }
    
    function field_proceso()
    {
        return '<input type="text" maxlength="2" value="" name="proceso_cada" style="width:50px"> Días.';
    }
    
    function dias($value, $row)
    {
        return $value.' días';
    }
    
    function suma_dias($post_array)
    {                       
        //Invierto la fecha               
        $fecha = implode("/", array_reverse( preg_split("/\D/", $post_array['fecha_limpieza']) ) );       
        
        //$fecha = $newDate;
        $dias = $post_array['proceso_cada'];
        
        $post_array['fecha_limpieza'] = $fecha;
        $post_array['proxima_limpieza'] = date("Y/m/d", strtotime("$fecha +$dias day"));
        
        return $this->db->insert('bitacora_aseo',$post_array);
    }   
    
}

/*
 * terminar el archivo ctrl_aseo.php
 */
   
   
   