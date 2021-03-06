<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-xs-12">
	<?php
		echo form_open(base_url() . 'index.php?finance/create_transaction/' , array('id'=>'frm_single_invoice_edit','class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));
	?>
		<div class="form-group">
			<label class="control-label col-xs-3">Transaction Type</label>
			<div class="col-xs-6">
				<select id="transaction_type" name="page_to_show" class="form-control">
					<option value="">Select</option>
					<option class="<?=get_access_class('take_student_payment','admin','accounting');?>" value="fees_income" <?php if($page_to_show == 'fees_income') echo "selected";?> ><?=get_phrase('student_fees_receipt');?></option>
					<option class="<?=get_access_class('take_other_income','admin','accounting');?>" value="other_income" <?php if($page_to_show == 'other_income') echo "selected";?>><?=get_phrase('other_income_receipt');?></option>
					<option class="<?=get_access_class('make_expense','admin','accounting');?>" value="expense" <?php if($page_to_show == 'expense') echo "selected";?>><?=get_phrase('expense');?></option>
					<option class="<?=get_access_class('tranfer_funds','admin','accounting');?>" value="tranfer_funds" <?php if($page_to_show == 'tranfer_funds') echo "selected";?>><?=get_phrase('funds_transfer');?></option>
					<option class="<?=get_access_class('raise_contra_entry','admin','accounting');?>" value="contra" <?php if($page_to_show == 'contra') echo "selected";?>><?=get_phrase('contra_entry');?></option>
				</select>
			</div>
			
			<div class="col-xs-3">
				<button class="btn btn-info" type="submit">Go</button>
			</div>
		</form>	
		</div>
	</div>
</div>
<p></p>
<div class="row">
	<div id="to_show" class="col-xs-12">
		<?=$loaded_page;?>
	</div>
</div>
