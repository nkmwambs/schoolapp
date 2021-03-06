<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$this->db->select(array('student.name as student','invoice.student_id as student_id','invoice_id',
'invoice.class_id as class_id','yr','term','amount','amount_due','creation_timestamp','status',
'carry_forward','transitioned','last_approval_request_id'));
$this->db->join('student','student.student_id=invoice.student_id');
$edit_data	=	$this->db->get_where('invoice' , array('invoice_id' => $param2) )->result_array();


//Spreading mode
$spreading_mode = $this->db->get_where('settings',
array('type'=>'student_payment_spread_mode'))->row()->description;

$row = $edit_data[0];

$this->db->select(array('pay_order','fees_structure_details.detail_id','fees_structure_details.name',
'fees_structure_details.amount','invoice_details.invoice_details_id','invoice_details.amount_due'));

$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');
$this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
$this->db->order_by('pay_order');
$invoice_details = $this->db->get_where("invoice_details",array('invoice_details.invoice_id'=>$row['invoice_id']))->result_object();

//foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default panel-shadow" data-collapsed="0">
			<div class="panel-heading">
                <div class="panel-title"><?php echo get_phrase('take_payment');?></div>
            </div>
            <div class="panel-body">
				<?php echo form_open(base_url() . 'index.php?finance/record_fees_income/take_payment/'.$row['invoice_id'], array(
					'class' => 'form-horizontal form-groups-bordered validate','target'=>'_top','id'=>'frm_payment'));?>


		           <input type="hidden" class="form-control" value="<?php echo $row['amount_due'];?>" readonly/>
		           <input type="hidden" class="form-control" name="amount_paid" value="<?php echo $this->crud_model->fees_paid_by_invoice($param2);?>" readonly/>
					<?php $bal = $this->crud_model->fees_balance_by_invoice($param2);?>
		           <input type="hidden" id="get_bal" class="form-control" value="<?php echo $bal;?>" readonly/>

							 <div class="form-group">
									 <label class="col-sm-offset-4 control-label"><?=get_phrase('student_name');?> : <?php echo $row["student"];?></label>
							 </div>

								<div class="form-group">
										<label class="control-label col-xs-3"><?=get_phrase('enter_cash_received');?></label>
										<div class="col-xs-6">
											<input type="number"  id="cash_received" class="form-control" />
										</div>
								</div>

								<div class="form-group">
 									 <label class="col-sm-offset-3 control-label"><?=get_phrase('automatic_details_spreading_mode');?> : <?php echo ucfirst($spreading_mode);?></label>
 							 </div>

							 <?php
								 if($invoice_details[0]->pay_order == 0 && $spreading_mode == 'order'){
							 ?>
								 <div class="form-group">
									 <div class="col-xs-12 text-center">
												 <span class="label label-danger">Fees structure items order not set</span>
									 </div>
								 </div>
							 <?php
									}
								?>

							  <div class="form-group">
		                <label class="col-sm-offset-6 control-label"><?php echo get_phrase('payment');?></label>
		            </div>

		            <div class="form-group">
		                <div class="col-sm-12">
							<table class="table">
								<thead>
									<tr>
										<th><?php echo get_phrase('item');?></th>
										<th><?php echo get_phrase('amount_payable');?></th>
										<th><?php echo get_phrase('paid');?></th>
										<th><?php echo get_phrase('balance');?></th>
										<th><?php echo get_phrase('payment');?></th>
									</tr>
								</thead>
								<tbody>
									<?php

										foreach($invoice_details as $inv):
									?>
										<tr>
											<td title="Item Order: <?=$inv->pay_order;?>"><?php echo $inv->name;?></td>
											<td class="amount_due_cell"><?php echo number_format($inv->amount_due,2);?></td>
											<td><?php echo number_format($this->crud_model->fees_paid_by_invoice_detail($inv->invoice_details_id),2);?></td>
											<td><?php echo number_format($this->crud_model->fees_balance_by_invoice_detail($inv->invoice_details_id),2);?></td>
											<td><input data-order="<?=$inv->pay_order;?>" required="required" type="text" onkeyup="return get_total_payment();" class="form-control paying" name="take_payment[<?php echo $inv->invoice_details_id;?>]" id="" value="0"/></td>
										</tr>

									<?php

										endforeach;
										$tot_due = array_sum(array_column($invoice_details, 'amount_due'));
										$tot_paid = $this->crud_model->fees_paid_by_invoice($param2);//array_sum(array_column($invoice_details, 'amount_paid'));
										$tot_bal  = $this->crud_model->fees_balance_by_invoice($param2);//array_sum(array_column($invoice_details, 'balance'));
									?>
									<tr><td><?=get_phrase('overpayment');?></td><td colspan="3"><input type="text" class="form-control overpay" name="overpayment_description" id="overpayment_description" readonly="readonly" /></td><td><input type="text" onkeyup="return get_total_payment();" id="overpayment" name="overpayment" class="form-control paying overpay" value="0" readonly="readonly"/></td></tr>
									<tr>
										<td>Totals</td><td id="total_amount_due_cell"><?php echo number_format($tot_due,2);?></td>
										<td><?php echo number_format($this->crud_model->fees_paid_by_invoice($param2),2);?></td>
										<td id="total_balance"><?php echo number_format($this->crud_model->fees_balance_by_invoice($param2),2);?></td>
										<td><input type="text" class="form-control" name="total_payment" id="total_payment" value="0" readonly="readonly"/></td>
									</tr>
								</tbody>
							</table>
		                </div>
		            </div>

								<div class="form-group">
		                <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
		                <div class="col-sm-6">
		                    <input value="Being amount recieved for school fees" type="text" required="required" class="form-control" name="description" id="description" placeholder="<?php echo get_phrase('description');?>"/>
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-sm-3 control-label"><?php echo get_phrase('payee');?></label>
		                <div class="col-sm-6">
		                    <input type="text" value="<?=$row['student']?>" required="required" class="form-control" name="payee" id="payee" placeholder="<?php echo get_phrase('payee');?>"/>
		                </div>
		            </div>

		            <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-6">
                            <select name="method" id="method" class="form-control" required="required">
                                <option value="1"><?php echo get_phrase('cash');?></option>
                                <option value="2"><?php echo get_phrase('banked');?></option>
								<option value="2"><?php echo get_phrase('lipa_karo_mpesa');?></option>
								<!-- <option value="2"><?php echo get_phrase('mpesa_paybill');?></option> -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="display: none;">
		                <label class="col-sm-3 control-label"><?php echo get_phrase('reference_number');?></label>
		                <div class="col-sm-6">
		                    <input type="text" required="required" class="form-control" name="ref" id="ref" placeholder="<?php echo get_phrase('payee');?>"/>
		                </div>
		            </div>

                    <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
	                    <div class="col-sm-6">
	                        <input type="text" class="datepicker form-control" readonly="readonly"
	                        	data-start-date="<?php echo $this->crud_model->next_transaction_date()->start_date;?>"
	                        	data-end-date="<?php echo $this->crud_model->next_transaction_date()->end_date;?>"
	                        	data-format="yyyy-mm-dd" name="timestamp"
	                            value="<?php echo $this->crud_model->next_transaction_date()->start_date;?>" required="required"/>
	                    </div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('serial_number');?></label>

						<div class="col-sm-6">
							<input type="text" class="form-control" readonly="readonly" value="<?=$this->crud_model->next_batch_number();?>" required="required">
						</div>
				</div>

                    <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id'];?>">

		            <div class="form-group">
		                <div class="col-sm-12">
		                    <input name="cashbook" type="submit" class="btn btn-info pull-left" value="<?php echo get_phrase('save_and_go_to_cashbook');?>" />
												<input name="invoices" type="submit" class="btn btn-info pull-right" value="<?php echo get_phrase('save_and_go_to_invoices');?>" />
										</div>
		            </div>

				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>


