<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<style>
	.add_row{
		color:green;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-list"></i>
					<?php echo get_phrase('add_multiple_items');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?finance/fees_structure_details/create_multiple_fields/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

					<div id="field_rows">
						<div class="form-group">
							<label for="" style="text-align: center;" class="control-label col-sm-4"><?=get_phrase('income_category');?></label>
							<label for="" style="text-align: center;"  class="control-label col-sm-4"><?=get_phrase('description');?></label>
							<label for="" style="text-align: center;"  class="control-label col-sm-4"><?=get_phrase('amount');?></label>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<select class="form-control" id="" name="income_category_id[]" >
									<option value=""><?=get_phrase('select_category')?></option>
									<?php
										$income_categories = $this->db->get_where('income_categories',array('default_category'=>0,'status'=>1))->result_object();

										foreach($income_categories as $income_category){
									?>
										<option value="<?=$income_category->income_category_id;?>"><?=$income_category->name;?></option>

									<?php
										}
									?>
								</select>
							</div>
							<div class="col-sm-4"><input type="text" class="form-control" id="" name="name[]" /></div>
							<div class="col-sm-3"><input type="number" class="form-control" id="" name="amount[]" /></div>
							<div class="col-sm-1 add_row" onclick="javascript:add_row_event(this);" style="cursor: pointer;" title="<?=get_phrase('add_row');?>">
								<i class="fa fa-plus-circle"></i>
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-12" style="text-align: center;">
							<button class="btn btn-default"><?=get_phrase('create');?></button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<script>



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
