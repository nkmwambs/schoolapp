<?php
	$invoice = $this->db->get_where("invoice",array("invoice_id"=>$param2))->row();
	echo form_open(base_url() . 'index.php?finance/invoice/edit_invoice/'.$param2 , array('id'=>'frm_single_invoice_edit','class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));
?>
	<div class="row">
		<div class="col-md-12">
        	<div class="panel panel-default panel-shadow" data-collapsed="0">
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo get_phrase('edit_invoice');?></div>
              	</div>
	            
	            <div class="panel-body">
	                                
	            	<input type="hidden" name="class_id" id="class_id" value="<?=$invoice->class_id;?>" />

		            <input type="hidden" name="student_id"  id="student_id"  value="<?=$invoice->student_id;?>" />
		                              
					<input type="hidden" name="yr"  id="yr"  value="<?=$invoice->yr;?>" />

	                <input type="hidden" name="term"  id="term"  value="<?=$invoice->term;?>" />
	                               
	                <div class="form-group">
	                	<label class="control-label col-sm-3" ><?=get_phrase("student")?></label>
	                    <div class="col-sm-9">
	                    	<input type="text" readonly="readonly" value="<?=$this->crud_model->get_type_name_by_id("student",$invoice->student_id);?>" class="form-control" />
	                    </div>
	                </div>
	                            	
	                <div class="form-group">
                    	<label class="col-sm-3 control-label"><?php echo get_phrase('total_payable');?></label>
                        <div class="col-sm-9">
                        	<input type="text" value="<?=$invoice->amount_due;?>" class="form-control" name="amount_due" readonly="readonly" id='amount_due'/>
                        </div>
                    </div>
                                
                    <div class="form-group">
                    	<div class="col-sm-12">
                        	<table class="table">
                            	<thead>
                                	<tr>
                                		<th><?=get_phrase('force_overpay');?></th>
                                		<th><?=get_phrase('item');?></th>
                                		<th><?=get_phrase('fee_structure_amount');?></th>
                                		<th><?=get_phrase('invoice_amount')?></th>
										<th><?=get_phrase('paid')?></th>				
                                		<th><?=get_phrase("adjusted_amount");?></th>
                                	</tr>
                                </thead>
                                <tbody id="fee_items">
                                
                                <?php
                                	$this->db->select(array('fees_structure_details.detail_id','fees_structure_details.name',
                                	'fees_structure_details.amount'));
                                	$this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
                                	$details = $this->db->get_where("fees_structure_details",array('yr'=>2018,'class_id'=>1,'term'=>1))->result_object();
                                	//print_r($details);
                                	$balance = 0;	
									$amount_paid = 0;
                                	
									foreach($details as $detail){
                                		//$fees_details = $this->db->get_where("fees_structure_details",array("detail_id"=>$detail->detail_id))->row();
                                ?>
                                	<tr>
                                		<td><input type="checkbox" class="overpay" id="overpay_<?=$detail->detail_id;?>"/></td>
	                               		<td><?=$detail->name;?></td>
                                		<td><?=$detail->amount;?></td>
                                		<?php
                                			$inv = $this->db->get_where("invoice_details",array("invoice_id"=>$param2,"detail_id"=>$detail->detail_id)); 
                                		?>
                                		<td><?=$amount_due = $inv->num_rows() > 0?$inv->row()->amount_due:0;?></td>
                                						
                                		<?php
											$paid = 0;
																					
											if($this->db->get_where('payment',array('invoice_id'=>$param2))->num_rows()>0){
												$payment = $this->db->get_where('payment',array('invoice_id'=>$param2))->row();//,'detail_id'=>$detail->detail_id
												
												if($this->db->get_where('student_payment_details',array('payment_id'=>$payment->payment_id,'detail_id'=>$detail->detail_id))->num_rows() > 0){
													$paid = $this->db->select_sum('amount')->get_where('student_payment_details',array('payment_id'=>$payment->payment_id,'detail_id'=>$detail->detail_id))->row()->amount;	
												}
												
												
											} 
																					
											$detail_bal = $amount_due - $paid;
										?>
										<td class="paid" id="paid_<?=$detail->detail_id;?>"><?=$paid;?></td>
                                						
                                		<td>
                                			<input type="text" class="form-control detail_amount_due" value="<?=$amount_due;?>" id="due_<?=$detail->detail_id;?>" name="detail_amount_due[<?=$detail->detail_id;?>]" />
                                		</td>
                                	</tr>	
                                	<?php
                                		$balance+=$detail_bal; 
										//$amount_paid+=$paid;
										}
                                	?>
                                </tbody>
                      		</table>
                       </div>	
					</div>    
	                            
	                            
	                <div class="form-group">
                    	<label class="col-sm-3 control-label"><?php echo get_phrase('paid');?></label>
                        <div class="col-sm-9">
                        <?php
                       		$tot_paid = 0;
                        	$payment_obj = $this->db->get_where('payment',array('invoice_id'=>$param2));
							if($payment_obj->num_rows()>0){
								$payment_id = $payment_obj->row()->payment_id;
	                        	$invoice_paid_object = $this->db->select_sum('amount')->get_where('student_payment_details',array('payment_id'=>$payment_id));
								
									if($invoice_paid_object->num_rows() > 0){
										$tot_paid = $invoice_paid_object->row()->amount;
									}
							}	
                        ?>
                        	<input type="text" class="form-control" id="amount_paid" name="amount_paid" value="<?=$tot_paid;?>" readonly="readonly" placeholder="<?php echo get_phrase('enter_payable_amount');?>"/>
                        </div>
                   	</div>    	                                
	                    		
	                <div class="form-group">
                    	<label class="col-sm-3 control-label"><?php echo get_phrase('balance');?></label>
                        <div class="col-sm-9">
                         	<input type="text" class="form-control" id="balance" name="balance" value="<?=$balance;?>" readonly="readonly" placeholder="<?php echo get_phrase('enter_payable_amount');?>"/>
                        </div>
                    </div>   
	                    
			        <div class="form-group">
		            	<div class="col-sm-5">
		                <button type="submit" id="btn-single" class="btn btn-info"><?php echo get_phrase('edit_invoice');?></button>
		             </div>
		        </div>                                                      
	                                
	    	</div>
	 	</div>
	</div>

</div>

<?php echo form_close();?> 
				
<script>

	
	$(".detail_amount_due").change(function(){
		var detail_paid = $(this).parent().prev().html();
		var detail_amount_due = $(this).parent().prev().prev().html();
		var changed_detail_due = $(this).val();
		var el_id = $(this).attr("id");
		var detail_id = el_id.split("_")[1];
		//alert(detail_id);
		var amount_due = 0;
		$.each($(".detail_amount_due"),function(i,el){
			amount_due += +parseInt($(el).val());
		});
		
		var paid  = 0;
		$.each($(".paid"),function(i,el){
			paid += parseInt($(el).html());
		});
		
		//alert(parseInt(changed_detail_due)-parseInt(detail_paid));
		
		if((parseInt(changed_detail_due)-parseInt(detail_paid)) < 0 && $("#overpay_"+detail_id).is(":checked")==false){
			alert("<?=get_phrase("amount_lesser_than_paid");?>");
			$(this).val(detail_amount_due);
			return false;
		}
		
		var balance = amount_due - paid;
		
		$("#amount_due").val(amount_due);
		$("#balance").val(balance);
	});
</script>			