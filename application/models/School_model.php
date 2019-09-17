<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //COMMON FUNCTION FOR SENDING SMS
    function lowest_class_numeric()
    {
        $numeric = $this->db->select_min('name_numeric')->get('class')->row()->name_numeric;

		return $this->db->get_where('class',array('name_numeric'=>$numeric))->row()->class_id;
    }

	function highest_class_numeric()
    {
    	 $numeric = $this->db->select_max('name_numeric')->get('class')->row()->name_numeric;

		return $this->db->get_where('class',array('name_numeric'=>$numeric))->row()->class_id;
    }

	function income_categories(){
		return $this->db->get('income_categories')->result_object();
	}

	function system_title(){
		return $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	}

	function funds_transfer_by_batch_number($batch_number){

		$this->db->select(array('cashbook.batch_number','cashbook.t_date','cashbook.amount',
		'income_categories.name as account_to','expense_category.name as account_from'));



		$this->db->join('payment','payment.batch_number=cashbook.batch_number');
		$this->db->join('other_payment_details','other_payment_details.payment_id=payment.payment_id');
		$this->db->join('income_categories','income_categories.income_category_id=other_payment_details.income_category_id');

		$this->db->join('expense','expense.batch_number=cashbook.batch_number');
		$this->db->join('expense_details','expense_details.expense_id=expense.expense_id');
		$this->db->join('expense_category','expense_category.expense_category_id=expense_details.expense_category_id');

		$transfer = $this->db->get_where('cashbook',array('cashbook.batch_number'=>$batch_number))->row();

		return $transfer;
	}

  function get_approval_record_status($record_type,$primary_key_value,$primary_key_field_name = ''){
      $primary_key_field = $record_type."_id";

      $status = array();
      $status['request_type'] = "";
      $status['request_status'] = "";

      if($primary_key_field_name!==""){
          $primary_key_field = $primary_key_field_name;
      }

      $record = $this->db->get_where($record_type,array($primary_key_field=>$primary_key_value))->row();

      $last_approval_request_id = $record->last_approval_request_id;

      if($last_approval_request_id > 0){
        $this->db->select(array('request_type.name as request_type','approval_request.status'));
        $this->db->join('request_type','request_type.request_type_id=approval_request.request_type_id');
        $approval_request = $this->db->get_where('approval_request',
        array('approval_request.approval_request_id'=>$last_approval_request_id))->row();

        $status['request_type'] = $approval_request->request_type;
        $status['request_status'] = $approval_request->status;
      }

      return $status;
  }

  function get_system_settings($type = ""){

    if($type!==""){
      $this->db->where(array('type'=>$type));
    }
    $settings = $this->db->get('settings')->result_object();
    $type_keys = array_column($settings,'type');
    $desc_keys = array_column($settings,'description');

    if($type!==""){
        $description =  array_combine($type_keys,$desc_keys);
        return $description[$type];
    }else{
        return array_combine($type_keys,$desc_keys);
    }

  }



  function auto_set_settings_values(){
    $required_settings_array = array(
      'manage_invoice_require_approval'=>'true',
      'allowable_variance_lower_limit'=>-10,
      'allowable_variance_upper_limit'=>10,
      'student_payment_spread_mode'=>'ratio',
      'show_unpaid_invoice_when_mass_creating_invoices'=>'true');

    foreach ($required_settings_array as $required_setting_key=>$required_setting_value) {
      $type = $this->db->get_where('settings',array('type'=>$required_setting_key));

      if($type->num_rows() == 0){
          $this->db->insert('settings',array('type'=>$required_setting_key,'description'=>$required_setting_value));
      }
    }
  }

  function get_default_income_category(){
    $default_category_obj = $this->db->get_where('income_categories',
    array('default_category'=>1));

    $default_category = "";

    if($default_category_obj->num_rows()>0){
      $default_category = $default_category_obj->row()->income_category_id;
    }

    return $default_category;
  }

  function get_fees_structure_detail_id_of_default_category($fees_id){
    $this->db->select(array('detail_id'));
    $this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
    $this->db->where(array('income_category_id'=>$this->get_default_income_category(),'fees_id'=>$fees_id));
    $detail_id = $this->db->get_where('fees_structure_details')->row()->detail_id;

    return $detail_id;
  }

}
