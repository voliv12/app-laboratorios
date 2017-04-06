<?php
Class Equipos_consulta extends CI_controller{
        
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
            $this->load->view('plantilla_usuario_view', $datos_plantilla);
               
        }

        function control()
        {
             if ($this->session->userdata('logged_in_usuario') == TRUE)
            {
                $crud = new grocery_CRUD();                     
                $crud->set_table('equipo');
                $crud->set_subject('Equipo');
                $crud->display_as('no_inventario','Inventario');            
                $crud->unset_operations();

                $crud->set_relation('responsable','usuario','nombre');                     
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
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
