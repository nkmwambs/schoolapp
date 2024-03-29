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

class Messages extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		//$this->db->db_select($this->session->app);
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

    }

  
      /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?messages/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?messages/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
		 $page_data['page_view']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

	function bulksms(){
		if ($this->session->userdata('active_login') != 1)
           redirect('login', 'refresh');	
		
		//Africa is Talking Fetch Messages
		
		// $username = $this->db->get_where('settings',array('type'=>'africastalking_user'))->row()->description;
		// $apiKey = $this->db->get_where('settings',array('type'=>'africastalking_api_id'))->row()->description;
		
		// $this->config->set_item('username', $username);
		// $this->config->set_item('apiKey', $apiKey);
		
		// $this->load->library('AfricasTalking');
		
		//try{
		//$page_data['outbox'] = $this->sms_model->fetch_messages_africastalking();//$this->africastalking->fetchMessages(0);
		// }catch(AfricasTalkingGatewayException $e){
		// 	$page_data['outbox'] = (object)array();
		// }
		//$page_data['outbox'] = $this->sms_reports(); 
		
		$page_data['page_name']  = 'bulksms';
		$page_data['page_view']  = 'message';
        $page_data['page_title'] = 'Bulk SMS';
        $this->load->view('backend/index', $page_data);		
	}
	
	function sms_reports(){
		$data['message_thread_code'] = "None";
		$data['message'] = json_encode($_POST);
		$data['sender'] = "None";
		$data['timestamp'] = current_time();
		$this->db->insert('message',$data);
	}

	function send_bulksms(){
		
	    $recipients = $this->input->post('reciever');//implode(',',$this->input->post('reciever'));
		$message = $this->input->post('message');
	    $response = $this->sms_model->send_sms($message,$recipients);
		echo json_encode($response);
		
	}
	
	function sms_delivery(){
		$data['message_id'] 	= $_POST['id'];
		$data['status'] 		= $_POST['status'];
		$data['phoneNumber'] 	= $_POST['phoneNumber'];
		$data['networkCode'] 	= $_POST['networkCode'];
		$data['failureReason'] 	= $_POST['failureReason'];
		$data['retryCount'] 	= 0;//$_POST['retryCount'];//Int
		
		$this->db->insert('sms_delivery',$data);		
		
	}
 
}
