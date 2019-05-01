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

class Account extends CI_Controller
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

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
		
        if ($param1 == 'update_profile_info') {
            $data['firstname']  = $this->input->post('firstname');
			$data['lastname']  = $this->input->post('lastname');
            $data['email'] = $this->input->post('email');
            
			$data2['name']  = $this->input->post('firstname')." ".$this->input->post('lastname');
            $data2['email'] = $this->input->post('email');
			
            $this->db->where('user_id', $this->session->userdata('login_user_id'));
            $this->db->update('user', $data);
			
			$this->db->where($this->session->login_type.'_id', $this->session->userdata('type_login_user_id'));
            $this->db->update($this->session->login_type, $data2);
			
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/'.$this->session->login_type.'_image/' . $this->session->userdata('type_login_user_id') . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?account/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('user', array(
                'user_id' => $this->session->userdata('login_user_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('user_id', $this->session->userdata('user_id'));
                $this->db->update('user', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?account/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
		$page_data['page_view']  = 'account';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
   
   	function change_password($param1="",$param2=""){
		    $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');		
			
			$login_type_id = $this->db->get_where("login_type",array("name"=>$param1))->row()->login_type_id;
						
            if ($data['new_password'] == $data['confirm_new_password']) {
                	
                $this->db->where(array('type_user_id'=> $param2,"login_type_id"=>$login_type_id));
				
                $this->db->update('user', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
			//exit;
            redirect(base_url() . 'index.php?'.$param1.'/'.$param1.'/', 'refresh');
				
	}
	
	function assign_profile($param1="",$param2=""){
			
		/**Check if exists**/
		$id = $param1.'_id';
		//$check_if_exists = $this->db->get_where($param1,array($id=>$param2))->num_rows();
		
		$login_type_id = $this->db->get_where("login_type",array("name"=>$param1))->row()->login_type_id;
		
		$exists = $this->db->get_where("user",array("type_user_id"=>$param2,'login_type_id'=>$login_type_id))->num_rows();
		
		if($exists == 0) {
			
			$record = $this->db->get_where($param1,array($id=>$param2))->row();
			//extract($record);
			
			$name_array = explode(" ", $record->name);
			
			$data['firstname'] = array_shift($name_array);
			$data['lastname'] = implode(" ", $name_array);
			$data['email'] = $record->email;
			$data['password'] = "default";
			$data['phone'] = $record->phone;
			$data['login_type_id'] = $login_type_id;//$this->db->get_where("login_type",array("name"=>$param1))->row()->login_type_id;
			$data['profile_id'] = $this->input->post('profile_id');
			$data['type_user_id'] = $param2;
			$data['auth'] = 1;
			
			//$msg = get_phrase("failed");
			
			
				$this->db->insert("user",$data);
				//$msg = get_phrase("success");
		}else{
			
				
			//Asign A Profile
			$data['profile_id'] = $this->input->post('profile_id');
			
			//$login_type_id = $this->db->get_where("login_type",array("name"=>$param1))->row()->login_type_id;
			
			$this->db->where(array('type_user_id'=> $param2,"login_type_id"=>$login_type_id));
			
			$this->db->update('user', $data);
			
			
		}
		
		if($this->db->affected_rows() > 0 ){
				$this->session->set_flashdata('flash_message', get_phrase('profile_updated'));
			}else{
				$this->session->set_flashdata('flash_message', get_phrase('update_failure'));
		}
		
		$link = $param1 == 'admin'?"admin/administrator":"teacher/teacher";
		
		redirect(base_url() .'index.php?'.$link.'/', 'refresh');
	}

}