<?php //endforeach;?>


<script>

	$("#cash_received").keyup(function(){

		var mode = "<?=$spreading_mode;?>";

		if(mode == 'ratio'){
			payment_spread_by_ratio($(this));
		}else{
			payment_spread_by_order($(this));
		}

	});

	function payment_spread_by_order(elem){
		var cash_received = elem.val();
		var detail_balance = 0;
		var paid = 0;
		var running_balance = cash_received;
		var detail_balance = 0;
		var topay = 0;

		$('.paying').each(function(i,el){

				detail_balance = accounting.unformat($(this).parent().prev().html().trim());

				if(parseFloat(detail_balance) <= parseFloat(running_balance)){
					topay = detail_balance;
				}else if(parseFloat(running_balance) > 0){
					topay = running_balance;
				}else{
					topay = 0;
				}

				$(el).val(topay);
				get_total_payment();
				paid = parseFloat(paid) + parseFloat($(el).val());
				running_balance  = parseFloat(cash_received) - parseFloat(paid);

				var overpayment = parseFloat(cash_received) - parseFloat(sum_total_payment());

				if(overpayment > 0){
					$('#overpayment').val(overpayment);
					$("#overpayment_description").val('Overpayment');
					get_total_payment();
				}


		});

	}

	function sum_total_payment(){
		    var sum = 0;
		    $('.paying').each(function() {
		        sum += Number($(this).val());
		    });

				return sum;
	}

	function payment_spread_by_ratio(elem){
		var count_of_paying_cell = $(".paying").length;
		var cash_received = elem.val();
		var amount_due = 0;
		var detail_balance = 0;
		var total_balance = accounting.unformat($("#total_balance").html().trim());
		var paying_ratio = 0;
		var pay_amount = 0;
		var overpay_amount = 0;

		$('.paying').each(function(i,el){
			if($(el).attr('id')!=='overpayment'){
			 var detail_balance = accounting.unformat($(this).parent().prev().html().trim());
			 paying_ratio = parseFloat(detail_balance)/parseFloat(total_balance);
			 pay_amount = parseFloat(paying_ratio) * parseFloat(cash_received);

			 var rounded_pay_amount = accounting.unformat(accounting.format(pay_amount));

			 if(rounded_pay_amount > detail_balance){
					rounded_pay_amount = detail_balance;
			 }

			 $(this).val(rounded_pay_amount);

			 get_total_payment();
		 }
		});

		if(parseFloat(cash_received) > parseFloat(total_balance)){
			overpay_amount = parseFloat(cash_received) - parseFloat(total_balance);
			$("#overpayment").val(overpay_amount);
			$("#overpayment_description").val('Overpayment');
			get_total_payment();
		}

	}

	$("#method").on('change',function(){
		if($(this).val() == 2){
			$("#ref").closest("div.form-group").css('display','block');
		}else{
			$("#ref").closest("div.form-group").css('display','none');
		}
	});

	function get_total_payment(){
		var tot = 0;
		$('.paying').each(function(){

			var amt = 0;

			if(!isNaN(parseInt($(this).val()))/2){
				amt = $(this).val();
			}

			tot = parseInt(tot)+parseInt(amt);
		});

		//alert(tot);

		$("#total_payment").val(tot);

		if(parseInt(tot) == parseInt(<?=$this->crud_model->fees_balance_by_invoice($param2);?>)){
			$(".overpay").removeAttr('readonly');
		}else if(parseInt(tot) < parseInt(<?=$this->crud_model->fees_balance_by_invoice($param2);?>)){
			$(".overpay").val(0);
			$(".overpay").prop("readonly","readonly");
		}
	}


	$(".paying").change(function(){
		var detail_balance = $(this).parent().prev().html();
		var detail_paying = $(this).val();

		if((parseInt(detail_paying) - parseInt($("#overpayment").val())) > parseInt(accounting.unformat(detail_balance))){
			alert("<?=get_phrase("paying_more_than_balance");?>");
			$(this).val("0");
			get_total_payment();
			return false;
		}

	});


</script>
