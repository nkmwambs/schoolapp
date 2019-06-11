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

class Finance extends CI_Controller
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

    /**
	 * Fees structure Management
	 */
	 
	 function scroll_fees_structure($year = ""){
	 	if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		
		$page_data['fees'] =  $this->db->get_where('fees_structure',array('yr'=>$year))->result_array();
		$page_data['year'] = $year;
		$page_data['page_name']  = 'fees_structure';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('fees_structure');
        $this->load->view('backend/index', $page_data);	
	 }
	 
	 function fees_structure_add(){
	 	if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		$page_data['page_name']  = 'fees_structure_add';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('add_fees_structure');
        $this->load->view('backend/index', $page_data);
	 }
	 
	 function fees_structure($param1 = '', $param2 = ''){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
			$data['class_id']   =   $this->input->post('class_id');
			$data['yr']   =   $this->input->post('yr');
			$data['term']   =   $this->input->post('term');
			
			//Check if the Fees structure Exists
			
			$chk = $this->db->get_where('fees_structure',array('name'=>$this->input->post('name')))->num_rows();
			
			if($chk===0){
				$this->db->insert('fees_structure' , $data);
				
				if($this->input->post('income_category_id')){
					$income_category_id = $this->input->post('income_category_id');
					$name = $this->input->post('category_name');
					$amount = $this->input->post('amount');
					$fees_id = $this->db->insert_id();
					
					for($i=0;$i<count($income_category_id);$i++){
						$data2['income_category_id'] = $income_category_id[$i];
						$data2['name'] = $name[$i];
						$data2['amount'] = $amount[$i];
						$data2['fees_id'] = $fees_id;
						
						$this->db->insert('fees_structure_details',$data2);
					}			
				}
		    	
            	$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));	
			}else{
				$this->session->set_flashdata('flash_message' , get_phrase('record_already_exists'));
			}
			
            
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
		
		if($param1=='clone'){
			$data['name']   =   $this->input->post('name');
			$data['class_id']   =   $this->input->post('class_id');
			$data['yr']   =   $this->input->post('yr');
			$data['term']   =   $this->input->post('term');
			
			//Check if the Fees structure Exists
			
			$chk = $this->db->get_where('fees_structure',array('name'=>$this->input->post('name')))->num_rows();
			
			$insert_id = 0;
			
			if($chk===0){
				$this->db->insert('fees_structure' , $data);
				$insert_id = $this->db->insert_id();	
            	$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));	
			}else{
				$this->session->set_flashdata('flash_message' , get_phrase('record_already_exists'));
			}
			
			/**Get original fees structure details**/
			$fees_structure_details = $this->db->select("name,income_category_id,amount")->get_where("fees_structure_details",array("fees_id"=>$param2));
			if($fees_structure_details->num_rows() > 0){
				
				$new_details =array();
				
				foreach($fees_structure_details->result_array() as $detail){
					
					$new_details = $detail;
					$new_details['fees_id'] = $insert_id;
										
					$this->db->insert("fees_structure_details",$new_details);
				}	

			}

		}
		
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
			$data['class_id']   =   $this->input->post('class_id');
			//$data['income_category_id']   =   $this->input->post('income_category_id');
			$data['yr']   =   $this->input->post('yr');
			$data['term']   =   $this->input->post('term');
			//$data['amount']   =   $this->input->post('amount');
			
            $this->db->where('fees_id' , $param2);
            $this->db->update('fees_structure' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
        if ($param1 == 'delete') {
           	//Check if there is an invoice for the fees structure
           	$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');
           	$count_invoice_details = $this->db->get_where('invoice_details',array('fees_id'=>$param2))->num_rows();
			
			$msg = get_phrase('deleted_failed');
			
			if($count_invoice_details == 0){
				$this->db->delete('fees_structure_details',array('fees_id'=>$param2));
				$this->db->delete('fees_structure',array('fees_id'=>$param2));
				
				if($this->db->affected_rows() > 0){
					$msg = get_phrase('data_deleted');
				}
			}
		
			
            $this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
		
		$page_data['fees'] =  $this->db->get_where('fees_structure',array('yr'=>date('Y')))->result_array();
		$page_data['year'] = date('Y');
		$page_data['page_name']  = 'fees_structure';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('fees_structure');
        $this->load->view('backend/index', $page_data);	
	}

	function fees_structure_details($param1 = '', $param2 = ''){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
			$data['fees_id']   =   $this->input->post('fees_id');
			$data['income_category_id']   =   $this->input->post('income_category_id');
			$data['amount']   =   $this->input->post('amount');

 			$this->db->insert('fees_structure_details' , $data);
			
			//Adjust Existing Invoices -- All student in the same 
			$structure = $this->db->get_where('fees_structure',array('fees_id'=>$this->input->post('fees_id')))->row();
			
			$class_id = $structure->class_id;
			$yr = $structure->yr;
			$term = $structure->term;
			
			$tot_fees = $this->db->select_sum('amount')->get_where('fees_structure_details',array('fees_id'=>$this->input->post('fees_id')))->row()->amount;
			
			//All student affected by the structure
			
			$students = $this->db->get_where('student',array('class_id'=>$class_id))->result_object();
			
			foreach($students as $inv):

				if($this->db->get_where('invoice',array('student_id'=>$inv->student_id,'yr'=>$yr,'term'=>$term))->num_rows()>0){
					$this->db->where(array('student_id'=>$inv->student_id,'yr'=>$yr,'term'=>$term));
					$data2['amount'] = $tot_fees;
					$this->db->update('invoice',$data2);
				}
				
			endforeach;

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
				
		if($param1=='create_multiple_fields'){
			$income_category_id = $this->input->post('income_category_id');
			$name = $this->input->post('name');
			$amount = $this->input->post('amount');
			$fees_id = $param2;
			
			for($i=0;$i<count($income_category_id);$i++){
				$data['income_category_id'] = $income_category_id[$i];
				$data['name'] = $name[$i];
				$data['amount'] = $amount[$i];
				$data['fees_id'] = $fees_id;
				
				$this->db->insert('fees_structure_details',$data);
			}
			
			$this->session->set_flashdata('flash_message' , get_phrase('data_created'));
            redirect(base_url() . 'index.php?finance/fees_structure');
		}
		
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
			$data['income_category_id']   =   $this->input->post('income_category_id');
			$data['amount']   =   $this->input->post('amount');
			
            $this->db->where('detail_id' , $param2);
            $this->db->update('fees_structure_details' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
        if ($param1 == 'delete') {
            $this->db->where('detail_id' , $param2);
            $this->db->delete('fees_structure_details');
			
			//Delete all invoice effects
			$this->db->where('detail_id' , $param2);
			 $this->db->delete('invoice_details');
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
		$page_data['page_name']  = 'fees_structure_details';
        $page_dat['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('detailed_fees_structure');
        $this->load->view('backend/index', $page_data);	
	}

	/** Invoice Management **/

	 function create_invoice($param1 = '' , $param2 = '' , $param3 = '') {

        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
     	
		//$page_data['term'] = $this->min_term();
	    $page_data['page_name']  = 'create_invoice';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('create_invoice');
        $this->load->view('backend/index', $page_data); 
    }		

/******MANAGE BILLING / INVOICES WITH STATUS*****/
	
	// function next_serial_number(){
// 		
// 			
		// $this->db->select_max('batch_number');
		// $max_serial_number = $this->db->get('cashbook')->row()->batch_number + 1;
// 		
		// $current_transaction_month = strtotime($this->current_transaction_month());
		// $last_reconciled_month = strtotime($this->last_reconciled_month());
		// $count_of_transactions_in_current_transacting_month = $this->db->get_where('cashbook',
		// array('t_date>='=>$this->current_transaction_month()))->num_rows();
// 		
		// if($current_transaction_month > $last_reconciled_month && $count_of_transactions_in_current_transacting_month == 0){
			// $max_serial_number = date('y').date('m',$current_transaction_month).'01';
		// }				
// 		
		// return $max_serial_number;
	// }
	
	function max_term(){
		return $this->db->select_max('term_number')->get('terms')->row()->term_number;
	}
	
	function min_term(){
		return $this->db->select_min('term_number')->get('terms')->row()->term_number;
	}
	
	function cancel_previous_invoice($student_id,$year,$term){
			
			if($term == $this->min_term()){
				$year -= 1;
				$term = $this->max_term();
			}else{
				$term -= 1;
			}
			
			//Cancel any previous unpaid invoice
			$unpaid_invoice = $this->db->get_where('invoice',
				array('status'=>'unpaid','student_id'=>$student_id,'yr'=>$year,'term'=>$term));
			
			if($unpaid_invoice->num_rows() > 0){
				$this->db->where(array('invoice_id'=>$unpaid_invoice->row()->invoice_id));
				$cancel_status['status'] = 'cancelled';
				$cancel_status['carry_forward'] = 1;
				$this->db->update('invoice',$cancel_status);
			}
			
	}

    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $this->db->trans_start();
			//Cancel a previous invoice
			$this->cancel_previous_invoice($this->input->post('student_id'),$this->input->post('yr'),$this->input->post('term'));
				
            $data['student_id']         = $this->input->post('student_id');
			$data['class_id']         = $this->input->post('class_id');
            $data['yr']              = $this->input->post('yr');
            $data['term']        = $this->input->post('term');
            $data['amount']             = $this->input->post('amount');
            $data['amount_due']        = $this->input->post('amount_due');
			//$data['balance']        = $this->input->post('amount_due');
            $data['status']             = "unpaid";//$this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->insert('invoice', $data);
			
			$invoice_id = $this->db->insert_id();
			
			$structure_ids = $this->input->post('detail_id');
			$payable_amount = $this->input->post('payable');
			$charge_overpay = array_sum($this->input->post("charge_overpay"));
			$ocharge = $this->input->post("charge_overpay");
			
			foreach($payable_amount as $key=>$value):
				if($value > 0){
					$data2['invoice_id'] 	= $invoice_id;
					$data2['detail_id'] 	= $key;
					
					if(isset($ocharge[$key])){
						$data2['amount_due'] 	= $value - $ocharge[$key];
					}else{
						$data2['amount_due'] 	= $value;
					}
					
				
					$this->db->insert('invoice_details',$data2);
				}
							
			endforeach;
			
			
			if($charge_overpay > 0){
				
				$active_note = $this->db->get_where("overpay",
				array("student_id"=>$this->input->post('student_id'),"status"=>"active"));
				
				if($active_note->num_rows() > 0){
					$this->db->where(array("student_id"=>$this->input->post('student_id'),"status"=>"active"));
					$amount = $active_note->row()->amount;
					//Consider using overpay_charge_detail table to record this
					// $current_amount_due = $active_note->row()->amount_due;
					// $new_amount_due = $current_amount_due - $charge_overpay;
// 					
					// $data8['amount_due'] = $new_amount_due;
					// if($new_amount_due === 0){
						// $data8['status'] = "cleared";
					// }
					// $this->db->update("overpay",$data8);
					
					$overpay_charge_data['invoice_id'] = $invoice_id;
					$overpay_charge_data['overpay_id'] = $active_note->row()->overpay_id;
					$overpay_charge_data['amount_redeemed'] = $charge_overpay;
					$overpay_charge_data['createddate'] = date('Y-m-d h:i:s');
					$overpay_charge_data['createdby'] = $this->session->login_user_id;
					$overpay_charge_data['lastmodifiedby'] = $this->session->login_user_id;
					
					$this->db->insert('overpay_charge_detail',$overpay_charge_data);
					
					//Update the overpay status to cleared if redeeming is complete
					$sum_redeemed_amount = $this->crud_model->overpay_balance($active_note->row()->overpay_id);
					
					if($sum_redeemed_amount == 0){
						$this->db->where(array('overpay_id'=>$active_note->row()->overpay_id));
						$clear_overpay_note['status'] = 'cleared';
						$this->db->update("overpay",$clear_overpay_note);
					}
					
				}
				
				$external_count = 0;
				foreach($ocharge as $overcharge_key => $overcharge_amount){
					//Create a funds tranfer from reserve account to the account pointed to
					$to_account_id = $this->db->get_where('fees_structure_details',
					array('detail_id'=>$overcharge_key))->row()->income_category_id;
					
					$from_account_id = $this->db->get_where('income_categories',
					array('default_category'=>1))->row()->income_category_id;
					
					$t_date = $this->crud_model->next_transaction_date()->start_date;
					
					$amount = $overcharge_amount;
					
					$this->record_internal_funds_transfer($t_date, $amount, $from_account_id, $to_account_id,$external_count);	
					
					$external_count++;	
				}
				
			}
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
					$this->session->set_flashdata('flash_message' , get_phrase('invoice_creation_failed'));
			}
			else
			{
			        $this->db->trans_commit();
					$this->session->set_flashdata('flash_message' , get_phrase('invoice_created_successfully'));
			}
			
			
            
            redirect(base_url() . 'index.php?finance/create_invoice', 'refresh');
        }


        if ($param1 == 'create_mass_invoice') {
        	
			//Count students with Invoices
					
			$cnt = 0;
					
			foreach($this->input->post('student_id') as $rows){
				if($this->db->get_where('invoice',array('student_id'=>$rows,'yr'=>$this->input->post('yr'),'term'=>$this->input->post('term')))->num_rows()>0){
					$cnt++;
				}
			}
			
            if ($cnt===0) {
                foreach ($this->input->post('student_id') as $id) {
                	
					//Cancel a previous invoice
					$this->cancel_previous_invoice($id,$this->input->post('yr'),$this->input->post('term'));
										
                	$invoice_found = $this->db->get_where("invoice",array("student_id"=>$id,"yr"=>$this->input->post('yr'),"term"=>$this->input->post('term')));
					if($invoice_found->num_rows() === 0){
	                    $data['student_id']         = $id;
						$data['class_id']         = $this->input->post('class_id');
	                    $data['yr']              = $this->input->post('yr');
	                    $data['term']        = $this->input->post('term');
	                    $data['amount']             = $this->input->post('amount');
	                    $data['amount_due']        = $this->input->post('amount_due');
						//$data['balance']        = $this->input->post('amount_due');
	                    $data['status']             = 'unpaid';
	                    $data['creation_timestamp'] = strtotime($this->input->post('date'));
	                    
	                    $this->db->insert('invoice', $data);
						
			            $invoice_id = $this->db->insert_id();
						
						$structure_ids = $this->input->post('detail_id');
						$payable_amount = $this->input->post('payable');
						
						foreach($payable_amount as $key=>$value){
							if($value > 0){
								$data2['invoice_id'] = $invoice_id;
								$data2['detail_id'] = $key;
								$data2['amount_due'] = $value;
								//$data2['balance'] = $value;
								$this->db->insert('invoice_details',$data2);
							}
										
						}
						
						
					}
                }
				
				$this->session->set_flashdata('flash_message' , get_phrase('invoices_created_successfully'));
            
           }else{
           		$this->session->set_flashdata('flash_message' , get_phrase('failed:_some_invoices_exists'));
           }
		   
		   redirect(base_url() . 'index.php?finance/create_invoice', 'refresh');
            
        }

		if($param1=="edit_invoice"){
			$data['amount_due'] = $this->input->post('amount_due');
			$data['amount_paid'] = $this->input->post('amount_paid');
			$data['balance'] = $this->input->post('balance');
			if($this->input->post('balance') === 0){
				$data['status'] = "paid";
			}elseif($this->input->post('balance') < 0){
				$data['status'] = "excess";
			}
			
			$this->db->where(array("invoice_id"=>$param2));
			$this->db->update("invoice",$data);
			
			foreach($this->input->post('detail_amount_due') as $invoice_details_id=>$amount_due){
					
					$this->db->where(array("invoice_details_id"=>$invoice_details_id));
					$data8['amount_due'] = $amount_due;

					$this->db->update("invoice_details",$data8);
				
			}
			//exit;
			$this->session->set_flashdata('flash_message' , get_phrase('edit_successful'));
			redirect(base_url() . 'index.php?finance/student_payments', 'refresh');
		}

        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?finance/invoice', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        

        if ($param1 == 'delete') {
        	
			//Check if invoice has payment done
			
			$check = $this->db->get_where('transaction',array('invoice_id'=>invoice_id))->num_rows();
			
			$msg = get_phrase('delete_failed');
			
			if($check == 0){
				
				//Delete Invoice Details
				$this->db->where('invoice_id', $param2);
	            $this->db->delete('invoice_details');
					
				$this->db->where('invoice_id', $param2);
	            $this->db->delete('invoice');	
				
				$msg = get_phrase('data_deleted');
			}
			
            $this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?finance/student_payments', 'refresh');
        }
		
		if ($param1 == 'cancel') {
			$this->db->where('invoice_id', $param2);
			$data3['status'] = 'cancelled';
            $this->db->update('invoice',$data3);
			
			$this->session->set_flashdata('flash_message' , get_phrase('invoice_cancelled'));
            redirect(base_url() . 'index.php?finance/student_payments', 'refresh');
		}

		if ($param1 == 'reclaim') {
					$data4['status'] = 'unpaid';	
					if($this->db->get_where("invoice",array("invoice_id"=>$param2,"amount_due"=>0))->num_rows() > 0){
						$data4['status'] = "paid";
					}
					$this->db->where('invoice_id', $param2);	
		            $this->db->update('invoice',$data4);
					
					$this->session->set_flashdata('flash_message' , get_phrase('invoice_reclaimed'));
		            redirect(base_url() . 'index.php?finance/student_payments', 'refresh');
				}
			
        $page_data['page_name']  = 'invoice';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

	/** Miscellaneous Methods **/
	
	function get_transport_info($student_id=""){
		
		$route = $this->db->get_where('student',array('student_id'=>$student_id))->row();
		
		$message = "Student not assigned to a route";
		
		//if($route_object->num_rows() > 0 ){
				
			//$route = $student->row();
			
			$route_object = $this->db->get_where('transport',array('transport_id'=>$route->transport_id));
		
			if($route_object->num_rows() > 0 ){
				$amount = $route_object->row()->route_fare;
				$message = "Student entitled to transport cost of Kes.". number_format($amount,2)." on route ".$route_object->row()->route_name;
			}
		//}
		
		
		echo $message;
	}
	
	function get_total_fees($term="",$year="",$class=""){
		//echo "You have choosen ".$terms;
		$fees = $this->db->get_where('fees_structure',array("term"=>$term,"yr"=>$year,"class_id"=>$class));
		
		$amount = 0;
		
		if($fees->num_rows() > 0){
			$fees_id = $fees->row()->fees_id;

			$query = $this->db->select_sum('amount')->get_where('fees_structure_details',array("fees_id"=>$fees_id));
			
			if($query->num_rows() > 0){
				$res = $query->result_array();
				
				foreach($res as $row):
					$amount = $row['amount'];
				endforeach;
			}
		}
		
		echo $amount;	
			
	}
	
	function default_income_category_fees_structure_detail($term="",$year="",$class=""){
		//Default category structure item
		$this->db->select(array('fees_structure_details.detail_id','fees_structure_details.name'));
		$this->db->join('fees_structure_details','fees_structure_details.income_category_id=income_categories.income_category_id');
		$this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
		$default_category_detail = $this->db->get_where('income_categories',
		array('default_category'=>1,'yr'=>$year,'term'=>$term,'class_id'=>$class))->row();
		
		return $default_category_detail;
	}
	
	function get_fees_items($term="",$year="",$class="",$student=""){
		
		$fees = $this->db->get_where('fees_structure',
		array("term"=>$term,"yr"=>$year,"class_id"=>$class));

		$body = "";
		
		if($fees->num_rows() > 0){
				$fees_id = $fees->row()->fees_id;
					
				$details_object = $this->db->get_where('fees_structure_details',array("fees_id"=>$fees_id));
				
				if($details_object->num_rows() > 0 ){
					$details = $details_object->result_object();
					
					$invoice = $this->db->get_where('invoice',array('student_id'=>$student,'yr'=>$year,'term'=>$term));
				
					$invoice_count = $invoice->num_rows();
					
					if($invoice_count === 0){
						foreach($details as $row):
							$amount = $row->amount;
							
							if($this->default_income_category_fees_structure_detail($term,$year,$class)->detail_id == $row->detail_id){
								$amount = $this->crud_model->student_unpaid_invoice_balance($student);
							}
							
							$body .= "<tr>
							<td><input type='checkbox' 
							onchange='return get_full_amount(".$row->detail_id.")' 
							id='chk_".$row->detail_id."'/></td>
							<td>".$row->name."</td>
							<td id='full_amount_".$row->detail_id."'>".$amount."</td>
							<td><input type='text' 
							onkeyup='return get_payable_amount(".$row->detail_id.")' 
							class='form-control payable_items' id='payable_".$row->detail_id."' 
							name='payable[".$row->detail_id."]' value='0' /></td>
							<td><input type='text' onchange='check_overpay_balance(this);' class='form-control charge_overpay' 
							value='0' name='charge_overpay[".$row->detail_id."]' /></td>
							<tr>";
						endforeach;
						
						
						
					}else{
						
						$amount_due = 0;
						echo "<input type='hidden' id='edit_invoice_id' value='".$invoice->row()->invoice_id."'/>";
						foreach($details as $row):
							
							$amount_due = $this->db->get_where('invoice_details',array('invoice_id'=>$invoice->row()->invoice_id,'detail_id'=>$row->detail_id))->row()->amount_due;
							$body .= "<tr><td><input type='checkbox' onchange='return get_full_amount(".$row->detail_id.")' id='chk_".$row->detail_id."'/></td><td>".$row->name."</td><td id='full_amount_".$row->detail_id."'>".$row->amount."</td><td><input type='text' onkeyup='return get_payable_amount(".$row->detail_id.")' class='form-control payable_items' id='payable_".$row->detail_id."' name='payable[".$row->detail_id."]' value='".$amount_due."'/></td><td><input type='text' value='0' class='form-control charge_overpay' name='charge_overpay[".$row->detail_id."]' /></td><tr>";
						endforeach;
					}	
				}
				
				
			}else{
				$body .= "<tr><td class='col-sm-4'>".get_phrase('no_items_found')."</td></tr>";
			}	
			
		echo $body;	
	}

	function get_mass_fees_items($term="",$year="",$class=""){
		$fees = $this->db->get_where('fees_structure',array("term"=>$term,"yr"=>$year,"class_id"=>$class));
		
		$str = "";
		
		if($fees->num_rows() > 0){
			$fees_id = $fees->row()->fees_id;
			
			$details = $this->db->get_where('fees_structure_details',array("fees_id"=>$fees_id))->result_object();
			
			foreach($details as $row):
				$str .= "<tr><td><input type='checkbox' onchange='return get_mass_full_amount(".$row->detail_id.")' id='mass_chk_".$row->detail_id."'/></td><td>".$row->name."</td><td id='mass_full_amount_".$row->detail_id."'>".$row->amount."</td><td><input type='text' onkeyup='return get_mass_payable_amount(".$row->detail_id.")' class='form-control mass_payable_items' id='mass_payable_".$row->detail_id."' name='payable[".$row->detail_id."]'/></td><tr>";
			endforeach;
		}else{
			$str .= "<tr><td colspan='3'>".get_phrase('no_items_found')."</td></tr>";
		}	
		
		echo $str;	
	}

	/** Expense Management **/
	
	function scroll_expense($month_stamp = ""){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');		
		
		
		$page_data['month_stamp']  = $month_stamp;
		$page_data['page_name']  = 'expense';
		$page_data['page_view'] = "finance";
		$page_data['expenses'] = $this->db->get_where('expense',
		array('month(t_date)'=>date('m',$month_stamp)))->result_object();
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data);
	}
	
	function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
            
        if ($param1 == 'create') {
			
			$this->db->trans_start();
			
			$data['payee']        			=   $this->input->post('payee'); 
			$data['batch_number']   		=   $this->crud_model->next_batch_number();//$this->crud_model->populate_batch_number($this->input->post('t_date'));   
			$data['t_date']        			=   $this->input->post('t_date');		
          	$data['invoice_id']     		= 	0;
		    $data['description']    		=   $this->input->post('description');			
            $data['transaction_method_id']  =   $this->input->post('method');	
			$data['transaction_type_id']	=   2;
			$data['cheque_no']				= 	$this->input->post('cheque_no');;
			$data['cleared']				= 	0;
            $data['amount']         		=   $this->input->post('amount');
            $data['createddate']      		=   strtotime($this->input->post('t_date'));
			$data['createdby']				= 	$this->session->login_user_id;
			$data['lastmodifiedby']				= 	$this->session->login_user_id;
			
			$this->db->insert('transaction' , $data);
			
			$transaction_id = $this->db->insert_id();
			
			$qty = $this->input->post('qty');
			$desc = $this->input->post('desc');
			$unitcost = $this->input->post('unitcost');
			$cost = $this->input->post('cost');
			$category = $this->input->post('category');
			
			foreach($qty as $key=>$val):
				
				$data2['transaction_id'] = $transaction_id;
				$data2['qty'] = $qty[$key];
				$data2['detail_description'] = $desc[$key];
				$data2['unitcost'] = $unitcost[$key];
				$data2['cost'] = $cost[$key];
				$data2['expense_category_id'] = $category[$key];
				$data2['invoice_details_id'] = 0;
				
				$this->db->insert('transaction_detail' , $data2);
				
			endforeach;
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
					$this->session->set_flashdata('flash_message' , get_phrase('process_failed'));
			}
			else
			{
			        $this->db->trans_commit();
					$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
			}
			
            redirect(base_url() . 'index.php?finance/cashbook/scroll/'.strtotime($this->input->post('t_date')), 'refresh');
        }
	/**
        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
        }
	**/	
		if($param1==='reverse'){
					
			$date = date('Y-m-d');
			
			$expense = $this->db->get_where('expense',array('expense_id'=>$param2))->row();

            $data['payee']        =   $this->db->get_where('settings',array('type'=>'system_name'))->row()->description;    
			$data['batch_mumber']        =   $this->crud_model->next_serial_number();
			$data['t_date']        =   date('Y-m-d');			
            $data['description']         =   get_phrase('reversal:_batch').' - '.$expense->batch_number;			
            $data['method']              =   $expense->method;				    	
            $data['amount']              =   -$expense->amount;	
            $data['timestamp']           =   strtotime(date('Y-m-d'));
            $this->db->insert('expense' , $data);
			
			$expense_id = $this->db->insert_id();
			
			$details = $this->db->get_where('expense_details',array('expense_id'=>$param2))->result_object();
			
			foreach($details as $row):
				$data2['expense_id'] = $expense_id;
				$data2['qty'] = $row->qty;
				$data2['description'] = $row->description;
				$data2['unitcost'] = -$row->unitcost;
				$data2['cost'] = -$row->cost;
				$data2['expense_category_id'] = $row->expense_category_id;
				
				$this->db->insert('expense_details' , $data2);
				
			endforeach;
			
			
			//Enter Income into the Cash Book
			$data1['t_date'] = date('Y-m-d');
			$data1['batch_number'] = $this->crud_model->next_serial_number();
			$data1['description'] = get_phrase('reversal:_batch').' - '.$expense->batch_number;
			$data1['transaction_type'] = '2';
			$data1['account'] = $expense->method;
			$data1['amount'] = -$expense->amount;
            $this->db->insert('cashbook' , $data1);
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('record_reversed_successful'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
		}

        $page_data['month_stamp'] = strtotime($this->crud_model->current_transaction_month());
        $page_data['page_name']  = 'expense';
		$page_data['page_view'] = "finance";
		$page_data['expenses'] = $this->db->get_where('expense',
		array('month(t_date)'=>date('m',strtotime($this->crud_model->current_transaction_month()))))->result_object();
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data); 
    }

	/**Income management **/
	
	function get_overpay($param1=""){
		$overpay = 0;
		
		$obj = $this->db->get_where("overpay",array("status"=>"active","student_id"=>$param1));
		
		if($obj->num_rows() > 0){
			$overpay = $obj->row()->amount;
		}
		
		echo $overpay;
	}


	
	function expense_scroll($param1=""){
		$this->db->where(array("YEAR(t_date)"=>date("Y",$param1)));
    	$this->db->order_by('timestamp' , 'desc');
    	$expenses = $this->db->get('expense')->result_object();
		$data['expenses'] = $expenses;
		$data['timestamp'] = $param1;
		
		echo $this->load->view("backend/finance/scroll_expense",$data,true);
	}
	
	function paid_invoice_scroll($param1=""){
		$this->db->where(array('status' => 'paid',"yr"=>date("Y",$param1)));
    	$this->db->order_by('creation_timestamp' , 'desc');
    	$paid_invoices = $this->db->get('invoice')->result_array();
		$data['paid_invoices'] = $paid_invoices;
		$data['timestamp'] = $param1;
		
		echo $this->load->view("backend/finance/scroll_paid_invoices",$data,true);
	}
	
	function scroll_student_payments($year = ""){
       if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
	   
	   
	   	$page_data['year'] = $year;
        $page_data['page_name']  = 'student_payments';
        $page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get_where('invoice',array('yr'=>$year))->result_array();
        $this->load->view('backend/index', $page_data); 	   		
	}
	
	function student_payments($param1 = '' , $param2 = '')
    {
       if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
	   
	   	if($param1=="create_overpay_note"){
	   		$data['student_id'] = $this->input->post('student_id');
			$data['income_id'] = $this->input->post('income_id');
			$data['amount'] = $this->input->post('amount');
			$data['amount_due'] = $this->input->post('amount');
			$data['description'] = $this->input->post('description');
			$data['status'] = $this->input->post('status');
			
			//Check if note exist for the income id
			$check_note = $this->db->get_where("overpay",array("income_id"=>$this->input->post('income_id')));
			
			//Check if student has an invoice with a balance
			$check_balance = $this->db->get_where("invoice",array("student_id"=>$this->input->post('student_id'),"status"=>"unpaid"));
			
			
			$message = get_phrase('failure');
			
			if($check_note->num_rows() === 0 && $check_balance->num_rows() === 0){
				$this->db->insert("overpay",$data);
				$message = get_phrase('note_created');	
			}
			
			$this->session->set_flashdata('flash_message' , $message);
            redirect(base_url() . 'index.php?finance/student_payments', 'refresh');
	   	}
	   
        $page_data['page_name']  = 'student_payments';
        $page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('student_payments');
		$page_data['year'] = date('Y');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get_where('invoice',array('yr'=>date('Y')))->result_array();
        $this->load->view('backend/index', $page_data); 
    }
	
	// function income_scroll($param1=""){
		// $this->db->where(array("YEAR(t_date)"=>date("Y",$param1)));
    	// $this->db->order_by('timestamp' , 'desc');
    	// $payments = $this->db->get('payment')->result_object();
		// $data['payments'] = $payments;
		// $data['timestamp'] = $param1;
