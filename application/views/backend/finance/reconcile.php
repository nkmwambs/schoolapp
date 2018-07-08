<?php
$transaction_type = array("1"=>"Student Fees","2"=>"Other Income");
$payment_method = array("1"=>"Cash","2"=>"Bank");

$month_start = date("Y-m-d",$current);
$month_end = date("Y-m-t",$current);

$str = "(cleared = '0' OR ( t_date BETWEEN '".$month_start."' AND  '".$month_end."' ) OR (t_date < '".$month_start."' AND cleared = '1' AND clearedMonth BETWEEN '".$month_start."' AND '".$month_end."' ))";

/**Deposit in Transit **/			
$this->db->where($str);
$this->db->where(array("method"=>"2"));
$bank_income = $this->db->get("payment")->result_object();

/** Outstanding Cheques **/	

//$str = "(cleared = '0' OR ( t_date BETWEEN '".$month_start."' AND  '".$month_end."' ) OR (t_date < '".$month_start."' AND cleared = '1' AND clearedMonth BETWEEN '".$month_start."' AND '".$month_end."' ))";
$this->db->where($str);
$this->db->where(array("method"=>"2"));
$bank_expense = $this->db->get("expense")->result_object();

/** Deposit in Transit**/

$this->db->where($str);
$this->db->where(array("method"=>"2"));
$deposit_in_transit = $this->db->select("SUM(amount) as amount")->get("payment")->row()->amount;


/** Outstanding Cheques **/

$this->db->where($str);
$this->db->where(array("method"=>"2"));
$outstanding_cheque = $this->db->select("SUM(amount) as amount")->get("expense")->row()->amount;

/** Cashbook Balance **/

$bank_balance = $this->crud_model->closing_bank_balance(date("Y-m-t",$current));
			
