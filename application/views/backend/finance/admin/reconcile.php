<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$transaction_type = array("1"=>"Student Fees","2"=>"Other Income");
$payment_method = array("1"=>"Cash","2"=>"Bank");

$month_start = date("Y-m-d",$current);
$month_end = date("Y-m-t",$current);

$str = " (( t_date <= '".$month_end."' AND cleared = '0' ) OR
(t_date <= '".$month_end."' AND cleared = 1 AND clearedMonth > '".$month_end."' )) ";


$str_this_month_cleared = " cleared = '1' AND clearedMonth BETWEEN '".$month_start."' AND  '".$month_end."' ";

/**Deposit in Transit Listing **/
$this->db->where($str);
$this->db->where(array("transaction_method_id"=>2,'transaction_type_id'=>1));
$bank_income = $this->db->get("transaction")->result_object();

/**Cleared this month In Transit Listing **/

$this->db->where($str_this_month_cleared);
$this->db->where(array("transaction_method_id"=>2,'transaction_type_id'=>1));
$in_transit_cleared = $this->db->get("transaction")->result_object();


/**Cleared this month In O/C Listing **/

$this->db->where($str_this_month_cleared);
$this->db->where(array("transaction_method_id"=>2,'transaction_type_id'=>2));
$oc_cleared = $this->db->get("transaction")->result_object();

/** Outstanding Cheques Listing **/

//$str = "(cleared = '0' OR ( t_date BETWEEN '".$month_start."' AND  '".$month_end."' ) OR (t_date < '".$month_start."' AND cleared = '1' AND clearedMonth BETWEEN '".$month_start."' AND '".$month_end."' ))";
$this->db->where($str);
$this->db->where(array("transaction_method_id"=>2,'transaction_type_id'=>2));
$bank_expense = $this->db->get("transaction")->result_object();

/** Deposit in Transit in statement**/

$this->db->where($str);
$this->db->where(array("transaction_method_id"=>2,'transaction_type_id'=>1));
$deposit_in_transit = 0;
$deposit_in_transit_obj = $this->db->select("SUM(amount) as amount")->get("transaction");

if($deposit_in_transit_obj->row()->amount !== null) {
	$deposit_in_transit = $deposit_in_transit_obj->row()->amount;
}



/** Outstanding Cheques in statement**/

$this->db->where($str);
$this->db->where(array("transaction_method_id"=>2,'transaction_type_id'=>2));
$outstanding_cheque = 0;
$outstanding_cheque_obj = $this->db->select("SUM(amount) as amount")->get("transaction");
if($outstanding_cheque_obj->row()->amount !== null) $outstanding_cheque = $outstanding_cheque_obj->row()->amount;

/** Cashbook Balance i statement **/

$bank_balance = $this->crud_model->closing_bank_balance(date("Y-m-t",$current));

