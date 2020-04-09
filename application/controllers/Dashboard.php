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

class Dashboard extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		//if($this->session->app === 'default')$this->load->database(); else $this->load->database($this->session->app,true);
        $this->load->library('session');
        $this->load->database();
       	//$this->db->db_select($this->session->app);

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

    }

    /***default functin, redirects to login page if no admin logged in yet***/
    function home($year = "",$term ="")
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
		
		//Africa is Talking User Data
		
		$username = $this->db->get_where('settings',array('type'=>'africastalking_user'))->row()->description;
		$apiKey = $this->db->get_where('settings',array('type'=>'africastalking_api_id'))->row()->description;
		
		$this->config->set_item('username', $username);
		$this->config->set_item('apiKey', $apiKey);
		
		$this->load->library('AfricasTalking');
		
		try{
			$page_data['user_data'] = $this->africastalking->getUserData();
		}catch(AfricasTalkingGatewayException $e){
			$page_data['user_data'] = (object)array('balance'=>0.00);
        }

        if($year == ""){
            $year = date('Y');
            $term = $this->crud_model->get_current_term();
        }
		        
        $page_data['page_name']  = 'dashboard';
        $page_data['page_view'] = "dashboard";
        $page_data['page_title'] = get_phrase('dashboard');
        $page_data['year'] = $year;
        $page_data['term'] = $term;
        $this->load->view('backend/index', $page_data);
    }

    function get_dashboard_year_and_term(){
        
        $post = $this->input->post();

        $term  = $this->crud_model->get_current_term();
        $year = date('Y');

        if($post['year'] == ""){
            if($this->crud_model->get_current_term() == 1){
                $year = date('Y') - 1;
                $term = 3;
            }elseif($this->crud_model->get_current_term() > 1){
                $year = date('Y');
                $term = $post['term'] - 1;
            }
        }else{
            if($post['term'] == 1){
                $year = $post['year'] - 1;
                $term = 3;
            }else{
                $year = $post['year'];
                $term = $post['term'] - 1;
            }
        }

        echo json_encode(['year'=>$year,'term'=>$term]);
    }

}
