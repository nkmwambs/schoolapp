<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-tasks"></i>
					<?php echo get_phrase('new_contra_entry');?>
            	</div>
            </div>
			<div class="panel-body">

				<?php echo form_open(base_url() . 'index.php?finance/contra_entry/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

				<div class="form-group">
					<label for="" class="control-label col-sm-4"><?=get_phrase('description');?></label>
					<div class="col-sm-8">
						<input type="text" required="required" class="form-control" name="description" id="description"/>
					</div>
				</div>

				<div class="form-group">
					<label for="" class="control-label col-sm-4"><?=get_phrase('date');?></label>
					<div class="col-sm-8">
						<input type="text" required="required" class="form-control datepicker" data-start-date="<?php echo $this->crud_model->next_transaction_date()->start_date;?>" data-end-date="<?php echo $this->crud_model->next_transaction_date()->end_date;?>" data-format="yyyy-mm-dd" readonly="readonly" name="t_date" id="t_date"/>
					</div>
				</div>

				<div class="form-group">
						<label for="field-2" class="col-sm-4 control-label"><?php echo get_phrase('batch_number');?></label>

						<div class="col-sm-8">
							<input type="text" name="batch_number" class="form-control" required="required" readonly="readonly" value="<?=$this->crud_model->next_batch_number();?>" required="required">
						</div>
				</div>

				<div class="form-group">
						<label for="field-2" class="col-sm-4 control-label"><?php echo get_phrase('bank_reference_number');?></label>

						<div class="col-sm-8">
							<input type="text" class="form-control" name="bank_reference_number" required="required"  value="" required="required">
						</div>
				</div>

				<div class="form-group">
					<label for="" class="control-label col-sm-4"><?=get_phrase('entry_type');?></label>
					<div class="col-sm-8">
						<select class="form-control select2" name="entry_type" id="entry_type" required="required">
							<option value=""><?=get_phrase('select');?></option>
							<option value="3"><?=get_phrase('to_bank');?></option>
							<option value="4"><?=get_phrase('to_cash');?></option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="" class="control-label col-sm-4"><?=get_phrase('amount');?></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="amount" id="amount" required="required"/>
					</div>
				</div>

				 <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('transact');?></button>
						</div>
					</div>

				<?php echo form_close();?>

			</div>
		</div>
	</div>
</div>
