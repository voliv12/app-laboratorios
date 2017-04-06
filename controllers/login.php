<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function index()
    {
    	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');

        //$datos_plantilla['titulo'] = "Acceso al sistema";
        //$datos_plantilla['contenido'] = $this->load->view('login_view', array(), true);
        //$this->load->view('plantilla_view', $datos_plantilla);
        $datos_plantilla['contenido'] = " ";
        $this->load->view('login_view', $datos_plantilla);

        //$this->load->model('equipos/mantenimiento_model');
        //$array= $this->mantenimiento_model->get_tabla_mantenimiento();
    }

    function validar_usuario()
    {
            $noPersonal = $this->input->post('noPersonal');
            $clave = $this->input->post('password');
            $this->load->model('usuarios_model');
            $row = $this->usuarios_model->buscar_en_BD($noPersonal, $clave);
            if(!$row)
            {
                $datos['mensaje'] = "El usuario ".$datos['noPersonal'] = $noPersonal." no está registrado o la contraseña es incorrecta. Intentelo de nuevo!";
                //$datos['link'] = "<input type='button' value='Intentar de nuevo' name='regresar' class='input_button' onclick='history.back()' />";
                $datos_plantilla['contenido'] = $this->load->view('success_login', $datos, true);
                $this->load->view('login_view', $datos_plantilla);
            }else
            {
                if($row->rol == 'Administrador')
                {
                    $newdata = array(
                                     'noPersonal' => $row->noPersonal,
                                     'perfil'     => $row->rol,
                                     'nombre'     => $row->nombre,
                                     'email'        => $row->email,
                                     'logged_in'  => TRUE
                                    );
                    $this->session->set_userdata($newdata);

                    $datos_plantilla['titulo'] = "Panel de Control";
                    $datos_plantilla['contenido'] = "Seleccione una opción del menú de arriba";
                    //$datos_plantilla['contenido'] = $this->load->view('panel', array(), true);

                    //####Actualizar para administrar usuarios: ###########
                    $this->load->view('plantilla_view', $datos_plantilla);
                }else
                {
                      $newdata = array(
                                     'noPersonal'   => $row->noPersonal,
                                     'perfil'       => $row->rol,
                                     'nombre'       => $row->nombre,
                                     'email'        => $row->email,
                                     'logged_in' => TRUE
                                    );
                      $this->session->set_userdata($newdata);

                      $datos_plantilla['titulo'] = "Inventario Materiales y Reactivos";
                      $datos_plantilla['contenido'] = "Seleccione una opción del menú de arriba";
                      //$datos_plantilla['contenido'] = $this->load->view('panel_consulta', array(), true);
                      $this->load->view('plantilla_view', $datos_plantilla);
                }
            }

    }

}
