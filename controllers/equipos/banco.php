<?php

Class Banco extends CI_controller{
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
        $datos_plantilla['titulo'] = "Control del Banco de Células"; 
        $datos_plantilla['contenido'] = $this->load->view('equipos/banco_view.php',$output, TRUE);
        $this->load->view('plantilla_view', $datos_plantilla);

    }

    function control()
    {
         if ($this->session->userdata('logged_in') == TRUE)
        {
            $crud = new grocery_CRUD();                     
            $crud->set_table('banco');
            $crud->set_subject('Registro');           
            $crud->set_rules('fecha', 'Fecha', 'required');            
            $crud->set_rules('nivel_inicial', 'Nivel inicial', 'required|integer');                       
            $crud->set_rules('nivel_final', 'Nivel final', 'required|integer');   
                        
            $crud->callback_column('nivel_inicial',array($this,'centimetros')); 
            $crud->callback_column('nivel_final',array($this,'centimetros')); 
            $crud->callback_add_field('nivel_inicial',array($this,'field_cm_1'));
            $crud->callback_add_field('nivel_final',array($this,'field_cm_2'));
            
            $output = $crud->render();

            $this->_example_output($output);
        }else
        {
            redirect('login');
        }
    }
    
    function centimetros($value, $row)
    {
        return $value.' cm';
    }
   
    function field_cm_1()
    {
        return '<input type="text" maxlength="3" value="" name="nivel_inicial" style="width:50px"> cm.';
    }
    
    function field_cm_2()
    {
        return '<input type="text" maxlength="3" value="" name="nivel_final" style="width:50px"> cm.';
    }
   
    function generar_grafica(){
        $fecha = array(                                                                  
                           'de'     => $this->input->post('de'),
                           'hasta'  => $this->input->post('hasta')
                       );        
        if($fecha['de'] < $fecha['hasta'])
        {                        
            $this->load->model('equipos/banco_model');
            $niveles = $this->banco_model->get_niveles($fecha);           
            
            if($niveles != NULL){
            $niveles['fecha'] = $niveles['fecha'];
            $niveles['nivel_inicial'] = $niveles['ni'];
            $niveles['nivel_final'] = $niveles['nf'];
            
            $datos_plantilla['titulo'] = "Gráfica de Banco de Células";                        
            $datos_plantilla['contenido'] = $this->load->view('equipos/graficas/grafica_banco_view', $niveles, true);
            $this->load->view('plantilla_view', $datos_plantilla);
            }else{
                $datos['mensaje'] = "No se encontraron registros para el rango de fechas proporcionadas.";  
                $datos['link'] = "<input type='button' value='Intentar de nuevo' name='regresar' class='input_button' onclick='history.back()' />";
                $datos_plantilla['contenido'] = $this->load->view('success', $datos, true);
                $this->load->view('plantilla_view', $datos_plantilla);                                    
            }
        }else{
            $datos['mensaje'] = "La fecha inicial(De) no puede ser mayor o igual a la fecha final(Hasta).";
            $datos['link'] = "<input type='button' value='Intentar de nuevo' name='regresar' class='input_button' onclick='history.back()' />";
            $datos_plantilla['contenido'] = $this->load->view('success', $datos, true);
            $this->load->view('plantilla_view', $datos_plantilla);       
        }
    }
}

/*
 * terminar el archivo banco.php
 */
