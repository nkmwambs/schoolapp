<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

    /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
     */

class Approval extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }


    public function list_approvals($status = 0)
    {
        if ($this->session->userdata('active_login')!=1) {
            redirect(base_url(), 'refresh');
        }


        $list_approvals = $this->db->get_where('approval_request',array('status'=>$status))->result_object();

        $page_data['status'] = array('new','approved','declined','reinstated');
        $page_data['set_state'] = $status;
        $page_data['records'] = $list_approvals;
        $page_data['page_name']  =	'list_approvals';
        $page_data['page_view'] = 'approval';
        $page_data['page_title'] =	get_phrase('list_approval_requests');
        $this->load->view('backend/index', $page_data);
    }

    function ajax_load_approval_list($status = 0){
      $list_approvals = $this->db->get_where('approval_request',array('status'=>$status))->result_object();

      $page_data['records'] = $list_approvals;
      $page_data['status'] = array('new','approved','declined','reinstated');

      echo $this->load->view('backend/approval/ajax_list_approvals',$page_data,TRUE);
    }

    function change_approval_request_status($action,$approval_request_id){
      $data['status'] = 0;

      //Request processing history variables
      $data['last_modified_date'] = date('Y-m-d');
      $data['last_modified_by'] = $this->session->login_user_id;
      $data['approved_by']  = $this->session->login_user_id;

      //Change request status
      if($action == 'approve'){
        $data['status'] = 1;
      }elseif($action == 'decline'){
        $data['status'] = 2;
      }elseif($action == 'reinstate'){
        $data['status'] = 3;
      }

      //Update the request based on status
      $this->db->where(array('approval_request_id'=>$approval_request_id));
      $this->db->update('approval_request',$data);

      //If any record updated send an email to the requestor
      if($this->db->affected_rows()>0){
        //$this->Email_model->requested_processing_email_template($approval_request_id);
      }
    }

    function take_action($action,$approval_request_id){

      $this->change_approval_request_status($action,$approval_request_id);

      $this->ajax_load_approval_list(0);
    }

    function add_request_comment($approval_request_id){


        $message_data['approval_request_id'] = $approval_request_id;
        $message_data['sender_id'] = $this->session->login_user_id;

        $recipient_object =  $this->db->get_where('approval_request_messaging',
        array('approval_request_id'=>$approval_request_id,'recipient_id'=>0));

        $message_data['recipient_id'] = $recipient_object->num_rows()>0?$recipient_object->row()->recipient_id:0;
        $message_data['message'] = $this->input->post('request_message');
        $message_data['created_date'] = date('Y-m-d');

        $this->db->insert('approval_request_messaging',$message_data);

      if(isset($_POST['post_comment'])){
        $this -> session -> set_flashdata('flash_message', get_phrase('comment_added_successful'));
      }elseif (isset($_POST['approve'])) {
          $this->change_approval_request_status('approve',$approval_request_id);
          $this -> session -> set_flashdata('flash_message', get_phrase('approval_successful'));
      }elseif(isset($_POST['decline'])){
          $this->change_approval_request_status('decline',$approval_request_id);
          $this -> session -> set_flashdata('flash_message', get_phrase('decline_successful'));
      }


      redirect(base_url() . 'index.php?approval/list_approvals', 'refresh');
    }
}
