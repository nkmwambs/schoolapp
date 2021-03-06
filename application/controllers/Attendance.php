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

class Attendance extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		//$this->db->db_select($this->session->app);
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

    }

    /****** DAILY ATTENDANCE *****************/
  	function manage_attendance($date='',$month='',$year='',$class_id='')
  	{
  		if($this->session->userdata('active_login')!=1)
              redirect(base_url() , 'refresh');

          $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;


  		if($_POST)
  		{
  			// Loop all the students of $class_id
              $students   =   $this->db->get_where('student', array('class_id' => $class_id,'active=>1'))->result_array();
              foreach ($students as $row)
              {
				  $morning_attendance_status  =   $this->input->post('morning_status_' . $row['student_id']);
				  $afternoon_attendance_status  =   $this->input->post('afternoon_status_' . $row['student_id']);

                  $this->db->where('student_id' , $row['student_id']);
                  $this->db->where('date' , $this->input->post('date'));

                  $this->db->update('attendance' , array('morning' => $morning_attendance_status,'afternoon' => $afternoon_attendance_status));

                  // if ($attendance_status == 2) {
// 
                      // if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                          // $student_name   = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
                          // $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $row['parent_id']))->row()->phone;
                          // $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                          // $this->sms_model->send_sms($message,$receiver_phone);
                      // }
                  // }

              }

  			$this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
  			redirect(base_url() . 'index.php?attendance/manage_attendance/'.$date.'/'.$month.'/'.$year.'/'.$class_id , 'refresh');
  		}
          $page_data['date']     =	$date;
          $page_data['month']    =	$month;
          $page_data['year']     =	$year;
          $page_data['class_id'] =	$class_id;

          $page_data['page_name']  =	'manage_attendance';
          $page_data['page_view'] = 'attendance';
          $page_data['page_title'] =	get_phrase('manage_daily_attendance');
  		      $this->load->view('backend/index', $page_data);
  	}
	
	function attendance_sheet_selector()
  	{
  		redirect(base_url() . 'index.php?attendance/tabulate_attendance/'.$this->input->post('month').'/'.
  						$this->input->post('year').'/'.
  							$this->input->post('class_id') , 'refresh');
  	}
	
	function tabulate_attendance($month,$year,$class_id=''){
  		if($this->session->userdata('active_login')!=1)
              redirect(base_url() , 'refresh');
		
		
		$this->db->select(array('student.student_id','student.name','student.roll','student.class_id',
		'class.name as class','morning','afternoon','date'));
		$this->db->join('class','class.class_id=student.class_id');
		$this->db->join('attendance','attendance.student_id=student.student_id');
		$this->db->order_by('date');
		$this->db->where(array('year(date)'=>$year,'month(date)'=>$month));
		$students   =   $this->db->get_where('student', array('student.class_id' => $class_id,'active'=>'1'))->result_array();
		
		$attendance = array();
		
		foreach($students as $student){
			$attendance[$student['student_id']]['student_information'] = array('student_id'=>$student['student_id'],'name'=>$student['name'],'roll'=>$student['roll'],'class'=>$student['class']);
			$attendance[$student['student_id']]['attendance'][$student['date']]['morning'] = $student['morning']; 
			$attendance[$student['student_id']]['attendance'][$student['date']]['afternoon'] = $student['afternoon'];
		}
		
		$page_data['attendance']    =	$attendance;
		$page_data['month']    =	$month;
        $page_data['year']     =	$year;
        $page_data['class_id'] =	$class_id;
		  
        $page_data['page_name']  =	'tabulate_attendance';
        $page_data['page_view'] = 'attendance';
       	$page_data['page_title'] =	get_phrase('tabulate_attendance');
  		$this->load->view('backend/index', $page_data);		
	}
	
  	function attendance_selector()
  	{
  		redirect(base_url() . 'index.php?attendance/manage_attendance/'.$this->input->post('date').'/'.
  					$this->input->post('month').'/'.
  						$this->input->post('year').'/'.
  							$this->input->post('class_id') , 'refresh');
  	}

}
