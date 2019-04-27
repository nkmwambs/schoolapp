<?php
	$this->db->where('status' , 'unpaid');
	$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $unpaid_invoices = $this->db->get('invoice')->result_array();
	
	
	$this->db->where('status' , 'paid');
	$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $paid_invoices = $this->db->get('invoice')->result_array();
	
	$this->db->where('status' , 'excess');
	$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $overpaid_invoices = $this->db->get('invoice')->result_array();
	
	$this->db->where('status' , 'active');
	//$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $overpay_notes = $this->db->get('overpay')->result_array();
	
	$this->db->where('status' , 'cleared');
	//$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $cleared_overpay_notes = $this->db->get('overpay')->result_array();
	
	$this->db->where('status' , 'cancelled');
	$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $cancelled_invoices = $this->db->get('invoice')->result_array();
	
?>

<hr/>

<div class="row">
	<div class="col-xs-12">
		<a href="<?=base_url();?>index.php?finance/student_collection_tally/<?=date('Y');?>" class="btn btn-default"> <i class="fa fa-list"></i> Payment tally sheet</a>
		<?php
			$count_to_notify = $this->db->get_where('invoice',array('status'=>'unpaid'))->num_rows();
		?>
		<div class="btn btn-default"><i class="fa fa-mobile"></i> SMS balances <span class="badge badge-primary"><?=$count_to_notify;?></span></div>
		<div class="btn btn-default"><i class="fa fa-envelope"></i> Email balances <span class="badge badge-primary"><?=$count_to_notify;?></span></div>
		<a href="<?php echo base_url(); ?>index.php?finance/create_invoice" class="btn btn-primary"><i class="fa fa-money"></i> Create Invoice</a>
	</div>
</div>

<hr />

