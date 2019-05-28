<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reminders extends CI_Controller {
	public function __construct() {
		parent::__construct(); 
		$this->load->database();
    	$this->load->library('email');
    	$this->load->model('Email_model');
		$this->load->helper("multi_language");
  	}
  	
  	public function index(){
    	if(!is_cli())
	  	{
	     	echo "This script can only be accessed via the command line" . PHP_EOL;
	      	return;
	  	}
	  	
			//Get All Active Users whose notify email is set to on and have not
			$users  = $this->db->get_where("user",array("auth"=>1,"email_notify"=>1))->result_object();  
			
			foreach($users as $user){
				$this->reminder_notification($user->user_id);
			}
			
	          
  	}
  
  
  	function reminder_notification($user_id=""){
		$this->email_model->period_reports($user_id);
 	}
  	
}