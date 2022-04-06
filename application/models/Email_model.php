<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

	function account_opening_email($account_type = '' , $email = '' ,$password = '')
	{
		$system_name	=	$this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;

		$email_msg		=	"Welcome to ".$system_name."<br />";
		$email_msg		.=	"Your account type : ".$account_type."<br />";
		$email_msg		.=	"Your login password : ".$password."<br />";
		$email_msg		.=	"Login Here : ".base_url()."<br />";

		$email_sub		=	"Account opening email";
		$email_to		=	$email;

		$this->do_email($email_msg , $email_sub , $email_to);
	}

	function password_reset_email($new_password = '' , $account_type = '' , $email = '')
	{
		$query			=	$this->db->get_where('user' , array('email' => $email));
		if($query->num_rows() > 0)
		{

			$email_msg	=	"Your account type is : ".ucfirst($account_type)."<br />";
			$email_msg	.=	"Your password is : ".$new_password."<br />";

			$email_sub	=	"Password reset request";
			$email_to	=	$email;
			$this->do_email($email_msg , $email_sub , $email_to);
			return true;
		}
		else
		{
			return false;
		}
	}

	function period_reports($user_id){
		$email_msg	= "Test email";

		$email_sub	=	"Test Email";
		$email_to	=	$this->db->get_where('user',array('user_id'=>$user_id))->row()->email;
		$this->do_email($email_msg , $email_sub , $email_to);
	}

	function requested_processing_email_template($approval_request_id){
		//Variables to be used in the mail template

		// $this->db->select(array('record_type.name as record_type',
		// 'user.name as requestor_name','user.email as requestor_email',
		// 'approval_request.status','request_type.name as request_type','approved_by'));
		// $this->db->join('request_type','request_type.request_type_id=approval_request.request_type_id');
		// $this->db->join('user','user.user_id=approval_request.created_by');
		// $this->db->join('user','user.user_id=approval_request.approved_by');
		// $this->db->join('record_type','record_type.record_type_id=approval_request.record_type_id');
		// $approval_request = $this->db->get_where('approval_request',array('approval_request_id'=>$approval_request_id))->row();
		//
		// $requestor_name = $approval_request->requestor_name;
		// $requestor_email =  $approval_request->requestor_email;
		// $record_type = $approval_request->record_type;
		// $new_status =  $approval_request->status;
		// $request_type = $approval_request->request_type;
		// $approver_name = $this->db->get_where('user',array('user_id'=>$approval_request))->row()->name;
		//
		// $email_msg	= "Dear ".$requestor_name.", <br/>";
		// $email_msg	.= "We are happy to inform you that your request has been ".$new_status.".<br/>";
		// $email_msg	.= "Kindly refer to the details below:<br/>";
		// $email_msg	.= "Record type: ".$record_type."<br/>";
		// $email_msg	.= "Request type: ".$request_type."<br/>";
		// $email_msg	.= "Status: ".$new_status."<br/>";
		//
		// $email_msg	.= "If you have any query please reach the approver, ".$approver_name."<br/>";

		$email_sub	=	"Request processing notification";
		$email_msg = "Testing";
		$requestor_email = "nkmwambs@gmail.com";
		$this->do_email($email_msg , $email_sub , $requestor_email);
	}

	function approval_confirmation($approval_id){

			$query			=	$this->db->get_where('approval' , array('approval_id' => $approval_id));

			$approver_object = $this->db->get_where('admin',array('is_approver'=>1))->result_array();
			$approvers_emails_array = array_column($approver_object, 'email');

			$originator = $this->db->get_where('user',array('user_id'=>$query->row()->createdby))->row()->email;

			$approvers_emails_array[] = $originator;

			$email_msg	= "This request has been approved successfully<br/>";
			$email_msg	.=	"<span style='background-color:yellow;'>".$query->row()->approval_detail."</span><br/>";

			$email_sub	=	"Request approved successfully";
			$email_to	=	$approvers_emails_array;
			$this->do_email($email_msg , $email_sub , $email_to);
	}

	function approval_request($approval_id){

			$approver_object = $this->db->get_where('admin',array('is_approver'=>1))->result_array();
			$approvers_emails_array = array_column($approver_object, 'email');

			$query			=	$this->db->get_where('approval' , array('approval_id' => $approval_id));

			$email_msg	=	$query->row()->approval_detail;
			$email_msg .= 	"<p>To approve click <a href='".base_url()."index.php?general/external_approval/".$approval_id."'>this</a> link</p>";

			$email_sub	=	"Approval Request";
			$email_to	=	$approvers_emails_array;
			$this->do_email($email_msg , $email_sub , $email_to);

	}

	/***custom email sender****/
	function do_email($msg=NULL, $sub=NULL, $to=NULL, $from=NULL)
	{

		$config = array();
			$config['useragent']	= "CodeIgniter";
			$config['mailpath']		= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
			$config['protocol']		= "smtp";
			$config['smtp_host']	= "localhost";
			$config['smtp_port']	= "25";
			$config['mailtype']		= 'html';
			$config['charset']		= 'utf-8';
			$config['newline']		= "\r\n";
			$config['wordwrap']		= TRUE;

				$this->load->library('email');

				$this->email->initialize($config);

		$system_name	=	$this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
		if($from == NULL)
			$from		=	$this->db->get_where('settings' , array('type' => 'system_email'))->row()->description;

		$this->email->from($from, $system_name);
		$this->email->from($from, $system_name);
		$this->email->to($to);
		$this->email->subject($sub);

		$msg	=	$msg."<br /><br /><br /><br /><br /><br /><br /><hr /><center><a href=\"https://techsys-kenya.com/school-management-system-pro\">&copy; 2013 School Management System Pro</a></center>";
		$this->email->message($msg);

		$this->email->send();

		log_message('error',$this->email->print_debugger());
	}
}
