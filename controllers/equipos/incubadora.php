<?php
Class Incubadora extends CI_controller{
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
        $datos_plantilla['titulo'] = "Control de Incubadora"; 
        $datos_plantilla['contenido'] = $this->load->view('equipos/incubadora_view.php',$output, TRUE);
        $this->load->view('plantilla_view', $datos_plantilla);

    }

    function control()
    {
         if ($this->session->userdata('logged_in') == TRUE)
        {
            $crud = new grocery_CRUD();                     
            $crud->set_table('incubadora');
            $crud->set_subject('Registro');           
            $crud->set_rules('fecha', 'Fecha', 'required|date');            
            $crud->set_rules('co2', 'Co2', 'required|numeric');                       
            $crud->set_rules('temp_exterior', 'Temperatura exterios', 'required|numeric');   
            $crud->set_rules('temp_interior', 'Temperatura interior', 'required|numeric');
            $crud->set_rules('presion', 'Presion', 'required|numeric');
            
            //$crud->callback_column('nivel_inicial',array($this,'centimetros')); 
            $crud->callback_column('temp_exterior',array($this,'grados'));
            $crud->callback_column('temp_interior',array($this,'grados'));
            $crud->callback_column('presion',array($this,'presion'));
            $crud->callback_add_field('co2',array($this,'field_co2'));
            $crud->callback_add_field('temp_exterior',array($this,'field_exterior'));
            $crud->callback_add_field('temp_interior',array($this,'field_interior'));
            $crud->callback_add_field('presion',array($this,'field_presion'));
            //$crud->callback_add_field('nivel_final',array($this,'field_cm_2'));
            
            $output = $crud->render();

            $this->_example_output($output);
        }else
        {
            redirect('login');
        }
    }
    
    function grados($value, $row)
    {
        return $value.' °C';
    }
    
    function presion($value, $row)
    {
        return $value.' Kg/cm2';
    }
   
    function field_exterior()
    {
        return '<span class="add-on"><i class="icon-fire"></i></span><input type="text" maxlength="3" value="" name="temp_exterior" style="width:50px"> °C.';
    }
    
    function field_interior()
    {
        return '<span class="add-on"><i class="icon-fire"></i></span><input type="text" maxlength="3" value="" name="temp_interior" style="width:50px"> °C.';
    }
    
    function field_co2()
    {
        return '<span class="add-on"><i class="icon-leaf"></i></span><input type="text" maxlength="3" value="" name="co2" style="width:50px">';
    }
    
    function field_presion()
    {
        return '<span class="add-on"><i class="icon-chevron-up"></i></span><input type="text" maxlength="3" value="" name="presion" style="width:50px"> Kg / Cm2';
    }
   
    function generar_grafica(){
        $fecha = array(                                                                  
                           'de'     => $this->input->post('de'),
                           'hasta'  => $this->input->post('hasta')
                       );        
        if($fecha['de'] < $fecha['hasta'])
        {                        
            $this->load->model('equipos/incubadora_model');
            $temps = $this->incubadora_model->get_temperaturas($fecha);           
            
            if($temps != NULL){
            $temps['fecha'] = $temps['fecha'];
            $temps['exterior'] = $temps['te'];
            $temps['interior'] = $temps['ti'];
            
            $datos_plantilla['titulo'] = "Gráfica Incubadora";                        
            $datos_plantilla['contenido'] = $this->load->view('equipos/graficas/grafica_incubadora_view', $temps, true);
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
 * terminar el archivo incubadora.php
 */
