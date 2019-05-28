<?php
// if (!defined('BASEPATH'))
    // exit('No direct script access allowed');

    /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
     */

class General extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

    }

	function check_duplicate_record(){
		$table = $this->input->post('table');
		$field = $this->input->post('field');
		$value = $this->input->post('value');
		
		$this->db->where($field,$value);
		echo $this->db->get($table)->num_rows();
	}   
	
	function external_approval($approval_id){
		
		$data['approval_status'] = 1;
		$this->db->where(array('approval_id'=>$approval_id));
		$this->db->update('approval',$data);
		
		//Trigger an email to the originator
		
		$this->load->view('backend/external', $page_data); 		
	} 

}
