<?php
Class Inventario_reactivo extends CI_controller{

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
            $datos_plantilla['titulo'] = "Inventario Reactivo";
            $datos_plantilla['contenido'] = $this->load->view('inventario/inventario_reactivo.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();

                $crud->where('tipo_utensilio','Reactivo');
                $crud->set_table('inventario');
                $crud->unset_columns('tipo_utensilio');
                $crud->display_as('utensilio','Reactivo');
                $crud->set_subject('Movimiento');
                $crud->required_fields('fecha','tipo_utensilio','utensilio','movimiento','cantidad','usuario');
                //$crud->set_rules('costo','Costo','required|numeric');
                $crud->set_relation('utensilio','reactivo','nombre');
                $crud->set_relation('proveedor','proveedor','nombre');
                $crud->set_relation('usuario','usuario','nombre');

                $crud->callback_add_field('tipo_utensilio',array($this,'add_field'));
                $crud->callback_column('cantidad',array($this,'add_unidad'));
                $crud->callback_insert(array($this,'realiza_operaciones'));

                $output = $crud->render();
                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }

        function add_field()
        {
            return '<input type="text" maxlength="50" value="Reactivo" name="tipo_utensilio" readonly>';
        }

        function add_unidad($value, $row)
        {
                $this->db->select('unidad_de_medida');
                $this->db->where('id', $row->utensilio);
                $query = $this->db->get('reactivo');
                $row_med = $query->row();
                return $value.' '.$row_med->unidad_de_medida;
        }

        function realiza_operaciones($post_array)
        {
            if($post_array['movimiento'] != NULL)
            {
                $this->db->select('total_stock, contenido_por_unidad, unidad_de_medida');
                $this->db->where('id', $post_array['utensilio']);
                $query = $this->db->get('reactivo');
                $row = $query->row();

                if($post_array['movimiento'] == "Entrada")
                {
                    $suma = $row->total_stock + $post_array['cantidad'];
                    $sum_rest = $suma;
                    //$en_uso = $row->en_uso;
                }else{
                    $resta = $row->total_stock - $post_array['cantidad'];
                    $sum_rest = $resta;
                    //$en_uso = $row->en_uso;
                    //$en_uso += $post_array['cantidad'];
                }

                if($row->unidad_de_medida == "Galón")
                {
                    $cantidad = $sum_rest / $row->contenido_por_unidad;
                }else{
                    $cantidad = $sum_rest;
                }

                $data = array('total_stock' => $sum_rest,
                              'cantidad' => $cantidad
                              //'en_uso' => $en_uso
                            );
                $post_array['fecha'] = implode("/", array_reverse( preg_split("/\D/", $post_array['fecha']) ) );
                $actualiza = array(
                            'update' => $this->db->update('reactivo',$data, array('id' => $post_array['utensilio'])),
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