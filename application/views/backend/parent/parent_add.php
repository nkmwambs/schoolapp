<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_parent');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?parents/parent/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email"
                            	value="">
						</div>
					</div>


					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>

						<div class="col-sm-5">
							<input type="number" class="form-control" name="phone" value="" required="required">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('relationship');?></label>

						<div class="col-sm-5">
							<select class="form-control select2" name="relationship" >
								<option><?=get_phrase("select");?></option>
								<?php
									$relationship = $this->db->get('relationship')->result_object();
									foreach($relationship as $row):
								?>
									<option value="<?=$row->relationship_id;?>"><?=$row->name;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('care_type');?></label>

						<div class="col-sm-5">
							<select class="form-control select2" onclick="toggleStudentList(this);" name="care_type" >
								<option><?=get_phrase("select");?></option>
								<option value="primary"><?=get_phrase("primary");?></option>
								<option value="secondary"><?=get_phrase("secondary");?></option>
							</select>
						</div>
					</div>
					
					<div class="form-group hidden" id="link_student_form_group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('link_to_student');?></label>

						<div class="col-sm-5">
							<?php
								$students  = $this->db->get_where('student',array('active'=>1,'parent_id'=>0))->result_object();
							?>
							<select class="form-control select2" name="link_to_student" >
								<option><?=get_phrase("select");?></option>
								<?php
									foreach($students as $student){
								?>
									<option value="<?=$student->student_id;?>"><?=$student->name;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>		
					
					<div class="form-group hidden" id="link_primay_caregiver_form_group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('link_to_primary_caregiver');?></label>

						<div class="col-sm-5">
							<?php
								$primary_caregivers  = $this->db->get_where('parent',array('status' => 1,'care_type' => 'primary'))->result_object();
							?>
							<select class="form-control select2" name="link_to_primary_caregiver" >
								<option><?=get_phrase("select");?></option>
								<?php
									foreach($primary_caregivers as $primary_caregiver){
								?>
									<option value="<?=$primary_caregiver->parent_id;?>"><?=$primary_caregiver->name;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>	

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('profession');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="profession" value="">
						</div>
					</div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default"><?php echo get_phrase('add_parent');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<script>
	function toggleStudentList(elem){
		if($(elem).val() == 'primary'){
			$("#link_student_form_group").removeClass('hidden');
			$('#link_primay_caregiver_form_group').addClass('hidden');
		}else{
			$("#link_student_form_group").addClass('hidden');
			$('#link_primay_caregiver_form_group').removeClass('hidden');
		}
		
	}
</script>