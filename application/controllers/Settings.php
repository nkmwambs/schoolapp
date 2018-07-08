<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
     */

class Settings extends CI_Controller
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
		
	  function school_settings($param1="",$param2=""){
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
		
		if($param1==='add_term'){
			
			$data['name']=$this->input->post('term');
			$data['name_number']=$this->input->post('term_number');
			
			$this->db->insert('terms',$data);
			
            $this->session->set_flashdata('flash_message' , get_phrase('term_added'));
            redirect(base_url() . 'index.php?admin/school_settings/', 'refresh');
		}
		if($param1==='edit_term'){
			$this->db->where(array('terms_id'=>$param2));
			
			$data['name'] = $this->input->post('term');
			$data['term_number'] = $this->input->post('term_number');
			
			$this->db->update('terms',$data);
			
			$this->session->set_flashdata('flash_message' , get_phrase('term_editted'));
            redirect(base_url() . 'index.php?admin/school_settings/', 'refresh');
		}
		if($param1=='delete_term'){
			$this->db->where(array('terms_id'=>$param2));
			
			$this->db->delete('terms');
			
			$this->session->set_flashdata('flash_message' , get_phrase('term_deleted'));
            redirect(base_url() . 'index.php?admin/school_settings/', 'refresh');
		}
		
		if($param1==='add_relationship'){
			$msg = get_phrase('duplicate_name');
			$data['name']=$this->input->post('name');

			if($this->db->get_where("relationship",array("name"=>$this->input->post('name')))->num_rows() === 0){
				$msg = get_phrase('record_added');
				$this->db->insert('relationship',$data);
			}
			
			
            $this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?admin/school_settings/', 'refresh');
		}
		
		if($param1=='delete_relationship'){
			$this->db->where(array('relationship_id'=>$param2));
			
			$this->db->delete('relationship');
			
			$this->session->set_flashdata('flash_message' , get_phrase('record_deleted'));
            redirect(base_url() . 'index.php?admin/school_settings/', 'refresh');
		}
		
		if($param1==='edit_relationship'){
			
			$msg = get_phrase('duplicate_record');
			
			if($this->db->get_where("relationship",array("name"=>$this->input->post('name')))->num_rows() === 0){
				$this->db->where(array('relationship_id'=>$param2));
				$data['name'] = $this->input->post('name');
				$this->db->update('relationship',$data);
				$msg = get_phrase('record_edited');
			}		
			
			$this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?admin/school_settings/', 'refresh');
		}
		
			    	
		$page_data['terms'] = $this->db->get('terms')->result_object();
        $page_data['page_name']                 = 'school_settings';
		$page_data['page_view'] = "settings";
        $page_data['page_title']                = get_phrase('school_settings');
        $this->load->view('backend/index', $page_data);	
	}

	

}	