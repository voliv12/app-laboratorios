<?php
Class Materiales extends CI_controller{

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
            $datos_plantilla['titulo'] = "Control de Materiales";
            $datos_plantilla['contenido'] = $this->load->view('catalogos/materiales_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
        }

        function _example_output_listado($output = null)
        {
            $datos_plantilla['titulo'] = "Control de Materiales";
            $datos_plantilla['contenido'] = $this->load->view('catalogos/listado_materiales_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();
                $crud->where('responsable',$this->noPersonal);
                $crud->set_table('material');
                $crud->set_subject('Material');
                $crud->set_rules('nombre', 'Nombre', 'required');
                //$crud->unset_delete();
                //$crud->set_rules('cantidad', 'Cantidad', 'required|numeric');
                $crud->set_rules('unidad_de_medida', 'Unidad de medida', 'required');
                $crud->set_rules('contenido_por_unidad', 'Contenido por unidad', 'integer');
                $crud->set_rules('minimo_stock', 'Minimo stock', 'required|numeric');
                $crud->display_as('unidad_de_medida','Presentacion');
                $crud->display_as('contenido_por_unidad','Con');
                $crud->unset_columns('responsable','en_uso','cantidad');
                $crud->field_type('cantidad', 'hidden', 0);
                $crud->field_type('total_stock','hidden', 0);
                $crud->field_type('responsable', 'hidden', $this->noPersonal);
                $crud->unset_fields('en_uso');

                $crud->callback_add_field('contenido_por_unidad',array($this,'field_contenido'));
                //$crud->callback_add_field('cantidad',array($this,'field_cantidad'));
                $crud->callback_column('total_stock',array($this,'add_piezas'));
                $crud->callback_column('minimo_stock',array($this,'add_piezas'));
                $crud->callback_insert(array($this,'realiza_operaciones'));

                $output = $crud->render();
                $this->load->model('inventario_model');
                $output->stock = $this->inventario_model->consulta_stock($this->noPersonal, 'material');
                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }

        function listar_materiales() //Listar los materiales de todos los usuarios
        {
        //echo $this->noPersonal;
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();
                $crud->set_table('material');
                $crud->set_subject('Material');
                $crud->unset_operations();
                $crud->set_relation('responsable','usuario','nombre');

                $output = $crud->render();
                $this->_example_output_listado($output);
            }else
            {
                redirect('login');
            }
        }

        function field_contenido()
        {
            return '<input type="text" id="contenido_por_unidad" maxlength="5" value="" name="contenido_por_unidad" style="width:50px"> Piezas.';
        }

        function add_piezas($value, $row)
        {
            return $value.' Piezas';
        }

        function realiza_operaciones($post_array)
        {
            if($post_array['unidad_de_medida'] != "Pieza")
            {
                if($post_array['total_stock'] == NULL)
                {
                    $post_array['total_stock'] = $post_array['cantidad'] * $post_array['contenido_por_unidad'];
                    return $this->db->insert('material',$post_array);
                }else{
                    return $this->db->insert('material',$post_array);
                }
            }else{
                $post_array['total_stock'] = $post_array['cantidad'];
                return $this->db->insert('material',$post_array);
            }
        }

         function field_cantidad()
        {
          return '<select name="cantidad" style="width:60px">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                  </select>';

        }
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
