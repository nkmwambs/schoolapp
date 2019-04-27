<hr />
<?php
//echo $next_serial_number;
//echo $this->crud_model->next_serial_number();
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
					<option value="fees_income" <?php if($page_to_show == 'fees_income') echo "selected";?> >Student Fees Receipt</option>
					<option value="other_income" <?php if($page_to_show == 'other_income') echo "selected";?>>Other Income Receipt</option>
					<option value="expense" <?php if($page_to_show == 'expense') echo "selected";?>>Expense</option>
					<option value="contra" <?php if($page_to_show == 'contra') echo "selected";?>>Contra Entry</option>
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
