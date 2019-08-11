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

class Exam extends CI_Controller
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




    /****MANAGE EXAMS*****/
    function exam($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            $data['comment'] = $this->input->post('comment');
            $this->db->insert('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?exam/exam/', 'refresh');
        }
        if ($param1 == 'edit' && $param2 == 'do_update') {
            $data['name']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            $data['comment'] = $this->input->post('comment');

            $this->db->where('exam_id', $param3);
            $this->db->update('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?exam/exam/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('exam', array(
                'exam_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('exam_id', $param2);
            $this->db->delete('exam');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?exam/exam/', 'refresh');
        }
        $page_data['exams']      = $this->db->get('exam')->result_array();
        $page_data['page_name']  = 'exam';
        $page_data['page_view']  = 'exam';
        $page_data['page_title'] = get_phrase('manage_exam');
        $this->load->view('backend/index', $page_data);
    }

    /****** SEND EXAM MARKS VIA SMS ********/
    function exam_marks_sms($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_sms') {

            $exam_id    =   $this->input->post('exam_id');
            $class_id   =   $this->input->post('class_id');
            $receiver   =   $this->input->post('receiver');

            // get all the students of the selected class
            $students = $this->db->get_where('student' , array(
                'class_id' => $class_id
            ))->result_array();
            // get the marks of the student for selected exam
            foreach ($students as $row) {
                
                $this->db->where('exam_id' , $exam_id);
                $this->db->where('student_id' , $row['student_id']);
                $marks = $this->db->get('mark')->result_array();
               
			    $message = 'Exam results for '.$row['name'].":";
				$total_marks = 0;
               
			    foreach ($marks as $row2) {
                    $subject       = $this->db->get_where('subject' , array('subject_id' => $row2['subject_id']))->row()->name;
                    $mark_obtained = $row2['mark_obtained'];
					$total_marks += $mark_obtained;
                    $message      .= $subject . ' : ' . $mark_obtained . ' , ';

                }
				
				$message .= "Total Marks: ".$total_marks;
				
                // send sms
                    
                if ($receiver == 'parent' && $row['parent_id'] != 0){
                	$receiver_phone = $this->db->get_where('parent' , array('parent_id' => $row['parent_id']))->row()->phone;
					
               		$this->sms_model->send_sms($message , $receiver_phone );
					
                }
                    
            }
            $this->session->set_flashdata('flash_message' , 'SMS sent');
            redirect(base_url() . 'index.php?exam/exam_marks_sms' , 'refresh');
        }
        $page_data['page_view']  = 'exam';
        $page_data['page_name']  = 'exam_marks_sms';
        $page_data['page_title'] = get_phrase('send_marks_by_sms');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE EXAM MARKS*****/
    function marks($exam_id = '', $class_id = '', $subject_id = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
            $page_data['subject_id'] = $this->input->post('subject_id');

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
                redirect(base_url() . 'index.php?exam/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
                redirect(base_url() . 'index.php?exam/marks/', 'refresh');
            }
        }
        if ($this->input->post('operation') == 'update') {
            $students = $this->db->get_where('student' , array('class_id' => $class_id))->result_array();
            foreach($students as $row) {
                $data['mark_obtained'] = $this->input->post('mark_obtained_' . $row['student_id']);
                $data['comment']       = $this->input->post('comment_' . $row['student_id']);

                $this->db->where('mark_id', $this->input->post('mark_id_' . $row['student_id']));
                $this->db->update('mark', array('mark_obtained' => $data['mark_obtained'] , 'comment' => $data['comment']));
            }
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?exam/marks/' . $this->input->post('exam_id') . '/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['subject_id'] = $subject_id;

        $page_data['page_info'] = 'Exam marks';
        $page_data['page_view']  = 'exam';
        $page_data['page_name']  = 'marks';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

	function delete_marks($class_id,$subject_id,$exam_id){
		// $class_id = $this->input->post('class_id');
		// $subject_id = $this->input->post('subject_id');
		// $exam_id = $this->input->post('exam_id');
		
		$this->db->where(array('class_id'=>$class_id,'subject_id'=>$subject_id,'exam_id'=>$exam_id));
		$this->db->delete('mark');
		
		echo get_phrase('finished');
	}

    // TABULATION SHEET
    function tabulation_sheet($class_id = '' , $exam_id = '') {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) {
        	
                redirect(base_url() . 'index.php?exam/tabulation_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id'] , 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class and exam');
                redirect(base_url() . 'index.php?exam/tabulation_sheet/', 'refresh');
            }
        }
		
		if($exam_id !=="" && $class_id !== ""){
			$exam_name  = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
        	$class_name = $this->db->get_where('class' , array('class_id' => $class_id ))->row()->name;
 			
			//$scores = $this->compute_total_marks_obtained($class_id,$exam_id);
			$positions = $this->compute_student_position($class_id,$exam_id);
			
			$page_data['positions'] = $positions;
			$page_data['subjects'] =  $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();	
			$page_data['exam_name'] = $exam_name;
			$page_data['class_name'] = $class_name;	
		}
		
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;

        $page_data['page_info'] = 'Exam marks';
        $page_data['page_view']  = 'exam';
        $page_data['page_name']  = 'tabulation_sheet';
        $page_data['page_title'] = get_phrase('tabulation_sheet');
        $this->load->view('backend/index', $page_data);

    }

	function compute_total_marks_obtained($class_id,$exam_id){
		
		$this->db->select(array('roll','student.name as student_name','mark.student_id','subject.name as subject_name','subject.subject_id','mark_obtained','comment'));
		$this->db->join('subject','subject.subject_id=mark.subject_id');
		$this->db->join('student','student.student_id=mark.student_id');
		$scores = $this->db->get_where('mark' , array('active'=>1,'mark.class_id' => $class_id,'mark.exam_id' => $exam_id))->result_array();
		
		$grouped_scores = array();
		
		$i = 0;
		
		foreach($scores as $score){
			$grade = $this->crud_model->get_grade($score['mark_obtained']);
			$grouped_scores[$score['roll'].' - '.$score['student_name']]['subject'][$i]['subject_name'] = $score['subject_name'];
			$grouped_scores[$score['roll'].' - '.$score['student_name']]['subject'][$i]['mark'] = $score['mark_obtained'];
			$grouped_scores[$score['roll'].' - '.$score['student_name']]['subject'][$i]['grade'] = $grade['grade_point'];
			$grouped_scores[$score['roll'].' - '.$score['student_name']]['avg_grade'] = 0;
			$grouped_scores[$score['roll'].' - '.$score['student_name']]['total_mark'] = 0;
			
			$i++;
		}
		
		$count_of_subjects  = $this->db->get_where('subject' , array('class_id' => $class_id))->num_rows();
		foreach($grouped_scores as $student=>$subject_scores){
			$total_marks = 0;
			$sum_grades = 0;
			
			foreach($subject_scores['subject'] as $subject_score){
				$total_marks += $subject_score['mark'];
				$sum_grades += $subject_score['grade'];
			}
			$grouped_scores[$student]['avg_grade'] = round($sum_grades/$count_of_subjects,0);
			$grouped_scores[$student]['total_mark'] = $total_marks;
		
		}
		
		return $grouped_scores;	    
	}

	function compute_student_position($class_id,$exam_id){
		$tabulation_sheet = $this->compute_total_marks_obtained($class_id,$exam_id);
		
		$score_array = array();
		
		foreach($tabulation_sheet as $student=>$score){
			$score_array[$student] = $score['total_mark'];
		}
		
		arsort($score_array);
		
		$sorted_scores = array();
		
		$position = 1;
		
		$previous_mark = 0;
		
		$skip_numbers = 0;
		
		foreach($score_array as $student=>$score){
			
			$sorted_scores[$student]['subject'] = $tabulation_sheet[$student]['subject'];
			$sorted_scores[$student]['total_marks'] = $score;
			$sorted_scores[$student]['grade_point'] = $tabulation_sheet[$student]['avg_grade'];
			
			$comment = "";
			
			if($this->db->get_where('grade',array('grade_point'=>$tabulation_sheet[$student]['avg_grade']))->num_rows()>0){
				$comment = $this->db->get_where('grade',array('grade_point'=>$tabulation_sheet[$student]['avg_grade']))->row()->comment;
			}
			
			$sorted_scores[$student]['grade_comment'] = $comment;
			
			if($previous_mark == $score){
				$sorted_scores[$student]['position'] = $position - 1;
				//$sorted_scores[$student]['previous_mark'] = $previous_mark;
				$skip_numbers++;
			}else{
				$sorted_scores[$student]['position'] = $position + $skip_numbers;
				//$sorted_scores[$student]['position'] = $position + $skip_numbers;
				//$sorted_scores[$student]['previous_mark'] = $previous_mark;
				
				$position = $position + $skip_numbers;
				$position++;
				
				$skip_numbers = 0;
			}
			
			
			$previous_mark = $score;
			
		}
		
		return $sorted_scores;
	}
	
    function tabulation_sheet_print_view($class_id , $exam_id) {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
		
		if($exam_id !=="" && $class_id !== ""){
			$exam_name  = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
        	$class_name = $this->db->get_where('class' , array('class_id' => $class_id ))->row()->name;
 			
			//$scores = $this->compute_total_marks_obtained($class_id,$exam_id);
			$positions = $this->compute_student_position($class_id,$exam_id);
			
			$page_data['positions'] = $positions;
			$page_data['subjects'] =  $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();	
			$page_data['exam_name'] = $exam_name;
			$page_data['class_name'] = $class_name;	
		}
			
        $page_data['class_id'] = $class_id;
        $page_data['exam_id']  = $exam_id;
        $this->load->view('backend/exam/tabulation_sheet_print_view' , $page_data);
    }


    /****MANAGE GRADES*****/
    function grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            $data['comment']     = $this->input->post('comment');
            $this->db->insert('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?exam/grade/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            $data['comment']     = $this->input->post('comment');

            $this->db->where('grade_id', $param2);
            $this->db->update('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?exam/grade/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('grade', array(
                'grade_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('grade_id', $param2);
            $this->db->delete('grade');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?exam/grade/', 'refresh');
        }
        $page_data['grades']     = $this->db->get('grade')->result_array();
        $page_data['page_name']  = 'grade';
        $page_data['page_view']  = 'exam';
        $page_data['page_title'] = get_phrase('manage_grade');
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet($student_id = '') {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('student' , array('student_id' => $student_id))->row()->class_id;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['page_name']  =   'student_marksheet';
        $page_data['page_view']  = 'exam';
        $page_data['page_title'] =   get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id , $exam_id) {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('student' , array('student_id' => $student_id))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/exam/student_marksheet_print_view', $page_data);
    }
}
