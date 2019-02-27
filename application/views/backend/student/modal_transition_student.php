<?php
//echo $param2;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_student');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?student/transition/add/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('transition_type');?></label>
			                    <div class="col-sm-9">
			                        <select name="transition_id" class="form-control" id="transition_id">
			                            <option value=""><?php echo get_phrase('select_transition');?></option>
										<?php
											$transitions = $this->db->get('transition')->result_object();
											
											foreach($transitions as $transition){
										?>
											<option value="<?=$transition->transition_id;?>"><?=ucfirst($transition->name);?></option>
										<?php
											}
										?>
				                    </select>
				                </div>
						</div>


					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('transition_date');?></label>

						<div class="col-sm-9">
							<input type="text" id="transition_date" class="form-control datepicker" readonly="readonly" name="transition_date" data-format='yyyy-mm-dd' data-start-view="1" />
						</div>
					</div>

					

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('reason');?></label>

						<div class="col-sm-9">
							<textarea class="form-control" name="reason" id="reason"></textarea>
						</div>
					</div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('create_a_transition');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>




