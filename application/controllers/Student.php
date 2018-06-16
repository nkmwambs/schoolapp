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

class Student extends CI_Controller
{


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

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($this->session->userdata('active_login') == 1)
            redirect(base_url() . 'index.php?student/student_information', 'refresh');
    }

    /****MANAGE STUDENTS *****/
    function student_add()
    {
      if ($this->session->userdata('active_login') != 1)
              redirect(base_url(), 'refresh');

      $page_data['page_name']  = 'student_add';
      $page_data['page_view']  = 'student';
      $page_data['page_title'] = get_phrase('add_student');
      $this->load->view('backend/index', $page_data);
    }

    function student($param1 = '', $param2 = '', $param3 = '')
      {
          if ($this->session->userdata('active_login') != 1)
              redirect('login', 'refresh');
          if ($param1 == 'create') {
              $data['name']           = $this->input->post('name');
              $data['birthday']       = $this->input->post('birthday');
              $data['sex']            = $this->input->post('sex');
              $data['address']        = $this->input->post('address');
              $data['phone']          = $this->input->post('phone');
              $data['email']          = $this->input->post('email');
              $data['class_id']       = $this->input->post('class_id');
              if ($this->input->post('section_id') != '') {
                  $data['section_id'] = $this->input->post('section_id');
              }
              $data['parent_id']      = $this->input->post('parent_id');
              $data['dormitory_id']   = $this->input->post('dormitory_id');
              $data['transport_id']   = $this->input->post('transport_id');
              $data['roll']           = $this->input->post('roll');
              $this->db->insert('student', $data);
              $student_id = $this->db->insert_id();


              if($this->input->post('secondary_care')){
                $care_array = $this->input->post('secondary_care');

          foreach($care_array as $caregiver_id){
            $data2['parent_id'] =  $caregiver_id;
            $data2['student_id'] =  $student_id;

            $this->db->insert('caregiver', $data2);
          }
              }


              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
              $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
              $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
              redirect(base_url() . 'index.php?student/student_add/' . $data['class_id'], 'refresh');
          }
          if ($param2 == 'do_update') {
              $data['name']           = $this->input->post('name');
              $data['birthday']       = $this->input->post('birthday');
              $data['sex']            = $this->input->post('sex');
              $data['address']        = $this->input->post('address');
              $data['phone']          = $this->input->post('phone');
              $data['email']          = $this->input->post('email');
              $data['class_id']       = $this->input->post('class_id');
              $data['section_id']     = $this->input->post('section_id');
              $data['parent_id']      = $this->input->post('parent_id');
              $data['dormitory_id']   = $this->input->post('dormitory_id');
              $data['transport_id']   = $this->input->post('transport_id');
              $data['roll']           = $this->input->post('roll');

              $this->db->where('student_id', $param3);
              $this->db->update('student', $data);

        if($this->input->post('secondary_care')){
                $care_array = $this->input->post('secondary_care');

          $this->db->where(array("student_id"=>$param3));
          $this->db->delete('caregiver');

          foreach($care_array as $caregiver_id){

            $data2['parent_id'] =  $caregiver_id;
            $data2['student_id'] =  $param3;

            $this->db->insert('caregiver', $data2);


          }
              }

              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
              $this->crud_model->clear_cache();
              $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
              redirect(base_url() . 'index.php?student/student_information/' . $param1, 'refresh');
          }

          if ($param2 == 'delete') {
              $this->db->where('student_id', $param3);
        $data['active'] = 0;

        $this->db->update('student',$data);
              //$this->db->delete('student');
              $this->session->set_flashdata('flash_message' , get_phrase('student_suspended'));
              redirect(base_url() . 'index.php?student/student_information/' . $param1, 'refresh');
          }

      if($param2==='unsuspend'){
              $this->db->where('student_id', $param3);
        $data['active'] = 1;

        $this->db->update('student',$data);
              //$this->db->delete('student');
              $this->session->set_flashdata('flash_message' , get_phrase('student_reinstated'));
              redirect(base_url() . 'index.php?student/student_information/' . $param1, 'refresh');
      }
    }

    function student_information($class_id = '')
    {
      if ($this->session->userdata('active_login') != 1)
              redirect('login', 'refresh');

      $page_data['page_name']  	= 'student_information';
      $page_data['page_view'] = "student";
      $page_data['page_title'] 	= get_phrase('student_information'). " - ".get_phrase('class')." : ".
                        $this->crud_model->get_class_name($class_id);
      $page_data['class_id'] 	= $class_id;
      $this->load->view('backend/index', $page_data);
    }

    function student_bulk_add($param1 = '')
  	{
  		if ($this->session->userdata('active_login') != 1)
              redirect(base_url(), 'refresh');

  		if ($param1 == 'import_excel')
  		{
  			move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_import.xlsx');
  			// Importing excel sheet for bulk student uploads

  			include 'simplexlsx.class.php';

  			$xlsx = new SimpleXLSX('uploads/student_import.xlsx');

  			list($num_cols, $num_rows) = $xlsx->dimension();
  			$f = 0;
  			foreach( $xlsx->rows() as $r )
  			{
  				// Ignore the inital name row of excel file
  				if ($f == 0)
  				{
  					$f++;
  					continue;
  				}
  				for( $i=0; $i < $num_cols; $i++ )
  				{
  					if ($i == 0)	    $data['name']			=	$r[$i];
  					else if ($i == 1)	$data['birthday']		=	$r[$i];
  					else if ($i == 2)	$data['sex']		    =	$r[$i];
  					else if ($i == 3)	$data['address']		=	$r[$i];
  					else if ($i == 4)	$data['phone']			=	$r[$i];
  					else if ($i == 5)	$data['email']			=	$r[$i];
  					else if ($i == 6)	$data['roll']			=	$r[$i];
  				}
  				$data['class_id']	=	$this->input->post('class_id');

  				$this->db->insert('student' , $data);
  				//print_r($data);
  			}
  			redirect(base_url() . 'index.php?student/student_information/' . $this->input->post('class_id'), 'refresh');
  		}
  		$page_data['page_name']  = 'student_bulk_add';
      $page_data['page_view'] = "student";
  		$page_data['page_title'] = get_phrase('add_bulk_student');
  		$this->load->view('backend/index', $page_data);
  	}
}
