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

class Install extends CI_Controller
{
    function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->library('session');
    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        //Destroy existing session if exists
        $this->session->sess_destroy();

        $page_data['school_name'] = $this->db->get_where('settings',array('type'=>'system_name'))->row()->description;

        $this->load->view('backend/install',$page_data);
    }

    function set_up_admin_user($action = ""){

      if($action == 'create'){

          //Create a database
          $this->create_database();

          //Dumb tables
          $this->dump_db_tables();

          //Update Admin table
          $this->update_admin_table($this->input->post());

          //Create a user in user table
          $this->populate_user_table();

          //Give access to user profile/ create an entitlement
          $this->create_an_entitlement_to_user_profile();
          //redirect(base_url().'index.php?install/set_up_system_settings','refresh');
      }


      $page_data['page_name'] = 'user_set_up';
      $page_data['page_title'] = get_phrase('user_set_up');
      $this->load->view('backend/install/index',$page_data);
    }


    function create_database(){

      //Get count of existing databases
      $query_string = "SELECT COUNT(*) as count FROM information_schema.SCHEMATA";

      $num_of_databases = 0;

      if($this->db->query($query_string)){
          $num_of_databases_obj = $this->db->query($query_string)->result_object();
          $num_of_databases = $num_of_databases_obj[0]->count;
      }

      //Create a new database if not exist
      $this->load->dbforge();

      $message = "failed";

      if($num_of_databases > 0 && !$this->session->db_name){
        if ($this->dbforge->create_database('schoolapp_'.$num_of_databases))
        {
            //Create a session to hold the database name
            $this->session->set_userdata('db_name','schoolapp_'.$num_of_databases);
            $message =  'success';
        }
      }

      return $message;

    }

    function dump_db_tables(){

      $message =  'failed';

      if($this->session->db_name && !$this->session->db_tables_created){
          $db_name = $this->session->db_name;

          //Get the contents of the install.sql file
          $sql = file_get_contents('install/assets/install.sql');

          $this->db->db_select($db_name);

          if($this->db->query($sql)){
            $this->session->set_userdata('db_tables_created',1);
            $message =  'success';
          }

          $this->db->db_select('schoolapp');
      }

      return $message;

    }

    function update_admin_table($post_array){

      $message = "failed";

      //Recieve post input
      $first_name = $post_array['first_name'];
      $last_name = $post_array['last_name'];
      $email = $post_array['email'];
      $gender = $post_array['sex'];
      $phone = $post_array['phone'];
      //$first_name = $post_array['password'];

      if($this->session->db_tables_created == 1){
        $data['name'] = $first_name.' '.$last_name;
        $data['email'] = $email;
        $data['birthday'] = "0000-00-00";
        $data['sex'] = $gender;
        $data['phone'] = $phone;
        $data['level'] = 0;
        $data['is_approver'] = 1;

        $db_name = $this->session->db_name;
        $this->db->db_select($db_name);

        //Count number of record and update if one exists else create
        $count_admins = $this->db->get('admin')->num_rows();

        if($count_admins == 0){
          if($this->db->insert('admin',$data)){
            $message = "success";
          }
        } else{
          if($this->db->update('admin',$data)){
            $message = "success";
          }
        }

        $this->db->db_select('schoolapp');

      }

      return $message;

    }

    function populate_user_table(){

    }

    function create_an_entitlement_to_user_profile(){

    }

    function set_up_system_settings(){
      //$this->session->set_userdata('installation_progress','system_set_up');
      $page_data['page_name'] = 'set_up_system_settings';
      $page_data['page_title'] = get_phrase('set_up_system_settings');
      $this->load->view('backend/install/index',$page_data);
    }

}
