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

class Subject extends CI_Controller
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

    /***default functin, redirects to login page if no admin logged in yet***/
    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $this->db->insert('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?subject/subject/'.$data['class_id'], 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
            $data['teacher_id'] = $this->input->post('teacher_id');

            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?subject/subject/'.$data['class_id'], 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
			
			delete_affected_rows_alert();
            
            redirect(base_url() . 'index.php?subject/subject/'.$param3, 'refresh');
        }
     $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $param1))->result_array();
        $page_data['page_view'] = 'subject';
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->view('backend/index', $page_data);
    }

	function list_schemes_of_work($param1 = "", $param2 = ""){
		if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
		
		$page_data['class_id'] = $param1;
		$page_data['subject_id'] = $param2;
		$page_data['schemes'] = $this->db->get_where('scheme_header',
		array('class_id'=>$param1,'subject_id'=>$param2));
		$page_data['page_view'] = 'subject';
        $page_data['page_name']  = 'list_schemes_of_work';
        $page_data['page_title'] = get_phrase('list_schemes_of_work');
        $this->load->view('backend/index', $page_data);
	}

	function schemes_of_work($param1 = "",$param2 = "",$param3 = "", $param4 = ""){
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
			
		if($param1 == 'add'){
			
			$msg = "Process failed";
			
			$term = $this->input->post('term_id');
			$year = $this->input->post('year');
			
			$data['class_id'] = $param2;
			$data['subject_id'] = $param3;
			$data['term_id'] = $term;
			$data['year'] = $year;
			$data['createdby'] = $this->session->login_user_id;
			$data['lastmodifiedby'] = $this->session->login_user_id;
			$data['createddate'] = date('Y-m-d h:i:s');
			
			//Check if a scheme is available
			$check = $this->db->get_where('scheme_header',
			array('class_id'=>$param2,'subject_id'=>$param3,'term_id'=>$this->input->post('term_id'),
			'year'=>$this->input->post('year')))->num_rows();
			
			if($check == 0){
				$this->db->insert('scheme_header',$data);
				$msg = "Schemes of Work Created Successful";
			}
			
			 
			$this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?subject/schemes_of_work/'.$param2.'/'.$param3.'/'.$term.'/'.$year, 'refresh');
		}
		
		$scheme_header = $this->db->get_where('scheme_header',
		array('class_id'=>$param1,'subject_id'=>$param2,'term_id'=>$param3,
		'year'=>$param4))->row();
		
		$page_data['scheme'] = $scheme_header;
		
		$page_data['scheme_details'] = $this->db->get_where('scheme',
		array('scheme_header_id'=>$scheme_header->scheme_header_id))->result_object();
		
        $page_data['page_name']  = 'schemes_of_work';
        $page_data['page_view']  = 'subject';
        $page_data['page_title'] = get_phrase('schemes_of_work');
        $this->load->view('backend/index', $page_data);		
	}
	
	function scheme_detail($param1 = "", $param2 = ""){
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');		
		
		if($param1 == 'add'){
			
			$data['scheme_header_id'] = $param2;	
			$data['week'] =  $this->input->post('week');
			$data['lesson'] =  $this->input->post('lesson');	
			$data['strand'] =  $this->input->post('strand');
			$data['sub_strand'] =  $this->input->post('sub_strand');
			$data['learning_outcomes'] =  $this->input->post('learning_outcomes');
			$data['inquiry_question'] =  $this->input->post('inquiry_question');
			$data['learning_experiences'] =  $this->input->post('learning_experiences');
			$data['learning_resources'] =  $this->input->post('learning_resources');
			$data['assessment'] =  $this->input->post('assessment');
			$data['createdby'] = $this->session->login_user_id;
			$data['lastmodifiedby'] = $this->session->login_user_id;
			$data['createddate'] = date('Y-m-d h:i:s');
			
			
			$this->db->insert('scheme',$data);
			$msg = "Schemes detail created successful";
			 
			$this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?subject/scheme_detail/'.$param2, 'refresh');
			
		}
		
		$page_data['scheme_header_id'] = $param1;		
		$page_data['page_name']  = 'scheme_detail';
        $page_data['page_view']  = 'subject';
        $page_data['page_title'] = get_phrase('scheme_detail');
        $this->load->view('backend/index', $page_data);
	}

	function lesson_plan($param1 = "", $param2 = ""){
		if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
			
			
		if($param2 == 'add'){
			
			$msg = "Process failed";
			
			$update['strand'] = $this->input->post('strand');
			$update['sub_strand'] = $this->input->post('sub_strand');
			$update['learning_outcomes'] = $this->input->post('learning_outcomes');
			$update['inquiry_question'] = $this->input->post('inquiry_question');
			$update['learning_resources'] = $this->input->post('learning_resources');
			
			$this->db->where(array('scheme_id'=>$param1));
			$this->db->update('scheme',$update);
			
			$add['scheme_id'] = $param1;
			$add['planned_date'] = $this->input->post('planned_date');
			$add['attendance_date'] = "0000-00-00";
			$add['class_routine_id'] = 0;
			$add['roll'] = $this->input->post('roll');
			$add['core_competencies'] = $this->input->post('core_competencies');
			$add['introduction'] = $this->input->post('introduction');
			$add['lesson_development'] = $this->input->post('lesson_development');
			$add['conclusion'] = $this->input->post('conclusion');
			$add['summary'] = $this->input->post('summary');
			$add['reflection'] = "";
			$add['signed_off_by'] = "";
			$add['signed_off_date'] = '0000-00-00';
			$add['createdby'] = $this->session->login_user_id;
			$add['lastmodifiedby'] = $this->session->login_user_id;
			$add['createddate'] = date('Y-m-d h:i:s');
			
			//Check if Lesson plan exists
			$check = $this->db->get_where('lesson_plan',array('scheme_id'=>$param1))->num_rows();
			
			if($check == 0 ){
				$this->db->insert('lesson_plan',$add);
				$msg = "Lesson plan created successful";
			}
			
			$this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?subject/lesson_plan/'.$param1, 'refresh');
		}		
			
		$lesson_plan = $this->db->get_where('lesson_plan',array('scheme_id'=>$param1));
		
		if($lesson_plan->num_rows() == 0){
			$page_data['scheme_detail'] = $this->db->get_where('scheme',array('scheme_id'=>$param1))->row();
			$page_data['page_name']  = 'lesson_plan_add';
			$page_data['page_title'] = get_phrase('add_lesson_plan');
		}else{
			$this->db->select(array('class.name as class_name','scheme_header.class_id as class_id','subject.name as subject','lesson_plan_id','scheme.scheme_id as scheme_id'));
			$this->db->select(array('planned_date','attendance_date','roll','core_competencies','introduction','lesson_development'));
			$this->db->select(array('conclusion','summary','reflection','strand','sub_strand','learning_outcomes','inquiry_question'));
			$this->db->select(array('scheme_header.subject_id as subject_id','learning_experiences','learning_resources','signed_off_by','signed_off_date'));
			$this->db->select(array('class_routine_id'));
			
			
			$this->db->join('scheme','scheme.scheme_id=lesson_plan.scheme_id');
			$this->db->join('scheme_header','scheme_header.scheme_header_id=scheme.scheme_header_id');
			$this->db->join('subject','subject.subject_id=scheme_header.subject_id');
			$this->db->join('class','class.class_id=scheme_header.class_id');
			//$this->db->join('class_routine','class_routine.class_routine_id=lesson_plan.class_routine_id');
			$page_data['lesson_plan'] = $lesson_plan = $this->db->get_where('lesson_plan',array('lesson_plan.scheme_id'=>$param1))->row();
			
			$page_data['class_routine'] = $this->db->get_where('class_routine',
			array('class_id'=>$lesson_plan->class_id,'subject_id'=>$lesson_plan->subject_id))->result_object();
			
			$page_data['page_name']  = 'lesson_plan';
			$page_data['page_title'] = get_phrase('lesson_plan');
		}	
		$page_data['scheme_id'] = $param1;	
        $page_data['page_view']  = 'subject';
        $this->load->view('backend/index', $page_data);
	}

	function get_date_of_class_routine($class_routine_id = ""){
		
		$day = $this->db->get_where('class_routine',array('class_routine_id'=>$class_routine_id))->row()->day;
		
		echo date( 'Y-m-d', strtotime( $day.' this week' ) );	
	}

	function post_lesson_plan_reflection(){
		$lesson_plan_id = $this->input->post('lesson_plan_id');
		$data['reflection'] = $this->input->post('reflection');
		
		$this->db->where(array('lesson_plan_id'=>$lesson_plan_id));
		$this->db->update('lesson_plan',$data);
	}

	function post_attendance_date_and_routine_id(){
		$lesson_plan_id = $this->input->post('lesson_plan_id');
		$data['attendance_date'] = $this->input->post('attendance_date');
		$data['class_routine_id'] = $this->input->post('class_routine_id');
		
		$this->db->where(array('lesson_plan_id'=>$lesson_plan_id));
		$this->db->update('lesson_plan',$data);
	}

}