// 		
		// echo $this->load->view("backend/finance/scroll_income",$data,true);
	// }
	
	function scroll_income($month = ""){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		$page_data['month_stamp'] = $month;
		$page_data['page_name']  = 'income';
		$page_data['page_view'] = "finance";
		$page_data['payments'] = $this->db->get_where('payment',
		array('month(t_date)'=>date('m',$month)))->result_object();
        $page_data['page_title'] = get_phrase('income');
        $this->load->view('backend/index', $page_data); 			
	}
		
	function income($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
            
        if ($param1 == 'create') {
       		//$res = $this->db->get("payment")->row()->serial;
			
			$this->db->trans_start();
        	
            $data['payee']        			=   $this->input->post('payee'); 
			$data['batch_number']   		=   $this->crud_model->next_batch_number();//$this->crud_model->populate_batch_number($this->input->post('t_date'));   
			$data['t_date']        			=   $this->input->post('t_date');		
          	$data['invoice_id']     		= 	0;
		    $data['description']    		=   $this->input->post('description');			
            $data['transaction_method_id']  =   $this->input->post('method');	
			$data['transaction_type_id']	=   1;
			$data['cheque_no']				= 	0;
			$data['cleared']				= 	0;
            $data['amount']         		=   $this->input->post('amount');
            $data['createddate']      		=   $this->input->post('t_date');
			$data['createdby']				= 	$this->session->login_user_id;
			$data['lastmodifiedby']			= 	$this->session->login_user_id;
			
            $this->db->insert('transaction' , $data);
			
			$transaction_id = $this->db->insert_id();
			
			$qty = $this->input->post('qty');
			$desc = $this->input->post('desc');
			$unitcost = $this->input->post('unitcost');
			$cost = $this->input->post('cost');
			$category = $this->input->post('category');
			
			foreach($qty as $key=>$val):
				$data2['transaction_id'] = $transaction_id;
				$data2['qty'] = $qty[$key];
				$data2['detail_description'] = $desc[$key];
				$data2['unitcost'] = $unitcost[$key];
				$data2['cost'] = $cost[$key];
				$data2['income_category_id'] = $category[$key];
				$data2['invoice_details_id'] = 0;
				
				$this->db->insert('transaction_detail' , $data2);
				
			endforeach;
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
					$this->session->set_flashdata('flash_message' , get_phrase('process_failed'));
			}
			else
			{
			        $this->db->trans_commit();
					$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
			}
			
            redirect(base_url() . 'index.php?finance/cashbook/scroll/'.strtotime($this->input->post('t_date')), 'refresh');
        }
	/**
        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
        }
	**/	
		if($param1==='reverse'){
					
			$date = date('Y-m-d');
			
			$income = $this->db->get_where('payment',array('payment_id'=>$param2))->row();

            $data['payee']        =   $this->db->get_where('settings',array('type'=>'system_name'))->row()->description;    
			$data['batch_mumber']        =   $this->crud_model->next_serial_number();
			$data['t_date']        =   date('Y-m-d');			
            $data['description']         =   get_phrase('reversal:_batch').' - '.$income->batch_number;			
            $data['method']              =   $income->method;				    	
            $data['amount']              =   -$income->amount;	
            $data['timestamp']           =   strtotime(date('Y-m-d'));
			$data['payment_type']		= "2";
            $this->db->insert('payment' , $data);
			
			$payment_id = $this->db->insert_id();
			
			$details = $this->db->get_where('other_payment_details',array('payment_id'=>$param2))->result_object();
			
			foreach($details as $row):
				$data2['payment_id'] = $payment_id;
				$data2['qty'] = $row->qty;
				$data2['description'] = $row->description;
				$data2['unitcost'] = -$row->unitcost;
				$data2['cost'] = -$row->cost;
				$data2['income_category_id'] = $row->income_category_id;
				
				$this->db->insert('other_payment_details' , $data2);
				
			endforeach;
			
			
			//Enter Income into the Cash Book
			$data1['t_date'] = date('Y-m-d');
			$data1['batch_number'] = $this->crud_model->next_serial_number();
			$data1['description'] = get_phrase('reversal:_batch').' - '.$income->batch_number;
			$data1['transaction_type'] = '1';
			$data1['account'] = $income->method;
			$data1['amount'] = -$income->amount;
            $this->db->insert('cashbook' , $data1);
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('record_reversed_successful'));
            redirect(base_url() . 'index.php?finance/income', 'refresh');
		}
		
		$page_data['month_stamp'] = strtotime($this->crud_model->current_transaction_month());
        $page_data['page_name']  = 'income';
		$page_data['page_view'] = "finance";
		$page_data['payments'] = $this->db->get_where('payment',
		array('month(t_date)'=>date('m',strtotime($this->crud_model->current_transaction_month()))))->result_object();
        $page_data['page_title'] = get_phrase('income');
        $this->load->view('backend/index', $page_data); 
    }	

	function check_batch_number($param1="",$table=""){
		$batch_obj = $this->db->get_where($table,array("batch_number"=>$param1));
		
		$batch_record = "";
		
		if($batch_obj->num_rows() > 0){
			$batch_record = $batch_obj->result_object();
			echo json_encode($batch_record);
		}else{
			echo $batch_record;
		}
		
		
	}
	
	function reconcile($param1="",$param2=""){
		if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		

        $page_data['page_name']  = 'reconcile';
		$page_data['page_view'] = "finance";
		$page_data["current"] = $param1;
        $page_data['page_title'] = get_phrase('bank_reconciliation');
        $this->load->view('backend/index', $page_data);
	}

	function clear_transactions(){
		$transaction_type = $_POST['record_type'];
		$record_id = $_POST["indx"];
		$month = $_POST['month'];
		
		//$check current clear state
		$record = $this->db->get_where('transaction',array("transaction_id"=>$record_id))->row();
		
		$data['cleared'] = 1;
		$data['clearedMonth'] = $month;
		
		if($record->cleared == '1'){
			$data['cleared'] = 0;
			$data['clearedMonth'] = "0000-00-00";	
		}
		
		
		$this->db->where(array("transaction_id"=>$record_id));
		$this->db->update('transaction',$data);
		
		if($this->db->affected_rows() > 0){
			echo "Update Successful";
		}else{
			echo "Error Occurred";
		}
	}
	
	function close_month($param1="",$param2=""){
		
		if($param1 == "create"){
			$data['statement_amount'] = $this->input->post("statement_amount");
			$data['month'] = date("Y-m-t",$param2);
			
			$msg = get_phrase('month_closed_successfully');
			//Check if reconcile Present
			$report = $this->db->get_where("reconcile",array("month"=>date("Y-m-t",$param2)));
			if($report->num_rows() > 0){
				$this->db->where(array("reconcile_id"=>$report->row()->reconcile_id));
				$this->db->update("reconcile",$data);
				$msg = get_phrase('month_editted_successfully');
			}else{
				$this->db->insert("reconcile",$data);
			}	
			
						
            $this->session->set_flashdata('flash_message' , $msg);
            redirect(base_url() . 'index.php?finance/reconcile/'.$param2, 'refresh');	
			
		}
		
	}

	function monthly_reconciliation($param1="",$param2=""){
		 if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
			
		if($param1 == "edit"){
			$reconcile = $this->db->get_where("reconcile",array("reconcile_id"=>$param2))->row();
			redirect(base_url() . 'index.php?finance/reconcile/'.strtotime($reconcile->month), 'refresh');	
		}
		
        $page_data['page_name']  = 'monthly_reconciliation';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('monthly_reconciliation');
	    $this->load->view('backend/index', $page_data); 
	}
	
	function contra_entry($param1="",$param2=""){
		
		if($param1==='create'){
			
			$this->db->trans_start();
			
			$data1['t_date'] = $this->input->post('t_date');
			$data1['batch_number'] = $this->crud_model->next_batch_number();//$this->crud_model->populate_batch_number(date('Y-m-d'));
			$data1['description'] = $this->input->post('description');
			$data1['transaction_type_id'] = $this->input->post('entry_type');
			$data1['transaction_method_id'] = 4;
			$data1['invoice_id'] = 0;
			$data1['amount'] = $this->input->post('amount');
			$data1['payee'] = get_phrase('system_generated');
			$data1['cheque_no'] = 0;
			$data1['createddate'] = $this->input->post('t_date');
			$data1['createdby'] = $this->session->login_user_id;
			$data1['lastmodifiedby'] = $this->session->login_user_id;
			
			$this->db->insert('transaction' , $data1);
			
			$transaction_id = $this->db->insert_id();
			
			$data2['transaction_id'] = $transaction_id;
			$data2['qty'] = 1;
			$data2['detail_description'] = get_phrase('contra_entry').': '.$this->db->get_where('transaction_type',array('transaction_type_id'=>$this->input->post('entry_type')))->row()->description;
			$data2['unitcost'] = $this->input->post('amount');
			$data2['cost'] = $this->input->post('amount');
			$data2['income_category_id'] = 0;
			$data2['invoice_details_id'] = 0;
				
			$this->db->insert('transaction_detail' , $data2);
        
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
					$this->session->set_flashdata('flash_message' , get_phrase('process_failed'));
			}
			else
			{
			        $this->db->trans_commit();
					$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
			}
		
		    redirect(base_url() . 'index.php?finance/cashbook/scroll/'.strtotime($this->input->post('t_date')), 'refresh');			
		}
		
		
		//$this->cash_book($param2);
	}
	
	function student_collection_tally($year,$filter = ""){
		 if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		 
		$term = 2;
		 
		//Get all unpaid invoices for the term
		$this->db->select(array('student.name as student','invoice.student_id','student.roll as roll',
		'fees_structure_details.income_category_id','invoice.invoice_id','income_categories.name as category','class.name as class'));
		
		$this->db->select_sum('invoice_details.amount_due');
		
		$this->db->join('invoice','invoice.invoice_id=invoice_details.invoice_id');
		$this->db->join('student','student.student_id=invoice.student_id');
		$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');
		$this->db->join('income_categories','income_categories.income_category_id=fees_structure_details.income_category_id');
		$this->db->join('class','class.class_id = invoice.class_id');
		
		$this->db->group_by('student.student_id');	
		$this->db->group_by('fees_structure_details.income_category_id');
		
		$ungrouped_payments = $this->db->get_where('invoice_details',array('yr'=>$year,'term'=>$term,'status'=>'unpaid'))->result_object();
		
		foreach($ungrouped_payments as $row){
			$this->db->select_sum('cost');
			$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
			$this->db->join('invoice','invoice.invoice_id=transaction.invoice_id');
			
			$this->db->group_by('transaction_detail.income_category_id');
			
			$this->db->where(array('transaction.invoice_id'=>$row->invoice_id,'income_category_id'=>$row->income_category_id));
			$paid = $this->db->get('transaction_detail')->row()->cost;
			
			$payments[$row->student_id]['fees'][$row->category]['due'] = $row->amount_due;
			$payments[$row->student_id]['fees'][$row->category]['paid'] = $paid;
			$payments[$row->student_id]['fees'][$row->category]['balance'] = $row->amount_due - $paid;
			$payments[$row->student_id]['student']['name'] = $row->student;
			$payments[$row->student_id]['student']['class'] = $row->class;
			$payments[$row->student_id]['student']['roll'] = $row->roll;
		}
		
		$page_data['payments'] 		= $payments;
        $page_data['page_name']  	= __FUNCTION__;
		$page_data['current_date'] 	= $t_date;
		$page_data['page_view'] 	= "finance";
        $page_data['page_title'] 	= get_phrase(__FUNCTION__)." (".get_phrase('unpaid_invoices').")";
        $this->load->view('backend/index', $page_data);

	}
	
	function month_fees_income_by_income_category($category_id = "", $start_month = ""){
		
		$this->db->where(array('payment.t_date>='=>date('Y-m-01',strtotime($start_month))));		
		$this->db->where(array('payment.t_date<='=>date('Y-m-t',strtotime($start_month))));
		$this->db->where(array('fees_structure_details.income_category_id'=>$category_id));		
		$this->db->join('student_payment_details','student_payment_details.payment_id=payment.payment_id');
		$this->db->join('fees_structure_details','fees_structure_details.detail_id=student_payment_details.detail_id');
		
		$total_income = $this->db->select_sum('student_payment_details.amount')->get('payment')->row()->amount;
		
		return $total_income;
	}

	// function to_date_fees_income_by_income_category($income_category_id){
