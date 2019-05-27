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
    function index()
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'dashboard';
        $page_data['page_view'] = "dashboard";
        $page_data['page_title'] = get_phrase('dashboard');
        $this->load->view('backend/index', $page_data);
    }

}
