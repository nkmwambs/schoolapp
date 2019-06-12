<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<style>
	.add_row{
		color:green;
	}
</style>

<?php
$default_category_obj = $this->db->get_where('income_categories',
							array('default_category'=>1));
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_fees_structure');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?finance/fees_structure/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));
                	if($default_category_obj->num_rows() == 0){
                ?>
                	<div class="well">A default income category is not selected in <a href="<?=base_url();?>index.php?settings/school_settings#v-income">settings</a></div>
                <?php		
                	}else{
                ?>
	
					
					<input type="hidden" readonly class="form-control" id="name" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						
                    
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
						
						<div class="col-sm-6">
							<select name="class_id" id="class_id" class="form-control select2">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$class = $this->db->order_by("name_numeric")->get('class')->result_array();
								foreach($class as $row):
									?>
                            		<option value="<?php echo $row['class_id'];?>">
										<?php echo $row['name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div>
						
					</div>                    
 
                    
					<div class="form-group">
						<label for="field-4" class="col-sm-3 control-label"><?php echo get_phrase('year');?></label>
                        
						<div class="col-sm-6">
							<!--<input type="text" class="form-control" id="yr" name="yr" min="2010" max="2050" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>-->
							<select name="yr" id="yr" class="form-control select2"  required="required">
								<option disabled selected value=""><?=get_phrase('select');?></option>
											<?php 
												$fy = range(date('Y')-3, date('Y')+3);
													
												foreach($fy as $yr):
											?>
												<option value="<?=$yr;?>"><?=$yr;?></option>
											<?php 
												endforeach;
											?>
								</select>
						</div>
					</div>   
					
					
					<div class="form-group">
						<label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('term');?></label>
                        
						<div class="col-sm-6">
							<!--<input type="text" class="form-control" name="term" id="term" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>-->
							<select class="form-control select2" id="term" name="term">
								<option disabled selected value=""><?=get_phrase('select');?></option>
								<?php
									$terms = $this->db->get('terms')->result_object();
									
									foreach($terms as $tm):
								?>
									<option value="<?php echo $tm->term_number;?>"><?php echo $tm->name;?></option>
								<?php
									endforeach;
								?>
							</select>
						</div>
					</div> 
					
					
					
					<div id="field_rows">
						<div class="form-group">
							<label for="" style="text-align: center;" class="control-label col-sm-4"><?=get_phrase('income_category');?></label>
							<label for="" style="text-align: center;"  class="control-label col-sm-4"><?=get_phrase('description');?></label>
							<label for="" style="text-align: center;"  class="control-label col-sm-4"><?=get_phrase('amount');?></label>
						</div>
						
						<?php
							$default_category = $default_category_obj->row();
						?>
						
						<input type="hidden" value="<?=$default_category->income_category_id;?>" name="income_category_id[]" />
						<input type="hidden" class="form-control" id="" name="category_name[]" value="<?=get_phrase('balance_brought_forward');?>" />
						<input type="hidden" class="form-control" id="" name="amount[]" value="0" />
						
						<div class="form-group">
							<div class="col-sm-4">
								<select class="form-control" id="" name="income_category_id[]" >
									<option value=""><?=get_phrase('select_category')?></option>
									<?php
										
										$income_categories = $this->db->get_where('income_categories',array('default_category'=>0))->result_object();
										
										foreach($income_categories as $income_category){									
									?>
										<option value="<?=$income_category->income_category_id;?>"><?=$income_category->name;?></option>
									
									<?php
										} 
									?>
								</select>
							</div>
							<div class="col-sm-4"><input type="text" class="form-control" id="" name="category_name[]" /></div>
							<div class="col-sm-3"><input type="number" class="form-control" id="" name="amount[]" /></div>
							<div class="col-sm-1 add_row" onclick="javascript:add_row_event(this);" style="cursor: pointer;" title="<?=get_phrase('add_row');?>">
								<i class="fa fa-plus-circle"></i>
							</div>
						</div>	
					</div>
					
					                

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_fees_structure');?></button>
						</div>
					</div>
                <?php 
                }	
                	echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>

<script>
	$('#term').change(function(){
		var class_name = $.trim($('#class_id option:selected').text()).replace(' ','_');
		var yr = $('#yr').val();
		var term = $('#term option:selected').text();
		
		$('#name').val('class_'+class_name+'_term_'+term+'_year_'+yr);
	});
	
	function add_row_event(el){
		
		if($(el).hasClass('add_row')){
			//Clone form_group
			var form_field = $(el).parent().clone();
			form_field.find('input,select').val('');
			//Append to the field_rows div
			form_field.appendTo('#field_rows');
			
			//Remove fa fa-plus-circle from prvious row
			$(el).toggleClass('add_row remove_row');
			$(el).css('color','red');
			$(el).prop('title','<?=get_phrase('Remove Row');?>');
			$(el).html('<i class="fa fa-minus-circle"></i>');
		}else{
			$(el).parent().remove();
		}
		
		
		
	}
</script>