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

class Class_Routine extends CI_Controller
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

    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['class_id']       = $this->input->post('class_id');
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            $this->db->insert('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?class_routine/class_routine/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['class_id']       = $this->input->post('class_id');
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');

            $this->db->where('class_routine_id', $param2);
            $this->db->update('class_routine', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?class_routine/class_routine/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class_routine', array(
                'class_routine_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_routine_id', $param2);
            $this->db->delete('class_routine');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?class_routine/class_routine/', 'refresh');
        }

    if($param1== "create_attendance"){
      $data['class_routine_id'] = $param2;
      $data['attendance_date'] = $this->input->post('attendance_date');
      $data['notes'] = $this->input->post('notes');

      $message = get_phrase('attendance_exists');
      $cond = array("class_routine_id"=>$param2,"attendance_date"=>$this->input->post('attendance_date'));
      if($this->db->where($cond)->get("class_routine_attendance")->num_rows()== 0){
        $this->db->insert("class_routine_attendance",$data);
        $message = get_phrase('attendance_created');
      }else{
        $this->db->where($cond);
        $this->db->update("class_routine_attendance",$data);
        $message = get_phrase('attendance_updated');
      }


      $this->session->set_flashdata('flash_message' , $message);
            redirect(base_url() . 'index.php?class_routine/class_routine/', 'refresh');
    }
    $page_data['routine_attendance'] = $this->db->get_where("class_routine_attendance",array("attendance_date"=>date('Y-m-d')))->result_object();
    $page_data['attendance_date'] = date("Y-m-d");
    $page_data['page_name']  = 'class_routine';
    $page_data['page_view'] = 'class_routine';
    $page_data['page_title'] = get_phrase('manage_class_routine');
    $this->load->view('backend/index', $page_data);
    }

    function create_routine_attendance($param2=""){
  			$data['class_routine_id'] = $param2;
  			$data['attendance_date'] = $this->input->post('attendance_date');
  			$data['notes'] = $this->input->post('notes');

  			$message = get_phrase('attendance_exists');
  			$cond = array("class_routine_id"=>$param2,"attendance_date"=>$this->input->post('attendance_date'));
  			if($this->db->where($cond)->get("class_routine_attendance")->num_rows()== 0){
  				$this->db->insert("class_routine_attendance",$data);
  				$message = get_phrase('attendance_created');
  			}else{
  				$this->db->where($cond);
  				$this->db->update("class_routine_attendance",$data);
  				$message = get_phrase('attendance_updated');
  			}

  			$this->search_class_routine($this->input->post('attendance_date'));
  	}

    function get_class_subject($class_id)
    {
        $subjects = $this->db->get_where('subject' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($subjects as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function search_class_routine($param1="",$param2=""){
      $cur_day = date("w",strtotime($param1));
      $first_date = date("Y-m-d",strtotime('-'.$cur_day." days",strtotime($param1)));
      $rem_days = 7 - $cur_day;
      $last_date = date("Y-m-d",strtotime('+'.$rem_days." days",strtotime($param1)));

      //$data['first'] = $first_date;
      //$data['last'] = $last_date;

      $query = "SELECT * FROM class_routine_attendance WHERE attendance_date BETWEEN '".$first_date."' AND '".$last_date."' ";

      $data['routine_attendance'] = $this->db->query($query);
      $data['attendance_date'] = $param1;
      echo $this->load->view("backend/class_routine/show_class_routine",$data,true);
    }
}
