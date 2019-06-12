<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

	$invoice = $this->db->get_where("invoice",array("invoice_id"=>$param2))->row();
	
	$this->db->select(array('fees_structure_details.detail_id','fees_structure_details.name',
    'fees_structure_details.amount','invoice_details_id','invoice_details.amount_due'));
                                	
	$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');									
    $this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
    $details = $this->db->get_where("invoice_details",array('invoice_details.invoice_id'=>$param2))->result_object();
    

	echo form_open(base_url() . 'index.php?finance/invoice/edit_invoice/'.$param2 , array('id'=>'frm_single_invoice_edit','class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));
?>
	<div class="row">
		<div class="col-md-12">
        	<div class="panel panel-default panel-shadow" data-collapsed="0">
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo get_phrase('edit_invoice');?></div>
              	</div>
	            
	            <div class="panel-body">
	            	<div class="btn btn-info" id="add_item"><?=get_phrase('add_item');?></div>
	            	<hr />
	                                
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
                                	
									foreach($details as $detail){

                                ?>
                                	<tr>
                                		<td><input type="checkbox" class="overpay" id="overpay_<?=$detail->detail_id;?>"/></td>
	                               		<td><?=$detail->name;?></td>
                                		<td><?=number_format($detail->amount,2);?></td>
                                		<td><?=number_format($detail->amount_due,2);?></td>
										<td class="paid" id="paid_<?=$detail->detail_id;?>">
											<?=number_format($this->crud_model->fees_paid_by_invoice_detail($detail->invoice_details_id),2);?></td>			
                                		<td>
                                			<input type="text" class="form-control detail_amount_due" value="<?=$detail->amount_due;?>" id="due_<?=$detail->invoice_details_id;?>" name="detail_amount_due[<?=$detail->invoice_details_id;?>]" />
                                		</td>
                                	</tr>	
                                	<?php
                                		
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
                       		
							$sum_paid = $this->crud_model->fees_paid_by_invoice($param2);//array_sum(array_column($details, 'amount_paid'));
							$sum_due = array_sum(array_column($details, 'amount_due'));
							$sum_balance = $sum_due - $sum_paid;
                        ?>
                        	<input type="text" class="form-control" id="amount_paid" name="amount_paid" value="<?=$sum_paid;?>" readonly="readonly"/>
                        </div>
                   	</div>    	                                
	                    		
	                <div class="form-group">
                    	<label class="col-sm-3 control-label"><?php echo get_phrase('balance');?></label>
                        <div class="col-sm-9">
                         	<input type="text" class="form-control" id="balance" name="balance" value="<?=$sum_balance;?>" readonly="readonly"/>
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

	$("#add_item").on('click',function(){
		
		//Remove the button to allow only adding one row
		$(this).remove();
		
		var row = "";
		
		var url = "<?=base_url();?>index.php?finance/add_invoice_item_row/<?=$invoice->term;?>/<?=$invoice->yr;?>/<?=$invoice->class_id;?>";
		
		var used_categories = JSON.parse('<?=json_encode(array_column($details, 'name'));?>');
		//alert(used_categories[0]);
		
		$.ajax({
			url:url,
			success:function(resp){
				
				var obj = JSON.parse(resp);
				
				var select_options = "<option><?=get_phrase('select');?></option>";
				
				$.each(obj,function(i,elem){
					
					if($.inArray(elem.name,used_categories) == -1){
						select_options += "<option value='"+elem.detail_id+"'>"+elem.name+"</option>";
					}
					
					
				});
				
				row = '<tr>'+
					'<td><input type="checkbox" disabled id=""/></td>'+
					'<td><select onchange="get_fees_structure_detail_amount(this)" class="form-control">'+select_options+'</select></td>'+
					'<td id="td_detail_amount"></td>'+
					'<td id="invoice_amount"></td>'+
					'<td id="paid_amount"></td>'+
					'<td id="adjusted_amount"></td>'+
				'</tr>';
				
				$("#fee_items").append(row);
			},
			error:function(){
				alert('Error occurred!');
			}
		});
	});
	
	function get_fees_structure_detail_amount(elem){
		var detail_id = $(elem).val();
		//alert('get_fees_structure_detail_amount');
		$.ajax({
			url:"<?=base_url();?>index.php?finance/get_fees_structure_detail_amount/"+detail_id,
			success:function(resp){
				$('#td_detail_amount').html(resp);
				$("#invoice_amount").html(resp);
				$("#paid_amount").html("0");
				$("#adjusted_amount").html('<input id="due_'+detail_id+'" type="text" onchange="calculate_balance(this);" class="form-control detail_amount_due" name="detail_amount_due['+detail_id+']" value="'+resp+'" />');
				
				$("#balance").val(sum_balance("#due_"+detail_id));
				$("#amount_due").val(sum_amount_due("#due_"+detail_id));
				
			},
			error:function(){
				alert('Error occurred!');
			}
		});
	}
	/**Only used when adding a new item in the invoice**/
	function sum_amount_due(elem){
		var sum  = (parseFloat('<?=$sum_due;?>') + parseFloat($(elem).val()));
		
		return sum;
	}
	
	/**Only used when adding a new item in the invoice**/
	
	function sum_balance(elem){
		var sum  = (parseFloat('<?=$sum_balance;?>') + parseFloat($(elem).val()));
		
		return sum;
	}
	
	// function sum_adjusted_amount(){
		// var sum  = 0;
		// $.each($(".detail_amount_due"),function(i,elem){
			// sum= parseFloat(sum) + parseFloat($(elem).val());
		// });
// 		
		// return sum;
	// }
	
	function calculate_balance(elem){
		$("#balance").val(sum_balance(elem));
		$("#amount_due").val(sum_amount_due(elem));
	}
	
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
		
		var paid  = <?=$sum_paid;?>;
		// $.each($(".paid"),function(i,el){
			// paid += parseInt($(el).html());
		// });
		
		//alert(parseInt(changed_detail_due)-parseInt(detail_paid));
		
		if((parseInt(changed_detail_due)-parseInt(detail_paid)) < 0 && $("#overpay_"+detail_id).is(":checked")==false){
			alert("<?=get_phrase("amount_lesser_than_paid");?>");
			$(this).val(detail_amount_due);
			return false;
		}
		
		var balance = amount_due - parseInt(paid);
		
		$("#amount_due").val(amount_due);
		$("#balance").val(balance);
	});
</script>			