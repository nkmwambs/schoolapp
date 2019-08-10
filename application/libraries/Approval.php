<?php

class Approval{
	
	private $CI = null;
	
	public function __construct(){
		
		$this->CI =& get_instance();
	
	}
	
	public function raise_approval_request($record_type,$record_type_primary_key,$request_type,$requestor_initial_message,$requestor_user_id = ""){
		
		//Get the record type id of the passed record type
		$record_type_id = $this->_get_record_type_id($record_type);
		
		//Get the request type id from the passed request type name
		$request_type_id = $this->_get_request_type_id($request_type);
		
		// Create an approval request record
		$last_approval_request_id = $this->_create_approval_request_record($record_type_id,$record_type_primary_key,$request_type_id,$requestor_user_id ="");
		
		// Log the initial request message
		$this->_log_request_message($last_approval_request_id,$requestor_initial_message,$requestor_user_id = "");
		
		//Update the record origin table e.g. Invoice with the id of the created request record
		$this->_update_record_origin_table($record_type,$record_type_primary_key,$last_approval_request_id);
		
		//Send an email to the approvers and copy the sender
		$this->_email_request($request_type,$last_approval_request_id);
	}
	
	private function _get_record_type_id($record_type){
		
		$record_type_id = $this->CI->db->get_where('record_type',
		array('name'=>$record_type))->row()->record_type_id;
		
		return $record_type_id;
	}
	
	private function _get_request_type_id($request_name){
		
		$request_type_id = $this->CI->db->get_where('request_type',
		array('name'=>$request_name))->row()->request_type_id;
		
		return $request_type_id;
	}
	
	private function _create_approval_request_record($record_type_id,$record_type_primary_key,$request_type_id,$requestor_user_id = ""){
		
		$approval_request_record_data['record_type_id'] 		=  	$record_type_id;
		$approval_request_record_data['record_type_primary_id'] =  	$record_type_primary_key;
		$approval_request_record_data['request_type_id'] 		=  	$request_type_id;
		$approval_request_record_data['status'] 				=  	0; //New request
		$approval_request_record_data['created_date'] 			=  	date('Y-m-d');
		
		//If the $requestor_user_id is empty use the logged user session user id
		$approval_request_record_data['created_by']				= 	$requestor_user_id == ""?$this->CI->session->login_user_id:$requestor_user_id;
		$approval_request_record_data['last_modified_by']		= 	$requestor_user_id == ""?$this->CI->session->login_user_id:$requestor_user_id;
		
		$approval_request_record_data['approved_by']			=  	0;// Not yet approved
		
		$this->CI->db->insert('approval_request',$approval_request_record_data);
		
		$last_approval_request_id = $this->CI->db->insert_id();
		
		return $last_approval_request_id;
	}
	
	private function _log_request_message($approval_request_id,$requestor_message,$sender_id = ""){
		
		$request_message_data['approval_request_id'] 	= $approval_request_id;
		
		//Use login session when the sender id is not specified
		$request_message_data['sender_id']				= $sender_id==""?$this->CI->session->login_user_id:$sender_id;
		
		$request_message_data['recipient_id']				= 0;//New request message has no specific receiver
		$request_message_data['message']					= $requestor_message;
		$request_message_data['created_date']				= date('Y-m-d');
		
		$this->CI->db->insert('approval_request_messaging',$request_message_data);
	}
	
	private function _update_record_origin_table($record_type,$record_type_primary_key,$last_approval_request_id){
		
		//last_approval_request_id is present in all origin tables e.g. Invoice, student, parent, transaction, reconcile
		$record_origin_table_data['last_approval_request_id'] = $last_approval_request_id;
		$this->CI->db->where(array($record_type."_id"=>$record_type_primary_key));
		$this->CI->db->update($record_type,$record_origin_table_data);
	}
	
	private function _email_request($record_type,$last_approval_request_id){
		
	}
	
	public function log_request_message_on_action($approval_request_id,$requestor_message,$approval_action = "approve"){
		
		//Approval action are: approve, decline, post_comment 
		
		$this->_log_request_message($approval_request_id,$requestor_message);
		
		$success_message = get_phrase('no_approval_action_performed');
		
		if($approval_action == 'post_comment'){
	        $success_message = get_phrase('comment_added_successful');
	     }elseif ($approval_action == 'approve') {
	         $this->change_approval_request_status('approve',$approval_request_id);
	         $success_message = get_phrase('approval_successful');
	     }elseif($approval_action == 'decline'){
	         $this->change_approval_request_status('decline',$approval_request_id);
	         $success_message = get_phrase('decline_successful');
	     }
		 
		 return $success_message;
		
	}
	
	public function change_approval_request_status($approval_action,$approval_request_id){
		$data['status'] = 0;

      //Request processing history variables
      $data['last_modified_date'] = date('Y-m-d');
      $data['last_modified_by'] = $this->CI->session->login_user_id;
      $data['approved_by']  = $this->CI->session->login_user_id;

      //Change request status
      if($approval_action == 'approve'){
        $data['status'] = 1;
      }elseif($approval_action == 'decline'){
        $data['status'] = 2;
      }elseif($approval_action == 'reinstate'){
        $data['status'] = 3;
      }

      //Update the request based on status
      $this->CI->db->where(array('approval_request_id'=>$approval_request_id));
      $this->CI->db->update('approval_request',$data);

      //If any record updated send an email to the requestor
      if($this->CI->db->affected_rows()>0){
        $this->_email_approval_message($approval_request_id);
      }
	}

	private function _email_approval_message($approval_request_id){
	 	
	 }	
	
	public function check_record_current_approval_status(){
		
	}
	
}
