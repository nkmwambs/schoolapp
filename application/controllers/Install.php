<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/*
 *	@author 	: Joyonto Roy
 *	date		: 27 september, 2014
 *	FPS School Management System Pro
 *	http://codecanyon.net/user/FreePhpSoftwares
 *	support@freephpsoftwares.com
 */

class Install extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> database();
		$this -> load -> library('session');
	}

	/***default functin, redirects to login page if no admin logged in yet***/
	public function index() {
		//Destroy existing session if exists
		$this -> session -> sess_destroy();

		$page_data['school_name'] = $this -> db -> get_where('settings', array('type' => 'system_name')) -> row() -> description;

		$this -> load -> view('backend/install', $page_data);
	}

	function set_up_admin_user($action = "") {

		if ($action == 'create') {

			$this -> db -> trans_start();

			$this -> create_user_in_main_db($this -> input -> post());
			//Create a database
			$this -> create_database();

			//Dumb tables
			$this -> dump_db_tables();

			//Update Admin table
			$this -> update_admin_table($this -> input -> post());

			//Create a user in user table
			$this -> populate_user_table($this -> input -> post());

			//Give access to user profile/ create an entitlement
			$this -> create_an_entitlement_to_user_profile();
			//redirect(base_url().'index.php?install/set_up_system_settings','refresh');

			if ($this -> db -> trans_status() === false) {
				$this -> db -> trans_rollback();
				$this -> session -> set_flashdata('flash_message', get_phrase('An operation failed'));
			} else {
				$this -> db -> trans_commit();
				$this -> session -> set_flashdata('flash_message', get_phrase('Successful'));
			}
		}

		$page_data['page_name'] = 'user_set_up';
		$page_data['page_title'] = get_phrase('user_set_up');
		
		$this -> load -> view('backend/install/index', $page_data);
	}

	function create_database() {

		//Get count of existing databases
		$query_string = "SELECT COUNT(*) as count FROM information_schema.SCHEMATA";

		$num_of_databases = 0;

		if ($this -> db -> query($query_string)) {
			$num_of_databases_obj = $this -> db -> query($query_string) -> result_object();
			$num_of_databases = $num_of_databases_obj[0] -> count;
		}

		//Create a new database if not exist
		$this -> load -> dbforge();

		$message = "failed";

		if ($num_of_databases > 0 && !$this -> session -> db_name && $this->session->main_user_created==1) {
			if ($this -> dbforge -> create_database('schoolapp_' . $num_of_databases)) {
				//Create a session to hold the database name
				$this -> session -> set_userdata('db_name', 'schoolapp_' . $num_of_databases);
				$message = 'success';
			}
		}

		return $message;

	}

	function dump_db_tables() {

		$message = 'failed';

		if ($this -> session -> db_name && !$this -> session -> db_tables_created) {
			$db_name = $this -> session -> db_name;

			//Get the contents of the install.sql file
			$sql = file_get_contents('install/assets/install.sql');

			$this -> db -> db_select($db_name);

			if ($this -> db -> query($sql)) {
				$this -> session -> set_userdata('db_tables_created', 1);
				$message = 'success';
			}

			//$this->db->db_select('schoolapp');
		}

		return $message;

	}

	function update_admin_table($post_array) {

		$message = "failed";

		//Recieve post input
		$first_name = $post_array['first_name'];
		$last_name = $post_array['last_name'];
		$email = $post_array['email'];
		$gender = $post_array['sex'];
		$phone = $post_array['phone'];
		//$first_name = $post_array['password'];

		if ($this -> session -> db_tables_created == 1) {
			$data['name'] = $first_name . ' ' . $last_name;
			$data['email'] = $email;
			$data['birthday'] = "0000-00-00";
			$data['sex'] = $gender;
			$data['phone'] = $phone;
			$data['level'] = 0;
			$data['is_approver'] = 1;

			$db_name = $this -> session -> db_name;

			$this -> db -> db_select($db_name);

			//Count number of record and update if one exists else create
			$count_admins = $this -> db -> get('admin') -> num_rows();

			if ($count_admins == 0) {
				if ($this -> db -> insert('admin', $data)) {
					
					$message = "success";
				}
			} else {
				if ($this -> db -> update('admin', $data)) {
					$message = "success";
				}
			}

			//$this->db->db_select('schoolapp');

		}

		return $message;

	}

	private function create_user_in_main_db($post_array) {

		$data['firstname'] = $post_array['first_name'];
		$data['lastname'] = $post_array['last_name'];
		$data['email'] = $post_array['email'];
		$data['phone'] = $post_array['phone'];
		$data['password'] = md5($post_array['password']);

		$data['app_id'] = 1;
		$data['auth'] = 1;

		if($this -> db -> insert('user', $data)){
			$this->session->set_userdata('main_user_created',1);
		}
	}

	private function populate_user_table($post_array) {

		$message = "failed";

		if ($this -> session -> db_tables_created == 1) {
			//Recieve post input
			$data['firstname'] = $post_array['first_name'];
			$data['lastname'] = $post_array['last_name'];
			$data['email'] = $post_array['email'];
			$data['phone'] = $post_array['phone'];
			$data['password'] = md5($post_array['password']);

			$data['app_id'] = 1;
			$data['auth'] = 1;

			$db_name = $this -> session -> db_name;

			$this -> db -> db_select($db_name);

			//Count number of record and update if one exists else create
			$user = $this -> db -> get('user') -> num_rows();

			// $insert_id=0;

			if ($user == 0) {
				$data['login_type_id'] = 1;
				$data['profile_id'] = 1;
				$data['type_user_id'] = 1;

				if ($this -> db -> insert('user', $data)) {
					//get the last inserted Id
					//$insert_id=$this->db->insert_id();
					$message = "success";
				}
			} else {
				if ($this -> db -> update('user', $data)) {
					//$insert_id=$count_admins->user_id;
					$message = "success";
				}
			}

			//Inject a trigger on the user table

			//$this->create_user_in_main_schoolapp_db($db_name,$post_array);

			$this -> db -> db_select('schoolapp');

			//Create  the user in schoolapp database
			// if($message=='success'){
			//
			// $user_in_main_schoolapp=$this->db->get_where('user', array('user_id'=>$insert_id))->num_row();
			//
			// if($user_in_main_schoolapp==0)
			// {
			// $data['email_notify']=1;
			// $data['app_id']=98;
			//
			// if($this->db->insert('user',$data)){
			//
			// //
			// }
			//
			// }
			// }

		}

		//return $main_schooldb;

	}

	
	function create_an_entitlement_to_user_profile() {

	}

	function set_up_system_settings() {
		//$this->session->set_userdata('installation_progress','system_set_up');
		$page_data['page_name'] = 'set_up_system_settings';
		$page_data['page_title'] = get_phrase('set_up_system_settings');
		$this -> load -> view('backend/install/index', $page_data);
	}

}
