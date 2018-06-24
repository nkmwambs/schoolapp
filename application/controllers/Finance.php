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
			
			foreach($payable_amount as $key=>$value):
				$data2['invoice_id'] = $invoice_id;
				$data2['detail_id'] = $key;
				$data2['amount_due'] = $value;
				
				$this->db->insert('invoice_details',$data2);			
			endforeach;

            $this->session->set_flashdata('flash_message' , get_phrase('invoice_created_successfully'));
            redirect(base_url() . 'index.php?finance/create_invoice', 'refresh');
        }

		// if($param1==="edit"){
// 	
			// //$structure_ids = $this->input->post('detail_id');
			// $payable_amount = $this->input->post('payable');
// 			
			// $sum_invoice = 0;
// 			
			// foreach($payable_amount as $key=>$value):
// 				
				// //Check structure details id in invoices
// 				
				// $details_id_check = $this->db->get_where('invoice_details',array('invoice_id'=>$param2,'detail_id'=>$key))->num_rows();
// 				
				// //Get old value
				// $this->db->where(array('invoice_id'=>$param2,'detail_id'=>$key));
				// $old_amount_due = $this->db->get('invoice_details')->row()->amount_due;
// 				
// 				
// 				
				// if($details_id_check>0){
// 					
					// //Update details
					// $this->db->where(array('invoice_id'=>$param2,'detail_id'=>$key));
// 					
					// $data['amount_due'] = $value;
					// $this->db->update('invoice_details',$data);	
// 							
					// //Update invoice
// 										
					// $this->db->set('amount_due',$this->input->post('amount_due'),FALSE);
					// $this->db->set('balance','amount_due - '.$this->db->get_where('invoice',array('invoice_id'=>$param2))->row()->amount_paid,FALSE);
// 
					// $this->db->where(array('invoice_id'=>$param2));
					// $this->db->update('invoice');	
// 					
				// }else{
					// $data['invoice_id'] = $param2;
					// $data['detail_id'] = $key;
					// $data['amount_due'] = $value;
// 				
					// $this->db->insert('invoice_details',$data);
// 					
					// //Adjust the Invoice header
// 					
					// $this->db->set('amount_due',$this->input->post('amount_due'),FALSE);
					// $this->db->set('balance','amount_due - '.$this->db->get_where('invoice',array('invoice_id'=>$param2))->row()->amount_paid,FALSE);
// 
// 					
					// $this->db->where(array('invoice_id'=>$param2));
					// $this->db->update('invoice');
				// }
// 							
				// $sum_invoice +=$value;
// 							
			// endforeach;
