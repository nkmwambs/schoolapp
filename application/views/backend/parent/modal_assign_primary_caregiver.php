<?php

$parents = $this->db->get_where("parent",array("status"=>1));

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-link"></i>
					<?php echo get_phrase('assign_primary_caregiver');?>
            	</div>
            </div>
			<div class="panel-body">
					
                <?php
                	if($parents->num_rows() > 0){
                	 echo form_open(base_url() . 'index.php?parents/parent/assign_primary_caregiver/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('primary_caregiver');?></label>

						<div class="col-sm-5">
							<select class="form-control select2" name="primary_caregiver_id" id="primary_caregiver_id">
								<option><?=get_phrase("select");?></option>
								<?php
									foreach($parents->result_object() as $row){	
								?>
									<option value="<?=$row->parent_id;?>"><?=$row->name;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
                         <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('assign_primary_caregiver');?></button>
                          </div>
					</div>
					
				
				<?php echo form_close();
					}else{
				?>
				<div class="well">No active parent not found</div>
				<?php		
					}
				?>
			</div>
		</div>
	</div>
</div>				