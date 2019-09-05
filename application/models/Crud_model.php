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
    function get_students($class_id,$active = 1) {
        $query = $this->db->get_where('student', array('class_id' => $class_id,'active'=>$active));
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

				$bank_income_cond = " ((transaction_type_id='1' AND transaction_method_id='2') OR transaction_type_id='3') AND t_date<'".$c_date."'";// AND t_date<='".$c_date."'

				$bank_income = $this->db->select_sum('amount')->where($bank_income_cond)->get('transaction')->row()->amount;

				$bank_expense_cond = " ((transaction_type_id='2' AND transaction_method_id='2') OR transaction_type_id='4') AND t_date<'".$c_date."'";

				$bank_expense = $this->db->select_sum('amount')->where($bank_expense_cond)->get('transaction')->row()->amount;

				$bank_balance = ($opening_bank_balance+$bank_income)-$bank_expense;

				//Sum all Cash Income and expenses in previous months before the supplied months and get their difference

				$cash_income_cond = " ((transaction_type_id='1' AND transaction_method_id='1') OR transaction_type_id='4') AND t_date<'".$c_date."'";

				$cash_income = $this->db->select_sum('amount')->where($cash_income_cond)->get('transaction')->row()->amount;

				$cash_expense_cond = " ((transaction_type_id='2' AND transaction_method_id='1') OR transaction_type_id='3') AND t_date<'".$c_date."'";

				$cash_expense = $this->db->select_sum('amount')->where($cash_expense_cond)->get('transaction')->row()->amount;

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
		$transactions = $this->db->get_where('transaction',array('Month(t_date)'=>$month,'Year(t_date)'=>$year))->result_object();

		$sum_bank_income = 0;
		$sum_bank_expense = 0;
		$bank_balance = 0;

		foreach($transactions as $rows){
			$bank_income = 0;
			if(($rows->transaction_type_id==='1' && $rows->transaction_method_id==='2')||$rows->transaction_type_id==='3') $bank_income = $rows->amount;
			$sum_bank_income +=	$bank_income;

			$bank_expense = 0;
			if(($rows->transaction_type_id==='2' && $rows->transaction_method_id==='2')||$rows->transaction_type_id==='4') $bank_expense = $rows->amount;
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
		$max_serial_number = $this->db->get('transaction')->row()->batch_number + 1;

		$current_transaction_month = strtotime($this->current_transaction_month());
		$last_reconciled_month = strtotime($this->last_reconciled_month());

		$count_of_transactions_in_current_transacting_month = $this->db->get_where('transaction',
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

	function budget_expense_summary_by_expense_category($expense_category_id,$fy,$terms_id){

		$arr = $this->months_in_a_term($terms_id);

		$month_total = array();

		for($i=1;$i<sizeof($arr)+1;$i++){
			$cond = "budget.expense_category_id=".$expense_category_id." AND budget_schedule.month=".$i." AND budget.fy=".$fy." AND budget.terms_id=".$terms_id;
			$month_total[$i] = $this->db->select_sum('amount')->join('budget','budget_schedule.budget_id=budget.budget_id',"right")->where($cond)->get('budget_schedule')->row()->amount;

		}

		return $month_total;
	}

	function budget_income_summary_by_expense_category($income_category_id,$fy,$terms_id){

		$arr = $this->months_in_a_term($terms_id);

		$month_total = array();

		for($i=1;$i<sizeof($arr)+1;$i++){
			$cond = "expense_category.income_category_id=".$income_category_id." AND budget_schedule.month=".$i." AND budget.fy=".$fy." AND budget.terms_id =".$terms_id;
			$this->db->join('budget','budget_schedule.budget_id=budget.budget_id',"right");
			$this->db->join('expense_category','budget.expense_category_id=expense_category.expense_category_id',"right");
			$month_total[$i] = $this->db->select_sum('amount')->where($cond)->get('budget_schedule')->row()->amount;

		}

		return $month_total;
	}

	function budget_summary_by_expense_category($fy,$term_id){

		$arr = $this->months_in_a_term($term_id);

		$month_total = array();

		for($i=1;$i<sizeof($arr)+1;$i++){
			$cond = "budget_schedule.month=".$i." AND budget.fy=".$fy." AND budget.terms_id=".$term_id;
			$month_total[$i] = $this->db->select_sum('amount')->join('budget','budget_schedule.budget_id=budget.budget_id',"right")->where($cond)->get('budget_schedule')->row()->amount;

		}

		return $month_total;
	}

	function next_cashbook_date(){

			//Get Cashbook Object
			$cashbook_obj = $this->db->get("transaction");

			$system_start_date = $this->db->get_where("settings",array("type"=>"system_start_date"))->row()->description;
			$start_date = date("Y-m-01",strtotime($system_start_date));
			$end_date = date("Y-m-t",strtotime($system_start_date));

			if($cashbook_obj->num_rows() > 0){

				/**Get Max data in the Cash Book**/

				$max_id = $this->db->select_max("transaction_id")->get("transaction")->row()->transaction_id;
				$last_transaction = $this->db->get_where("transaction",array("transaction_id"=>$max_id))->row();
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
		$arr = $this->db->join("entitlement","entitlement.entitlement_id=access.entitlement_id")
    ->get_where('access',array("profile_id"=>$param1))->result_object();

		foreach($arr as $row){
			$user_previledges[] = $row->name;
		}

		return in_array($privilege, $user_previledges) ? true : false;

	}

	function grep_db($db_name, $search_values)
		{
			// Init vars
			$table_fields = array();
			$cumulative_results = array();
			$use_tables = array('student','parent','teacher');

			// Pull all table columns that have character data types
			$result = $this->db->query("
				SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
				FROM  `INFORMATION_SCHEMA`.`COLUMNS`
				WHERE  `TABLE_SCHEMA` =  '{$db_name}'
				AND `DATA_TYPE` IN ('varchar', 'char', 'text','longtext')
				")->result_array();

			// Build table-keyed columns so we know which to query
			foreach ( $result  as $o )
			{
				if(!in_array($o['TABLE_NAME'], $use_tables)) continue;

				$table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];
			}

			// Build search query to pull the affected rows
			// Search Each Row for matches
			foreach($table_fields as $table_name => $fields)
			{
				// Clear search array
				$search_array = array();

				// Add a search for each search match
				foreach($fields as $field)
				{

					foreach($search_values as $value)
					{
						$search_array[] = " `{$field}` LIKE '%{$value}%' ";
					}
				}
				// Implode $search_array
				$search_string = implode (' OR ', $search_array);


				$query_string = "SELECT * FROM `{$table_name}`  WHERE {$search_string}";


				$table_results[$table_name] = $this->db->query($query_string)->result_array();
				$cumulative_results = array_merge($cumulative_results, $table_results);
			}

			return $cumulative_results;
		}

	/**
	 * Start of Upgraded Finance Model
	 */

	//  	function next_batch_number(){
  //
	// 	$this->db->select_max('batch_number');
	// 	$max_serial_number = $this->db->get('transaction')->row()->batch_number + 1;
  //
	// 	$current_transaction_month = strtotime($this->current_transaction_month());
	// 	$last_reconciled_month = strtotime($this->last_reconciled_month());
  //
	// 	$count_of_transactions_in_current_transacting_month = $this->db->get_where('transaction',
	// 	array('t_date>='=>$this->current_transaction_month()))->num_rows();
  //
	// 	if($current_transaction_month > $last_reconciled_month &&
	// 		$count_of_transactions_in_current_transacting_month == 0){
	// 	 	$max_serial_number = date('y').date('m',$current_transaction_month).'01';
	// 	}
  //
	// 	return $max_serial_number;
	// }

  private function generate_voucher_number($date,$next_serial){

      $yr = date('y',strtotime($date));

      $month = date('n',strtotime($date));

      if($month===12){
        $month = 1;
        $yr = $yr+1;
      }

      if($month<10){
        $month ='0'.$month;
      }

      if($next_serial<10){
        $next_serial = '0'.$next_serial;
      }

      return $yr.$month.$next_serial;
  }

  function next_batch_number(){

      $voucher_count = $this->db->get('transaction')->num_rows();

      $last_mfr_date = $this->db->select_max('month')->get('reconcile')->row()->month;

      $max_voucher_id = $this->db->select_max('transaction_id')->get('transaction')->row()->transaction_id;

      $voucher_date = $this->db->get_where('transaction',array("transaction_id"=>$max_voucher_id))->row()->t_date;

      if($voucher_count>0){

        $current_voucher_date = $voucher_date;

        $start_month_date = date("Y-m-01",strtotime($voucher_date));

        $end_month_date = date("Y-m-t",strtotime($voucher_date));

        $current_voucher = $this->db->get_where('transaction',array("transaction_id"=>$max_voucher_id))->row()->batch_number;

        if(strtotime($last_mfr_date)< strtotime($start_month_date)){

          $vnum = $this->generate_voucher_number($start_month_date,substr($current_voucher,4)+1);

        }elseif(strtotime($last_mfr_date) >= strtotime($start_month_date)){

          $current_voucher_date = date('Y-m-01',strtotime('first day of next month',strtotime($last_mfr_date)));

          $start_month_date = date("Y-m-d",strtotime('first day of next month',strtotime($last_mfr_date)));

          $end_month_date = date("Y-m-t",strtotime('last day of next month',strtotime($last_mfr_date)));

          $vnum = $this->generate_voucher_number($start_month_date,1);

        }

      }else{
        $system_start_date = $this->db->get_where("settings",array("type"=>"system_start_date"))->row()->description;

        $current_voucher_date = date("Y-m-01",strtotime('first day of the next month',strtotime($system_start_date)));

        $end_month_date = date("Y-m-t",strtotime($system_start_date));

        $current_voucher_date = $system_start_date;

        $vnum = $this->generate_voucher_number($system_start_date,1);
      }

      $voucher_details['vnum'] = $vnum;
      $voucher_details['current_voucher_date'] = $current_voucher_date;
      $voucher_details['start_month_date'] = $start_month_date;
      $voucher_details['end_month_date'] = $end_month_date;

      return $vnum;//(object)$voucher_details;

   }

	function account_opening_balance($curr_date){

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

				$bank_income = $this->db->select_sum('amount')->where($bank_income_cond)->get('transaction')->row()->amount;

				$bank_expense_cond = " ((transaction_type='2' AND account='2') OR transaction_type='4') AND t_date<'".$c_date."'";

				$bank_expense = $this->db->select_sum('amount')->where($bank_expense_cond)->get('transaction')->row()->amount;

				$bank_balance = ($opening_bank_balance+$bank_income)-$bank_expense;

				//Sum all Cash Income and expenses in previous months before the supplied months and get their difference

				$cash_income_cond = " ((transaction_type='1' AND account='1') OR transaction_type='4') AND t_date<'".$c_date."'";

				$cash_income = $this->db->select_sum('amount')->where($cash_income_cond)->get('transaction')->row()->amount;

				$cash_expense_cond = " ((transaction_type='2' AND account='1') OR transaction_type='3') AND t_date<'".$c_date."'";

				$cash_expense = $this->db->select_sum('amount')->where($cash_expense_cond)->get('transaction')->row()->amount;

				$cash_balance = ($opening_cash_balance+$cash_income)-$cash_expense;
		}
		//Return the Cash and Bank Balances

		return array('cash_balance'=>$cash_balance,'bank_balance'=>$bank_balance);
	}

	function next_transaction_date(){

			//Get Cashbook Object
			$cashbook_obj = $this->db->get("transaction");

			$system_start_date = $this->db->get_where("settings",array("type"=>"system_start_date"))->row()->description;
			$start_date = date("Y-m-01",strtotime($system_start_date));
			$end_date = date("Y-m-t",strtotime($system_start_date));

			if($cashbook_obj->num_rows() > 0){

				/**Get Max data in the Cash Book**/

				$max_id = $this->db->select_max("transaction_id")->get("transaction")->row()->transaction_id;
				$last_transaction = $this->db->get_where("transaction",array("transaction_id"=>$max_id))->row();
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

	function get_invoice_detail_balance($invoice_detail_id){

		//Get details due amount
		$due_amount = $this->db->get_where('invoice_details',
		array('invoice_details_id'=>$invoice_detail_id))->row()->amount_due;


		//Get Sum paid
		$amount_paid = $this->get_invoice_detail_amount_paid($invoice_detail_id);

		//Compute balance
		$balance = $due_amount - $amount_paid;

		return $balance;
	}

	function get_invoice_detail_amount_paid($invoice_detail_id){

		$amount_paid = $this->db->select_sum('cost')->get_where('transaction_detail',
		array('invoice_details_id'=>$invoice_detail_id))->row()->cost;

		return $amount_paid;
	}

	function get_invoice_amount_paid($invoice_id){

		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$amount_paid = $this->db->select_sum('cost')->get_where('transaction_detail',
		array('invoice_id'=>$invoice_id))->row()->cost;

		return $amount_paid;
	}

	function get_invoice_balance($invoice_id){
		$invoice_due = $this->db->get_where('invoice',array('invoice_id'=>$invoice_id))->row()->amount_due;

		$balance = $invoice_due - $this->get_invoice_amount_paid($invoice_id);

		return $balance;
	}

	function get_invoice_payment_history($invoice_id){
		$this->db->select(array('transaction.invoice_id','transaction.t_date',
        'transaction_detail.cost','invoice_details.detail_id',
		'fees_structure_details.name','transaction.transaction_method_id',
		'transaction_method.description as transaction_method'));

		$this->db->join('invoice_details','invoice_details.invoice_details_id=transaction_detail.invoice_details_id');
 		$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$this->db->join('transaction_method','transaction_method.transaction_method_id=transaction.transaction_method_id');
		$payment_history = $this->db->get_where('transaction_detail', array('transaction.invoice_id' => $invoice_id));

		return $payment_history;
	}

	function redeemed_overpay($overpay_id){

		return $this->db->select_sum('amount_redeemed')->get_where('overpay_charge_detail',
		array('overpay_id'=>$overpay_id))->row()->amount_redeemed;
	}

	function overpay_balance($overpay_id){
		$overpay_amount = $this->db->get_where('overpay',array('overpay_id'=>$overpay_id))->row()->amount;

		$redeemed_overpay = $this->redeemed_overpay($overpay_id);

		return $overpay_amount - $redeemed_overpay;
	}

	function get_term_range_of_months($date){
		$month = date('n',strtotime($date));

		$all_terms = $this->db->get('terms')->result_object();

		$range = array();

		foreach($all_terms as $term){
			$term_months[$term->terms_id] = range($term->start_month, $term->end_month);

			if(in_array($month, $term_months[$term->terms_id])){
				$range = range($term->start_month, $term->end_month);
				break;
			}
		}

		return $range;
	}

	function get_month_key_in_term($date){
		$month = date('n',strtotime($date));

		 $all_terms = $this->db->get('terms')->result_object();

		 $key = 1;

		 foreach($all_terms as $term){
			$term_months[$term->terms_id] = range($term->start_month, $term->end_month);

			if(in_array($month, $term_months[$term->terms_id])){
				$key = array_search($month, $term_months[$term->terms_id]) + 1;
				break;
			}
		}

		return $key;
	}

	function get_current_term_based_on_date($date){
		$month = date('n',strtotime($date));

		 $all_terms = $this->db->get('terms')->result_object();

		 $term_data = array();

		 foreach($all_terms as $term){
			$term_months[$term->terms_id] = range($term->start_month, $term->end_month);

			if(in_array($month, $term_months[$term->terms_id])){
				$term_data['term_id'] = $term->terms_id;
				$term_data['key'] = array_search($month, $term_months[$term->terms_id]) + 1;
				break;
			}
		}

		return $term_data;
	}

	function get_current_term_limit_dates($date){
		/**
		 * Compute term last and start dates and return them in an array of two elements with
		 * keys term_start_date and term_end_date
		 */

		 $month = date('n',strtotime($date));

		 $year = date('Y',strtotime($date));

		 $all_terms = $this->db->get('terms')->result_object();

		 $term_limits = array();

		 foreach($all_terms as $term){
			$term_months[$term->terms_id] = range($term->start_month, $term->end_month);

			 $start_month = strlen($term->start_month) == 1 ? '0'.$term->start_month:$term->start_month;
			 $end_month = strlen($term->end_month) == 1 ? '0'.$term->end_month:$term->end_month;

			if(in_array($month, $term_months[$term->terms_id])){
				$term_limits['term_start_date'] = $year.'-'.$start_month.'-01';
				$term_limits['term_end_date'] = date('Y-m-t',strtotime($year.'-'.$end_month.'-01'));
				break;
			}
		}

		return $term_limits;
	}

	function get_current_term(){
		$current_transacting_month = $this->current_transaction_month();

		$month = date('n',strtotime($current_transacting_month));

		$all_terms = $this->db->get('terms')->result_object();

		$term_months = array();

		$current_term = 1;

		foreach($all_terms as $term){
			$term_months[$term->terms_id] = range($term->start_month, $term->end_month);//array($term->start_month,$term->end_month);

			if(in_array($month, $term_months[$term->terms_id])){
				$current_term = $term->terms_id;
				break;
			}
		}

		return $current_term;

	}

	function months_in_a_term($term_id){

		$term = $this->db->get_where('terms',array('terms_id'=>$term_id))->row();

		return range($term->start_month, $term->end_month);
	}

	function months_in_a_term_short_name($term_id){

		$arr = array();

		$short = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

		$cnt = 0;
		foreach($this->months_in_a_term($term_id) as $month_number){
			$arr[$cnt] = $short[$month_number];
			$cnt++;
		}

		return $arr;
	}

	function fees_paid_by_invoice($invoice_id){

		$total_paid = 0;

		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$obj = $this->db->select_sum('cost')->get_where('transaction_detail',
		array('invoice_id'=>$invoice_id));

		$count_of_details = $this->db->get_where('invoice_details',array('invoice_id'=>$invoice_id))->num_rows();

		if($count_of_details != 0 && $obj->row()->cost > 0){
			$total_paid = $obj->row()->cost;
		}
		// $this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		// $total_paid = $this->db->select_sum('cost')->get_where('transaction_detail',
		// array('invoice_id'=>$invoice_id))->row()->cost;

		return $total_paid;
	}

	function fees_amount_due_by_invoice($invoice_id){
    $this->db->join('invoice_details','invoice_details.invoice_id=invoice.invoice_id');
		$details_amount_due = $this->db->select_sum('invoice_details.amount_due')->get_where('invoice',array('invoice.invoice_id'=>$invoice_id))->row()->amount_due;

    $invoice_amount_due = $this->db->select_sum('amount_due')->get_where('invoice',array('invoice_id'=>$invoice_id))->row()->amount_due;

    if($invoice_amount_due !== $details_amount_due){
        $this->db->where(array('invoice_id'=>$invoice_id));
        $this->db->update('invoice',array('amount_due'=>$details_amount_due));
    }

    return $details_amount_due;
  }


	function fees_balance_by_invoice($invoice_id){

		$amount_due = $this->fees_amount_due_by_invoice($invoice_id);//$this->db->select_sum('amount_due')->get_where('invoice',array('invoice_id'=>$invoice_id))->row()->amount_due;

		$paid = $this->fees_paid_by_invoice($invoice_id);

		$balance = $amount_due - $paid;

		//$this->db->where(array('invoice_id'=>$invoice_id));

		if($balance == 0){
			$this->db->where(array('invoice_id'=>$invoice_id,'status<>'=>'cancelled'));
			$this->db->update('invoice',array('status'=>'paid'));
		}
		elseif($balance < 0){
			$this->db->where(array('invoice_id'=>$invoice_id,'status<>'=>'cancelled'));
			$this->db->update('invoice',array('status'=>'excess'));
		}elseif($balance > 0){

			$this->db->where(array('invoice_id'=>$invoice_id,'status<>'=>'cancelled'));
			$this->db->update('invoice',array('status'=>'unpaid'));
		}

		return $balance;
	}

	function fees_paid_by_invoice_detail($invoice_details_id){

		$total_paid = $this->db->select_sum('cost')->get_where('transaction_detail',
		array('invoice_details_id'=>$invoice_details_id))->row()->cost;

		return $total_paid;
	}

	function student_unpaid_invoice_balance($student_id){
		$invoice_id_obj = $this->db->get_where('invoice',array('student_id'=>$student_id,'status'=>'unpaid'));

		$unpaid = 0;

		if($invoice_id_obj->num_rows() > 0){
			$invoice_id = $invoice_id_obj->row()->invoice_id;
			$unpaid = $this->fees_balance_by_invoice($invoice_id);
		}

		return $unpaid;
	}

	function fees_balance_by_invoice_detail($invoice_details_id){
		$amount_due = $this->db->select_sum('amount_due')->get_where('invoice_details',array('invoice_details_id'=>$invoice_details_id))->row()->amount_due;

		$paid = $this->fees_paid_by_invoice_detail($invoice_details_id);

		return $amount_due - $paid;
	}


	function term_total_paid_fees($year, $term){

		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$this->db->join('invoice','invoice.invoice_id=transaction.invoice_id');
		$total_paid = $this->db->select_sum('cost')->get_where('transaction_detail',
		array('yr'=>$year,'term'=>$term))->row()->cost;

		//Terms Overpayments
		$this->db->join('transaction','transaction.transaction_id=overpay.transaction_id');
		$this->db->join('invoice','invoice.invoice_id=transaction.invoice_id');
		$overpaid = $this->db->select_sum('overpay.amount')->get_where('overpay',array('yr'=>$year,'term'=>$term))->row()->amount;

		return $total_paid - $overpaid;
	}

	function term_total_fees_balance($year, $term){
		$this->db->join('invoice_details','invoice_details.invoice_id=invoice.invoice_id');
		$amount_due = $this->db->select_sum('invoice_details.amount_due')->get_where('invoice',
    array('yr'=>$year,'term'=>$term,'invoice.status<>'=>'cancelled'))->row()->amount_due;

		$paid = $this->term_total_paid_fees($year, $term);

		return $amount_due - $paid;
	}

	function get_invoice_transaction_history($invoice_id){
		$this->db->join('transaction_method','transaction_method.transaction_method_id=transaction.transaction_method_id');

		$history = $this->db->select(array('transaction.batch_number','t_date','amount','transaction.description as description',
		'transaction_method.description as transaction_method'))->get_where('transaction',
		array('invoice_id'=>$invoice_id))->result_object();

		return $history;
	}

	function max_transaction_date(){
		return $this->db->select_max('t_date')->get('transaction')->row()->t_date;
	}

	function check_transaction_reverse_approval($transaction_id){

		$approval_obj =$this->db->get_where('approval',
		array('affected_table_name'=>'transaction','action_to_approve'=>'reverse_transaction',
		'affected_record_id'=>$transaction_id));

		$approval_status = -1;

		if($approval_obj->num_rows() > 0){
			$approval_status = $approval_obj->row()->approval_status;
		}

		return $approval_status;
	}
	 /**
	  * End of Upgraded Finance Model
	  */

  function year_unpaid_invoices($year){

    $this -> db -> where('status', 'unpaid');
    $this -> db -> where('yr', $year);
    $this -> db -> order_by('creation_timestamp', 'desc');
    $unpaid_invoices = $this -> db -> get('invoice') -> result_array();

    return $unpaid_invoices;
  }

function year_paid_invoices($year){
    $this -> db -> where('status', 'paid');
    $this -> db -> where('yr', $year);
    $this -> db -> order_by('creation_timestamp', 'desc');
    $paid_invoices = $this -> db -> get('invoice') -> result_array();

    return $paid_invoices;
}

function year_overpaid_invoice($year){
  $this -> db -> where('status', 'excess');
  $this -> db -> where('yr', $year);
  $this -> db -> order_by('creation_timestamp', 'desc');
  $overpaid_invoices = $this -> db -> get('invoice') -> result_array();

  return $overpaid_invoices;
}

function active_overpay_notes(){
  $this -> db -> where('status', 'active');
  //$this->db->where('yr' , $year);
  $this -> db -> order_by('creation_timestamp', 'desc');
  $overpay_notes = $this -> db -> get('overpay') -> result_array();

  return $overpay_notes;
}

function cleared_overpay_notes(){
  $this -> db -> where('status', 'cleared');
  //$this->db->where('yr' , $year);
  $this -> db -> order_by('creation_timestamp', 'desc');
  $cleared_overpay_notes = $this -> db -> get('overpay') -> result_array();

  return $cleared_overpay_notes;
}

function year_cancelled_invoices($year){
  $this -> db -> where('status', 'cancelled');
  $this -> db -> where('yr', $year);
  $this -> db -> order_by('creation_timestamp', 'desc');
  $cancelled_invoices = $this -> db -> get('invoice') -> result_array();

  return $cancelled_invoices;
}

function student_invoice_tally_by_income_category($year = "" , $invoice_status = 'unpaid'){

  $term = $this->get_current_term();

  //Get all unpaid invoices for the term
  $this -> db -> select(array('student.name as student', 'invoice.student_id', 'student.roll as roll',
  'fees_structure_details.income_category_id', 'invoice.invoice_id', 'income_categories.name as category',
  'class.name as class'));

  $this -> db -> select_sum('invoice_details.amount_due');

  $this -> db -> join('invoice', 'invoice.invoice_id=invoice_details.invoice_id');
  $this -> db -> join('student', 'student.student_id=invoice.student_id');
  $this -> db -> join('fees_structure_details', 'fees_structure_details.detail_id=invoice_details.detail_id');
  $this -> db -> join('income_categories', 'income_categories.income_category_id=fees_structure_details.income_category_id');
  $this -> db -> join('class', 'class.class_id = invoice.class_id');

  $this -> db -> group_by('student.student_id');
  $this -> db -> group_by('fees_structure_details.income_category_id');

  $ungrouped_payments = $this -> db -> get_where('invoice_details',
  array('invoice.yr' => $year, 'invoice.term' => $term, 'invoice.status' => $invoice_status)) -> result_object();

  return $ungrouped_payments;
}


function get_invoice_amount_paid_by_income_category($invoice_id,$income_category_id){
  $this -> db -> select_sum('cost');
  $this -> db -> join('transaction', 'transaction.transaction_id=transaction_detail.transaction_id');
  $this -> db -> join('invoice', 'invoice.invoice_id=transaction.invoice_id');

  $this -> db -> group_by('transaction_detail.income_category_id');

  $this -> db -> where(array('transaction.invoice_id' => $invoice_id, 'income_category_id' => $income_category_id));
  $paid_obj = $this -> db -> get('transaction_detail');

  $paid = 0;

  if($paid_obj->num_rows()>0){
      $paid = $paid_obj-> row() -> cost;
  }

  return $paid;
}

}
