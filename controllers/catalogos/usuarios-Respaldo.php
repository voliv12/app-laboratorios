<?php
Class Usuarios extends CI_controller{

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
            $datos_plantilla['titulo'] = "Control de Usuarios";
            $datos_plantilla['contenido'] = $this->load->view('catalogos/usuarios_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);

        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();
                $crud->set_table('usuario');
                $crud->set_subject('Usuario');
                //$crud->columns('noPersonal','email', 'nombre', 'telefono', 'rol');
                //$crud->fields('email', 'password', 'nombre', 'telefono', 'rol');
                $crud->change_field_type('password', 'password');

                $crud->set_rules('email', 'Email', 'required|valid_email');
                $crud->set_rules('password', 'Password', 'required');
                $crud->set_rules('nombre', 'Nombre', 'required');
                //$crud->unset_columns('tipo_utensilio');
                //$crud->display_as('id','Material');
                //$crud->set_subject('Control');

                //$crud->set_relation('id','material','nombre');

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
