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
            $this->noPersonal = $this->session->userdata('noPersonal');
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

        /*function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();

                $crud->where('noPersonal',$this->noPersonal);
                $crud->set_table('academico');
                $crud->set_relation('categoria', 'categoria', 'nombre_categoria');
                $crud->set_relation('departamento','departamento', 'nombre_depto');
                $crud->unset_columns('noPersonal','nombre_grado','direccion','rfc','curp','correos','licenciatura','titulo_cedula_lic','especialidad','titulo_cedula_esp','maestria','titulo_cedula_mae','doctorado','titulo_cedula_doc');
                $crud->unset_fields('nombre_grado');
                $crud->unset_add();
                $crud->unset_delete();

                $crud->display_as('grado','Ultimo grado de estudios');
                $crud->field_type('noPersonal','readonly');

                $output = $crud->render();
                $output->titulo_tabla = '<div class="alert alert-success"><h4>Información personal del Académico</h4></div>';
                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }*/
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */