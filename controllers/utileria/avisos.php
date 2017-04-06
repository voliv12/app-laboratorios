<?php
class Avisos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        $this->load->database();
        /* ------------------ */
    }

    function index()
    {
        $this->db->select('*');
        $this->db->from('mantenimiento_equipo');
        $this->db->join('equipo', 'equipo.id = mantenimiento_equipo.equipo');
        $query = $this->db->get();
        if($query->num_rows != 0){
            foreach ($query->result() as $row)
            {
                //$fecha_0 = "2013-07-01";
                $fecha_0 = date("y-m-d");
                $fecha_1 = $row->proximo_mantenimiento;
                $dias = $this->diferencia_fechas($fecha_1, $fecha_0, "DIAS", FALSE);
                $datos['equipo'] = $row->descripcion;
                $datos['fecha'] = $fecha_1;
                if($dias <= 5){
                    $this->envia_aviso($datos);
                }else{
                    echo "Todavia faltan ".$dias." dias para mantenimiento del equipo:  ".$row->descripcion."<br>";
                }
            }
        }else{
            echo "No hay fechas próximas de mantenimiento";
        }
   }

    function envia_aviso()
   {
        $email_config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'voliv12@gmail.com',
            'smtp_pass' => 'Espectrum21',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

        $this->load->library('email', $email_config);

        $this->email->clear();
        $this->email->from('voliv12@gmail.com', 'Vick');
        $this->email->to('voliv12@hotmail.com');
        $this->email->subject('Aviso inventario');
        $this->email->message('Se ha llegado al minimo en stock de material');

        $this->email->send();

        echo $this->email->print_debugger();
   }

   function diferencia_fechas($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false)
   {
       $f0 = strtotime($fecha_principal);
       $f1 = strtotime($fecha_secundaria);
       if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
       $resultado = ($f0 - $f1);
       switch ($obtener) {
           default: break;
           case "MINUTOS"   :   $resultado = $resultado / 60;   break;
           case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
           case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
           case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
        }
       if($redondear) $resultado = round($resultado);
       return $resultado;
   }

}