<?php

$login_type_id = $this->db->get_where("login_type",array("name"=>$param2))->row()->login_type_id;
//echo $login_type_id;
$profiles = $this->db->get_where("profile",array("login_type_id"=>$login_type_id));

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-link"></i>
					<?php echo get_phrase('assign_profile');?>
            	</div>
            </div>
			<div class="panel-body">
					
                <?php
                	if($profiles->num_rows()>0){
                	 echo form_open(base_url() . 'index.php?account/assign_profile/teacher/'.$param3 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('new_password');?></label>

						<div class="col-sm-5">
							<select class="form-control" name="profile_id" id="profile_id">
								<option><?=get_phrase("select");?></option>
								<?php
									foreach($profiles->result_object() as $row){	
								?>
									<option value="<?=$row->profile_id;?>"><?=$row->name;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
                         <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('assign_profile');?></button>
                          </div>
					</div>
					
				
				<?php echo form_close();
					}else{
				?>
				<div class="well">Profiles not found</div>
				<?php		
					}
				?>
			</div>
		</div>
	</div>
</div>				