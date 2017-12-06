<?php
Class Reactivos extends CI_controller{

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
            $datos_plantilla['titulo'] = "Catálogo de Reactivos";
            $datos_plantilla['contenido'] = $this->load->view('catalogos/reactivos_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
        }

        function _example_output_listado($output = null)
        {
            $datos_plantilla['titulo'] = "Control de Reactivos";
            $datos_plantilla['contenido'] = $this->load->view('catalogos/listado_reactivos_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();
                $crud->where('responsable',$this->noPersonal);
                $crud->set_table('reactivo');
                $crud->set_subject('Reactivo');
                $crud->set_rules('nombre', 'Nombre', 'required');
                //$crud->unset_delete();
                $crud->set_rules('unidad_de_medida', 'Unidad de medida', 'required');
                $crud->set_rules('minimo_stock', 'Minimo stock', 'required|numeric');
                $crud->set_rules('responsable', 'Responsable', 'required');
                //$crud->unset_fields('total_stock','contenido_por_unidad');
                $crud->unset_columns('responsable', 'cantidad');
                $crud->field_type('cantidad','hidden', 0);
                $crud->field_type('total_stock','hidden', 0);
                $crud->field_type('responsable', 'hidden', $this->noPersonal);


                $crud->callback_column('minimo_stock',array($this,'add_unidad'));
                $crud->callback_column('total_stock',array($this,'add_unidad'));
                //$crud->callback_insert(array($this,'realiza_operaciones'));

                $output = $crud->render();
                $this->load->model('inventario_model');
                $output->stock = $this->inventario_model->consulta_stock($this->noPersonal, 'reactivo');
                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }

        function listar_reactivos() //Listar los reactivos de todos los usuarios
        {
        //echo $this->noPersonal;
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();
                $crud->set_table('reactivo');
                $crud->set_subject('Reactivo');
                $crud->unset_operations();
                $crud->set_relation('responsable','usuario','nombre');

                $output = $crud->render();
                $this->_example_output_listado($output);
            }else
            {
                redirect('login');
            }
        }

         function add_unidad($value, $row)
        {
            return $value.' '.$row->unidad_de_medida;
        }

        function realiza_operaciones($post_array)
        {
            if(($post_array['unidad_de_medida'] == "Galón") || ($post_array['unidad_de_medida'] == "Frasco")  )
            {
                if($post_array['total_stock'] == NULL)
                {
                    $post_array['total_stock'] = $post_array['cantidad'] * $post_array['contenido_por_unidad'];
                    return $this->db->insert('reactivo',$post_array);
                }else{
                    return $this->db->insert('reactivo',$post_array);
                }
            }else{
                $post_array['total_stock'] = $post_array['cantidad'];
                return $this->db->insert('reactivo',$post_array);
            }
        }
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