?>
<div class="row">
	<div class="col-sm-12">
		<a href="<?=base_url();?>index.php?finance/cashbook/scroll/<?=$current;?>" class="btn btn-success btn-icon"><i class="fa fa-angle-left"></i><?=get_phrase("cashbook");?></a>

		<a href="<?=base_url();?>index.php?finance/monthly_reconciliation" class="btn btn-success btn-icon"><i class="fa fa-angle-left"></i><?=get_phrase("reconciliation_reports");?></a>
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
					<a href="#deposit_in_transit_pane" data-toggle="tab">
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

				<li class="">
					<a href="#bank_statement" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('bank_statement');?></span>

					</a>
				</li>

				<li class="">
					<a href="#notes" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('notes');?></span>

					</a>
				</li>

			</ul>
	<?php echo form_open(base_url() . 'index.php?finance/close_month/create/'.$current , array("id"=>"activity_form",'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

		<div class="tab-content">
			<p></p>

			<div class="tab-pane active" id="reconciliation_statement">

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
							<input type="text" id="statement_amount" <?=($mode=='view' || $mode=='approve')?"readonly='readonly'":""?> name="statement_amount" class="form-control" value="<?=$statement_amount;?>" />
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
							<input type="text" id="adjusted_bank_amount" readonly="readonly" name="adjusted_bank_amount" class="form-control" value="0" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3">Suspense Balance</label>
						<div class="col-sm-2">
							<input type="text" id="suspense_balance" readonly="readonly" name="suspense_balance" class="form-control" value="0" />
						</div>

						<label class="control-label col-sm-3">Post Suspense Amount</label>
						<div class="col-sm-1">
							<input <?=($mode=='view' || $mode=='approve')?"disabled='disabled'":""?> type="checkbox" class="" id="allow_suspense_amount" />
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<div id="status_holder" class="label label-danger">Status: <span id="status"></span></div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<?php if($mode=='create'){?>
									<button type="submit" id="submit" class="btn btn-success">Close Financial Month</button>
							<?php }elseif($mode=='edit'){?>
									<button type="submit" id="edit" class="btn btn-success">Edit Financial Report</button>
							<?php }elseif($mode=='approve'){?>
									<button type="submit" id="approve" class="btn btn-success">Approve Financial Report</button>
									<button type="submit" id="decline" class="btn btn-warning">Decline Financial Report</button>
							<?php }?>
						</div>
					</div>



			</div>

			<div class="tab-pane" id="deposit_in_transit_pane">
				<table class="table table-striped" id="deposit_in_transit_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Batch Number</th>
							<th>Payee</th>
							<th>Description</th>
							<th>Payment Type</th>
							<th>Payment Method</th>
							<th>Amount</th>
							<th <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>>Status</th>
							<th>Change Month</th>
						</tr>
					</thead>
					<tbody>
						<?php
							//print_r($bank_income);
							foreach($bank_income as $row){
						?>
							<tr>
								<td><?=$row->t_date;?></td>
								<td><div class="btn btn-success" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_transaction/<?=$row->batch_number?>');"><?=$row->batch_number?></div></td>
								<td><?=$row->payee;?></td>
								<td><?=$row->description;?></td>
								<td><?=$this->db->get_where('transaction_type',
								array('transaction_type_id'=>$row->transaction_type_id))->row()->description;?></td>
								<td><?=$this->db->get_where('transaction_method',
								array('transaction_method_id'=>$row->transaction_method_id))->row()->description;?></td>
								<td><?=$row->amount;?></td>
								<?php
									$btn_label = "Clear";
									if($row->cleared == 1){
										$btn_label = "Unclear";
									}
								?>
								<td <?=$mode=='view'?"style='display:none;'":""?>><button class="btn btn-primary record_clear" id="<?php echo "income_".$row->transaction_id;?>"><?=$btn_label;?></button></td>
								<td><?=$row->clearedMonth;?></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>

			<div class="tab-pane" id="cleared_in_transit">
				<table class="table table-striped" id="cleared_in_transit_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Batch Number</th>
							<th>Payee</th>
							<th>Description</th>
							<th>Payment Type</th>
							<th>Payment Method</th>
							<th>Amount</th>
							<th <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>>Status</th>
							<th>Change Month</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($in_transit_cleared as $row){
						?>
							<tr>
								<td><?=$row->t_date;?></td>
								<td><div class="btn btn-success" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_transaction/<?=$row->batch_number?>');"><?=$row->batch_number?></div></td>
								<td><?=$row->payee;?></td>
								<td><?=$row->description;?></td>
								<td><?=$this->db->get_where('transaction_type',
								array('transaction_type_id'=>$row->transaction_type_id))->row()->description;?></td>
								<td><?=$this->db->get_where('transaction_method',
								array('transaction_method_id'=>$row->transaction_method_id))->row()->description;?></td>
								<td><?=$row->amount;?></td>
								<?php
									$btn_label = "Clear";
									if($row->cleared == 1){
										$btn_label = "Unclear";
									}
								?>
								<td <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>><button class="btn btn-primary record_unclear" id="<?php echo "income_".$row->transaction_id;?>"><?=$btn_label;?></button></td>
								<td><?=$row->clearedMonth;?></td>
							</tr>
						<?php
							}
						?>

					</tbody>
				</table>
			</div>

			<div class="tab-pane" id="outstanding_cheques">

				<table class="table table-striped" id="outstanding_cheques_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Batch Number</th>
							<th>Payee</th>
							<th>Description</th>
							<th>Payment Type</th>
							<th>Payment Method</th>
							<th>Amount</th>
							<th <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>>Status</th>
							<th>Change Month</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($bank_expense as $row){
						?>
							<tr>
								<td><?=$row->t_date;?></td>
								<td><div class="btn btn-success" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_transaction/<?=$row->batch_number?>');"><?=$row->batch_number?></div></td>
								<td><?=$row->payee;?></td>
								<td><?=$row->description;?></td>
								<td><?=$this->db->get_where('transaction_type',
								array('transaction_type_id'=>$row->transaction_type_id))->row()->description;?></td>
								<td><?=$this->db->get_where('transaction_method',
								array('transaction_method_id'=>$row->transaction_method_id))->row()->description;?></td>
								<td><?=$row->amount;?></td>
								<?php
									$btn_label = "Clear";
									if($row->cleared == 1){
										$btn_label = "Unclear";
									}
								?>
								<td <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>><button class="btn btn-primary record_clear" id="expense_<?=$row->transaction_id;?>"><?=$btn_label;?></button></td>
								<td><?=$row->clearedMonth;?></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>

			</div>

			<div class="tab-pane" id="cleared_outstanding">
				<table class="table table-striped" id="cleared_outstanding_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Batch Number</th>
							<th>Payee</th>
							<th>Description</th>
							<th>Payment Type</th>
							<th>Payment Method</th>
							<th>Amount</th>
							<th <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>>Status</th>
							<th>Change Month</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($oc_cleared as $row){
						?>
							<tr>
								<td><?=$row->t_date;?></td>
								<td><div class="btn btn-success" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_transaction/<?=$row->batch_number?>');"><?=$row->batch_number?></div></td>
								<td><?=$row->payee;?></td>
								<td><?=$row->description;?></td>
								<td><?=$this->db->get_where('transaction_type',
								array('transaction_type_id'=>$row->transaction_type_id))->row()->description;?></td>
								<td><?=$this->db->get_where('transaction_method',
								array('transaction_method_id'=>$row->transaction_method_id))->row()->description;?></td>
								<td><?=$row->amount;?></td>
								<?php
									$btn_label = "Clear";
									if($row->cleared == 1){
										$btn_label = "Unclear";
									}
								?>
								<td <?=($mode=='view' || $mode=='approve')?"style='display:none;'":""?>><button class="btn btn-primary record_unclear" id="<?php echo "income_".$row->transaction_id;?>"><?=$btn_label;?></button></td>
								<td><?=$row->clearedMonth;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>

			<div class="tab-pane" id="bank_statement">

				<div class="row">
					<?php if($mode=='create' || $mode=='edit'){?>
					<div class="col-sm-4">

							<div class="panel panel-default" data-collapsed="0">
				        	<div class="panel-heading">
				            	<div class="panel-title" >
				            		<i class="entypo-plus-circled"></i>
									<?php echo get_phrase('upload_bank_statements');?>
				            	</div>
				            </div>
							<div class="panel-body"  style="max-width:50; overflow: auto;">
								<!--<h3>Drop Bank Statements Here</h3>-->
								<form id="myDropZone"  action="<?php echo base_url();?>index.php?finance/bank_statements_upload/<?php echo $current;?>" class="dropzone">
									<div class="dz-message" data-dz-message><span style="font-size: 15pt;font-weight: bold;">Drag and Drop Bank Statements here!</span></div>
								</form>

							</div>
					</div>

					</div>

				<?php }?>

				<?php if($mode=='create' || $mode=='edit'){?>
					<div class="col-sm-8">
				<?php }else{?>
					<div class="col-sm-12">
				<?php }?>

							<div class="panel panel-default" data-collapsed="0">
				        	<div class="panel-heading">
				            	<div class="panel-title" >
				            		<i class="entypo-plus-circled"></i>
									<?php echo get_phrase('view_bank_statements');?>
				            	</div>
				            </div>
							<div class="panel-body"  style="max-width:50; overflow: auto;">
										<?php if($mode!=='view' || $mode!=='approve'){?>
				          		<button onclick="confirm_action('<?php echo base_url();?>index.php?finance/delete_bank_statement/<?=$current;?>');" class="btn btn-icon btn-red" id="deleting"><i class="entypo-cancel-squared"></i><?= get_phrase('delete');?></button>
										<?php }?>
				          	<hr>
				                <?php

				                ?>
				                <table class="table table-hover table-striped">
				                	<thead>
				                		<tr>
				                			<th><?= get_phrase('bank_statement');?></th>
				                			<th><?= get_phrase('upload_date');?></th>
				                			<th><?= get_phrase('file_size');?></th>
				                			<th></th>
				                		</tr>
				                	</thead>
				                	<tbody>
				                		<?php
				                			//echo 'uploads/bank_statements/'.$this->session->center_id.'/'.date('Y-m',$tym);
				                			if(file_exists('uploads/bank_statements/'.date('Y-m',$current).'/')){
				                			$map = directory_map('uploads/bank_statements/'.date('Y-m',$current).'/', FALSE, TRUE);
															//print_r($map);
				                			foreach($map as $row):
																 $prop = (object)get_file_info('uploads/bank_statements/'.date('Y-m',$current).'/'.$row);
				                		?>
					                		<tr>
					                			<td><a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/bank_statement_download/<?= $row;?>/<?=$current;?>');"><?= $row;?></a></td>
					                			<td><?= date('d-m-Y',$prop->date);?></td>
					                			<td><?= number_format(($prop->size/1000000),2).' MB';?></td>
					                		</tr>
				                		<?php
				                			endforeach;
											}
				                		?>
				                	</tbody>
				                </table>

							</div>
					</div>

					</div>
				</div>

			</div>

			<div class="tab-pane" id="notes">
					<div class="row">

							<div class="col-sm-6">
									<label class="col-sm-12 control-label">Creator Notes</label>
									<div class="col-sm-12">
											<textarea <?php if($mode=='approve' || $mode=='view'){echo "readonly='readonly'";}?> name="creator_notes" class="form-control" cols="" rows="">
												<?php echo $report->row()->creator_notes;?>
											</textarea>
									</div>
							</div>

							<div class="col-sm-6">
								<label class="col-sm-12 control-label">Approver Notes</label>
								<div class="col-sm-12">
										<textarea class="form-control" cols="" rows="" name="approver_notes" <?=$mode!=="approve"?"readonly='readonly'":'';?> >
												<?php echo $report->row()->approver_notes;?>
										</textarea>
								</div>
							</div>
					</div>
			</div>

		</div>

	</div>
</form>
</div>

<script>

	$(document).ready(function(){

		/** Remove a row from deposit in transit and outstanding cheques table **/

		$(".record_clear, .record_unclear").click(function(){
			var record_obj = $(this).attr("id").split("_");
			var record_id = record_obj[1];
			var record_type = record_obj[0];
			var closest_tr = $(this).closest("tr");
			var url = '<?=base_url();?>index.php?finance/clear_transactions';
			var data = {"record_type":record_type,"indx":record_id,"month":'<?=date("Y-m-t",$current);?>'};

			if($(this).hasClass("record_clear")){
				if(record_type == 'income'){
					$(this).html("Unclear").toggleClass("record_unclear record_clear");
					closest_tr.clone().appendTo("#cleared_in_transit_table > tbody");
					closest_tr.remove();
				}else if(record_type == 'expense'){
					//alert($(this).attr('id'));
					$(this).html("Unclear").toggleClass("record_unclear record_clear");
					closest_tr.clone().appendTo("#cleared_outstanding_table > tbody");
					closest_tr.remove();
				}
			}else{
				if(record_type == 'income'){
					$(this).html("Clear").toggleClass("record_clear record_unclear");
					closest_tr.clone().appendTo("#deposit_in_transit_table > tbody");
					closest_tr.remove();
				}else if(record_type == 'expense'){
					$(this).html("Unclear").toggleClass("record_clear record_unclear");
					closest_tr.clone().appendTo("#outstanding_cheques_table > tbody");
					closest_tr.remove();
				}
			}

			$.ajax({
				url:url,
				data:data,
				type:"POST",
				success:function(resp){
					//alert(resp);
					location.reload();
				},
				error:function(){
					alert("Error Occurred");
				}
			});
		});


		/** Remove arow from cleared effects to in traist or outstanding table **/

		// $(".record_unclear").click(function(){
//
		// });



		var outstanding = $("#outstanding_cheque").val();
		var in_transit = $("#deposit_in_transit").val();
		var statement = $("#statement_amount").val();
		var adjusted_bank = parseFloat(statement) - parseFloat(outstanding) + parseFloat(in_transit);
		var bank = $("#cashbook_amount").val();
		var status  = parseFloat(adjusted_bank) - parseFloat(bank);

		$("#adjusted_bank_amount").val(adjusted_bank);
		$("#status").html(status);
		$("#suspense_balance").val(status);

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

			$("#suspense_balance").val(status);

			if(status == 0){
				$("#status_holder").attr("class", "label label-success")
			}else{
				$("#status_holder").attr("class", "label label-danger")
			}

		});

		$("#decline,#approve").click(function(ev){
			alert("action under development");
			ev.preventDefault();

		});

		$("#submit,#edit").click(function(ev){

			var outstanding = $("#outstanding_cheque").val();
			var in_transit = $("#deposit_in_transit").val();
			var statement = $("#statement_amount").val();
			var adjusted_bank = parseFloat(statement) - parseFloat(outstanding) + parseFloat(in_transit);
			var bank = $("#cashbook_amount").val();
			var status  = parseFloat(adjusted_bank) - parseFloat(bank);

			//alert($('#allow_suspense_amount').is(':checked'));

			if(parseFloat(status) == 0 || $('#allow_suspense_amount').is(':checked')){
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



	$(function(){
	  Dropzone.options.myDropZone = {
	  	//paramName: "bStatement",
	  	uploadMultiple:true,
	    maxFilesize: 5,
	    maxFiles:5,
	    addRemoveLinks: true,
	    //clickable:false,
	    //dictMaxFilesExceeded:'Upload not more than 5 files',
	    dictInvalidFileType:'Please upload PDF files only',
	    //dictDefaultMessage:'Drag and Drop Bank Statements here',
	    dictResponseError: 'Server not Configured',
	    //dictFileTooBig:'Maximum file size is 5MB',
	    //dictMaxFilesExceeded:'You can only upload one file',
	    //autoProcessQueue:true,
	    //acceptedFiles: ".pdf",

	    init:function(){
	      var self = this;
	      // config
	      self.options.addRemoveLinks = true;
	      self.options.dictRemoveFile = "Delete";
	      //New file added
	      self.on("addedfile", function (file) {
	        console.log('new file added ', file);
	      });


	      //On Server Success
	      self.on("success", function(file, responseText) {
	            //alert(responseText);
	            location.reload();
	        });

	        //Delete


	      // Send file starts
	      self.on("sending", function (file) {
	        console.log('upload started', file);
	        $('.meter').show();
	      });


	      // File upload Progress
	      self.on("totaluploadprogress", function (progress) {
	        console.log("progress ", progress);
	        $('.roller').width(progress + '%');
	      });

	      self.on("queuecomplete", function (progress) {
	        $('.meter').delay(999).slideUp(999);
	      });

	      // On removing file
	      self.on("removedfile", function (file) {
	        //console.log(file);
	        alert('You are deleting '+file.name);

	        $.ajax({
			url: "<?php echo base_url();?>index.php?finance/delete_bank_statement/",
			type: "POST",
			data: { 'name': file.name}
			});

	      });
	    }
	  };
	})

</script>
