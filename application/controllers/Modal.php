<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	@author 	: Nicodemus Karisa Mwambire
 *	date		: 16th June, 2018
 *	Techsys School Management System
 *	https://www.techsysolutions.com
 *	support@techsysolutions.com
 */
class Modal extends CI_Controller {


	function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

	/***default function, redirects to login page if no admin logged in yet***/
	public function index()
	{

	}


	/*
	*	$page_name		=	The name of page
	*/
	function popup($page_name = '' , $param2 = '' , $param3 = '')
	{
		$account_type		=	$this->session->userdata('page_type');
		$page_data['param2']		=	$param2;
		$page_data['param3']		=	$param3;
		
		if(file_exists(APPPATH.'/views/backend/'.$account_type.'/'.$this->session->login_type.'/'.$page_name.'.php' )){
			$this->load->view('backend/'.$account_type.'/'.$this->session->login_type.'/'.$page_name.'.php' ,$page_data);			
		}else{
			$this->load->view('backend/'.$account_type.'/'.$page_name.'.php' ,$page_data);
		}

		echo '<script src="assets/js/neon-custom-ajax.js"></script>';
	}
}
