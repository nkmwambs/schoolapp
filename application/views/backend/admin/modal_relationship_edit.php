<?php
$relationship = $this->db->get_where('relationship',array('relationship_id'=>$param2))->row();
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_relationship');?>
            	</div>
            </div>
			<div class="panel-body">
				<?php echo form_open(base_url() . 'index.php?admin/school_settings/edit_relationship/'.$param2, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" value="<?= $relationship->name;?>" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" />
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default"><?php echo get_phrase('edit_relationship');?></button>
						</div>
					</div>
					
				</form>	
			</div>
		</div>
	</div>
</div>				