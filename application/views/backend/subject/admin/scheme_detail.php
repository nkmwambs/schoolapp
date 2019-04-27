<?php
//echo $scheme_header_id;
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_schemes_of_work');?>
            	</div>
            </div>
			<div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?subject/scheme_detail/add/'.$scheme_header_id , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('week');?></label>
                    <div class="col-sm-8 controls">
                        <input type="number" name='week'  class="form-control" value="0" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('lesson');?></label>
                    <div class="col-sm-8 controls">
                        <input type="number" name='lesson'  class="form-control" value="0" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('strand');?></label>
                    <div class="col-sm-8 controls">
                        <input type="text" name='strand'  class="form-control" value="" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('sub_strand');?></label>
                    <div class="col-sm-8 controls">
                        <input type="text" name='sub_strand'  class="form-control" value="" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('specific_learning_outcomes');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='learning_outcomes'  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('key_inquiry_question');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='inquiry_question'  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('learning_experiences');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='learning_experiences'  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('learning_resources');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='learning_resources'  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('assessment');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='assessment'  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                
                <div class="form-group">
                	<div class="col-sm-12">
                		<button type="submit" class="btn btn-info"><?=get_phrase('create')?></button>
                	</div>
                </div>
                
				</form>
			</div>
		</div>
	</div>
</div>				