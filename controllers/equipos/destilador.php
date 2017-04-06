<?php

Class Destilador extends CI_controller{
    
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
            $datos_plantilla['titulo'] = "Control Destilador"; 
            $datos_plantilla['contenido'] = $this->load->view('equipos/destilador_view.php',$output, TRUE);
            $this->load->view('plantilla_view', $datos_plantilla);
               
        }

        function control()
        {
             if ($this->session->userdata('logged_in') == TRUE)
            {
                $crud = new grocery_CRUD();                     
                $crud->set_table('destilador');
                $crud->set_subject('Registro');
                $crud->fields('fecha','operador','nivel_inicial','nivel_final','tiempo','observa_previo','hora_encendido','hora_sal_agua', 'hora_sal_vapor','columna_vapor','hora_apagado','volumen_destilada','observa_encendido','observa_grales');                
                //$crud->fields('email', 'password', 'nombre', 'institucion', 'telefono', 'rol');
                //$crud->change_field_type('password', 'password');
                $crud->set_rules('fecha', 'Fecha', 'required');
                $crud->set_rules('operador', 'Operador', 'required');
                $crud->set_rules('nivel_inicial', 'Nivel inicial', 'required|numeric');                       
                $crud->set_rules('nivel_final', 'Nivel final', 'required|numeric');
                $crud->set_rules('tiempo', 'Tiempo', 'required');                
                $crud->set_rules('hora_encendido', 'Hora de encendido', 'required');
                $crud->set_rules('hora_sal_agua', 'Hora salida agua', 'required');
                $crud->set_rules('hora_sal_vapor', 'Hora salida de vapor', 'required');
                $crud->set_rules('coluna_vapor', 'Calumna de vapor', 'required|numeric');
                $crud->set_rules('hora_apagado', 'Hora de apagado', 'required');
                $crud->set_rules('volumen_destilada', 'Volumen destilada', 'required|numeric');                
                $crud->display_as('observa_previo', 'Observaciones previas al encendido');                
                $crud->display_as('hora_encendido', 'Hora de encendido');
                $crud->display_as('hora_sal_agua', 'Hora salida agua');
                $crud->display_as('hora_sal_vapor', 'Hora salida de vapor');
                $crud->display_as('coluna_vapor', 'Calumna de vapor');
                $crud->display_as('hora_apagado', 'Hora de apagado');
                $crud->display_as('volumen_destilada', 'Volumen destilada');
                $crud->display_as('observa_encendido', 'Observaciones al encendido');
                $crud->display_as('observa_grales', 'Observaciones generales');
                //$crud->unset_columns('tipo_utensilio');
                //$crud->display_as('id','Material');
                //$crud->set_subject('Control');
                $crud->set_relation('operador','usuario','nombre');
                $crud->callback_column('tiempo',array($this,'text_horas'));
                $crud->callback_add_field('nivel_inicial',array($this,'field_lts_1'));
                $crud->callback_add_field('nivel_final',array($this,'field_lts_2'));
                $crud->callback_add_field('tiempo',array($this,'field_tiempo'));
                $crud->callback_add_field('hora_encendido',array($this,'field_encendido'));
                $crud->callback_add_field('hora_sal_agua',array($this,'field_sal_agua'));
                $crud->callback_add_field('hora_sal_vapor',array($this,'field_sal_vapor'));
                $crud->callback_add_field('columna_vapor',array($this,'field_columna'));
                $crud->callback_add_field('hora_apagado',array($this,'field_apagado'));
                $crud->callback_add_field('volumen_destilada',array($this,'field_destilada'));                              
                $crud->callback_insert(array($this,'realiza_operaciones'));
                //$crud->callback_update(array($this,'realiza_operaciones'));
                $output = $crud->render();

                $this->_example_output($output);
            }else
            {
                redirect('login');
            }
        }                   

    function text_horas($value, $row)
    {
        return $value.' hrs.';
    }
    
    function field_lts_1()
    {
        return '<span class="add-on"><i class="icon-tint"></i></span><input type="text" maxlength="3" value="" name="nivel_inicial" style="width:50px"> Litros.';
    }
    
    function field_lts_2()
    {
        return '<span class="add-on"><i class="icon-tint"></i></span><input type="text" maxlength="3" value="" name="nivel_final" style="width:50px"> Litros.';
    }
    
    function field_tiempo()
    {
        return '<span class="add-on"><i class="icon-time"></i></span>
                <select name="tiempo" style="width:60px">
                  <option>2</option>
                  <option>4</option>
                </select> Horas.';
    }
    
    function field_encendido()
    {                       
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="hora_encendido" style="width:50px"> (hh:mm) 0-23 hrs.';  
    }

    function field_sal_agua()
    {                       
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="hora_sal_agua" style="width:50px"> (hh:mm) 0-23 hrs.';  
    }
    
    function field_sal_vapor()
    {                       
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="hora_sal_vapor" style="width:50px"> (hh:mm) 0-23 hrs.';  
    }

    function field_apagado()
    {                       
        return '<span class="add-on"><i class="icon-time"></i></span><input type="text" maxlength="5" value="" name="hora_apagado" style="width:50px"> (hh:mm) 0-23 hrs.';  
    }
    
    function field_columna()
    {
        return '<span class="add-on"><i class="icon-resize-vertical"></i></span><input type="text" maxlength="3" value="" name="columna_vapor" style="width:50px"> Centímetros.';
    }
    
     function field_destilada()
    {
        return '<span class="add-on"><i class="icon-tint"></i></span><input type="text" maxlength="3" value="" name="volumen_destilada" style="width:50px"> Litros.';
    }
          
    function realiza_operaciones($post_array)
    {
        $ni     = $post_array['nivel_inicial'];
        $nf     = $post_array['nivel_final'];
        $tiempo = $post_array['tiempo'];
        $hr_enc = $post_array['hora_encendido'];
        $hr_sa  = $post_array['hora_sal_agua'];
        $hr_sv  = $post_array['hora_sal_vapor'];
        $vd     = $post_array['volumen_destilada'];
        
        $dif = ($nf - $ni);
        $mtrs = ($dif / 100);
        $Vm = (3.1416 * 0.3025 * $mtrs);
        $Vl = ($Vm * 1000);
        $enf_hr = ($Vl / $tiempo);
        
        $dif_sa = date("H:i", strtotime("00:00") + strtotime($hr_sa) - strtotime($hr_enc));
        if($dif_sa == '00:00')
        {
            $dif_sa = null;
        }
                
        $dif_sv = date("H:i", strtotime("00:00") + strtotime($hr_sv) - strtotime($hr_enc));
        if($dif_sv == '00:00')
        {
            $dif_sv = null;
        }                
        
        $lt_hr = ($vd / $tiempo);
        
        //Invierto la fecha
        $newDate = implode("/", array_reverse( preg_split("/\D/", $post_array['fecha']) ) );
                
        $data['fecha']              = $newDate;
        $data['operador']           = $post_array['operador'];  
        $data['nivel_inicial']      = $post_array['nivel_inicial'];
        $data['nivel_final']        = $post_array['nivel_final'];
        $data['diferencia']         = $dif;
        $data['enfri_total']        = $Vl;
        $data['enfri_por_hor']      = $enf_hr;
        $data['tiempo']             = $tiempo;
        $data['observa_previo']     = $post_array['observa_previo'];
        $data['hora_encendido']     = $hr_enc;
        $data['hora_sal_agua']      = $hr_sa;
        $data['dif_sal_agua']       = $dif_sa;
        $data['hora_sal_vapor']     = $hr_sv;
        $data['dif_sal_vapor']      = $dif_sv;
        $data['columna_vapor']      = $post_array['columna_vapor'];
        $data['hora_apagado']       = $post_array['hora_apagado'];
        $data['volumen_destilada']  = $vd;
        $data['litros_hora']        = $lt_hr;
        $data['observa_encendido']  = $post_array['observa_encendido'];
        $data['observa_grales']     = $post_array['observa_grales'];        
        
        if(!strtotime($post_array['hora_encendido'])){
            return FALSE;               
        }elseif(!strtotime($post_array['hora_sal_agua'])){
            return FALSE;               
        }elseif(!strtotime($post_array['hora_sal_vapor'])){
            return FALSE;               
        }elseif(!strtotime($post_array['hora_apagado'])){
            return FALSE;               
        }else{
        return $this->db->insert('destilador',$data);
        }
    }
     
    function a_graficar(){
        $datos_plantilla['titulo'] = "Gráfica Destilador Felisa";                        
        $datos_plantilla['contenido'] = $this->load->view('equipos/form_destilador_view', NULL, true);
        $this->load->view('plantilla_view', $datos_plantilla);
    }
    
    function generar_grafica(){
        $graficar = array(                                                                  
                            'agua'   => $this->input->post('agua'),
                            'de'     => $this->input->post('de'),
                            'hasta'  => $this->input->post('hasta')
                       );        
        if($graficar['de'] < $graficar['hasta'])
        {                        
            $this->load->model('equipos/destilador_model');
            $lts_hr = $this->destilador_model->get_litros_hr($graficar);           
            
            if($lts_hr != NULL){
            $lts_hr['fecha'] = $lts_hr['fecha'];
            $lts_hr['litros'] = $lts_hr['ni'];            
            if($graficar['agua'] == "destilada" ){
                $lts_hr['agua'] = "Agua destilada";  
            }else{
                $lts_hr['agua'] = "Agua de enfriamiento"; 
            }
            
            $datos_plantilla['titulo'] = "Gráfica Destilador Felisa";                        
            $datos_plantilla['contenido'] = $this->load->view('equipos/graficas/grafica_destilador_view', $lts_hr, true);
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
 * terminar el archivo destilador.php
 */
