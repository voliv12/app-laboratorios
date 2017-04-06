<?php
Class Inventario_material extends CI_controller{

        function __construct()
        {
            parent::__construct();

            /* Standard Libraries */
            $this->load->database();
            $this->load->helper('url');
            /* ------------------ */

            $this->load->library('grocery_CRUD');
            $this->load->library('email');

            $this->noPersonal = $this->session->userdata('noPersonal');
            $this->correo = $this->session->userdata('email');
        }

        function _example_output($output = null)
        {
            $datos_plantilla['titulo'] = "Inventario Material";
            $datos_plantilla['contenido'] = $this->load->view('inventario/entrada_material.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);

        }

        function _example_output_salida($output = null)
        {
            $datos_plantilla['titulo'] = "Inventario Material";
            $datos_plantilla['contenido'] = $this->load->view('inventario/salida_material.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);

        }

        function entrada()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();

                $crud->where('tipo_utensilio','Material');
                $crud->where('movimiento','Entrada');
                $crud->where('inventario.responsable', $this->noPersonal);
                $crud->set_table('inventario');
                $crud->unset_columns('tipo_utensilio','responsable','movimiento','destino');
                $crud->unset_fields('destino');
                $crud->unset_edit_fields('cantidad','destino');
                $crud->display_as('utensilio','Material');
                $crud->set_subject('Entrada de Material');
                $crud->required_fields('fecha','tipo_utensilio','utensilio','movimiento','cantidad','usuario');
                //$crud->set_rules('costo','Costo','required|numeric');

                $crud->field_type('tipo_utensilio', 'hidden', 'Material');
                $crud->set_relation('utensilio','material','nombre', array('responsable' => $this->noPersonal));
                $crud->field_type('movimiento', 'hidden', 'Entrada');
                $crud->set_relation('proveedor','proveedor','nombre');
                $crud->field_type('responsable', 'hidden', $this->noPersonal);
                $crud->set_relation('fuente_financiamiento','fuente','Fuente');

                //$crud->callback_add_field('tipo_utensilio',array($this,'add_field'));
                $crud->callback_column('cantidad',array($this,'add_unidad'));
                $crud->callback_insert(array($this,'realiza_operaciones'));

                $output = $crud->render();
                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }

        function salida()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();

                $crud->where('tipo_utensilio','Material');
                $crud->where('movimiento','Salida');
                $crud->where('inventario.responsable', $this->noPersonal);
                $crud->set_table('inventario');
                $crud->unset_columns('tipo_utensilio','responsable','movimiento','costo','factura','estado_factura','proveedor','fuente_financiamiento');
                $crud->unset_fields('costo','factura','estado_factura','proveedor','fuente_financiamiento');
                $crud->unset_edit_fields('material','cantidad','costo','factura','estado_factura','proveedor','fuente_financiamiento');
                $crud->display_as('utensilio','Material');
                $crud->set_subject('Salida de Material');
                //$crud->required_fields('fecha','tipo_utensilio','utensilio','movimiento','cantidad','usuario');
                //$crud->set_rules('costo','Costo','required|numeric');

                $crud->field_type('tipo_utensilio', 'hidden', 'Material');
                $crud->set_relation('utensilio','material','nombre', array('responsable' => $this->noPersonal));
                $crud->field_type('movimiento', 'hidden', 'Salida');
                //$crud->set_relation('proveedor','proveedor','nombre');
                $crud->field_type('responsable', 'hidden', $this->noPersonal);
                //$crud->set_relation('fuente_financiamiento','fuente','Fuente');

                //$crud->callback_add_field('tipo_utensilio',array($this,'add_field'));
                $crud->callback_column('cantidad',array($this,'add_unidad'));
                $crud->callback_insert(array($this,'realiza_operaciones'));

                $output = $crud->render();
                $this->_example_output_salida($output);
            }else
            {
                redirect('login');
            }
        }

        function add_field()
        {
            return '<input type="text" maxlength="50" value="Material" name="tipo_utensilio" readonly>';
        }

        function add_unidad($value, $row)
        {
                return $value.' piezas';
        }

        function realiza_operaciones($post_array)
        {
            if($post_array['movimiento'] != NULL)
            {
                $this->db->select('nombre, total_stock, minimo_stock, contenido_por_unidad, unidad_de_medida, en_uso');
                $this->db->where('id', $post_array['utensilio']);
                $query = $this->db->get('material');
                $row = $query->row();

                if($post_array['movimiento'] == "Entrada")
                {
                    $suma = $row->total_stock + $post_array['cantidad'];
                    $sum_rest = $suma;
                    $en_uso = $row->en_uso;
                }else{
                    $resta = $row->total_stock - $post_array['cantidad'];
                    $sum_rest = $resta;
                    $en_uso = $row->en_uso;
                    $en_uso += $post_array['cantidad'];
                }

                if($row->unidad_de_medida != "Pieza")
                {
                    $cantidad = $sum_rest / $row->contenido_por_unidad;
                }else{
                    $cantidad = $sum_rest;
                }

                $data = array('total_stock' => $sum_rest,
                              'cantidad' => $cantidad,
                              'en_uso' => $en_uso
                            );
                $post_array['fecha'] = implode("/", array_reverse( preg_split("/\D/", $post_array['fecha']) ) );
                $actualiza = array(
                            'update' => $this->db->update('material',$data, array('id' => $post_array['utensilio'])),
                            'insert' => $this->db->insert('inventario', $post_array)
                            );
                return $actualiza;
            }
        }

}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
