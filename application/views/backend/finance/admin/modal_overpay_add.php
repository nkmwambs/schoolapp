<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_note');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?finance/create_overpay_note' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label for="invoice_id" class="col-sm-3 control-label"><?php echo get_phrase('student');?></label>

						<div class="col-sm-6">
							<select class="form-control select2" required="required" name="invoice_id" id="invoice_id">
								<option value=""><?=get_phrase("select")?></option>
								<?php
									$this->db->where(array('invoice.term'=>$this->crud_model->get_current_term(),'yr'=>date('Y')));
									$this->db->where(array('invoice.status'=>'paid'));
									$this->db->or_where(array('invoice.status'=>'excess'));
									$this->db->join('invoice','invoice.student_id=student.student_id');
									$students = $this->db->get("student")->result_object();
									foreach($students as $student){
								?>
									<option value="<?=$student->invoice_id;?>"><?=$student->name;?> (Invoice ID: <?=$student->invoice_id;?>)</option>
								<?php
									}
								?>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label for="batch_number" class="col-sm-3 control-label"><?php echo get_phrase('batch_number');?></label>

						<div class="col-sm-6">
							<input type="text" required="required" class="form-control" readonly="readonly" value="<?=$this->crud_model->next_batch_number();?>" id="batch_number" placeholder="<?=get_phrase("batch_number");?>" />
						</div>
						<div class="col-sm-3" id="batch_number_message" style="color: red;"></div>
					</div>

					<div class="form-group">
						<label for = 'note_date' class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
						<div class="col-sm-6">
								<input type="text" class="datepicker form-control" readonly="readonly" id = 'note_date'
									data-start-date="<?php echo $this->crud_model->next_transaction_date()->start_date;?>"
									data-end-date="<?php echo $this->crud_model->next_transaction_date()->end_date;?>"
									data-format="yyyy-mm-dd" name="timestamp"
										value="" required="required"/>
						</div>
					</div>

					<div class="form-group">
						<label for="amount" class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>

						<div class="col-sm-6">
							<input type="text" class="form-control" required="required" name="amount" id="amount" placeholder="<?=get_phrase("amount");?>" />
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('details');?></label>

						<div class="col-sm-6">
							<input type="text" class="form-control" required="required" id="income_description" placeholder="<?=get_phrase("status");?>" readonly="readonly" />
						</div>
					</div> -->

					<div class="form-group">
									<label for = 'method' class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
									<div class="col-sm-6">
											<select name="method" id="method" class="form-control" required="required">
													<option value="1"><?php echo get_phrase('cash');?></option>
													<option value="2"><?php echo get_phrase('banked');?></option>
					<option value="2"><?php echo get_phrase('lipa_karo_mpesa');?></option>
					<!-- <option value="2"><?php echo get_phrase('mpesa_paybill');?></option> -->
											</select>
									</div>
							</div>


					<div class="form-group">
						<label for="description" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>

						<div class="col-sm-6">
							<textarea class="form-control" required="required" name="description" id="description" placeholder="<?=get_phrase("description");?>"></textarea>
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>

						<div class="col-sm-6">
							<input type="text" class="form-control" required="required" name="status" id="status" placeholder="<?=get_phrase("status");?>" readonly="readonly" />
						</div>
					</div> -->

					 <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" id="submit" class="btn btn-info"><?php echo get_phrase('add_note');?></button>
						</div>
					</div>

				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

<script>

	$("#batch_number").change(function(){
		var batch_number = $(this).val();
		var url = "<?=base_url();?>index.php?finance/check_batch_number/"+batch_number+"/payment";

		$.ajax({
			url:url,
			beforeSend:function(){
				$("#batch_number_message").html("<?=get_phrase('checking...');?>");
			},
			success:function(response){

				if(response==""){
					$("#batch_number_message").html("<?=get_phrase('batch_number_not_existing');?>");
				}else{
					var obj = JSON.parse(response);

					$("#batch_number_message").html("");
					$("#income_id").val(obj[0].income_id);
					$("#amount").val(obj[0].amount);
					$("#income_description").val(obj[0].description);
					$("#status").val('active');
				}

			},
			error:function(){
				$("#batch_number_message").html("<?=get_phrase('error_occurred');?>");
			}
		});

	});
</script>
