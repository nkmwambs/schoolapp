<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    /*
     *	@author 	: Nicodemus Karisa Mwambire
     *	date		: 16th June, 2018
     *	Techsys School Management System
     *	https://www.techsysolutions.com
     *	support@techsysolutions.com
	 *  
     */

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->config->load('localrepositoryvars');
		$this->load->database();
        $this->db->db_select($this->config->item('db_prefix').'_default',true);
        
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {

      if ($this->session->userdata('active_login') == 1)
          redirect(base_url() . 'index.php?dashboard', 'refresh');

        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');

        if ($this->session->userdata('teacher_login') == 1)
            redirect(base_url() . 'index.php?teacher/dashboard', 'refresh');

        if ($this->session->userdata('student_login') == 1)
            redirect(base_url() . 'index.php?student/dashboard', 'refresh');

        if ($this->session->userdata('parent_login') == 1)
            redirect(base_url() . 'index.php?parents/dashboard', 'refresh');

        $this->load->view('backend/login');
    }

    //Ajax login function
    function ajax_login() {
        $response = array();

        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        $password = $_POST["password"];
        $response['submitted_data'] = $_POST;

        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '') {
        $credential = array('email' => $email, 'password' => md5($password),"auth"=>'1');

        // Checking login credential for admin
        $query = $this->db->get_where('user', $credential);
        if ($query->num_rows() > 0) {
            
						
			//Switch App database session
			$this->session->set_userdata('app', $this->config->item('db_prefix').'_app'.$query->row()->app_id);
			
			$this->db->db_select('school_app1');
			
			
			$row = $this->db->get_where('user',array('email'=>$query->row()->email));
			
            $login_type = $this->db->get_where("login_type",array("login_type_id"=>$row->login_type_id))->row()->name;
            $this->session->set_userdata('active_login', '1');
            $this->session->set_userdata('login_user_id', $row->user_id);
            $this->session->set_userdata('login_firstname', $row->firstname);
            $this->session->set_userdata('login_lastname', $row->lastname);
            $this->session->set_userdata('login_email', $row->email);
            $this->session->set_userdata('login_type_id', $row->login_type_id);
            $this->session->set_userdata('login_profile', $row->profile_id);
            $this->session->set_userdata('profile_id', $row->profile_id);
			
			$this->session->set_userdata('login_type', $login_type);
// 			
			$this->session->set_userdata('profile', 
				$this->db->get_where('profile',array('profile_id'=>$row->profile_id))->row()->name);
				
			// $label = $login_type.'_id';
// 			
			// $type_table_id = $this->db->get_where($login_type,
			// array("email"=>$row->email))->row()->$label;
// 			
			$this->session->set_userdata('type_login_user_id',  $type_table_id);
			
			
            return 'success';
        }
		
        return 'invalid';
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function ajax_forgot_password()
    {
        $resp                   = array();
        $resp['status']         = 'false';
        $email                  = $_POST["email"];
        $reset_account_type     = '';
        //resetting user password here
        $new_password           =   substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('admin' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'admin';
            $this->db->where('email' , $email);
            $this->db->update('admin' , array('password' => $new_password));
            $resp['status']         = 'true';
        }
        // Checking credential for student
        $query = $this->db->get_where('student' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'student';
            $this->db->where('email' , $email);
            $this->db->update('student' , array('password' => $new_password));
            $resp['status']         = 'true';
        }
        // Checking credential for teacher
        $query = $this->db->get_where('teacher' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'teacher';
            $this->db->where('email' , $email);
            $this->db->update('teacher' , array('password' => $new_password));
            $resp['status']         = 'true';
        }
        // Checking credential for parent
        $query = $this->db->get_where('parent' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'parent';
            $this->db->where('email' , $email);
            $this->db->update('parent' , array('password' => $new_password));
            $resp['status']         = 'true';
        }

        // send new password to user email
        $this->email_model->password_reset_email($new_password , $reset_account_type , $email);

        $resp['submitted_data'] = $_POST;

        echo json_encode($resp);
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}
