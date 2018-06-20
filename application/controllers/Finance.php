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

class Finance extends CI_Controller
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

    /**
	 * Fees structure Management
	 */
	 
	 function fees_structure($param1 = '', $param2 = ''){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
			$data['class_id']   =   $this->input->post('class_id');
			$data['yr']   =   $this->input->post('yr');
			$data['term']   =   $this->input->post('term');
			
			//Check if the Fees structure Exists
			
			$chk = $this->db->get_where('fees_structure',array('name'=>$this->input->post('name')))->num_rows();
			
			if($chk===0){
				$this->db->insert('fees_structure' , $data);
            	$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));	
			}else{
				$this->session->set_flashdata('flash_message' , get_phrase('record_already_exists'));
			}
			
            
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
		
		if($param1=='clone'){
			$data['name']   =   $this->input->post('name');
			$data['class_id']   =   $this->input->post('class_id');
			$data['yr']   =   $this->input->post('yr');
			$data['term']   =   $this->input->post('term');
			
			//Check if the Fees structure Exists
			
			$chk = $this->db->get_where('fees_structure',array('name'=>$this->input->post('name')))->num_rows();
			
			$insert_id = 0;
			
			if($chk===0){
				$this->db->insert('fees_structure' , $data);
				$insert_id = $this->db->insert_id();	
            	$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));	
			}else{
				$this->session->set_flashdata('flash_message' , get_phrase('record_already_exists'));
			}
			
			/**Get original fees structure details**/
			$fees_structure_details = $this->db->select("name,income_category_id,amount")->get_where("fees_structure_details",array("fees_id"=>$param2));
			if($fees_structure_details->num_rows() > 0){
				
				$new_details =array();
				
				foreach($fees_structure_details->result_array() as $detail){
					
					$new_details = $detail;
					$new_details['fees_id'] = $insert_id;
										
					$this->db->insert("fees_structure_details",$new_details);
				}	

			}

		}
		
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
			$data['class_id']   =   $this->input->post('class_id');
			//$data['income_category_id']   =   $this->input->post('income_category_id');
			$data['yr']   =   $this->input->post('yr');
			$data['term']   =   $this->input->post('term');
			//$data['amount']   =   $this->input->post('amount');
			
            $this->db->where('fees_id' , $param2);
            $this->db->update('fees_structure' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
        if ($param1 == 'delete') {
            $this->db->where('fees_id' , $param2);
            $this->db->delete('fees_structure');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
		$page_data['page_name']  = 'fees_structure';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('fees_structure');
        $this->load->view('backend/index', $page_data);	
	}

	function fees_structure_details($param1 = '', $param2 = ''){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
			$data['fees_id']   =   $this->input->post('fees_id');
			$data['income_category_id']   =   $this->input->post('income_category_id');
			$data['amount']   =   $this->input->post('amount');

 			$this->db->insert('fees_structure_details' , $data);
			
			//Adjust Existing Invoices -- All student in the same 
			$structure = $this->db->get_where('fees_structure',array('fees_id'=>$this->input->post('fees_id')))->row();
			
			$class_id = $structure->class_id;
			$yr = $structure->yr;
			$term = $structure->term;
			
			$tot_fees = $this->db->select_sum('amount')->get_where('fees_structure_details',array('fees_id'=>$this->input->post('fees_id')))->row()->amount;
			
			//All student affected by the structure
			
			$students = $this->db->get_where('student',array('class_id'=>$class_id))->result_object();
			
			foreach($students as $inv):

				if($this->db->get_where('invoice',array('student_id'=>$inv->student_id,'yr'=>$yr,'term'=>$term))->num_rows()>0){
					$this->db->where(array('student_id'=>$inv->student_id,'yr'=>$yr,'term'=>$term));
					$data2['amount'] = $tot_fees;
					$this->db->update('invoice',$data2);
				}
				
			endforeach;

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/fees_structure');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
			$data['income_category_id']   =   $this->input->post('income_category_id');
			$data['amount']   =   $this->input->post('amount');
			
            $this->db->where('detail_id' , $param2);
            $this->db->update('fees_structure_details' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/fees_structure');
        }
        if ($param1 == 'delete') {
            $this->db->where('detail_id' , $param2);
            $this->db->delete('fees_structure_details');
			
			//Delete all invoice effects
			$this->db->where('detail_id' , $param2);
			 $this->db->delete('invoice_details');
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/fees_structure');
        }
		$page_data['page_name']  = 'fees_structure_details';
        $page_dat['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('detailed_fees_structure');
        $this->load->view('backend/index', $page_data);	
	}

	/** Invoice Management **/

}
