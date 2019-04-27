<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('lesson_plan');?>
            	</div>
            </div>
			<div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?subject/lesson_plan/'.$scheme_id.'/add' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('planned_date');?></label>
                    <div class="col-sm-8 controls">
                        <input type="text" name='planned_date' readonly="readonly"  class="form-control datepicker" data-format = "yyyy-mm-dd" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('strand');?></label>
                    <div class="col-sm-8 controls">
                        <input type="text" name="strand"  class="form-control" value="<?=$scheme_detail->strand;?>" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('sub_strand');?></label>
                    <div class="col-sm-8 controls">
                        <input type="text" name="sub_strand"  class="form-control" value="<?=$scheme_detail->sub_strand;?>" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('specific_learning_outcomes');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name="learning_outcomes"  class="form-control" rows="10"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"><?=$scheme_detail->learning_outcomes;?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('key_inquiry_question');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name="inquiry_question"  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"><?=$scheme_detail->inquiry_question;?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('class_roll');?></label>
                    <div class="col-sm-8 controls">
                        <input type="number" name='roll'  class="form-control" value="" 
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('core_competencies,values,PCIs');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='core_competencies'  class="form-control"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                                 
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('learning_resources');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='learning_resources'  class="form-control" rows="10"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"><?=$scheme_detail->learning_resources;?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('introduction');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='introduction'  class="form-control" rows="10"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('lesson_development');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='lesson_development'  class="form-control" rows="20"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('conclusion');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='conclusion'  class="form-control" rows="5"
                        data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('summary');?></label>
                    <div class="col-sm-8 controls">
                        <textarea name='summary'  class="form-control" rows="5"
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