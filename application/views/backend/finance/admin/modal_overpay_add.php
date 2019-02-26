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
				
                <?php echo form_open(base_url() . 'index.php?finance/student_payments/create_overpay_note/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
				
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('student');?></label>
                        
						<div class="col-sm-6">
							<select class="form-control select2" required="required" name="student_id" id="student_id">
								<option value=""><?=get_phrase("select")?></option>
								<?php
									$students = $this->db->get("student")->result_object();
									foreach($students as $student){
								?>
									<option value="<?=$student->student_id;?>"><?=$student->name;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
									
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('batch_number');?></label>
                        
						<div class="col-sm-6">
							<input type="text" required="required" class="form-control" id="batch_number" placeholder="<?=get_phrase("batch_number");?>" />
						</div>
						<div class="col-sm-3" id="batch_number_message" style="color: red;"></div>
					</div>
					
					<input type="hidden" name="income_id" required="required" id="income_id" />
											
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" required="required" name="amount" id="amount" placeholder="<?=get_phrase("amount");?>" readonly="readonly" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('details');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" required="required" id="income_description" placeholder="<?=get_phrase("status");?>" readonly="readonly" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        
						<div class="col-sm-6">
							<textarea class="form-control" required="required" name="description" id="description" placeholder="<?=get_phrase("description");?>"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" required="required" name="status" id="status" placeholder="<?=get_phrase("status");?>" readonly="readonly" />
						</div>
					</div>
					
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
		var url = "<?=base_url();?>index.php?finance/check_batch_number/"+batch_number;
		
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