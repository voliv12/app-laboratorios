<?php
Class Respaldos extends CI_controller{

    function generar_respaldo()
    {
         if ($this->session->userdata('logged_in') == TRUE)
        {
            $this->load->helper('file');
            $this->load->helper('download');
            $this->load->dbutil();

            $backup =& $this->dbutil->backup();                                         
            write_file('respaldoBD.gz', $backup);                
            force_download('respaldoBD.gz', $backup);

        }else
        {
            redirect('login');
        }
    }              
}
 /*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
