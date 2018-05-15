<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-link"></i>
					<?php echo get_phrase('assign_beneficiaries');?>
            	</div>
            </div>
			<div class="panel-body">
				
				<?php echo form_open(base_url() . 'index.php?admin/parent/add_caregivers/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
				
					<div class="form-group">
						<label class="control-label col-sm-3"><?=get_phrase("beneficiaries");?></label>
						<div class="col-sm-9">
							<select class="form-control select2" name="student_id[]" id="secondary_care" multiple="multiple">
								<?php 
									$students = $this->db->get_where('student')->result_array();
									foreach($students as $row):
								?>
                            		<option value="<?php echo $row['student_id'];?>" <?php if($this->db->get_where('caregiver',array('parent_id'=>$param2,'student_id'=>$row['student_id']))->num_rows() > 0 ) echo "selected";?>>
										<?php echo $row['name'];?>
                                    </option>
                                <?php
									endforeach;
							  	?>
							</select>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default"><?php echo get_phrase('update');?></button>
						</div>
					</div>
					
					
				</form>
						
			</div>
		</div>
	</div>
</div>			