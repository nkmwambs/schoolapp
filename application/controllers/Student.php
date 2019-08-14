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

class Student extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> database();
		$this -> load -> library('session');
		$this -> load -> model('Student_model', 'students');
		//$this -> db -> db_select($this -> session -> app);
		/*cache control*/
		$this -> output -> set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this -> output -> set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this -> output -> set_header('Pragma: no-cache');
		$this -> output -> set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	}

	/***default functin, redirects to login page if no admin logged in yet***/
	public function index() {
		if ($this -> session -> userdata('active_login') != 1)
			redirect(base_url() . 'index.php?login', 'refresh');

		if ($this -> session -> userdata('active_login') == 1)
			redirect(base_url() . 'index.php?student/student_information', 'refresh');
	}

	public function ajax_list() {
		$list = $this -> students -> get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $student) {

			$row = array();

			$row[] = "";
			$row[] = $student -> roll;
			$row[] = $student -> name;
			$row[] = $student -> address;
			$row[] = $student -> email;

			$data[] = $row;
		}

		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this -> students -> count_all(), "recordsTotal" => $this -> students -> count_filtered(), "recordsFiltered" => $this -> students -> count_filtered(), "data" => $data, );
		//output to json format
		echo json_encode($output);
	}

	/****MANAGE STUDENTS *****/
	function student_add() {
		if ($this -> session -> userdata('active_login') != 1)
			redirect(base_url(), 'refresh');

		$page_data['page_name'] = 'student_add';
		$page_data['page_view'] = 'student';
		$page_data['page_title'] = get_phrase('add_student');
		$this -> load -> view('backend/index', $page_data);
	}

	function student_edit($student_id) {
		if ($this -> session -> userdata('active_login') != 1)
			redirect('login', 'refresh');

		$page_data['student_id'] = $student_id;
		$page_data['page_name'] = 'student_edit';
		$page_data['page_view'] = "student";
		$page_data['page_title'] = get_phrase('edit_student');
		$this -> load -> view('backend/index', $page_data);
	}

	function student_promote($param1 = "", $param2 = "", $param3 = "") {

		$class = $this -> db -> get_where('class', array('class_id' => $param2));
		$new_numeric = $class -> row() -> name_numeric + 1;
		$new_class = $this -> db -> get_where("class", array("name_numeric" => $new_numeric));

		if ($param1 == "mass_promotion") {

			$this -> db -> where(array("class_id" => $param2, 'active' => 1));
			$data['class_id'] = $new_class -> row() -> class_id;

			$this -> db -> update("student", $data);

			if ($this -> db -> affected_rows() > 0)
				$msg = get_phrase('data_updated');
			else
				$msg = get_phrase('no_data_updated');

			$this -> session -> set_flashdata('flash_message', $msg);

			redirect(base_url() . "index.php?student/student_information/" . $new_class -> row() -> class_id, 'refresh');
		}

		if ($param1 == "single_promotion") {

			$this -> db -> where(array("class_id" => $param2, "student_id" => $param3));
			$data['class_id'] = $new_class -> row() -> class_id;

			$this -> db -> update("student", $data);

			if ($this -> db -> affected_rows() > 0)
				$msg = get_phrase('data_updated');
			else
				$msg = get_phrase('no_data_updated');

			$this -> session -> set_flashdata('flash_message', $msg);

			redirect(base_url() . "index.php?student/student_information/" . $new_class -> row() -> class_id, 'refresh');
		}

		if ($param1 == "single_demotion") {

			$new_numeric = $class -> row() -> name_numeric - 1;
			$new_class = $this -> db -> get_where("class", array("name_numeric" => $new_numeric));

			$this -> db -> where(array("class_id" => $param2, "student_id" => $param3));
			$data['class_id'] = $new_class -> row() -> class_id;

			$this -> db -> update("student", $data);

			if ($this -> db -> affected_rows() > 0)
				$msg = get_phrase('data_updated');
			else
				$msg = get_phrase('no_data_updated');

			$this -> session -> set_flashdata('flash_message', $msg);

			redirect(base_url() . "index.php?student/student_information/" . $new_class -> row() -> class_id, 'refresh');
		}

	}

	function student($param1 = '', $param2 = '', $param3 = '') {
		if ($this -> session -> userdata('active_login') != 1)
			redirect('login', 'refresh');
		if ($param1 == 'create') {
			$data['name'] = $this -> input -> post('name');
			$data['birthday'] = $this -> input -> post('birthday');
			$data['sex'] = $this -> input -> post('sex');
			$data['address'] = $this -> input -> post('address');
			$data['phone'] = $this -> input -> post('phone');
			$data['email'] = $this -> input -> post('email');
			$data['class_id'] = $this -> input -> post('class_id');
			if ($this -> input -> post('section_id') != '') {
				$data['section_id'] = $this -> input -> post('section_id');
			}
			$data['parent_id'] = $this -> input -> post('parent_id');
			$data['dormitory_id'] = $this -> input -> post('dormitory_id');
			$data['transport_id'] = $this -> input -> post('transport_id');
			$data['roll'] = $this -> input -> post('roll');
			$data['upi_number'] = $this -> input -> post('upi_number');
			$this -> db -> insert('student', $data);
			$student_id = $this -> db -> insert_id();

			if ($this -> input -> post('secondary_care')) {
				$care_array = $this -> input -> post('secondary_care');

				foreach ($care_array as $caregiver_id) {
					$data2['parent_id'] = $caregiver_id;
					$data2['student_id'] = $student_id;

					$this -> db -> insert('caregiver', $data2);
				}
			}

			move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
			$this -> session -> set_flashdata('flash_message', get_phrase('data_added_successfully'));
			$this -> email_model -> account_opening_email('student', $data['email']);
			//SEND EMAIL ACCOUNT OPENING EMAIL
			redirect(base_url() . 'index.php?student/student_add/' . $data['class_id'], 'refresh');
		}
		if ($param2 == 'do_update') {
			$data['name'] = $this -> input -> post('name');
			$data['birthday'] = $this -> input -> post('birthday');
			$data['sex'] = $this -> input -> post('sex');
			$data['address'] = $this -> input -> post('address');
			$data['phone'] = $this -> input -> post('phone');
			$data['email'] = $this -> input -> post('email');
			$data['class_id'] = $this -> input -> post('class_id');
			$data['section_id'] = $this -> input -> post('section_id');
			$data['parent_id'] = $this -> input -> post('parent_id');
			$data['dormitory_id'] = $this -> input -> post('dormitory_id');
			$data['transport_id'] = $this -> input -> post('transport_id');
			$data['roll'] = $this -> input -> post('roll');
			$data['upi_number'] = $this -> input -> post('upi_number');

			$this -> db -> where('student_id', $param3);
			$this -> db -> update('student', $data);

			if ($this -> input -> post('secondary_care')) {
				$care_array = $this -> input -> post('secondary_care');

				$this -> db -> where(array("student_id" => $param3));
				$this -> db -> delete('caregiver');

				foreach ($care_array as $caregiver_id) {

					$data2['parent_id'] = $caregiver_id;
					$data2['student_id'] = $param3;

					$this -> db -> insert('caregiver', $data2);

				}
			}

			move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
			$this -> crud_model -> clear_cache();
			$this -> session -> set_flashdata('flash_message', get_phrase('data_updated'));
			redirect(base_url() . 'index.php?student/student_information/' . $param1, 'refresh');
		}

		if ($param2 == 'delete') {
			$this -> db -> where('student_id', $param3);
			$data['active'] = 0;

			$this -> db -> update('student', $data);

			$this -> session -> set_flashdata('flash_message', get_phrase('student_suspended'));
			redirect(base_url() . 'index.php?student/student_information/' . $param1, 'refresh');
		}

		if ($param2 === 'reinstate') {

			$data['active'] = 1;
			$this -> db -> where('student_id', $param3);
			$this -> db -> update('student', $data);

			$data2['status'] = 0;
			$this -> db -> where('student_id', $param3);
			$this -> db -> update('transition_detail', $data2);

			//Reactivate the last cancelled invoice
			$check_cancelled_invoice_on_transition = $this -> db -> get_where('invoice',
			array('student_id' => $param3, 'status' => 'cancelled', 'transitioned' => 1));

			if ($check_cancelled_invoice_on_transition -> num_rows() > 0) {
				$this -> db -> where(array('invoice_id' => $check_cancelled_invoice_on_transition -> row() -> invoice_id));
				$update['status'] = 'unpaid';
				$update['transitioned'] = 0;
				$this -> db -> update('invoice', $update);
			}

			//Reactivate the caregiver is deactivated

			$parent_id = $this->db->get_where('student',array('student_id'=>$param3))->row()->parent_id;

			if($parent_id != 0){
				//Get the parent object
				$parent = $this->db->get_where('parent',array('parent_id'=>$parent_id));

				//Only update the parent if present in the database table and is inactive
				if($parent->num_rows() > 0 && $parent->row()->status == 0){
					$this->db->where(array('parent_id'=>$parent_id));
					$data_parent_status['status'] = 1;
					$this->db->update('parent',$data_parent_status);
				}
			}

			$this -> session -> set_flashdata('flash_message', get_phrase('student_reinstated'));
			redirect(base_url() . 'index.php?student/student_information/' . $param1, 'refresh');
		}
	}

	function all_students() {
		if ($this -> session -> userdata('active_login') != 1)
			redirect('login', 'refresh');

		$this->db->select(array('student_id','student.name as student_name','class.name as class_name',
		'student.address','roll','sex','student.class_id as class_id','student.parent_id as parent_id'));

		$this->db->join('class','class.class_id=student.class_id');
		$this->db->join('parent','parent.parent_id=student.parent_id');

		$page_data['students'] = $this->db->get_where('student',array('student.active'=>1))->result_array();
		$page_data['page_name'] = 'all_students';
		$page_data['page_view'] = "student";
		$page_data['page_title'] = get_phrase('students_information');
		$this -> load -> view('backend/index', $page_data);
	}

	function transition($param1 = '', $student_id = "") {

		$student = $this -> db -> get_where('student', array('student_id' => $student_id)) -> row();

		$data['transition_id'] = $this -> input -> post('transition_id');
		$data['transition_date'] = $this -> input -> post('transition_date');
		$data['student_id'] = $student_id;
		$data['reason'] = $this -> input -> post('reason');

		//Check if a transition exists
		$transition_exists = $this -> db -> get_where('transition_detail',
		array('student_id' => $student_id, 'status' => 1));

		$msg = get_phrase('action_failed');

		if ($param1 == 'add') {
			if ($transition_exists -> num_rows() == 0) {
				$this -> db -> insert('transition_detail', $data);

				$data2['active'] = 0;
				$this -> db -> where(array('student_id' => $student_id));
				$this -> db -> update('student', $data2);

				//Check if student has active invoice.
				//Unpaid invoices are given a transitioned flag of 1 when a student transitions
				$count_unpaid_invoice = $this -> db -> get_where('invoice', array('student_id' => $student_id, 'status' => 'unpaid')) -> num_rows();

				if ($count_unpaid_invoice > 0) {
					$this -> db -> where(array('student_id' => $student_id, 'status' => 'unpaid'));
					$data4['status'] = 'cancelled';
					$data4['transitioned'] = 1;
					$this -> db -> update('invoice', $data4);
				}

				//Check if a student has a parent (Both Primary and Secondary) + The parent has only this
				//Student as their only active student

				$this -> db -> select(array('parent.parent_id'));
				$this -> db -> join('student', 'student.parent_id=parent.parent_id');
				$active_parent = $this -> db -> get_where('parent',
				array('parent.status' => 1, 'student.student_id' => $student_id));

				if ($active_parent -> num_rows() > 0) {

					$parent_id = $active_parent -> row() -> parent_id;

					$active_student_with_same_parent = $this -> db -> get_where('student',
					array('parent_id' => $parent_id, 'active' => 1)) -> num_rows();

					if ($active_student_with_same_parent == 0) {
						$this -> db -> where(array('parent_id' => $parent_id));
						$data5['status'] = 0;
						$this -> db -> update('parent', $data5);
					}

				}

				$msg = get_phrase('action_successful');
			}
		}

		if ($param1 == 'edit') {
			if ($transition_exists -> num_rows() > 0) {
				$this -> db -> where(array('student_id' => $student_id));
				$this -> db -> update('transition_detail', $data);
				$msg = get_phrase('action_successful');
			}
		}

		$this -> session -> set_flashdata('flash_message', $msg);
		redirect(base_url() . 'index.php?student/student_information/' . $student -> class_id, 'refresh');
	}

	function student_information($class_id = '') {
		if ($this -> session -> userdata('active_login') != 1)
			redirect('login', 'refresh');

		$page_data['page_name'] = 'student_information';
		$page_data['page_view'] = "student";
		$page_data['page_title'] = get_phrase('student_information') . " - " . get_phrase('class') . " : " . $this -> crud_model -> get_class_name($class_id);
		$page_data['class_id'] = $class_id;
		$this -> load -> view('backend/index', $page_data);
	}

	function student_bulk_add($param1 = '') {
		if ($this -> session -> userdata('active_login') != 1)
			redirect(base_url(), 'refresh');

		if ($param1 == 'import_excel') {
			move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_import.xlsx');
			// Importing excel sheet for bulk student uploads

			include 'simplexlsx.class.php';

			$xlsx = new SimpleXLSX('uploads/student_import.xlsx');

			list($num_cols, $num_rows) = $xlsx -> dimension();
			$f = 0;
			foreach ($xlsx->rows() as $r) {
				// Ignore the inital name row of excel file
				if ($f == 0) {
					$f++;
					continue;
				}
				for ($i = 0; $i < $num_cols; $i++) {
					if ($i == 0)
						$data['name'] = $r[$i];
					else if ($i == 1)
						$data['birthday'] = $r[$i];
					else if ($i == 2)
						$data['sex'] = $r[$i];
					else if ($i == 3)
						$data['address'] = $r[$i];
					else if ($i == 4)
						$data['phone'] = $r[$i];
					else if ($i == 5)
						$data['email'] = $r[$i];
					else if ($i == 6)
						$data['roll'] = $r[$i];
				}
				$data['class_id'] = $this -> input -> post('class_id');

				$this -> db -> insert('student', $data);
				//print_r($data);
			}
			redirect(base_url() . 'index.php?student/student_information/' . $this -> input -> post('class_id'), 'refresh');
		}
		$page_data['page_name'] = 'student_bulk_add';
		$page_data['page_view'] = "student";
		$page_data['page_title'] = get_phrase('add_bulk_student');
		$this -> load -> view('backend/index', $page_data);
	}

	/**Miscelleneous Methods **/

	function get_class_students($class_id = "", $yr = "", $term = "") {

		//$class_id = "1";
		//$yr = "2018";
		//$term = "1";

		$students_object = $this -> db -> get_where('student', array('class_id' => $class_id, 'active' => 1));

		$option = '<option value="">' . get_phrase("no_student_found") . '</option>';

		if ($students_object -> num_rows() > 0) {
			$students = $students_object -> result_array();

			$option = '<option value="">' . get_phrase("select_a_student") . '</option>';
			foreach ($students as $row) {

				$sql = "SELECT * FROM invoice WHERE invoice.status = 'unpaid' AND  student_id = '" . $row['student_id'] . "' AND class_id=" . $class_id . " AND yr = " . $yr . " AND term = " . $term . " ";

				$query = $this -> db -> query($sql) -> num_rows();

				if ($query == 0) {
					$option .= '<option value="' . $row['student_id'] . '">' . $row['name'] . '</option>';
				}

			}

			echo $option;
		}

	}

	function get_class_students_mass($class_id = "", $yr = "", $term = "") {
		$students_array = $this -> db -> order_by('name') -> get_where('student', array('class_id' => $class_id, 'active' => 1)) -> result_array();
		// $yr = "2018";
		// $term = "1";
		// $class_id = "1";
		$students = array();

		foreach ($students_array as $student) {
			$check_invoice_object = $this -> db -> get_where("invoice", array("student_id" => $student['student_id'], "yr" => $yr, "term" => $term));
			if ($check_invoice_object -> num_rows() === 0) {
				$students[] = $student;
			}
		}

		echo '
<div class="form-group">
	<label class="col-sm-3 control-label">' . get_phrase('students') . '</label>
	<div class="col-sm-9">
		';
		foreach ($students as $row) {
			echo '
		<div class="checkbox">
			<label>
				<input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">
				' . $row['name'] . '</label>
		</div>';
		}
		echo '
		<br>
		<button type="button" class="btn btn-default" onClick="select()">
			' . get_phrase('select_all') . '
		</button>
		';
		echo '
		<button style="margin-left: 5px;" type="button" class="btn btn-default" onClick="unselect()">
			' . get_phrase('select_none') . '
		</button>
		';
		echo '
	</div>
</div>';
	}

}
