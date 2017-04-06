<?php
Class Proveedores_consulta extends CI_controller{
        
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
            $datos_plantilla['titulo'] = "Control de Proveedores"; 
            $datos_plantilla['contenido'] = $this->load->view('catalogos/proveedores_view.php',$output, TRUE);
            $this->load->view('plantilla_usuario_view', $datos_plantilla);
               
        }
         
        function control()
        {
            if ($this->session->userdata('logged_in_usuario') == TRUE)
            {
                $crud = new grocery_CRUD();                     
                $crud->set_table('proveedor');
                $crud->set_subject('proveedor');
                $crud->unset_operations();

                $output = $crud->render();

                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }                 
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
