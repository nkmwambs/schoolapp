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

class Admin extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->load->library('approval');
		
		//$this->db->db_select($this->session->app);
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

    }

	function administrator(){
		if($this->session->userdata('active_login')!=1)
              redirect(base_url() , 'refresh');
		
		
		$admin = $this->db->get('admin')->result_object();
		
		$page_data['records'] = $admin;
		$page_data['page_name']  =	'administrator';
        $page_data['page_view'] = 'administrator';
        $page_data['page_title'] =	get_phrase('manage_administrators');
  		$this->load->view('backend/index', $page_data);
	}
	
	function admin($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
            $data['level']     = $this->input->post('level');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $this->db->insert('admin', $data);
            $admin_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $admin_id . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('admin', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/admin/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
            $data['level']     = $this->input->post('level');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');

            $this->db->where('admin_id', $param2);
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $param2 . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/administrator/', 'refresh');
        } else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_admin_id'] = $param2;
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('admin', array(
                'admin_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('teacher');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?teacher/teacher/', 'refresh');
        }
        $page_data['records']   = $this->db->get('admin')->result_object();
        $page_data['page_name']  = 'administrator';
        $page_data['page_view']  = 'administrator';
        $page_data['page_title'] = get_phrase('manage_administrator');
        $this->load->view('backend/index', $page_data);
    }


	 public function list_approvals($status = 0)
    {
        if ($this->session->userdata('active_login')!=1) {
            redirect(base_url(), 'refresh');
        }


        $list_approvals = $this->db->get_where('approval_request',array('status'=>$status))->result_object();

        $page_data['status'] = array('new','approved','declined','reinstated','implemented');
        $page_data['set_state'] = $status;
        $page_data['records'] = $list_approvals;
        $page_data['page_name']  =	'list_approvals';
        $page_data['page_view'] = 'administrator';
        $page_data['page_title'] =	get_phrase('list_approval_requests');
        $this->load->view('backend/index', $page_data);
    }

    function ajax_load_approval_list($status = 0){
      $list_approvals = $this->db->get_where('approval_request',array('status'=>$status))->result_object();

      $page_data['records'] = $list_approvals;
      $page_data['status'] = array('new','approved','declined','reinstated','implemented');

      echo $this->load->view('backend/administrator/ajax_list_approvals',$page_data,TRUE);
    }

	function proccess_request_approval($approval_request_id){
		
		$requestor_message 	= $this->input->post('request_message');
		$approval_action 	= $_POST['approval_action'];
		
		$success_message = $this->approval->log_request_message_on_action($approval_request_id,$requestor_message,$approval_action);
		
		$this -> session -> set_flashdata('flash_message', $success_message);

      	redirect(base_url() . 'index.php?admin/list_approvals', 'refresh');
	}

   function take_action($action,$approval_request_id){

      $this->approval->change_approval_request_status($action,$approval_request_id);

      $this->ajax_load_approval_list(0);
    }
}