?>
<div class="row">
	<div class="col-sm-12">
		<a href="<?=base_url();?>index.php?finance/scroll_cashbook/<?=$current;?>" class="btn btn-success btn-icon"><i class="fa fa-angle-left"></i><?=get_phrase("back");?></a>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-sm-12">
		
		<ul class="nav nav-tabs bordered">
				
				<li class="active">
					<a href="#reconciliation_statement" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('reconciliation_statement');?></span>
						<!-- <span class="badge badge-default"><?php echo count($overpay_notes);?></span> -->
					</a>
				</li>
				
				<li class="">
					<a href="#deposit_in_transit" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('deposit_in_transit');?></span> 
						<!-- <span class="badge badge-danger"><?php echo count($unpaid_invoices);?></span> -->
					</a>
				</li>
				
				<li class="">
					<a href="#cleared_in_transit" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cleared_in_transit');?></span>
						<!-- <span class="badge badge-success"><?php echo count($paid_invoices);?></span> -->
					</a>
				</li>
				
				<li class="">
					<a href="#outstanding_cheques" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('outstanding_cheques');?></span>
						<!-- <span class="badge badge-default"><?php echo count($overpaid_invoices);?></span> -->
					</a>
				</li>
				
				<li class="">
					<a href="#cleared_outstanding" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cleared_outstanding');?></span>
						<!-- <span class="badge badge-default"><?php echo count($overpay_notes);?></span> -->
					</a>
				</li>
								
				
			</ul>
		
		<div class="tab-content">
			
			<div class="tab-pane active" id="reconciliation_statement">
				<?php echo form_open(base_url() . 'index.php?finance/close_month/create/'.$current , array("id"=>"activity_form",'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
				
					<div class="form-group">
						<label class="control-label col-sm-3">Bank Statement Date</label>
						<div class="col-sm-6">
							<input type="text" id="statement_date" value="<?=date("Y-m-t",$current);?>" readonly="readonly" name="statement_date" class="form-control datepicker" data-format="yyyy-mm-dd" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3">Bank Statement Amount</label>
						<div class="col-sm-6">
							<?php
								$statement_amount = 0;
								
								$report = $this->db->get_where("reconcile",array("month"=>date("Y-m-t",$current)));
								
								if($report->num_rows() > 0){
									$statement_amount = $report->row()->statement_amount	;
								}
							?>
							<input type="text" id="statement_amount" name="statement_amount" class="form-control" value="<?=$statement_amount;?>" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3">Cashbook Balance</label>
						<div class="col-sm-6">
							<input type="text" id="cashbook_amount" name="cashbook_amount" class="form-control" readonly="readonly" value="<?=$bank_balance;?>" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3">Outstanding Cheques</label>
						<div class="col-sm-6">
							<input type="text" id="outstanding_cheque" name="outstanding_cheque" value="<?=$outstanding_cheque;?>" readonly="readonly" class="form-control" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3">Deposit In Transit</label>
						<div class="col-sm-6">
							<input type="text" id="deposit_in_transit" name="deposit_in_transit" class="form-control" readonly="readonly" value="<?=$deposit_in_transit;?>" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3">Adjusted Balance</label>
						<div class="col-sm-6">
							<input type="text" id="adjusted_bank_amount" readonly="readonly" name="adjusted_bank_amount" class="form-control" value="" />
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<div id="status_holder" class="label label-danger">Status: <span id="status"></span></div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<button type="submit" id="submit" class="btn btn-success">Close Financial Month</button>
						</div>
					</div>
				
				</form>				
			</div>
			
			<div class="tab-pane" id="deposit_in_transit">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Batch Number</th>
							<th>Payee</th>
							<th>Description</th>
							<th>Payment Type</th>
							<th>Payment Method</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Change Month</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($bank_income as $row){
						?>
							<tr>
								<td><?=$row->t_date;?></td>
								<td><?=$row->batch_number;?></td>
								<td><?=$row->payee;?></td>
								<td><?=$row->description;?></td>
								<td><?=$transaction_type[$row->payment_type];?></td>
								<td><?=$payment_method[$row->method];?></td>
								<td><?=$row->amount;?></td>
								<?php
									$btn_label = "Clear";
									if($row->cleared == 1){
										$btn_label = "Unclear";
									}
								?>
								<td><button class="btn btn-primary"><?=$btn_label;?></button></td>
								<td><?=$row->clearedMonth;?></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
			
			<div class="tab-pane" id="cleared_in_transit"></div>
			
			<div class="tab-pane" id="outstanding_cheques">
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Batch Number</th>
							<th>Payee</th>
							<th>Description</th>
							<!-- <th>Payment Type</th> -->
							<th>Payment Method</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Change Month</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($bank_expense as $row){
						?>
							<tr>
								<td><?=$row->t_date;?></td>
								<td><?=$row->batch_number;?></td>
								<td><?=$row->payee;?></td>
								<td><?=$row->description;?></td>
								<!-- <td><?=$transaction_type[$row->payment_type];?></td> -->
								<td><?=$payment_method[$row->method];?></td>
								<td><?=$row->amount;?></td>
								<?php
									$btn_label = "Clear";
									if($row->cleared == 1){
										$btn_label = "Unclear";
									}
								?>
								<td><button class="btn btn-primary"><?=$btn_label;?></button></td>
								<td><?=$row->clearedMonth;?></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
				
			</div>
			
			<div class="tab-pane" id="cleared_outstanding"></div>
			

		</div>	
		
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var outstanding = $("#outstanding_cheque").val();
		var in_transit = $("#deposit_in_transit").val();
		var statement = $("#statement_amount").val();
		var adjusted_bank = parseFloat(statement) - parseFloat(outstanding) + parseFloat(in_transit);	
		var bank = $("#cashbook_amount").val();
		var status  = parseFloat(adjusted_bank) - parseFloat(bank);
		
		$("#adjusted_bank_amount").val(adjusted_bank);
		$("#status").html(status);
		
		if(status == 0){
			$("#status_holder").attr("class","label label-success")
		}else{
			$("#status_holder").attr("class","label label-danger")
		}
		
		
		$("#statement_amount").keyup(function(){
			var outstanding = $("#outstanding_cheque").val();
			var in_transit = $("#deposit_in_transit").val();
			var statement = $(this).val();
			var adjusted_bank = parseFloat(statement) - parseFloat(outstanding) + parseFloat(in_transit);		
			var bank = $("#cashbook_amount").val();
			var status  = parseFloat(adjusted_bank) - parseFloat(bank);
			
			$("#adjusted_bank_amount").val(adjusted_bank);
			$("#status").html(status);
			
			if(status == 0){
				$("#status_holder").attr("class", "label label-success")
			}else{
				$("#status_holder").attr("class", "label label-danger")
			}
		
		});
		
		
		$("#submit").click(function(ev){
			
			var outstanding = $("#outstanding_cheque").val();
			var in_transit = $("#deposit_in_transit").val();
			var statement = $("#statement_amount").val();
			var adjusted_bank = parseFloat(statement) - parseFloat(outstanding) + parseFloat(in_transit);		
			var bank = $("#cashbook_amount").val();
			var status  = parseFloat(adjusted_bank) - parseFloat(bank);
		
			//alert(status);
			
			if(parseFloat(status) == 0){
				var cfrm = confirm("Are you sure you want to submit report?");
				
				if(!cfrm){
					alert("Process Aborted!");
					ev.preventDefault();
				}
				
			}else{	
				alert("Reconciliation Incorrect");
				ev.preventDefault();
			}
			
		});
		
	});
	
	
</script>