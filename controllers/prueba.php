<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Prueba extends CI_Controller {
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
        $this->load->view('example.php',$output);    
    }
	function banco()
	{		
        $crud = new grocery_CRUD();
 
        //$crud->set_theme('datatables');
        $crud->set_table('banco');
        //$crud->set_subject('Office');
        //$crud->columns('city','country','phone','addressLine1','postalCode');
 
        $output = $crud->render();
 
        $this->_example_output($output);
	}
        
}
?>