// 			
// 			
            // $this->session->set_flashdata('flash_message' , get_phrase('invoice_editted_successfully'));
            // redirect(base_url() . 'index.php?finance/create_invoice', 'refresh');			
		// }

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
							$data2['invoice_id'] = $invoice_id;
							$data2['detail_id'] = $key;
							$data2['amount_due'] = $value;
							
							$this->db->insert('invoice_details',$data2);			
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
				$this->db->where(array("detail_id"=>$detail_id,"invoice_id"=>$param2));
				$data8['amount_due'] = $amount_due;
				$this->db->update("invoice_details",$data8);
			}
			//exit;
			$this->session->set_flashdata('flash_message' , get_phrase('edit_successful'));
			redirect(base_url() . 'index.php?finance/income', 'refresh');
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
			
			$invoice_details = $this->db->get_where('invoice_details',array('invoice_id'=>$this->input->post('invoice_id')))->result_object();
			
			$take_payment = $this->input->post('take_payment');
			
			$amt = 0;
			
			foreach($invoice_details as $key=>$value){
				if($take_payment[$key]!=='0'){
					
					$amt += $take_payment[$key];
					
					$data['invoice_id']   =   $this->input->post('invoice_id');
		            $data['student_id']   =   $this->input->post('student_id');
		            $data['yr']        =   $this->input->post('yr');
					$data['serial'] = $res+1;
					$data['batch_number'] = $this->crud_model->populate_batch_number($this->input->post('timestamp'));
					$data['detail_id']  =   $value->detail_id;
		            $data['term']  =   $this->input->post('term');
		            $data['method']       =   $this->input->post('method');
		            $data['amount']       =   $take_payment[$key];
		            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
		            $this->db->insert('payment' , $data);
		          }	
			}
			
			
			//Enter Income into the Cash Book
			$data1['t_date'] = date('Y-m-d');
			$data1['batch_number'] = $this->crud_model->populate_batch_number($this->input->post('timestamp'));
			$data1['description'] = get_phrase('student_payment').' - '.$this->db->get_where('student',array('student_id'=>$this->input->post('student_id')))->row()->name;
			$data1['transaction_type'] = '1'; //1 Means Income and 2 means expenses
			$data1['account'] = $this->input->post('method');
			$data1['amount'] = $amt;
            $this->db->insert('cashbook' , $data1);
			
			

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

            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?finance/income', 'refresh');
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
            redirect(base_url() . 'index.php?finance/income', 'refresh');
        }
		
		if ($param1 == 'cancel') {
			$this->db->where('invoice_id', $param2);
			$data3['status'] = 'cancelled';
            $this->db->update('invoice',$data3);
			
			$this->session->set_flashdata('flash_message' , get_phrase('invoice_cancelled'));
            redirect(base_url() . 'index.php?finance/income', 'refresh');
		}

		if ($param1 == 'reclaim') {
					$data4['status'] = 'unpaid';	
					if($this->db->get_where("invoice",array("invoice_id"=>$param2,"amount_due"=>0))->num_rows() > 0){
						$data4['status'] = "paid";
					}
					$this->db->where('invoice_id', $param2);	
		            $this->db->update('invoice',$data4);
					
					$this->session->set_flashdata('flash_message' , get_phrase('invoice_reclaimed'));
		            redirect(base_url() . 'index.php?finance/income', 'refresh');
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
							
							$body .= "<tr><td><input type='checkbox' onchange='return get_full_amount(".$row->detail_id.")' id='chk_".$row->detail_id."'/></td><td>".$row->name."</td><td id='full_amount_".$row->detail_id."'>".$row->amount."</td><td><input type='text' onkeyup='return get_payable_amount(".$row->detail_id.")' class='form-control payable_items' id='payable_".$row->detail_id."' name='payable[".$row->detail_id."]'/></td><tr>";
						endforeach;
			
					}else{
						
						$amount_due = 0;
						echo "<input type='hidden' id='edit_invoice_id' value='".$invoice->row()->invoice_id."'/>";
						foreach($details as $row):
							
							$amount_due = $this->db->get_where('invoice_details',array('invoice_id'=>$invoice->row()->invoice_id,'detail_id'=>$row->detail_id))->row()->amount_due;
							$body .= "<tr><td><input type='checkbox' onchange='return get_full_amount(".$row->detail_id.")' id='chk_".$row->detail_id."'/></td><td>".$row->name."</td><td id='full_amount_".$row->detail_id."'>".$row->amount."</td><td><input type='text' onkeyup='return get_payable_amount(".$row->detail_id.")' class='form-control payable_items' id='payable_".$row->detail_id."' name='payable[".$row->detail_id."]' value='".$amount_due."'/></td><tr>";
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
		
		$str = "<tr><td colspan='3'>".get_phrase('no_items_found')."</td></tr>";
		
		if($fees->num_rows() > 0){
			$fees_id = $fees->row()->fees_id;
			
			$details = $this->db->get_where('fees_structure_details',array("fees_id"=>$fees_id))->result_object();
			
			foreach($details as $row):
				echo "<tr><td><input type='checkbox' onchange='return get_mass_full_amount(".$row->detail_id.")' id='mass_chk_".$row->detail_id."'/></td><td>".$row->name."</td><td id='mass_full_amount_".$row->detail_id."'>".$row->amount."</td><td><input type='text' onkeyup='return get_mass_payable_amount(".$row->detail_id.")' class='form-control mass_payable_items' id='mass_payable_".$row->detail_id."' name='payable[".$row->detail_id."]'/></td><tr>";
			endforeach;
		}	
		
		echo $str;	
	}

	/**Income management **/
	
	function income($param1 = '' , $param2 = '')
    {
       if ($this->session->userdata('active_login') != 1)
            redirect('login', 'refresh');
	   
        $page_data['page_name']  = 'income';
        $page_data['page_view'] = "finance";
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }	
}