<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('year');?> <?=$year;?>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/scroll_student_payments/<?=$year - 1;?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-md-10">
			
			<ul class="nav nav-tabs bordered">
				<li class="active">
					<a href="#unpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('unpaid_invoices');?></span> 
						<span class="badge badge-danger"><?php echo count($unpaid_invoices);?></span>
					</a>
				</li>
				
				<li class="">
					<a href="#cleared" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cleared_invoices');?></span>
						<span class="badge badge-success"><?php echo count($paid_invoices);?></span>
					</a>
				</li>
				
				<li class="">
					<a href="#overpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('overpaid_invoices');?></span>
						<span class="badge badge-default"><?php echo count($overpaid_invoices);?></span>
					</a>
				</li>
				
				<li class="">
					<a href="#overpay_notes" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('overpay_notes');?></span>
						<span class="badge badge-default"><?php echo count($overpay_notes);?></span>
					</a>
				</li>
				
				<li class="">
					<a href="#cleared_overpay_notes" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cleared_overpay_notes');?></span>
						<span class="badge badge-default"><?php echo count($cleared_overpay_notes);?></span>
					</a>
				</li>
				
				<!-- <li>
					<a href="#paid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('payment_history');?></span>
					</a>
				</li> -->
				
				<li>
					<a href="#cancelled" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cancelled_invoices');?></span>
						<span class="badge badge-info"><?php echo count($cancelled_invoices);?></span>
					</a>
				</li>
				
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="unpaid">
					
											
						<table  class="table table-bordered datatable example">
                	<thead>
                		<tr>
                			<th>#</th>
                    		<th><div><?php echo get_phrase('student');?></div></th>
                    		<th><div><?php echo get_phrase('year');?></div></th>
                    		<th><div><?php echo get_phrase('term');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('fee_structure_total');?></div></th>
                            <th><div><?php echo get_phrase('payable_amount');?></div></th>
                            <th><div><?php echo get_phrase('balance');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                    		$count = 1;
                    		
                    		foreach($unpaid_invoices as $row):
                    	?>
                        <tr>
                        	<td><?php echo $count++;?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $row['yr'];?></td>
							<td><?php echo $row['term'];?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
							<td><?php echo $row['amount'];?></td>
                            <td><?php echo $row['amount_due'];?></td>
                            <?php
                            	$bal = $row['amount_due'] - $row['amount_paid']; 
                            ?>
                            <td><?php echo $bal;?></td>
							<td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <?php if ($bal != 0):?>

                                    <li class="take_student_payment">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_take_payment/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('take_payment');?>
                                        </a>
                                    </li>
                                    <li class="divider take_student_payment"></li>
                                    <?php endif;?>
                                    
                                    <!-- VIEWING INVOICE LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo get_phrase('view_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- EDIT INVOICE LINK -->
                                    <li class="edit_invoice">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider edit_invoice"></li>

                                    <!-- DELETION LINK -->
                                    <li class="delete_or_cancel_invoice">
                                    	<?php
                                    	if($this->db->get_where("payment",array("invoice_id"=>$row['invoice_id']))->num_rows() === 0){	
                                    	?>
	                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?finance/invoice/delete/<?php echo $row['invoice_id'];?>');">
	                                            <i class="entypo-trash"></i>
	                                                <?php echo get_phrase('delete_invoice');?>
	                                        </a>
	                                        
                                        <?php
										}else{
                                    	?>
                                    		<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/invoice/cancel/<?php echo $row['invoice_id'];?>');">
	                                            <i class="entypo-cancel"></i>
	                                                <?php echo get_phrase('cancel_invoice');?>
	                                        </a>
                                    	
                                    	<?php
										}
                                    	?>
                                     </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
					
				</div>
				
				<div class="tab-pane" id="cleared">
					<div class="row" id="paid_invoices_placeholder">
						
						<div class="col-sm-1">
							<a id="prev_year" title="<?=date('Y',strtotime("-1 Year"))?>" href="#cleared"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
						</div>
						
						<div class="col-sm-10">
								<table  class="table table-bordered datatable example">
			                	<thead>
			                		<tr>
			                			<th>#</th>
			                    		<th><div><?php echo get_phrase('student');?></div></th>
			                    		<th><div><?php echo get_phrase('year');?></div></th>
			                    		<th><div><?php echo get_phrase('term');?></div></th>
			                    		<th><div><?php echo get_phrase('class');?></div></th>
			                            <th><div><?php echo get_phrase('fee_structure_total');?></div></th>
			                            <th><div><?php echo get_phrase('payable_amount');?></div></th>
			                            <th><div><?php echo get_phrase('balance');?></div></th>
			                    		<th><div><?php echo get_phrase('date');?></div></th>
										<th><div><?php echo get_phrase('action');?></div></th>
									</tr>
								</thead>
			                    <tbody>
			                    	<?php
			                    		$count = 1;
			                    		//$this->db->where('status' , 'paid');
			                    		//$this->db->order_by('creation_timestamp' , 'desc');
			                    		//$invoices = $this->db->get('invoice')->result_array();
			                    		foreach($paid_invoices as $row3):
			                    	?>
			                        <tr>
			                        	<td><?php echo $count++;?></td>
										<td><?php echo $this->crud_model->get_type_name_by_id('student',$row3['student_id']);?></td>
										<td><?php echo $row3['yr'];?></td>
										<td><?php echo $row3['term'];?></td>
										<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
										<td><?php echo $row3['amount'];?></td>
			                            <td><?php echo $row3['amount_due'];?></td>
			                            <?php
			                            	$bal = $row3['amount_due'] - $row3['amount_paid']; 
			                            ?>
			                            <td><?php echo $bal;?></td>
										<td><?php echo date('d M,Y', $row3['creation_timestamp']);?></td>
										<td>
											<div class="btn-group">
			                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			                                    Action <span class="caret"></span>
			                                </button>
			                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
			
			
			                                    <li>
			                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row3['invoice_id'];?>');">
			                                            <i class="entypo-bookmarks"></i>
			                                                <?php echo get_phrase('view_history');?>
			                                        </a>
			                                    </li>
			
			                                </ul>
			                            </div>
										</td>
			                        </tr>
			                        <?php endforeach;?>
			                    </tbody>
			                </table>		
						</div>
						
						
						<div class="col-sm-1">
							<a id="next_year" title="<?=date('Y',strtotime("+1 Year"))?>" href="#cleared"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
						</div>
	
					</div>	
					
									
				</div>
				
				<div class="tab-pane" id="overpaid">
						
					<table  class="table table-bordered datatable example">
                	<thead>
                		<tr>
                			<th>#</th>
                    		<th><div><?php echo get_phrase('student');?></div></th>
                    		<th><div><?php echo get_phrase('year');?></div></th>
                            <th><div><?php echo get_phrase('fee_structure_total');?></div></th>
                            <th><div><?php echo get_phrase('payable_amount');?></div></th>
                            <th><div><?php echo get_phrase('balance');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
							<th><div><?php echo get_phrase('action');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                    		$count = 1;
                    		//$this->db->where('status' , 'paid');
                    		//$this->db->order_by('creation_timestamp' , 'desc');
                    		//$invoices = $this->db->get('invoice')->result_array();
                    		foreach($overpaid_invoices as $row3):
                    	?>
                        <tr>
                        	<td><?php echo $count++;?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row3['student_id']);?></td>
							<td><?php echo $row3['yr'];?></td>
							<td><?php echo $row3['amount'];?></td>
                            <td><?php echo $row3['amount_due'];?></td>
                            <?php
                            	$bal = $row3['amount_due'] - $row3['amount_paid']; 
                            ?>
                            <td><?php echo $bal;?></td>
							<td><?php echo date('d M,Y', $row3['creation_timestamp']);?></td>
							<td>
								<div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">


                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row3['invoice_id'];?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('view_history');?>
                                        </a>
                                    </li>

                                </ul>
                            </div>
							</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
									
				</div>
				
				<!-- <div class="tab-pane" id="paid">
					
					<table class="table table-bordered datatable example">
					    <thead>
					        <tr>
					            <th><div>#</div></th>
					            <th><div><?php echo get_phrase('student');?></div></th>
					            <th><div><?php echo get_phrase('year');?></div></th>
					            <th><div><?php echo get_phrase('term');?></div></th>
					            <th><div><?php echo get_phrase('method');?></div></th>
					            <th><div><?php echo get_phrase('amount');?></div></th>
					            <th><div><?php echo get_phrase('date');?></div></th>
					            <th></th>
					        </tr>
					    </thead>
					    <tbody>
					        <?php 
					        	$count = 1;
					        	//$this->db->where('payment_type' , 'income');
					        	$this->db->order_by('timestamp' , 'desc');
								$this->db->group_by('serial');
					        	$payments = $this->db->get('payment')->result_array();
								//print_r($payments);
					        	foreach ($payments as $row):
					        ?>
					        <tr>
					        	<td><?php echo $count++;?></td>
					        	<td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->name;?></td>
					            <td><?php echo $row['yr'];?></td>
					            <td><?php echo $this->db->get_where('terms',array('term_number'=>$row['term']))->row()->name;?></td>
					            <td>
					            	<?php 
					            		if ($row['method'] == 1)
					            			echo get_phrase('cash');
					            		if ($row['method'] == 2)
					            			echo get_phrase('check');
					            		if ($row['method'] == 3)
					            			echo get_phrase('card');
					                    if ($row['method'] == 'paypal')
					                    	echo 'paypal';
					            	?>
					            </td>
					            <td><?php echo $row['amount'];?></td>
					            <td><?php echo date('d M,Y', $row['timestamp']);?></td>
					            <td>
					            	
					            	<div class="btn-group">
									 <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
									        Action <span class="caret"></span>
									 </button>
									       <ul class="dropdown-menu dropdown-default pull-right" role="menu">
									                        
									          
									            <li>
									               	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_receipt/<?php echo $row['batch_number'];?>');">
									                   	<i class="fa fa-eye-slash"></i>
															<?php echo get_phrase('view_receipt');?>
									               	</a>
									             </li>
									             <li class="divider"></li>
									                        
									             
									             <li>
									                 <a href="<?=base_url();?>index.php?finance/download_receipt/<?php echo $row['batch_number'];?>" >
									                     <i class="fa fa-download"></i>
															<?php echo get_phrase('download_receipt');?>
									                  </a>
									             </li>
									        </ul>
									</div>
					            
					        </tr>
					        <?php endforeach;?>
					    </tbody>
					</table>
						
				</div> -->
				
				<div class="tab-pane" id="overpay_notes">
					
					<!-- <div class="row">
						
						<div class="col-sm-12">
							<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_overpay_add/');" 
							class="btn btn-primary pull-right add_over_note">
							<i class="entypo-plus-circled"></i>
							<?php echo get_phrase('add_note');?>
							</a> 
							
						</div>
					</div> -->
					
					<hr/>
					
					<div class="row">	
						<div class="col-sm-12">
								<table class="table table-bordered datatable example">
							    <thead>
							        <tr>
							            <th><div>#</div></th>
							            <th><div><?php echo get_phrase('student');?></div></th>
							            <th><div><?php echo get_phrase('amount');?></div></th>
							            <th><div><?php echo get_phrase('balance');?></div></th>
							            <th><div><?php echo get_phrase('description');?></div></th>
							            <th><div><?php echo get_phrase('status');?></div></th>
							            <th><div><?php echo get_phrase('date');?></div></th>
							            
							        </tr>
							    </thead>
							    <tbody>
							    	<?php
							    		$notes_object = $this->db->get_where("overpay",array("status"=>"active"));
							    		
										if($notes_object->num_rows() > 0){
											$cnt = 1;
											foreach($notes_object->result_object() as $row){
							    	?>
							    			<tr>
							    				<td><?=$cnt;?></td>
							    				<td><?=$this->crud_model->get_type_name_by_id("student",$row->student_id);?></td>
							    				<td><?=$row->amount;?></td>
							    				<td><?=$row->amount_due;?></td>
							    				<td><?=$row->description;?></td>
							    				<td><?=$row->status;?></td>
							    				<td><?=$row->creation_timestamp;?></td>
							    			</tr>
							    	<?php
							    				$cnt++;
											}
										}
							    	?>
							    	
								</tbody>
							</table>		
							</div>		
						</div>
				</div>
				
				<div class="tab-pane" id="cleared_overpay_notes">
					
					<div class="row">
						
						<div class="col-sm-12">
							<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_overpay_add/');" 
							class="btn btn-primary pull-right">
							<i class="entypo-plus-circled"></i>
							<?php echo get_phrase('add_note');?>
							</a> 
							
						</div>
					</div>
					
					<hr/>
					
					<div class="row">	
						<div class="col-sm-12">
								<table class="table table-bordered datatable example">
							    <thead>
							        <tr>
							            <th><div>#</div></th>
							            <th><div><?php echo get_phrase('student');?></div></th>
							            <th><div><?php echo get_phrase('amount');?></div></th>
							            <th><div><?php echo get_phrase('balance');?></div></th>
							            <th><div><?php echo get_phrase('description');?></div></th>
							            <th><div><?php echo get_phrase('status');?></div></th>
							            <th><div><?php echo get_phrase('date');?></div></th>
							            
							        </tr>
							    </thead>
							    <tbody>
							    	<?php
							    		$notes_object = $this->db->get_where("overpay",array("status"=>"cleared"));
							    		
										if($notes_object->num_rows() > 0){
											$cnt = 1;
											foreach($notes_object->result_object() as $row){
							    	?>
							    			<tr>
							    				<td><?=$cnt;?></td>
							    				<td><?=$this->crud_model->get_type_name_by_id("student",$row->student_id);?></td>
							    				<td><?=$row->amount;?></td>
							    				<td><?=$row->amount_due;?></td>
							    				<td><?=$row->description;?></td>
							    				<td><?=$row->status;?></td>
							    				<td><?=$row->creation_timestamp;?></td>
							    			</tr>
							    	<?php
							    				$cnt++;
											}
										}
							    	?>
							    	
								</tbody>
							</table>		
							</div>		
						</div>
				</div>
	
				
				<div class="tab-pane" id="cancelled">
					<table class="table table-bordered datatable example">
					    <thead>
					        <tr>
					        	<th><div>#</div></th>
						        <th><div><?php echo get_phrase('student');?></div></th>
	                    		<th><div><?php echo get_phrase('year');?></div></th>
	                    		<th><div><?php echo get_phrase('term');?></div></th>
	                    		<th><div><?php echo get_phrase('class');?></div></th>
	                            <th><div><?php echo get_phrase('fee_structure_total');?></div></th>
	                            <th><div><?php echo get_phrase('payable_amount');?></div></th>
	                            <th><div><?php echo get_phrase('balance');?></div></th>
	                    		<th><div><?php echo get_phrase('date');?></div></th>
	                    		<th><div><?php echo get_phrase('options');?></div></th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php
                    		$count = 1;
                    		
                    		foreach($cancelled_invoices as $row):
                    	?>
                        <tr>
                        	<td><?php echo $count++;?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $row['yr'];?></td>
							<td><?php echo $row['term'];?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
							<td><?php echo $row['amount'];?></td>
                            <td><?php echo $row['amount_due'];?></td>
                            <?php
                            	$bal = $row['amount_due'] - $row['amount_paid']; 
                            ?>
                            <td><?php echo $bal;?></td>
							<td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    
                                    <!-- VIEWING INVOICE LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo get_phrase('view_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- Re-Claim LINK -->
                                    <?php
                                    if($row['carry_forward'] == 0){
                                    ?>
                                    <li class="reclaim_cancelled_invoice">
                                        <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/invoice/reclaim/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-reply"></i>
                                                <?php echo get_phrase('reclaim_invoice');?>
                                            </a>
                                     </li>
                                     <?php
									}
                                    ?>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
					    </tbody>
					  </table>  	
				</div>	
				
			</div>
			
			
	</div>
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/scroll_student_payments/<?=$year + 1;?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		

		// var datatable = $(".example").dataTable({
			// "sPaginationType": "bootstrap",
// 			
		// });
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
		
		   if (location.hash) {
			        $("a[href='" + location.hash + "']").tab("show");
			    }
			    $(document.body).on("click", "a[data-toggle]", function(event) {
			        location.hash = this.getAttribute("href");
			    });
		
			$(window).on("popstate", function() {
			    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
			    $("a[href='" + anchor + "']").tab("show");
		
			});
		
	});
	
$("#prev_year, #next_year").click(function(){

	var url = "<?=base_url();?>index.php?finance/paid_invoice_scroll/<?=strtotime('-1 year');?>";
	if($(this).attr('id')=='next_year'){
		url = "<?=base_url();?>index.php?finance/paid_invoice_scroll/<?=strtotime('+1 year');?>";
	}
	
	$.ajax({
		url:url,
		beforeSend:function(){
			
		},
		success:function(resp){
			$("#paid_invoices_placeholder").html(resp);
		},
		error:function(){
			
		}	
	});
	
});


jQuery(document).ready(function($)
	{


		var datatable = $(".datatable").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [

					{
						"sExtends": "xls",
						"mColumns": [0, 1, 2, 3, 4, 5]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1, 2, 3, 4, 5]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(1, false);
							datatable.fnSetColumnVis(5, false);

							this.fnPrint( true, oConfig );

							window.print();

							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(1, true);
									  datatable.fnSetColumnVis(5, true);
								  }
							});
						},

					},
				]
			},

		});

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>