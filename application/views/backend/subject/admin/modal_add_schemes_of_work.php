<?php
$class = $this->db->get_where('class',array('class_id'=>$param2))->row()->name; 
$subject = $this->db->get_where('subject',array('class_id'=>$param3))->row()->name;
$terms  = $this->db->get('terms')->result_object();
$years = range(date('Y') - 5,date('Y') + 5);

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
                <?php echo form_open(base_url() . 'index.php?subject/schemes_of_work/add/'.$param2.'/'.$param3 , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                    <div class="col-sm-5 controls">
                        <input type="text" readonly="readonly" class="form-control" value="<?=$class;?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
                    <div class="col-sm-5 controls">
                        <input type="text" readonly="readonly" class="form-control" value="<?=$subject;?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('term');?></label>
                    <div class="col-sm-5 controls">
                        <select class="form-control" name="term_id" 
                        	data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                        	<option value=""><?=get_phrase('select');?></option>
                        	<?php
                        		foreach($terms as $row){
                        	?>
                        		<option value="<?=$row->terms_id;?>"><?=$row->name;?></option>
                        	<?php
								}
                        	?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('year');?></label>
                    <div class="col-sm-5 controls">
                        <select class="form-control" name="year" 
                        	data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                        	<option value=""><?=get_phrase('select');?></option>
                        	<?php
                        		foreach($years as $row){
                        	?>
                        		<option value="<?=$row;?>"><?=$row;?></option>
                        	<?php
								}
                        	?>
                        </select>
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
	