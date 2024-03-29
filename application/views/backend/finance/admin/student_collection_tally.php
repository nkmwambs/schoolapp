<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//print_r($this->crud_model->student_invoice_tally('2019'));
?>
<div class="row">
	<div class="col-xs-12">
		<?php echo form_open(base_url() . 'index.php?finance/student_collection_tally' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
				<div class="form-group">
						<label class="control-label col-xs-3"><?=get_phrase('choose_invoice_status');?></label>
						<div class="col-xs-2">
							<select class="form-control" name="invoice_status">
									<option value="unpaid"><?=get_phrase('select_status');?></option>
									<option value="unpaid" <?php if($invoice_status == 'unpaid') echo 'selected';?> ><?=get_phrase('unpaid');?></option>
									<option value="paid"  <?php if($invoice_status == 'paid') echo 'selected';?>  ><?=get_phrase('paid');?></option>
									<option value="excess"  <?php if($invoice_status == 'excess') echo 'selected';?>  ><?=get_phrase('excess');?></option>
									<option value="cancelled"  <?php if($invoice_status == 'cancelled') echo 'selected';?>  ><?=get_phrase('cancelled');?></option>
							</select>
						</div>
						<label class="control-label col-xs-2"><?=get_phrase('year');?></label>
						<div class="col-xs-2">
							<select class = 'form-control' name = 'year'>
								<?php 
									for($lower_year = date('Y') - 5; $lower_year < date('Y'); $lower_year++){
								?>
									<option value = '<?=$lower_year;?>' <?php if($year == $lower_year) echo 'selected';?> ><?=$lower_year;?></option>
								<?php
									}
								?>
								
								<option value = '<?=date('Y');?>' <?php if($year == date('Y')) echo 'selected';?>><?=date('Y');?></option>
								
								<?php 
									for($upper_year = date('Y') + 1; $upper_year < date('Y') + 5; $upper_year++){
								?>
									<option value = '<?=$upper_year;?>' <?php if($year == $upper_year) echo 'selected';?> ><?=$upper_year;?></option>
								<?php
									}
								?>

							</select>
						</div>
						<div class="col-xs-2">
							<input type="submit" class="btn btn-default" value="<?=get_phrase('go');?>"/>
						</div>
				</div>
		</form>
	</div>
</div>

<hr/>

<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered datatable">
			<thead>
				<tr>
					<th nowrap="nowrap" rowspan="2">Student Name</th>
					<th rowspan="2">Class</th>
					<th rowspan="2">Roll Number</th>

					<?php
						foreach($income_categories as $category){
					?>
						<th colspan="3" nowrap="nowrap"><?=$category->name;?></th>

					<?php
						}
					?>
					<th colspan="3">Total</th>
				</tr>
				<tr>

					<?php
						foreach($income_categories as $category){
					?>
						<th>Due</th>
						<th>Paid</th>
						<th>Balance</th>
					<?php
						}
					?>
					<th>Due</th>
					<th>Paid</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$total_due = 0;
					$total_paid = 0;
					$total_balance = 0;
					foreach($payments as $student=>$payment){
				?>
					<tr>
						<td nowrap="nowrap"><?=$payment['student']['name'];?></td>
						<td><?=$payment['student']['class'];?></td>
						<td><?=$payment['student']['roll'];?></td>

						<?php
							$due = 0;
							$paid = 0;
							$balance = 0;

							foreach($income_categories as $category){
						?>

							<td>
								<?=number_format(isset($payment['fees'][$category->name]['due'])?$payment['fees'][$category->name]['due']:0,2);?>
						 	</td>
							<td>
								<?=number_format(isset($payment['fees'][$category->name]['paid'])?$payment['fees'][$category->name]['paid']:0,2);?>
							</td>
							<td>
								<?=number_format(isset($payment['fees'][$category->name]['balance'])?$payment['fees'][$category->name]['balance']:0,2);?>
							</td>
						<?php
								$due += isset($payment['fees'][$category->name]['due'])?$payment['fees'][$category->name]['due']:0;
								$paid += isset($payment['fees'][$category->name]['paid'])?$payment['fees'][$category->name]['paid']:0;
								$balance += isset($payment['fees'][$category->name]['balance'])?$payment['fees'][$category->name]['balance']:0;
							}
						?>
						<td class="aggregate_due"><?=number_format($due,2);?></td>
						<td class="aggregate_paid"><?=number_format($paid,2);?></td>
						<td class="aggregate_balance"><?=number_format($balance,2);?></td>
					</tr>
				<?php
					$total_due += $due;
					$total_paid +=$paid;
					$total_balance+=$balance;
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">Total</th>

					<?php
						foreach($income_categories as $category){
					?>
						<th><?=number_format(isset($payments['fees'],$category->name)?array_sum(array_column(array_column($payments['fees'],$category->name),'due')):0,2);?></th>
						<th><?=number_format(isset($payments['fees'],$category->name)?array_sum(array_column(array_column($payments['fees'],$category->name),'paid')):0,2);?></th>
						<th><?=number_format(isset($payments['fees'],$category->name)?array_sum(array_column(array_column($payments['fees'],$category->name),'balance')):0,2);?></th>
					<?php
						}
					?>
					<th><?=number_format($total_due,2);?></th>
					<th><?=number_format($total_paid,2);?></th>
					<th><?=number_format($total_balance,2);?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>

</script>