// 		
		// $system_start_date = $this->db->get_where('settings',
		// array('type'=>'system_start_date'))->row()->description; 
// 		
		// $last_reconciled_date = $this->db->select_max('month')->get('reconcile')->row()->month;
// 		
		// $this->db->where(array('payment.t_date>='=>date('Y-m-01',strtotime($system_start_date))));		
		// $this->db->where(array('payment.t_date<='=>date('Y-m-t',strtotime($last_reconciled_date))));
		// $this->db->where(array('fees_structure_details.income_category_id'=>$income_category_id));		
		// $this->db->join('student_payment_details','student_payment_details.payment_id=payment.payment_id');
		// $this->db->join('fees_structure_details','fees_structure_details.detail_id=student_payment_details.detail_id');
// 		
		// $total_income = $this->db->select_sum('student_payment_details.amount')->get('payment')->row()->amount;
// 		
		// return $total_income;
	// }

	
	function to_date_income_by_income_category($income_category_id,$month_start_date){
		$system_start_date = $this->db->get_where('settings',
		array('type'=>'system_start_date'))->row()->description; 
		
		//$last_reconciled_date = $this->db->select_max('month')->get('reconcile')->row()->month;
		
		$this->db->where(array('t_date>='=>date('Y-m-01',strtotime($system_start_date))));		
		$this->db->where(array('t_date<='=>date('Y-m-t',strtotime($month_start_date))));
		$this->db->where(array('transaction_detail.income_category_id'=>$income_category_id));
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$total_income = $this->db->select_sum('transaction_detail.cost')->group_by('transaction_detail.income_category_id')->get('transaction_detail')->row()->cost;
		
		return $total_income;
	}	
	
	
	function to_date_expense_by_income_category($income_category_id,$month_start_date){
		
		$system_start_date = $this->db->get_where('settings',
		array('type'=>'system_start_date'))->row()->description; 
		
		//$last_reconciled_date = $this->crud_model->last_reconciled_month();		
		
		$this->db->where(array('transaction.t_date>='=>date('Y-m-01',strtotime($system_start_date))));		
		$this->db->where(array('transaction.t_date<='=>date('Y-m-t',strtotime($month_start_date))));
		
		$this->db->where(array('expense_category.income_category_id'=>$income_category_id));
		$this->db->join('expense_category','expense_category.expense_category_id=transaction_detail.expense_category_id');
		
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		return $month_expense = $this->db->select_sum('transaction_detail.cost')->group_by('expense_category.expense_category_id')->get('transaction_detail')->row()->cost;
		
	}
	
	function system_start_date(){
		return $month_start_date = $this->db->get_where('settings',
		array('type'=>'system_start_date'))->row()->description; 
	}
	
	
	function to_date_opening_balance_by_income_category($month_start_date){
		
		$income_categories = $this->db->get('income_categories')->result_object();
		
		$income_category_ids = array_column($income_categories, 'income_category_id');
		$system_opening_balance = array_column($income_categories, 'opening_balance');
		
		$system_set_opening_balance = array_combine($income_category_ids, $system_opening_balance);
		
		$opening_balance = array();
		
		foreach($system_set_opening_balance as $income_category_id => $opening_amount){
			
			$opening_balance[$income_category_id] = $opening_amount + 
			($this->to_date_income_by_income_category($income_category_id,$month_start_date) - 
			$this->to_date_expense_by_income_category($income_category_id,$month_start_date));
		}
		
		
		return $opening_balance;
	}
	
	function term_expense_to_date($income_category_id,$month_start_date){
		
		extract($this->crud_model->get_current_term_limit_dates($month_start_date));
		
		$this->db->where(array('transaction.t_date>='=>date('Y-m-01',strtotime($term_start_date))));		
		$this->db->where(array('transaction.t_date<='=>date('Y-m-t',strtotime($month_start_date))));
		
		$this->db->where(array('expense_category.income_category_id'=>$income_category_id));
		$this->db->join('expense_category','expense_category.expense_category_id=transaction_detail.expense_category_id');
		
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		return $expense_to_date = $this->db->select_sum('transaction_detail.cost')->group_by('expense_category.expense_category_id')->get('transaction_detail')->row()->cost;
		
	
	}
	
	function term_income_to_date($income_category_id,$month_start_date){
		
		$term_data = $this->crud_model->get_current_term_based_on_date($month_start_date);
		
		$term_dates = $this->crud_model->get_current_term_limit_dates($month_start_date);
		
		$this->db->where(array('transaction.t_date>='=>date('Y-m-01',strtotime($term_dates['term_start_date']))));	
		$this->db->where(array('transaction.t_date<='=>date('Y-m-t',strtotime($month_start_date))));	
		$this->db->where(array('invoice.term'=>$term_data['term_id']));			
		$this->db->where(array('transaction_detail.income_category_id'=>$income_category_id));		
		
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$this->db->join('invoice','invoice.invoice_id=transaction.invoice_id');
		
		$total_income_to_date = $this->db->select_sum('transaction_detail.cost')->get('transaction_detail')->row()->cost;
		
		return $total_income_to_date;			
	}
	
	function term_projected_income($income_category_id,$month_start_date){
		
		$term_data = $this->crud_model->get_current_term_based_on_date($month_start_date);
		
		$this->db->where(array('yr'=>date('Y',strtotime($month_start_date))));
		$this->db->where(array('term'=>$term_data['term_id']));
		$this->db->where(array('income_category_id'=>$income_category_id));
		
		$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');
		$this->db->join('invoice','invoice.invoice_id=invoice_details.invoice_id');
		$project_income = $this->db->select_sum('invoice_details.amount_due')->get('invoice_details')->row()->amount_due;
		
		return $project_income;
	}
	
	function term_budget_to_date($month_start_date,$income_category_id){
		
		$term_month_range = $this->crud_model->get_term_range_of_months($month_start_date);
		
		$current_month_count = date('n',strtotime($month_start_date));
		
		$term = $this->crud_model->get_current_term_based_on_date($month_start_date);
		
		$this->db->where(array('budget.terms_id'=>$term['term_id']));
		$this->db->where(array('budget_schedule.month<='=>$term['key']));
		
		$this->db->where(array('budget.fy'=>date('Y',strtotime($month_start_date))));
		$this->db->where(array('expense_category.income_category_id'=>$income_category_id));
		
		$this->db->join('budget','budget.budget_id=budget_schedule.budget_id');
		$this->db->join('expense_category','expense_category.expense_category_id=budget.expense_category_id');		
		$expense_to_date = $this->db->select_sum('budget_schedule.amount')->get('budget_schedule')->row()->amount;
		
		return $expense_to_date;
	}	

	function variance_grid($month_start_date = ""){
		
		$variances = array();
		
		$income_categories = $this->db->get('income_categories')->result_object();
		
		$category_labels = array_column($income_categories, 'name');
		$income_category_ids = array_column($income_categories, 'income_category_id');
		$categories = array_combine($income_category_ids, $category_labels);
		
		$month_expense = array();
		$expense_to_date = array();
		$budget_to_date = array();
		
		foreach($income_category_ids as $income_category_id){
			$month_expense[$income_category_id] = $this->month_expense_by_income_category($income_category_id,$month_start_date);
			$expense_to_date[$income_category_id] = $this->term_expense_to_date($income_category_id, $month_start_date);
			$budget_to_date[$income_category_id] = $this->term_budget_to_date($month_start_date,$income_category_id);
		}
		
		
		$variances['categories'] 		= $categories;
		$variances['month_expense'] 	= $month_expense;
		$variances['expense_to_date'] 	= $expense_to_date;
		$variances['budget_to_date'] 	= $budget_to_date;
		
		return $variances;
	}

	function income_variance_grid($month_start_date = ""){
			
		$variances = array();
		
		$income_categories = $this->db->get('income_categories')->result_object();
		
		$category_labels = array_column($income_categories, 'name');
		$income_category_ids = array_column($income_categories, 'income_category_id');
		$categories = array_combine($income_category_ids, $category_labels);

		$income_to_date = array();
		$projected_income = array();
		
		foreach($income_category_ids as $income_category_id){
			$income_to_date[$income_category_id] = $this->term_income_to_date($income_category_id, $month_start_date);
			$projected_income[$income_category_id] = $this->term_projected_income($income_category_id, $month_start_date);
		}
		
		
		$variances['categories'] 		= $categories;
		$variances['income_to_date'] 	= $income_to_date;
		$variances['projected_income'] 	= $projected_income;
		
		return $variances;	
	}

	function income_variance_report($start_month_date = ""){

        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');		
		
		
		if($start_month_date == "") {
			$start_month_date = $this->crud_model->current_transaction_month();	
		}else{
			$start_month_date = date('Y-m-01',$start_month_date);
		}
		
		$page_data['t_date'] = $start_month_date;
		$page_data['variances'] = $this->income_variance_grid($start_month_date);		
        $page_data['page_name']  = 'income_variance_report';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('income_variance');
        $this->load->view('backend/index', $page_data);
			
	}
	
	function month_income_by_income_category($category_id = "", $start_month = ""){
		
		$this->db->where(array('t_date>='=>date('Y-m-01',strtotime($start_month))));		
		$this->db->where(array('t_date<='=>date('Y-m-t',strtotime($start_month))));
		$this->db->where(array('transaction_detail.income_category_id'=>$category_id));
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$total_income = $this->db->select_sum('transaction_detail.cost')->group_by('transaction_detail.income_category_id')->get('transaction_detail')->row()->cost;
		
		return $total_income;
	}
	
	function month_expense_by_income_category($income_category_id,$month_start_date){
		
		$this->db->where(array('transaction.t_date>='=>date('Y-m-01',strtotime($month_start_date))));		
		$this->db->where(array('transaction.t_date<='=>date('Y-m-t',strtotime($month_start_date))));
		
		$this->db->where(array('expense_category.income_category_id'=>$income_category_id));
		$this->db->join('expense_category','expense_category.expense_category_id=transaction_detail.expense_category_id');
		
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		return $month_expense = $this->db->select_sum('transaction_detail.cost')->group_by('expense_category.expense_category_id')->get('transaction_detail')->row()->cost;
		
	}
	function fund_balances($month_start_date = ""){
		
		$fund_balances = array();
		
		$income_categories = $this->db->get('income_categories')->result_object();
		
		$category_labels = array_column($income_categories, 'name');
		$income_category_ids = array_column($income_categories, 'income_category_id');
		$categories = array_combine($income_category_ids, $category_labels);
		
		$opening_balances = array();
		$month_income = array();
		$month_expense = array();
		
		if($month_start_date == "") $month_start_date = $this->crud_model->current_transaction_month();
		
		$reconciliation_count = $this->db->get('reconcile')->num_rows();
		$opening_balances = array_column($income_categories, 'opening_balance');
		
		
		if($reconciliation_count > 0 && 
			(
				strtotime($month_start_date) > strtotime($this->system_start_date()) && 
				
					strtotime('last day of next month',strtotime($this->crud_model->last_reconciled_month())) ==  
						strtotime('last day of this month',strtotime($month_start_date))	
			)){
			
			$opening_balances = $this->to_date_opening_balance_by_income_category($month_start_date);
		
		}elseif(strtotime($month_start_date) == strtotime($this->system_start_date()) ){
			$opening_balances = array_combine($income_category_ids, $opening_balances);
		}else{
			$null_value = array();
			foreach($income_category_ids as $id){
				$null_value[$id] = 0;
			}
			$opening_balances = array_combine($income_category_ids, $null_value);
		} 
		
		foreach($income_category_ids as $income_category_id){
			$month_income[$income_category_id] = $this->month_income_by_income_category($income_category_id,$month_start_date);
			$month_expense[$income_category_id] = $this->month_expense_by_income_category($income_category_id,$month_start_date);
		}
		
		$fund_balances['categories'] = $categories;
		$fund_balances['opening_balances'] = $opening_balances;
		$fund_balances['month_income'] = $month_income;
		$fund_balances['month_expense'] = $month_expense;
		
		return $fund_balances;
	}
	
	function fund_balance_report($start_month_date = ""){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');		
		
		
		if($start_month_date == "") {
			$start_month_date = $this->crud_model->current_transaction_month();	
		}else{
			$start_month_date = date('Y-m-01',$start_month_date);
		}
		
		$page_data['t_date'] = $start_month_date;
		$page_data['fund_balances'] = $this->fund_balances($start_month_date);		
        $page_data['page_name']  = 'fund_balance_report';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('fund_balance');
        $this->load->view('backend/index', $page_data);
	}
	
	
	
	function expense_variance_report($start_month_date = ""){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');		
		
		
		if($start_month_date == "") {
			$start_month_date = $this->crud_model->current_transaction_month();	
		}else{
			$start_month_date = date('Y-m-01',$start_month_date);
		}
		
		$page_data['t_date'] = $start_month_date;
		$page_data['variances'] = $this->variance_grid($start_month_date);		
        $page_data['page_name']  = 'expense_variance_report';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('expense_variance');
        $this->load->view('backend/index', $page_data);		
	}
	
	function scroll_budget($year){
		
		
		$current_term = $this->input->post('terms_id');
		$months_in_term_short = $this->crud_model->months_in_a_term_short_name($current_term);
        
		$page_data['year']  = $year;
		$page_data['current_term'] = $current_term;
		$page_data['months_in_term_short']  = $months_in_term_short;
        $page_data['page_name']  = 'budget';
		$page_data['page_view'] = 'finance';
        $page_data['page_title'] = get_phrase('budget');
        $this->load->view('backend/index', $page_data);	
	}
	
	public function budget($param="",$param2=""){
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
		
		if($param==='create'){
			
			$data['expense_category_id'] = $this->input->post('expense_category_id');
			$data['description'] = $this->input->post('description');
			$data['fy'] = $this->input->post('fy');
			$data['terms_id'] = $this->input->post('terms_id');
			$data['qty'] = $this->input->post('qty');
			$data['unitcost'] = $this->input->post('unitcost');
			$data['often'] = $this->input->post('often');
			$data['total'] = $this->input->post('total');
			
			$this->db->insert('budget',$data);
			
			$insert_id = $this->db->insert_id();
			
			$months = $this->input->post('months');
			
			for($i=0;$i<count($months);$i++):
				$data2['month'] = $i+1;
				$data2['amount'] = $months[$i];
				$data2['budget_id'] = $insert_id;
				
				$this->db->insert('budget_schedule',$data2);
			
			endfor;

			$this->session->set_flashdata('flash_message', 'Record Created');
            redirect(base_url() . 'index.php?finance/budget/', 'refresh');
		}
		
		if($param == 'edit_item'){
			$data['expense_category_id'] = $this->input->post('expense_category_id');
			$data['description'] = $this->input->post('description');
			$data['fy'] = $this->input->post('fy');
			$data['qty'] = $this->input->post('qty');
			$data['unitcost'] = $this->input->post('unitcost');
			$data['often'] = $this->input->post('often');
			$data['total'] = $this->input->post('total');
			
			$this->db->where(array('budget_id'=>$param2));
			
			$this->db->update('budget',$data);
			
			
			$months = $this->input->post('months');
			
			for($i=0;$i<count($months);$i++):
				$month = $i+1;
				$data2['amount'] = $months[$i];
				
				$this->db->where(array('month'=>$month,'budget_id'=>$param2));
				
				$this->db->update('budget_schedule',$data2);
			
			endfor;

			$this->session->set_flashdata('flash_message', 'Record Edited');
            redirect(base_url() . 'index.php?finance/budget/', 'refresh');			
		}
		
		if($param==='delete_item'){
			
			$this->db->where(array('budget_id'=>$param2));
			
			$this->db->delete('budget');
			
			$this->db->where(array('budget_id'=>$param2));
			
			$this->db->delete('budget_schedule');
			
			$this->session->set_flashdata('flash_message', 'Record Deleted');
            redirect(base_url() . 'index.php?admin/budget/', 'refresh');
		}
		
		$page_data['year']  = date('Y');
		
		if($param==="scroll"){
			$page_data['year']  = $param2;
		}

		$current_term = $this->crud_model->get_current_term();
		//$months_in_term = $this->crud_model->months_in_a_term($current_term);
		$months_in_term_short = $this->crud_model->months_in_a_term_short_name($current_term);
        
		$page_data['current_term'] = $current_term;
		$page_data['months_in_term_short']  = $months_in_term_short;
        $page_data['page_name']  = 'budget';
		$page_data['page_view'] = 'finance';
        $page_data['page_title'] = get_phrase('budget');
        $this->load->view('backend/index', $page_data);		
	}

	function change_new_item_budget_month_spread($term_id){
		$data['months_in_term_short'] = $this->crud_model->months_in_a_term_short_name($term_id);
		
		echo $this->load->view('backend/finance/admin/load_new_budget_month_spread',$data,true);
	}

	function edit_budget($budget_id = ""){
		$this->db->select(array('budget.budget_id','expense_category_id','description','fy','qty','unitcost','often',
		'total','budget_schedule_id','month','amount'));
		$this->db->join('budget_schedule','budget_schedule.budget_id=budget.budget_id');
		echo json_encode($this->db->get_where('budget',array('budget.budget_id'=>$budget_id))->result_object());
	}

	function validate_cheque_number($cheque_number){
		$count = $this->db->get_where('expense',array('cheque_no'=>$cheque_number))->num_rows();
		
		if($count>0){
			echo "Cheque number exists";
		}else{
			echo 0;
		}
	}

	function create_transaction($page = "", $page_to_show = ""){
		if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');	
		
		if($this->input->post('page_to_show')){
			$page = "";
			
			$data = array();
		
			$page_to_show = $this->input->post('page_to_show');
							
			switch($page_to_show):
				case "other_income":
					$page = "income_add";
					break;
				case "expense":
					$page = "expense_add";
					break;
				case 'contra':
					$page = "contra_entry";
					break;	
				case 'fees_income':
					$page = "active_invoices";
					break;
				case 'tranfer_funds':
					$page = 'tranfer_funds';
					break;
				default:
					$page = "active_invoices";
			endswitch;		
			
			redirect(base_url() . 'index.php?finance/create_transaction/'.$page."/".$page_to_show,'refresh');
		}
		
		
		$data['year'] = date('Y');
		$data['page_to_show'] = $page_to_show;
		$data['next_serial_number'] = $this->crud_model->next_serial_number();
		
		$page_data['loaded_page'] = $page == ""?"":$this->load->view('backend/finance/admin/'.$page,$data,true);
        $page_data['page_name']  = 'create_transaction';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('create_transaction');
        $this->load->view('backend/index', $page_data);			
	}	

	
	function funds_transfer(){
        
        $t_date = $this->input->post('t_date');
        $amount = $this->input->post('amount');
        $from_account_id  = $this->input->post('account_from'); 
        $to_account_id  = $this->input->post('account_to');
        $description  = $this->input->post('description');
		
		$this->db->trans_start();
		
        $this->record_internal_funds_transfer($t_date, $amount, $from_account_id, $to_account_id,$ext_cnt = 0 , $description);
		
		if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
					$this->session->set_flashdata('flash_message' , get_phrase('process_failed'));
			}
			else
			{
			        $this->db->trans_commit();
					$this->session->set_flashdata('flash_message' , get_phrase('funds_transferred_successfully'));
			}
		
		redirect(base_url() . 'index.php?finance/cashbook/scroll/'.strtotime($t_date),'refresh');
	}
	
	function year_funds_transfers($year){
		
		$this->db->select(array('transaction.batch_number','transaction.t_date','transaction_detail.cost',
		'income_categories.name'));
		
			
		$this->db->join('transaction','transaction.transaction_id=transaction_detail.transaction_id');
		$this->db->join('income_categories','income_categories.income_category_id=transaction_detail.income_category_id');
		
		$transfer_raw = $this->db->get_where('transaction_detail',array('transaction_type_id'=>5,'YEAR(transaction.t_date)'=>$year))->result_array();
		
		$transfer_grouped = array();
		
		foreach($transfer_raw as $record){
			$transfer_grouped[$record['batch_number']][] = $record;

		}
		
		foreach($transfer_grouped as $batch=>$row){
			$transfer[$batch]['t_date'] = $row[0]['t_date'];
			$transfer[$batch]['batch_number'] = $row[0]['batch_number'];
			
			foreach($row as $check){
			
				if($check['cost'] < 0){
					$transfer[$batch]['account_from'] = $check['name'];
				}else{
					$transfer[$batch]['account_to'] = $check['name'];
				}
				
				$transfer[$batch]['amount'] = abs($check['cost']);
			}
		}
		
		
		return $transfer;
	}
	
	function funds_transfers_report($year = ''){
		if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		$year = $year==""?date('Y'):$year;
		
		$page_data['year'] = $year;
		$page_data['transfers'] = $this->year_funds_transfers($year);
        $page_data['page_name']  = 'funds_transfers_report';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('funds_transfers');
        $this->load->view('backend/index', $page_data);			
	}
	
	function add_invoice_item_row($term,$year,$class){
		$this->db->select(array('fees_structure_details.name','fees_structure_details.detail_id',
		'fees_structure_details.income_category_id','fees_structure_details.amount'));
		$this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
		$fees = $this->db->get_where('fees_structure_details',
		array("term"=>$term,"yr"=>$year,"class_id"=>$class))->result_object();		
	
		echo json_encode($fees);
	}
	
	function get_fees_structure_detail_amount($detail_id){
		echo $this->db->get_where('fees_structure_details',array('detail_id'=>$detail_id))->row()->amount;
	}
	
	function show_transaction_page(){
	
	}
	
	/**
	 * Revamped code for finance transactions using the new transaction tables
	 * 
	 */
	 
	function record_fees_income($param1 = ""){
		
		 if ($param1 == 'take_payment') {
        	
						
			$take_payment = $this->input->post('take_payment');
						
			$this->db->trans_start();
			//Create a Payment Record
			$data_payment['batch_number'] 			= 	$this->crud_model->next_batch_number();
			$data_payment['t_date'] 				= 	$this->input->post('timestamp');
			$data_payment['invoice_id'] 			= 	$this->input->post('invoice_id');
			$data_payment['transaction_method_id']	=   $this->input->post('method');
			$data_payment['description']			=   $this->input->post('description');
			
			if($this->input->post('ref')){
				$data_payment['description']			=   $this->input->post('description').' - '.get_phrase('reference_number').': '.$this->input->post('ref');
			}
			
			$data_payment['payee']					=   $this->input->post('payee');
			$data_payment['transaction_type_id']	=   "1";
			
			if($this->input->post('overpayment') > 0){
				$data_payment['amount']	 			=  array_sum($take_payment) + $this->input->post('overpayment');						
			}else{
				$data_payment['amount']				=   array_sum($take_payment);
			}
			$data_payment['createddate']    		=   strtotime($this->input->post('timestamp'));
			$data_payment['createdby']    			=   $this->session->login_user_id;
			$data_payment['lastmodifiedby']			=   $this->session->login_user_id;
			
			
			$this->db->insert('transaction' , $data_payment);
			
			$last_transaction_id = $this->db->insert_id();
			
			
			//Update Invoice Details

			foreach($take_payment as $key=>$value){
				if($value > 0){
					
					//Create Transaction details
					
					$data_transaction['transaction_id'] 	= $last_transaction_id;
					$data_transaction['invoice_details_id'] = $key;
					
					$this->db->select(array('income_category_id'));
					$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');
					$income_category_id = $this->db->get_where('invoice_details',
					array('invoice_details_id'=>$key))->row()->income_category_id;
					
					$data_transaction['income_category_id'] = $income_category_id;
					
					$data_transaction['qty']				= 1;
					
					$data_transaction['detail_description'] = get_phrase('school_fees_payment_for_').$this->db->get_where('income_categories',
					array('income_category_id'=>$income_category_id))->row()->name;
					
					$data_transaction['unitcost'] 			= $value;
					$data_transaction['cost'] 				= $value;

					
					$this->db->insert("transaction_detail",$data_transaction);
								
		          }	
			}
			
			//Check if amount fully settled
			if($this->crud_model->get_invoice_balance($this->input->post('invoice_id')) == 0){
				$settled_invoice['status'] = 'paid';
				$this->db->where(array('invoice_id'=>$this->input->post('invoice_id')));
				$this->db->update('invoice',$settled_invoice);
			}	
					
						
			//Check if there is an overpayment
			if($this->input->post('overpayment') > 0){
				
				$student_id = $this->db->get_where('invoice',array('invoice_id'=>$this->input->post('invoice_id')))->row()->student_id;
				
				$overpay['student_id'] = $student_id;
				$overpay['transaction_id'] = $last_transaction_id;
				$overpay['amount'] = $this->input->post('overpayment');
				//$overpay['amount_due'] = $this->input->post('overpayment');
				$overpay['description'] = $this->input->post('overpayment_description');
				
				$this->db->insert('overpay',$overpay);
				
				
				//Insert this to the reverse account by creating a transaction_detail
				
				$to_reserve['transaction_id'] 	= $last_transaction_id;
				$to_reserve['invoice_details_id'] = 0;
				
				$to_reserve['income_category_id'] = $this->db->get_where('income_categories',
				array('default_category'=>1))->row()->income_category_id;
					
				$to_reserve['qty']				= 1;
					
				$to_reserve['detail_description'] = get_phrase('excess_payment');
				$to_reserve['unitcost'] = $this->input->post('overpayment');
				$to_reserve['cost'] = $this->input->post('overpayment');
				$this->db->insert('transaction_detail',$to_reserve);
				
				//Update invoice to excess status
				$excess_invoice['status'] = 'excess';
				$this->db->where(array('invoice_id'=>$this->input->post('invoice_id')));
				$this->db->update('invoice',$excess_invoice);
				
			}
			
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
					$this->session->set_flashdata('flash_message' , get_phrase('payment_failed'));
			}
			else
			{
			        $this->db->trans_commit();
					$this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
			}
            
            redirect(base_url() . 'index.php?finance/cashbook/scroll/'.strtotime($this->input->post('timestamp')), 'refresh');
        }
	}
	
	function record_other_income(){
		
	}
		
	function record_expenses(){
		
	}	
	
	
	function record_internal_funds_transfer($t_date,$amount,$from_account_id,$to_account_id,$external_count = 0,$description = ""){
		
		if($external_count == 0){	
			$data_payment['batch_number'] 			= 	$this->crud_model->next_batch_number();
			$data_payment['t_date'] 				= 	$t_date;
			$data_payment['invoice_id'] 			= 	0;
			$data_payment['transaction_method_id']	=   4;//funds_transfer
			$data_payment['description']			=   $description==""?get_phrase('internal_funds_transfer'):get_phrase('funds_transfer').': '.$description;
			$data_payment['payee']					=   get_phrase('system_generated');
			$data_payment['transaction_type_id']	=   5;
			$data_payment['amount']					=   0;
			$data_payment['createddate']    		=   date('Y-m-d h:i:s');
			$data_payment['createdby']    			=   $this->session->login_user_id;
			$data_payment['lastmodifiedby']			=   $this->session->login_user_id;	
				
			$this->db->insert('transaction' , $data_payment);
				
			$this->session->set_userdata('last_transaction_id',$this->db->insert_id());
		}
		//Create Transaction details
		
		$affected_income_categories = array($from_account_id,$to_account_id);
		
		$cnt = 0;
		foreach($affected_income_categories as $account_id){
			if($amount > 0){
				$data_transaction['transaction_id'] 	= $this->session->last_transaction_id;
				$data_transaction['invoice_details_id'] = 0;						
				$data_transaction['income_category_id'] = $account_id;
				$data_transaction['qty']				= 1;
				$data_transaction['detail_description'] = $description==""?get_phrase('internal_funds_transfer'):get_phrase('funds_transfer').': '.$description;
				if($cnt == 0){
					$data_transaction['unitcost'] 			= - $amount;
					$data_transaction['cost'] 				= - $amount;	
				}else{
					$data_transaction['unitcost'] 			= $amount;
					$data_transaction['cost'] 				= $amount;
				}
									
				$this->db->insert("transaction_detail",$data_transaction);
					
			}
			
			$cnt++;
		}
					
		
	}
	
	function record_funds_transfer(){
		
		
	}
	
	function cashbook($param1 = "" , $param2 = ""){
		if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		$t_date = $this->crud_model->next_transaction_date()->start_date;
		
		if($param1=="scroll") $t_date = date('Y-m-d',$param2); 
			
		$month = date('m',strtotime($t_date));
		$year = date('Y',strtotime($t_date));
		
		$opening_balance = $this->crud_model->opening_account_balance($t_date);
		
		//Transactions for the month
		$this->db->select(array('transaction_id','t_date','batch_number','invoice_id','transaction.description','payee',
		'transaction.transaction_type_id','transaction_type.description as transaction_type','transaction.transaction_method_id',
		'cheque_no','amount','is_cancelled','reversing_batch_number','cleared','transaction_method.description as transaction_method'));
		
		$this->db->join('transaction_type','transaction_type.transaction_type_id=transaction.transaction_type_id');
		$this->db->join('transaction_method','transaction_method.transaction_method_id=transaction.transaction_method_id');
		
		$transactions = $this->db->get_where('transaction',
		array('Month(t_date)'=>$month,'Year(t_date)'=>$year))->result_object();

		$page_data['cash_balance'] = $opening_balance['cash_balance'];
		$page_data['bank_balance'] = $opening_balance['bank_balance'];
        $page_data['page_name']  = 'cashbook';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('cash_book');
		$page_data['current'] = $t_date;
		$page_data['transactions'] = $transactions;
        $this->load->view('backend/index', $page_data); 
	}
	
	function reverse_transaction($transaction_id){
		
		$msg = get_phrase('data_not_updated');
		
		//Check if transaction is cancellable
		$transaction = $this->db->get_where('transaction',
		array('transaction_id'=>$transaction_id))->row();
		
		$is_cancelled = $transaction->is_cancelled;
		$cleared = $transaction->cleared;
		
		//Update the is_cancelled to 1
		if($is_cancelled == 0 && $cleared !== 1){
			
			$this->db->trans_start();
				
			$cancel_status = false;
				
			if($transaction->invoice_id != 0){
			
				//Reverse School Fees Payment
				$cancel_status = $this->reverse_school_fees_payment($transaction_id, $transaction->invoice_id);
			
			}elseif($transaction->invoice_id == 0 && 
					($transaction->transaction_type_id = 1 || $transaction->transaction_type_id = 2)){	
			
				//Reverse an Income or Expense
				$cancel_status = $this->reverse_income_or_expense($transaction_id, $transaction->transaction_type_id);
			
			}elseif($transaction->transaction_type_id = 3 || $transaction->transaction_type_id = 4){	
			
				//Reverse a contra entry
				$cancel_status = $this->reverse_contra_entry($transaction_id, $transaction->transaction_type_id);
			
			}
			
			if($cancel_status){
		
				$this->db->where(array('transaction_id'=>$transaction_id));
				$data['is_cancelled'] = 1;
				//$data['reversing_batch_number'] = $this->crud_model->next_batch_number();//$this->session->last_inserted_transaction_id
				
				$this->db->update('transaction',$data);	
			}
			
			
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			}
			else
			{
			        $this->db->trans_commit();
					if($cancel_status){
						$msg = get_phrase('data_updated');	
					}else{
						$msg = get_phrase('reverse_not_allowed');
					}
			}
			
			
		}
		
		$this->session->set_flashdata('flash_message' ,$msg );
        redirect(base_url() . 'index.php?finance/cashbook');
	}
	
	function reverse_school_fees_payment($transaction_id,$invoice_id){
		/**
		 * Can only reverse a transaction of the last invoice
		 * When the last invoice is fully paid the invoice becomes active
		 * Do not reverse a transaction if the invoice is cancelled
		 * If the reversed payment has an overpay the overpay note will be cancelled
		 */
		 
		 $cancel_status = false;
		 
		 //Check if is the last invoice for the student
		 $student = $this->db->get_where('invoice',array('invoice_id'=>$invoice_id))->row()->student_id;
		 
		 //Use this invoice_id from now henceforth
		 $last_invoice_id = $this->db->select_max('invoice_id')->get_where('invoice',
		 array('student_id'=>$student))->row()->invoice_id;
		 
		 //Is invoice cancelled?
		 $is_cancelled = $this->db->get_where('invoice',
		 array('status'=>'cancelled','invoice_id'=>$last_invoice_id))->num_rows();
		 
		 if($last_invoice_id == $invoice_id && $is_cancelled == 0){
		 	
			//Get cancellable invoice
			$cancellable = $this->db->get_where('invoice',
			 	array('invoice_id'=>$last_invoice_id))->row();
			
			if($cancellable->status == 'unpaid'){
				// If active invoice - Put here anything to be done when cancelling a transaction affecting unpaid invoice
				
			}elseif($cancellable->status == 'paid'){
				// If the invoice is cleared - Put here anything to be done when cancelling a transaction affecting cleared invoice
				$this->db->where(array('invoice_id'=>$last_invoice_id));
				$update_status_to_unpaid['status'] = 'unpaid';
				$this->db->update('invoice',$update_status_to_unpaid);
				
			}elseif($cancellable->status == 'excess'){
				// If the invoice is excess paid (Overpaid)  - Put here anything to be done when cancelling a transaction affecting excess invoice
				
			}
			
			$cancel_status = $this->clone_transaction_for_reverse($transaction_id);
			 
		 	//$cancel_status = true;
		 }
		 
		 return $cancel_status;
	}
	
	function reverse_income_or_expense($transaction_id){
		return $this->clone_transaction_for_reverse($transaction_id);
	}
	
	function reverse_contra_entry($transaction_id){
		return $this->clone_transaction_for_reverse($transaction_id);
	}
	
	function clone_transaction_for_reverse($transaction_id){
		
		$transaction_header = $this->db->get_where('transaction',
			array('transaction_id'=>$transaction_id))->result_array();
		
		$transaction_header = $transaction_header[0];	
			
		$transaction_detail = $this->db->get_where('transaction_detail',
			array('transaction_id'=>$transaction_id))->result_array();
			
		//Create a reversed header
		$transaction_header['amount'] = - $transaction_header['amount'];
		$transaction_header['description'] = get_phrase('reversal_of_batch_number')." ".$transaction_header['batch_number'];
		$transaction_header['batch_number'] = $this->crud_model->next_batch_number();
		$transaction_header['t_date'] = $this->crud_model->max_transaction_date();
		
		//Remove primary key
		array_shift($transaction_header);
		
		$reverse_header = $transaction_header;
		
		$this->db->insert('transaction',$reverse_header);
		
		$last_transaction_id = $this->db->insert_id();
		
		//print_r($transaction_detail);
		//Create a reversed detail
		for ($i=0; $i <count($transaction_detail) ; $i++) {
			array_shift($transaction_detail[$i]); 
			$transaction_detail[$i]['unitcost'] = - $transaction_detail[$i]['unitcost'];
			$transaction_detail[$i]['cost'] = - $transaction_detail[$i]['cost'];
			$transaction_detail[$i]['transaction_id'] = $last_transaction_id;
		}
			
		$reversed_detail = $transaction_detail;
						
		$this->db->insert_batch('transaction_detail',$reversed_detail);
		
		//Update the reversed batch number column
		$this->db->where(array('transaction_id'=>$transaction_id));
		$update_reversed_batch_number['reversing_batch_number'] = $transaction_header['batch_number'];
		$this->db->update('transaction',$update_reversed_batch_number);	
		
		//Update the approval table to approval status of 2
		
		$this->db->where(array('affected_table_name'=>'transaction','affected_record_id'=>$transaction_id,
		'affected_table_field'=>'is_cancelled'));
		
		$approval_data['approval_status'] = 2;
		
		$this->db->update('approval',$approval_data);
		
		
		$cancel_status = true;
		
		return $cancel_status;
	}

	function get_invoice_info($type,$year){
		$data['select_type'] = $type;
		$data['year'] = $year;
		echo $this->load->view('backend/finance/admin/load_invoice_info',$data,true);
	}
	
	function reverse_transaction_approval_request($transaction_id){
		
		$this->db->select(array('t_date','transaction_type.name as transaction_type',
		'transaction_method.name as transaction_method','batch_number','transaction.description','amount'));
		$this->db->join('transaction_method','transaction_method.transaction_method_id=transaction.transaction_method_id');
		$this->db->join('transaction_type','transaction_type.transaction_type_id=transaction.transaction_type_id');
		$affected = $this->db->get_where('transaction',array('transaction_id'=>$transaction_id))->row();
		
		$detail = "Kindly approve the reversal of the record with details below:<br/>";
		$detail .= "Transaction Date: ".date('jS F Y',strtotime($affected->t_date))."<br/>";
		$detail .= "Transaction Type: ".ucfirst($affected->transaction_type)."<br/>";
		$detail .= "Transaction Method: ".ucfirst($affected->transaction_method)."<br/>";
		$detail .= "Batch Number: ".$affected->batch_number."<br/>";
		$detail .= "Payee: ".$affected->payee."<br/>";
		$detail .= "Description: ".$affected->description."<br/>";
		$detail .= "Amount: ".number_format($affected->amount,2)."<br/>";
		$detail .= "Originator: ".$this->db->get_where('user',
		array('user_id'=>$this->session->login_user_id))->row()->firstname."<br/>";
		
		//$detail .= "Thanks in advance: ";
		
		$data['affected_table_name'] = 'transaction';
		$data['affected_record_id'] = $transaction_id;
		$data['affected_table_field'] = 'is_cancelled';
		$data['affected_table_field_value'] = 1;
		$data['action_to_approve'] = 'reverse_transaction';
		$data['approval_status'] = 0;
		$data['approval_detail'] = $detail;
		
		$data['createdby'] = $this->session->login_user_id;
		$data['lastmodifiedby'] = $this->session->login_user_id;
		$data['createddate'] = date('Y-m-d h:i:s');
		
		$this->db->insert(approval,$data);
		
		//Trigger email to the approver
		$this->email_model->approval_request($this->db->insert_id());
		
		$this->session->set_flashdata('flash_message' , get_phrase('approval_request_submitted'));
		redirect(base_url() . 'index.php?finance/cashbook');
	}

}
