<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_profile');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?settings/user_profiles/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="" class="control-label col-sm-3"><?=get_phrase("role");?></label>
						<div class="col-sm-6">
							<select class="form-control" name="login_type_id" id="login_type_id">
								<option><?=get_phrase("select");?></option>
								<?php
									$login_type = $this->db->get("login_type")->result_object();
									
									foreach($login_type as $row){
								?>
										<option value="<?=$row->login_type_id;?>"><?=$row->name;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        
						<div class="col-sm-6">
							<textarea  name="description" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
						</div>
					</div>
                    
                    
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_profile');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>