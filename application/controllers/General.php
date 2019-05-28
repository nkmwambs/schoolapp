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
		
		$msg = "Approval Failed. Someone has already approved this request";
		
		//Check if already approved
		$approval_status = $this->db->get_where('approval',
		array('approval_id'=>$approval_id))->row()->approval_status;
		
		if($approval_status == 0){
			$data['approval_status'] = 1;
			$data['lastmodifieddate'] = date('Y-m-d h:i:s');
			$this->db->where(array('approval_id'=>$approval_id));
			$this->db->update('approval',$data);
			
			$msg = "Approval Successful";
		}		
		
		//Trigger an email to the originator
		$this->email_model->approval_confirmation($approval_id);
		
		$page_data['message'] = $msg;
		
		$this->load->view('backend/external', $page_data); 		
	} 

}
