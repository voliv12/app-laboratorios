<?php
Class Equipos extends CI_controller{
        
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
            $datos_plantilla['titulo'] = "Control de Equipos"; 
            $datos_plantilla['contenido'] = $this->load->view('catalogos/equipos_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
               
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();                     
                $crud->set_table('equipo');
                $crud->set_subject('Equipo');
                $crud->display_as('no_inventario','Núm. Inventario');  
                $crud->display_as('no_serie','Núm. Serie');                  
                $crud->set_rules('no_serie', 'Número de Serie', 'required');
                $crud->set_rules('descripcion', 'Descripcion', 'required');
                $crud->set_rules('importe', 'Importe', 'numeric');
                $crud->set_rules('responsable', 'Responsable', 'required');
                $crud->unset_texteditor('descripcion','full_text');

                $crud->set_relation('responsable','usuario','nombre'); 
                $crud->callback_add_field('importe',array($this,'field_importe'));
                $crud->callback_column('importe',array($this,'valorPesos'));           

                $output = $crud->render();
                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }
        
        function valorPesos($value, $row)
        {
            return '$ '.$value;
        }
        
        function field_importe()
        {
            return '$ <input type="text" maxlength="3" value="" name="importe" style="width:190px">';
        }
        
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
