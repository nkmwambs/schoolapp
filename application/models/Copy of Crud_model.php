<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
    	if($this->db->get_where($type, array($type . '_id' => $type_id))->num_rows() > 0){
    		return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
    	}else{
    		return "";
    	}
        
    }

    ////////STUDENT/////////////
    function get_students($class_id) {
        $query = $this->db->get_where('student', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_student_info($student_id) {
        $query = $this->db->get_where('student', array('student_id' => $student_id));
        return $query->result_array();
    }
	
	function get_parent_info($parent_id){
		$query = $this->db->get_where('parent', array('parent_id' => $parent_id));
        return $query->result_array();
	}

    /////////TEACHER/////////////
    function get_teachers() {
        $query = $this->db->get('teacher');
        return $query->result_array();
    }

    function get_teacher_name($teacher_id) {
        $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_teacher_info($teacher_id) {
        $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
        return $query->result_array();
    }

    //////////SUBJECT/////////////
    function get_subjects() {
        $query = $this->db->get('subject');
        return $query->result_array();
    }

    function get_subject_info($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    function get_subjects_by_class($class_id) {
        $query = $this->db->get_where('subject', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_subject_name_by_id($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
        return $query->name;
    }

    ////////////CLASS///////////
    function get_class_name($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_class_name_numeric($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name_numeric'];
    }

    function get_classes() {
        $query = $this->db->get('class');
        return $query->result_array();
    }

    function get_class_info($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        return $query->result_array();
    }
	/////////INCOMES CATEGORIES////////////
    function get_income_categories() {
        $query = $this->db->get('income_categories');
        return $query->result_array();
    }

    function get_income_category_name($income_category_id) {
        $query = $this->db->get_where('income_categories', array('income_category_id' => $income_category_id));
        $res = $query->result_array();
		foreach ($res as $row)
            return $row['name'];
    }	

    //////////EXAMS/////////////
    function get_exams() {
        $query = $this->db->get('exam');
        return $query->result_array();
    }

    function get_exam_info($exam_id) {
        $query = $this->db->get_where('exam', array('exam_id' => $exam_id));
        return $query->result_array();
    }

    //////////GRADES/////////////
    function get_grades($obtained_mark="") {
    	$string = "mark_from >= $obtained_mark OR mark_to <= $obtained_mark";
    	$this->db->where($string);
        $query = $this->db->get('grade');
        return $query->result_array();
    }

    function get_grade_info($grade_id) {
        $query = $this->db->get_where('grade', array('grade_id' => $grade_id));
        return $query->result_array();
    }

    function get_obtained_marks( $exam_id , $class_id , $subject_id , $student_id) {
        $marks = $this->db->get_where('mark' , array(
                                    'subject_id' => $subject_id,
                                        'exam_id' => $exam_id,
                                            'class_id' => $class_id,
                                                'student_id' => $student_id))->result_array();
                                        
        foreach ($marks as $row) {
            echo $row['mark_obtained'];
        }
    }

    function get_highest_marks( $exam_id , $class_id , $subject_id ) {
        $this->db->where('exam_id' , $exam_id);
        $this->db->where('class_id' , $class_id);
        $this->db->where('subject_id' , $subject_id);
        $this->db->select_max('mark_obtained');
        $highest_marks = $this->db->get('mark')->result_array();
        foreach($highest_marks as $row) {
            echo $row['mark_obtained'];
        }
    }

    function get_grade($mark_obtained) {
        $query = $this->db->get('grade');
        $grades = $query->result_array();
        foreach ($grades as $row) {
            if ($mark_obtained >= $row['mark_from'] && $mark_obtained <= $row['mark_upto'])
                return $row;
        }
    }

    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    function get_system_settings() {
        $query = $this->db->get('settings');
        return $query->result_array();
    }

    ////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

    /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    /////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }

    ////////STUDY MATERIAL//////////
    function save_study_material_info()
    {
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['title'] 		= $this->input->post('title');
        $data['description']    = $this->input->post('description');
        $data['file_name'] 	= $_FILES["file_name"]["name"];
        $data['file_type'] 	= $this->input->post('file_type');
        $data['class_id'] 	= $this->input->post('class_id');
        
        $this->db->insert('document',$data);
        
        $document_id            = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" . $_FILES["file_name"]["name"]);
    }
    
    function select_study_material_info()
    {
        $this->db->order_by("timestamp", "desc");
        return $this->db->get('document')->result_array(); 
    }
    
    function select_study_material_info_for_student()
    {
        $student_id = $this->session->userdata('student_id');
        $class_id   = $this->db->get_where('student', array('student_id' => $student_id))->row()->class_id;
        $this->db->order_by("timestamp", "desc");
        return $this->db->get_where('document', array('class_id' => $class_id))->result_array();
    }
    
    function update_study_material_info($document_id)
    {
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['title'] 		= $this->input->post('title');
        $data['description']    = $this->input->post('description');
        $data['class_id'] 	= $this->input->post('class_id');
        
        $this->db->where('document_id',$document_id);
        $this->db->update('document',$data);
    }
    
    function delete_study_material_info($document_id)
    {
        $this->db->where('document_id',$document_id);
        $this->db->delete('document');
    }
    
    ////////private message//////
    function send_new_private_message() {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));

        $reciever   = $this->input->post('reciever');
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['reciever']            = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');


        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }
	
	//Accounting
	
	function opening_account_balance($curr_date){
		
		$start_date = $this->db->get_where('settings',array('type'=>'system_start_date'))->row()->description;
		
		$opening_bank_balance = $this->db->get_where('accounts',array('name'=>'bank'))->row()->opening_balance;
		
		$opening_cash_balance = $this->db->get_where('accounts',array('name'=>'cash'))->row()->opening_balance;
		
		$bank_balance = 0;
		
		$cash_balance = 0;
		
		if(strtotime(date('Y-m-01',strtotime($start_date)))===strtotime(date('Y-m-01',strtotime($curr_date)))){
			
				$bank_balance = $this->db->get_where('accounts',array('name'=>'bank'))->row()->opening_balance;
		
				$cash_balance = $this->db->get_where('accounts',array('name'=>'cash'))->row()->opening_balance;
		
		}elseif(strtotime(date('Y-m-01',strtotime($start_date)))<strtotime(date('Y-m-01',strtotime($curr_date)))){
			
				$c_date = date('Y-m-01',strtotime($curr_date));
				
				//Sum all Bank Income and expenses in previous months before the supplied month and get their difference
				
				$month = date('m',strtotime($c_date));
				$year = date('Y',strtotime($c_date));
				
				$bank_income_cond = " ((transaction_type='1' AND account='2') OR transaction_type='3') AND t_date<'".$c_date."'";// AND t_date<='".$c_date."'
				
				$bank_income = $this->db->select_sum('amount')->where($bank_income_cond)->get('cashbook')->row()->amount;
				
				$bank_expense_cond = " ((transaction_type='2' AND account='2') OR transaction_type='4') AND t_date<'".$c_date."'";
				
				$bank_expense = $this->db->select_sum('amount')->where($bank_expense_cond)->get('cashbook')->row()->amount;
				
				$bank_balance = ($opening_bank_balance+$bank_income)-$bank_expense;
				
				//Sum all Cash Income and expenses in previous months before the supplied months and get their difference
				
				$cash_income_cond = " ((transaction_type='1' AND account='1') OR transaction_type='4') AND t_date<'".$c_date."'";
				
				$cash_income = $this->db->select_sum('amount')->where($cash_income_cond)->get('cashbook')->row()->amount;
				
				$cash_expense_cond = " ((transaction_type='2' AND account='1') OR transaction_type='3') AND t_date<'".$c_date."'";
				
				$cash_expense = $this->db->select_sum('amount')->where($cash_expense_cond)->get('cashbook')->row()->amount;
				
				$cash_balance = ($opening_cash_balance+$cash_income)-$cash_expense;
		}
		//Return the Cash and Bank Balances
		
		return array('cash_balance'=>$cash_balance,'bank_balance'=>$bank_balance);
	}

	function closing_bank_balance($t_date = ""){
		//$t_date = date("Y-m-t",$current);
		$month = date('m',strtotime($t_date));
		$year = date('Y',strtotime($t_date));
		$opening_balance = $this->crud_model->opening_account_balance(date('Y-m-t',strtotime($t_date)));
		$transactions = $this->db->get_where('cashbook',array('Month(t_date)'=>$month,'Year(t_date)'=>$year))->result_object();
		
		$sum_bank_income = 0;
		$sum_bank_expense = 0;
		$bank_balance = 0;
							
		foreach($transactions as $rows){
			$bank_income = 0;
			if(($rows->transaction_type==='1' && $rows->account==='2')||$rows->transaction_type==='3') $bank_income = $rows->amount;		
			$sum_bank_income +=	$bank_income;
			
			$bank_expense = 0;
			if(($rows->transaction_type==='2' && $rows->account==='2')||$rows->transaction_type==='4') $bank_expense = $rows->amount;
			$sum_bank_expense +=	$bank_expense;
				
		}
		
		$bank_balance = $opening_balance['bank_balance']+$sum_bank_income-$sum_bank_expense;
		
		return  $bank_balance;
		
	}
	
	function system_start_date(){
		return $month_start_date = $this->db->get_where('settings',
		array('type'=>'system_start_date'))->row()->description; 
	}
	
	function current_transaction_month(){
		
		$month_start_date = $this->system_start_date(); 
		
		//Check if there is any reconciliation done
		$reconciliation_count = $this->db->get('reconcile')->num_rows();
		
		if($reconciliation_count > 0){
			$max_reconcile_date = $this->db->select_max('month')->get('reconcile')->row()->month;
			$month_start_date = date('Y-m-01',strtotime('first day of next month',strtotime($max_reconcile_date)));
		}
			
		return $month_start_date;
	}
	
		function last_reconciled_month(){
		
		$last_reconcile_date = date('Y-m-01',strtotime('-1 month',strtotime($this->db->get_where('settings' , array('type'=>'system_start_date'))->row()->description))); 
		
		if($this->db->get('reconcile')->num_rows() > 0){
			$last_reconcile_date = $this->db->select_max('month')->get('reconcile')->row()->month;
		}
		
		return $last_reconcile_date;
	}
		
	function next_serial_number(){
		
			
		$this->db->select_max('batch_number');
		$max_serial_number = $this->db->get('cashbook')->row()->batch_number + 1;
		
		$current_transaction_month = strtotime($this->current_transaction_month());
		$last_reconciled_month = strtotime($this->last_reconciled_month());
		
		$count_of_transactions_in_current_transacting_month = $this->db->get_where('cashbook',
		array('t_date>='=>$this->current_transaction_month()))->num_rows();
		
		if($current_transaction_month > $last_reconciled_month && 
			$count_of_transactions_in_current_transacting_month == 0){
		 	$max_serial_number = date('y').date('m',$current_transaction_month).'01';
		}				
 		
		return $max_serial_number;
	}

	// function populate_batch_number($cur_date){
		// //Check if Cashbook has any record
		// $cashbook_records = $this->db->get('cashbook')->num_rows();
// 		
		// $batch_number = date('y',strtotime($cur_date)).date('m',strtotime($cur_date));
// 		
		// if($cashbook_records===0){
			// $batch_number .='01';
		// }else{
			// $last_batch_number = $this->db->select_max('batch_number')->get('cashbook')->row()->batch_number;
			// $batch_serial = substr($last_batch_number, 4);
			// $nxt_batch_serial = $batch_serial+1;
// 			
			// $next_batch_serial = '';
// 			
			// if($nxt_batch_serial<10) {
				// $next_batch_serial .='0'.$nxt_batch_serial;
			// }else{
				// $next_batch_serial=$nxt_batch_serial;
			// }
// 			
			// $batch_number .=$next_batch_serial;
		// }
// 		
		// return $batch_number;
	// }
	
	function month_income_by_income_category($category_id,$current_date){
		$detail_ids = $this->db->get_where('fees_structure_details',array('income_category_id'=>$category_id))->result_object();
		$month_income = 0;
		
		foreach($detail_ids as $ids):
			$cond = "detail_id=".$ids->detail_id." AND t_date>=".strtotime($current_date)." AND t_date<=".strtotime(date("Y-m-t",strtotime($current_date)))."";
			$this->db->where($cond);
			$month_income += $this->db->select_sum('amount')->get('student_payment_details')->row()->amount;
		endforeach;
		
		return $month_income;
	}

	function sum_income_by_income_category($category_id,$current_date){
		$detail_ids = $this->db->get_where('fees_structure_details',array('income_category_id'=>$category_id))->result_object();
		$sum_income = 0;
		
		foreach($detail_ids as $ids):
			$cond = "detail_id=".$ids->detail_id." AND t_date<".strtotime(date("Y-m-01",strtotime($current_date)))."";
			$this->db->where($cond);
			$sum_income += $this->db->select_sum('amount')->get('student_payment_details')->row()->amount;
		endforeach;
		
		return $sum_income;
	}

	function  month_expense_by_income_category($category_id,$current_date){
		
		$expense_ids = $this->db->get_where('expense_category',array('income_category_id'=>$category_id))->result_object();
		
		$expense_headers = $this->db->get('expense')->result_object();
		
		$month_expense = 0;
		
		foreach($expense_ids as $row):
				$cond = " expense_details.expense_category_id= ".$row->expense_category_id." AND expense.timestamp>='".$current_date."' AND expense.timestamp<='".date('Y-m-t',strtotime($current_date))."'";
				$this->db->join('expense', 'expense_details.expense_id = expense.expense_id', 'right');
				$this->db->where($cond);
				$month_expense += $this->db->select_sum('cost')->get('expense_details')->row()->cost;
		endforeach;		
		
		return $month_expense;
	}

	function  sum_expense_by_income_category($category_id,$current_date){
		
		$expense_ids = $this->db->get_where('expense_category',array('income_category_id'=>$category_id))->result_object();
		
		$expense_headers = $this->db->get('expense')->result_object();
		
		$sum_expense = 0;
		
		foreach($expense_ids as $row):
				$cond = " expense_details.expense_category_id= ".$row->expense_category_id."  AND expense.timestamp<'".date('Y-m-01',strtotime($current_date))."'";
				$this->db->join('expense', 'expense_details.expense_id = expense.expense_id', 'right');
				$this->db->where($cond);
				$sum_expense += $this->db->select_sum('cost')->get('expense_details')->row()->cost;
		endforeach;		
		
		return $sum_expense;
	}	
	function revenue_opening_balance($category,$current_date){
		$start_date = $this->db->get_where('settings',array('type'=>'system_start_date'))->row()->description;
	
		$open = 0;
		
		if(strtotime(date('Y-m-01',strtotime($start_date)))===strtotime(date('Y-m-01',strtotime($current_date)))){
			
				$open_obj = $this->db->get_where('opening_balance',array('income_category_id'=>$category));
					
					if($open_obj->num_rows()!==0){
						$open = $open_obj->row()->amount;	
					}
		}else{
			
			$open_obj = $this->db->get_where('opening_balance',array('income_category_id'=>$category));
			
			$open_raw = 0;
				
					if($open_obj->num_rows()!==0){
						$open_raw = $open_obj->row()->amount;	
					}
			
			$open = $open_raw + $this->sum_income_by_income_category($category, $current_date)-$this->sum_expense_by_income_category($category, $current_date);
		}
		return $open;
	}

	function budget_expense_summary_by_expense_category($expense_category_id,$fy){
		
		$arr = range(1,12);
		
		$month_total = array();
		
		for($i=1;$i<sizeof($arr)+1;$i++){
			$cond = "budget.expense_category_id=".$expense_category_id." AND budget_schedule.month=".$i." AND budget.fy=".$fy."";	
			$month_total[$i] = $this->db->select_sum('amount')->join('budget','budget_schedule.budget_id=budget.budget_id',"right")->where($cond)->get('budget_schedule')->row()->amount; 
			
		}
			
		return $month_total;
	}

	function budget_income_summary_by_expense_category($income_category_id,$fy){
		
		$arr = range(1,12);
		
		$month_total = array();
		
		for($i=1;$i<sizeof($arr)+1;$i++){
			$cond = "expense_category.income_category_id=".$income_category_id." AND budget_schedule.month=".$i." AND budget.fy=".$fy."";	
			$this->db->join('budget','budget_schedule.budget_id=budget.budget_id',"right");
			$this->db->join('expense_category','budget.expense_category_id=expense_category.expense_category_id',"right");
			$month_total[$i] = $this->db->select_sum('amount')->where($cond)->get('budget_schedule')->row()->amount; 
			
		}
			
		return $month_total;
	}
	
	function budget_summary_by_expense_category($fy){
		
		$arr = range(1,12);
		
		$month_total = array();
		
		for($i=1;$i<sizeof($arr)+1;$i++){
			$cond = "budget_schedule.month=".$i." AND budget.fy=".$fy."";	
			$month_total[$i] = $this->db->select_sum('amount')->join('budget','budget_schedule.budget_id=budget.budget_id',"right")->where($cond)->get('budget_schedule')->row()->amount; 
			
		}
			
		return $month_total;
	}
	
	function next_cashbook_date(){
		
		//Get Cashbook Object
		$cashbook_obj = $this->db->get("cashbook");
		
		$system_start_date = $this->db->get_where("settings",array("type"=>"system_start_date"))->row()->description;
		$start_date = date("Y-m-01",strtotime($system_start_date));
		$end_date = date("Y-m-t",strtotime($system_start_date));
		
		if($cashbook_obj->num_rows() > 0){
		
			/**Get Max data in the Cash Book**/
			
			$max_id = $this->db->select_max("cashbook_id")->get("cashbook")->row()->cashbook_id;
			$last_transaction = $this->db->get_where("cashbook",array("cashbook_id"=>$max_id))->row();
			$reconcile = $this->db->get("reconcile");
			
			$start_date = $last_transaction->t_date;
			$end_date = date('Y-m-t',strtotime($last_transaction->t_date));
			
			if($reconcile->num_rows() > 0){
				$last_reconcile_month = $this->db->select_max("month")->get("reconcile")->row()->month;
				if(strtotime($last_transaction->t_date) < strtotime($last_reconcile_month) || 
				strtotime($last_transaction->t_date) == strtotime($last_reconcile_month)){
					$start_date = date("Y-m-01",strtotime('first day of next month',strtotime($last_reconcile_month)));
					$end_date = date("Y-m-t",strtotime('first day of next month',strtotime($last_reconcile_month)));
				}
				
				
			}
		}
		/**Derive Start and End Dates**/
		
		$cashbook_dates['start_date'] = $start_date;
		$cashbook_dates['end_date'] = $end_date;
		//$cashbook_dates['extra'] = $max_id;
		
		/** Create Date Object**/
		
		return (object)$cashbook_dates;
	}

	/**USER PREVILEDGES**/
	
	function user_privilege($param1="",$privilege=""){
		
		$user_previledges = array();
		$arr = $this->db->join("entitlement","entitlement.entitlement_id=access.entitlement_id")->get_where('access',array("profile_id"=>$param1))->result_object();
			
		foreach($arr as $row){
			$user_previledges[] = $row->name;
		}
		
		return in_array($privilege, $user_previledges) ? true : false; 

	}

}
