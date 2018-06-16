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

class Parents extends CI_Controller
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

    function parent($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']        			= $this->input->post('name');
            $data['email']       			= $this->input->post('email');
            $data['phone']       			= $this->input->post('phone');
            $data['address']     			= $this->input->post('address');
            $data['relationship_id']     	= $this->input->post('relationship');
            $data['care_type']     	= $this->input->post('care_type');
            $data['profession']  			= $this->input->post('profession');
            $this->db->insert('parent', $data);
            $this->email_model->account_opening_email('parent', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?parents/parent/', 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']                   = $this->input->post('name');
            $data['email']                  = $this->input->post('email');
            $data['phone']                  = $this->input->post('phone');
            $data['address']                = $this->input->post('address');
            $data['relationship_id']     	= $this->input->post('relationship');
            $data['care_type']     	= $this->input->post('care_type');
            $data['profession']             = $this->input->post('profession');
            $this->db->where('parent_id' , $param2);
            $this->db->update('parent' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?parents/parent/', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('parent_id' , $param2);
            $this->db->delete('parent');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?parents/parent/', 'refresh');
        }

        if($param1 === "add_caregivers"){
          $this->db->where(array("parent_id"=>$param2));
          $this->db->delete('caregiver');
          foreach($this->input->post("student_id") as $student_id){

            $data['student_id'] = $student_id;
            $data['parent_id'] = $param2;

            $this->db->insert('caregiver',$data);
          }
        }

        $page_data['page_title'] 	= get_phrase('all_parents');
        $page_data['page_name']  = 'parent';
        $page_data['page_view']  = 'parent';
        $this->load->view('backend/index', $page_data);
    }

    function parent_activity($param1=""){
          if ($this->session->userdata('active_login') != 1)
              redirect('login', 'refresh');

      if($param1==='create'){
        $data['name'] = $this->input->post("name");
        $data["description"] = $this->input->post("description");
        $data['start_date'] = $this->input->post("start_date");
        $data["end_date"] = $this->input->post("end_date");

        $this->db->insert("activity",$data);

        $activity_id = $this->db->insert_id();

        redirect(base_url().'index.php?parents/parent_add_activity/'.$activity_id,"refresh");
      }


          $page_data['page_name']   = 'parent_activity';
          $page_data['page_view']   = "parent";
          $page_data['page_title']  = get_phrase('parents_activity');
          $page_data['activities']  = $this->db->order_by("end_date asc")->get("activity")->result_object();
          $this->load->view('backend/index', $page_data);
    }

    function parent_add_activity($param1="",$param2="",$param3=""){
          if ($this->session->userdata('active_login') != 1)
              redirect('login', 'refresh');

      if($param1=="search"){

        $list_parents = $this->db->get('parent')->result_object();

        if($param2 > 0){
          $select_string = "parent.parent_id as parent_id, parent.name as name ";
          $this->db->select($select_string);
          $this->db->join("student","student.parent_id=parent.parent_id");
          $list_parents = $this->db->get_where('parent',array("class_id"=>$param2))->result_object();
        }

        $data['activity_id'] = $param3;

        $data['list_parents'] = $list_parents;

        echo $this->load->view("backend/parent/data_ul_parents",$data,TRUE);

        return FALSE;
      }


          $page_data['page_name'] = __FUNCTION__;
          $page_data['page_view'] = 'parent';
          $page_data['page_title'] = get_phrase('add_parents');
          $this->load->view('backend/index', $page_data);
    }


    function load_activity_register($param1=""){
      $data['record'] = $this->db->get_where('activity',array('activity_id'=>$param1))->row();
      echo $this->load->view('backend/parent/new_activity_register', $data,TRUE);
    }

    function parent_expected_attendance($param1=""){
      //print_r($_POST);
      //$parent_ids = $_POST;
      $activity_id =  $param1;
      //print_r($_POST['parent_ids']);
      if($this->db->get_where("activity_attendance",array("activity_id"=>$activity_id))->num_rows() > 0){
        $this->db->where(array("activity_id"=>$activity_id));
        $this->db->delete("activity_attendance");
      }

      foreach ($_POST['parent_ids'] as $parent_id) {
        $data['parent_id'] = $parent_id['value'];
        $data['activity_id'] = $activity_id;
        $data['expected'] = '1';

        $this->db->insert('activity_attendance',$data);
      }

      echo get_phrase('success');
    }

    function mark_parent_activity_attendance($param1=""){
  		$attendance = $this->input->post();
      //echo $param1;
  		$message = "Attendance Marked Successfully";
  		foreach($attendance['attendance'] as $key=>$value){
  			   $data['attendance'] = $value;

  				$this->db->where(array("activity_id"=>$param1,"parent_id"=>$key));
  				$this->db->update("activity_attendance",$data);
  		}
  		echo $message;
  	}

    function parent_activity_attendance_print($activity_id) {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
        $activity     = $this->db->get_where('activity' , array('activity_id' => $activity_id))->row();

        $page_data['activity'] =   $activity;
        $this->load->view('backend/parent/parent_activity_attendance_print', $page_data);
    }
}
