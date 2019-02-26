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

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

    }

    /**
	 * Fees structure Management
	 */
	 
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
            $this->db->where('fees_id' , $param2);
            $this->db->delete('fees_structure');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?finance/fees_structure');
        }
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
     
	    $page_data['page_name']  = 'create_invoice';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('create_invoice');
        $this->load->view('backend/index', $page_data); 
    }		

/******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['student_id']         = $this->input->post('student_id');
			$data['class_id']         = $this->input->post('class_id');
            $data['yr']              = $this->input->post('yr');
            $data['term']        = $this->input->post('term');
            $data['amount']             = $this->input->post('amount');
            $data['amount_due']        = $this->input->post('amount_due');
			$data['balance']        = $this->input->post('amount_due');
            $data['status']             = "unpaid";//$this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->insert('invoice', $data);
			
			$invoice_id = $this->db->insert_id();
			
			$structure_ids = $this->input->post('detail_id');
			$payable_amount = $this->input->post('payable');
			$charge_overpay = array_sum($this->input->post("charge_overpay"));
			
			foreach($payable_amount as $key=>$value):
				if($value > 0){
					$data2['invoice_id'] 	= $invoice_id;
					$data2['detail_id'] 	= $key;
					$data2['amount_due'] 	= $value;
					$data2['balance']        = $value;
				
					$this->db->insert('invoice_details',$data2);
				}
							
			endforeach;
			
			if($charge_overpay > 0){
				
				$active_note = $this->db->get_where("overpay",array("student_id"=>$this->input->post('student_id'),"status"=>"active"));
				
				if($active_note->num_rows() > 0){
					$this->db->where(array("student_id"=>$this->input->post('student_id'),"status"=>"active"));
					$amount = $active_note->row()->amount;
					$current_amount_due = $active_note->row()->amount_due;
					$new_amount_due = $current_amount_due - $charge_overpay;
					
					$data8['amount_due'] = $new_amount_due;
					if($new_amount_due === 0){
						$data8['status'] = "cleared";
					}
					$this->db->update("overpay",$data8);
					
				}
				
			}

            $this->session->set_flashdata('flash_message' , get_phrase('invoice_created_successfully'));
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
                	$invoice_found = $this->db->get_where("invoice",array("student_id"=>$id,"yr"=>$this->input->post('yr'),"term"=>$this->input->post('term')));
					if($invoice_found->num_rows() === 0){
	                    $data['student_id']         = $id;
						$data['class_id']         = $this->input->post('class_id');
	                    $data['yr']              = $this->input->post('yr');
	                    $data['term']        = $this->input->post('term');
	                    $data['amount']             = $this->input->post('amount');
	                    $data['amount_due']        = $this->input->post('amount_due');
						$data['balance']        = $this->input->post('amount_due');
	                    $data['status']             = 'unpaid';
	                    $data['creation_timestamp'] = strtotime($this->input->post('date'));
	                    
	                    $this->db->insert('invoice', $data);
						
			            $invoice_id = $this->db->insert_id();
						
						$structure_ids = $this->input->post('detail_id');
						$payable_amount = $this->input->post('payable');
						
						foreach($payable_amount as $key=>$value):
							if($value > 0){
								$data2['invoice_id'] = $invoice_id;
								$data2['detail_id'] = $key;
								$data2['amount_due'] = $value;
								$data2['balance'] = $value;
								$this->db->insert('invoice_details',$data2);
							}
										
						endforeach;
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
			
			foreach($this->input->post('detail_amount_due') as $detail_id=>$amount_due){
				//Check if record exists
								
				$this->db->where(array("detail_id"=>$detail_id,"invoice_id"=>$param2));
				if($this->db->get('invoice_details')->num_rows() > 0){
					$data8['amount_due'] = $amount_due;
					$this->db->update("invoice_details",$data8);
				}else{
					$data8['invoice_id'] = $param2;
					$data8['detail_id'] = $detail_id;
					$data8['amount_due'] = $amount_due;
					$data8['amount_paid'] = 0;
					$data8['amount_paid'] = $amount_due;
					$this->db->insert("invoice_details",$data8);
				}
				
				
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
        if ($param1 == 'take_payment') {
        	
			$this->db->select_max('serial');
			$res = $this->db->get("payment")->row()->serial;
						
			$take_payment = $this->input->post('take_payment');
			
			
			
			//Create a Payment Record
			$data_payment['batch_number'] 	= $this->crud_model->populate_batch_number($this->input->post('timestamp'));
			$data_payment['serial'] 		=  $res+1;
			$data_payment['t_date'] 		= $this->input->post('timestamp');
			$data_payment['invoice_id'] 	= $this->input->post('invoice_id');
			$data_payment['method']			=   $this->input->post('method');
			$data_payment['description']	=   $this->input->post('description');
			$data_payment['payee']			=   $this->input->post('payee');
			$data_payment['payment_type']	=   "1";//array_sum($take_payment);
			$data_payment['amount']			=   array_sum($take_payment);
			$data_payment['timestamp']    	=   strtotime($this->input->post('timestamp'));
			
			
			$this->db->insert('payment' , $data_payment);
			
			$last_payment_id = $this->db->insert_id();
			
			//Update Invoice Details
			
			//$invoice_details = $this->db->get_where('invoice_details',array('invoice_id'=>$this->input->post('invoice_id')))->result_object();
			
			foreach($take_payment as $key=>$value){
				if($value > 0){
					
					$detail = $this->db->get_where("invoice_details",array("detail_id"=>$key))->row();
												
					$paid_to_date  = $detail->amount_paid + $value;
					
					$data_invoice['amount_paid']   	=   $paid_to_date;
					$data_invoice['balance'] 		= 	$detail->amount_due - $paid_to_date;
					$data_invoice['detail_id'] 		=  $key;
					$data_invoice['last_payment_id']  		=   $last_payment_id;
		            
					$this->db->where(array("invoice_id"=> $this->input->post('invoice_id'), "detail_id"=>$key));
					
		            $this->db->update('invoice_details' , $data_invoice);
					
					//Create Payment details
					
					$data_details['payment_id'] 	= $last_payment_id;//$this->input->post('invoice_id');
					$data_details['detail_id'] 		=  $key;
					$data_details['amount'] 		= $value;
					$data_details['t_date'] 		= $this->input->post('timestamp');
					
					$this->db->insert("student_payment_details",$data_details);
								
		          }	
			}
			
			//Update Invoice Record			

            $data2['amount_paid']   =   $this->input->post('total_payment');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('balance', 'balance - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');
			
			$bal = $this->db->get_where('invoice',array('invoice_id'=>$param2))->row()->balance;
			
			if($bal<=0){
				$data3['status']   =   'paid';
            	$this->db->where('invoice_id' , $param2);
				$this->db->update('invoice',$data3);
			}
			
					
			//Enter Income into the Cash Book
			$data1['t_date'] = $this->input->post('timestamp');//date('Y-m-d');
			$data1['batch_number'] = $this->crud_model->populate_batch_number($this->input->post('timestamp'));

			$student_id = $this->db->get_where("invoice",array("invoice_id"=>$this->input->post('invoice_id')))->row()->student_id;
						
			$data1['description'] = get_phrase('student_payment').' - '.$this->db->get_where('student',array('student_id'=>$student_id))->row()->name;
			$data1['transaction_type'] = '1'; //1 Means Income and 2 means expenses
			$data1['account'] = $this->input->post('method');
			$data1['amount'] = array_sum($take_payment);
            $this->db->insert('cashbook' , $data1);
			
			
			//exit;
            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?finance/student_payments', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
			
			//Delete Invoice Details
			$this->db->where('invoice_id', $param2);
            $this->db->delete('invoice_details');
			
			//Delete Payments
			$this->db->where('invoice_id', $param2);
            $this->db->delete('payment');
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
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
	
	function get_fees_items($term="",$year="",$class="",$student=""){
		
		$fees = $this->db->get_where('fees_structure',array("term"=>$term,"yr"=>$year,"class_id"=>$class));

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
							
							$body .= "<tr><td><input type='checkbox' onchange='return get_full_amount(".$row->detail_id.")' id='chk_".$row->detail_id."'/></td><td>".$row->name."</td><td id='full_amount_".$row->detail_id."'>".$row->amount."</td><td><input type='text' onkeyup='return get_payable_amount(".$row->detail_id.")' class='form-control payable_items' id='payable_".$row->detail_id."' name='payable[".$row->detail_id."]' value='0' /></td><td><input type='text' class='form-control charge_overpay' value='0' name='charge_overpay[".$row->detail_id."]' /></td><tr>";
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
	
	function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
            
        if ($param1 == 'create') {
            $data['payee']        =   $this->input->post('payee'); 
			$data['batch_number']        =   $this->crud_model->populate_batch_number($this->input->post('t_date'));   
			$data['t_date']        =   $this->input->post('t_date');		
            $data['description']         =   $this->input->post('description');			
            $data['method']              =   $this->input->post('method');	
			$data['cheque_no']              =   $this->input->post('cheque_no');			    	
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->insert('expense' , $data);
			
			$expense_id = $this->db->insert_id();
			
			$qty = $this->input->post('qty');
			$desc = $this->input->post('desc');
			$unitcost = $this->input->post('unitcost');
			$cost = $this->input->post('cost');
			$category = $this->input->post('category');
			
			foreach($qty as $key=>$val):
				$data2['expense_id'] = $expense_id;
				$data2['qty'] = $qty[$key];
				$data2['description'] = $desc[$key];
				$data2['unitcost'] = $unitcost[$key];
				$data2['cost'] = $cost[$key];
				$data2['expense_category_id'] = $category[$key];
				
				$this->db->insert('expense_details' , $data2);
				
			endforeach;
			
			
			//Enter Income into the Cash Book
			$data1['t_date'] = $this->input->post('t_date');
			$data1['batch_number'] = $this->crud_model->populate_batch_number($this->input->post('t_date'));
			$data1['description'] = $this->input->post('description');
			$data1['transaction_type'] = '2';
			$data1['account'] = $this->input->post('method');
			$data1['amount'] = $this->input->post('amount');;
            $this->db->insert('cashbook' , $data1);
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
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
			$data['batch_mumber']        =   $this->crud_model->populate_batch_number($date);
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
			$data1['batch_number'] = $this->crud_model->populate_batch_number(date('Y-m-d'));
			$data1['description'] = get_phrase('reversal:_batch').' - '.$expense->batch_number;
			$data1['transaction_type'] = '2';
			$data1['account'] = $expense->method;
			$data1['amount'] = -$expense->amount;
            $this->db->insert('cashbook' , $data1);
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('record_reversed_successful'));
            redirect(base_url() . 'index.php?finance/expense', 'refresh');
		}

        $page_data['page_name']  = 'expense';
		$page_data['page_view'] = "finance";
		$page_data['expenses'] = $this->db->get('expense')->result_object();
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data); 
    }

	/**Income management **/
	
	function get_overpay($param1=""){
		$overpay = 0;
		
		$obj = $this->db->get_where("overpay",array("status"=>"active","student_id"=>$param1));
		
		if($obj->num_rows() > 0){
			$overpay = $obj->row()->amount_due;
		}
		
		echo $overpay;
	}

	function income_scroll($param1=""){
		$this->db->where(array("YEAR(t_date)"=>date("Y",$param1)));
    	$this->db->order_by('timestamp' , 'desc');
    	$payments = $this->db->get('payment')->result_object();
		$data['payments'] = $payments;
		$data['timestamp'] = $param1;
		
		echo $this->load->view("backend/finance/scroll_income",$data,true);
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
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }

		
	function income($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
            
        if ($param1 == 'create') {
       		$res = $this->db->get("payment")->row()->serial;
			
        	
            $data['payee']        	=   $this->input->post('payee'); 
			$data['serial']        	=   $res+1; 
			$data['batch_number']   =   $this->crud_model->populate_batch_number($this->input->post('t_date'));   
			$data['t_date']        	=   $this->input->post('t_date');		
            $data['description']    =   $this->input->post('description');			
            $data['method']         =   $this->input->post('method');	
			$data['payment_type']   =   "2";
            $data['amount']         =   $this->input->post('amount');
            $data['timestamp']      =   strtotime($this->input->post('t_date'));
            $this->db->insert('payment' , $data);
			
			$payment_id = $this->db->insert_id();
			
			$qty = $this->input->post('qty');
			$desc = $this->input->post('desc');
			$unitcost = $this->input->post('unitcost');
			$cost = $this->input->post('cost');
			$category = $this->input->post('category');
			
			foreach($qty as $key=>$val):
				$data2['payment_id'] = $payment_id;
				$data2['qty'] = $qty[$key];
				$data2['description'] = $desc[$key];
				$data2['unitcost'] = $unitcost[$key];
				$data2['cost'] = $cost[$key];
				$data2['income_category_id'] = $category[$key];
				
				$this->db->insert('other_payment_details' , $data2);
				
			endforeach;
			
			
			//Enter Income into the Cash Book
			$data1['t_date'] = $this->input->post('t_date');
			$data1['batch_number'] = $this->crud_model->populate_batch_number($this->input->post('t_date'));
			$data1['description'] = $this->input->post('description');
			$data1['transaction_type'] = '1';
			$data1['account'] = $this->input->post('method');
			$data1['amount'] = $this->input->post('amount');;
            $this->db->insert('cashbook' , $data1);
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?finance/income', 'refresh');
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
			$data['batch_mumber']        =   $this->crud_model->populate_batch_number($date);
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
			$data1['batch_number'] = $this->crud_model->populate_batch_number(date('Y-m-d'));
			$data1['description'] = get_phrase('reversal:_batch').' - '.$income->batch_number;
			$data1['transaction_type'] = '1';
			$data1['account'] = $income->method;
			$data1['amount'] = -$income->amount;
            $this->db->insert('cashbook' , $data1);
			
			
            $this->session->set_flashdata('flash_message' , get_phrase('record_reversed_successful'));
            redirect(base_url() . 'index.php?finance/income', 'refresh');
		}

        $page_data['page_name']  = 'income';
		$page_data['page_view'] = "finance";
		$page_data['payments'] = $this->db->get('payment')->result_object();
        $page_data['page_title'] = get_phrase('income');
        $this->load->view('backend/index', $page_data); 
    }	

	function check_batch_number($param1="",$table="income"){
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
		$table = $_POST['record_type'];
		$record_id = $_POST["indx"];
		$month = $_POST['month'];
		
		//$check current clear state
		$record = $this->db->get_where($table,array($table."_id"=>$record_id))->row();
		
		$data['cleared'] = 1;
		$data['clearedMonth'] = $month;
		
		if($record->cleared == '1'){
			$data['cleared'] = 0;
			$data['clearedMonth'] = "0000-00-00";	
		}
		
		
		$this->db->where(array($table."_id"=>$record_id));
		$this->db->update($table,$data);
		
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
	
	
	function scroll_cashbook($param1=""){
		if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		$t_date = date('Y-m-d',$param1);
		
		$month = date('m',strtotime($t_date));
		$year = date('Y',strtotime($t_date));
		
		$opening_balance = $this->crud_model->opening_account_balance($t_date);
		
		$page_data['cash_balance'] = $opening_balance['cash_balance'];
		$page_data['bank_balance'] = $opening_balance['bank_balance'];
        $page_data['page_name']  = 'cash_book';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('cash_book');
		$page_data['current'] = $t_date;
		$page_data['transactions'] = $this->db->get_where('cashbook',array('Month(t_date)'=>$month,'Year(t_date)'=>$year))->result_object();
        $this->load->view('backend/index', $page_data);
		
	}
	
	
	function cash_book($param1="") {
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
		
		$t_date = date('Y-m-d');
		
		if($param1==="scroll") $t_date = $this->input->post('t_date'); 
		
		if($param1==="") {
			
			$t_date = date('Y-m-01');
			
			$reconcile = $this->db->get("reconcile");
			
			$cashbook = $this->db->get("cashbook");
			
			if($reconcile->num_rows() > 0 && $cashbook->num_rows() > 0){
				
				$last_reconcile_month = $this->db->select_max("month")->get("reconcile")->row()->month;

				if(date("Y-m-01",strtotime($last_reconcile_month)) < $t_date ){
					$t_date = date("Y-m-01",strtotime('+1 month',strtotime($last_reconcile_month)));
				}
				
			}elseif($cashbook->num_rows() == 0){
				$t_date = $this->db->get_where('settings',array('type'=>'system_start_date'))->row()->description;	
			}elseif($reconcile->num_rows() === 0){
				$t_date = $this->db->select_max("t_date")->get("cashbook")->row()->t_date;
			}
		}
			
		$month = date('m',strtotime($t_date));
		$year = date('Y',strtotime($t_date));
		
		$opening_balance = $this->crud_model->opening_account_balance($t_date);
		

		$page_data['cash_balance'] = $opening_balance['cash_balance'];
		$page_data['bank_balance'] = $opening_balance['bank_balance'];
        $page_data['page_name']  = 'cash_book';
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('cash_book');
		$page_data['current'] = $t_date;
		$page_data['transactions'] = $this->db->get_where('cashbook',array('Month(t_date)'=>$month,'Year(t_date)'=>$year))->result_object();
        $this->load->view('backend/index', $page_data); 
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
			//Enter Income into the Cash Book
			$data1['t_date'] = $this->input->post('t_date');
			$data1['batch_number'] = $this->crud_model->populate_batch_number(date('Y-m-d'));
			$data1['description'] = $this->input->post('description');
			$data1['transaction_type'] = $this->input->post('entry_type');
			$data1['account'] = 0;
			$data1['amount'] = $this->input->post('amount');
            $this->db->insert('cashbook' , $data1);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?finance/cash_book/'.$param2, 'refresh');			
		}
		
		
		//$this->cash_book($param2);
	}
	
	function financial_report($param1=""){
        if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');		
		
		$t_date = date('Y-m-d');
		
		if($param1==="scroll") $t_date = $this->input->post('t_date'); 
		
		if($param1==="") $t_date = date('Y-m-01');

        $page_data['page_name']  = 'financial_report';
		$page_data['current_date'] = $t_date;
		$page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('financial_report');
        $this->load->view('backend/index', $page_data);
	}
	
	public function budget($param="",$param2=""){
        if ($this->session->userdata('active_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
		
		if($param==='create'){
			
			$data['expense_category_id'] = $this->input->post('expense_category_id');
			$data['description'] = $this->input->post('description');
			$data['fy'] = $this->input->post('fy');
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
            redirect(base_url() . 'index.php?admin/budget/', 'refresh');
		}
		
		if($param==='delete_item'){
			
			$this->db->where(array('budget_id'=>$param2));
			
			$this->db->delete('budget');
			
			$this->db->where(array('budget_id'=>$param2));
			
			$this->db->delete('budget_schedule');
			
			$this->session->set_flashdata('flash_message', 'Record Deleted');
            redirect(base_url() . 'index.php?admin/budget/', 'refresh');
		}
		
		if($param==='edit_item'){
			
		}
		
		$page_data['year']  = date('Y');
		if($param==="scroll"){
			$page_data['year']  = $param2;
		}
        $page_data['page_name']  = 'budget';
		$page_data['page_view'] = 'finance';
        $page_data['page_title'] = get_phrase('budget');
        $this->load->view('backend/index', $page_data);		
	}

	function validate_cheque_number($cheque_number){
		$count = $this->db->get_where('expense',array('cheque_no'=>$cheque_number))->num_rows();
		
		if($count>0){
			echo "Cheque number exists";
		}else{
			echo 0;
		}
	}
		
}
