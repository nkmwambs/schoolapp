<?php
	$this->db->where('status' , 'unpaid');
    $this->db->order_by('creation_timestamp' , 'desc');
    $unpaid_invoices = $this->db->get('invoice')->result_array();
	
	
	$this->db->where('status' , 'paid');
    $this->db->order_by('creation_timestamp' , 'desc');
    $paid_invoices = $this->db->get('invoice')->result_array();
	
	$this->db->where('status' , 'excess');
    $this->db->order_by('creation_timestamp' , 'desc');
    $overpaid_invoices = $this->db->get('invoice')->result_array();
	
	$this->db->where('status' , 'cancelled');
    $this->db->order_by('creation_timestamp' , 'desc');
    $cancelled_invoices = $this->db->get('invoice')->result_array();
	
?>
<div class="row">
	<div class="col-md-12">
			
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
				
				<li>
					<a href="#paid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('payment_history');?></span>
					</a>
				</li>
				
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

                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_take_payment/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('take_payment');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
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
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- DELETION LINK -->
                                    <li>
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
                    		foreach($paid_invoices as $row3):
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
				
				<div class="tab-pane" id="paid">
					
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
									                        
									            <!-- View Receipt -->
									            <li>
									               	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_receipt/<?php echo $row['batch_number'];?>');">
									                   	<i class="fa fa-eye-slash"></i>
															<?php echo get_phrase('view_receipt');?>
									               	</a>
									             </li>
									             <li class="divider"></li>
									                        
									             <!--Download Receipt -->
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
						
				</div>
				
				<div class="tab-pane" id="cancelled">
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
                    		
                    		foreach($cancelled_invoices as $row):
                    	?>
                        <tr>
                        	<td><?php echo $count++;?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $row['yr'];?></td>
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
                                    <li>
                                        <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/invoice/reclaim/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-reply"></i>
                                                <?php echo get_phrase('reclaim_invoice');?>
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
				
			</div>
			
			
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		

		var datatable = $(".example").dataTable({
			"sPaginationType": "bootstrap",
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>