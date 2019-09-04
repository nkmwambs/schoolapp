<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$income_categories = $this->db->get('income_categories')->result_object();
?>
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
							<td><?=number_format(isset($payment['fees'][$category->name]['due'])?$payment['fees'][$category->name]['due']:0,2);?></td>
							<td><?=number_format(isset($payment['fees'][$category->name]['paid'])?$payment['fees'][$category->name]['paid']:0,2);?></td>
							<td><?=number_format(isset($payment['fees'][$category->name]['balance'])?$payment['fees'][$category->name]['balance']:0,2);?></td>
						<?php
								$due += isset($payment['fees'][$category->name]['due'])?$payment['fees'][$category->name]['due']:0;
								$paid += isset($payment['fees'][$category->name]['paid'])?$payment['fees'][$category->name]['paid']:0;
								$balance += isset($payment['fees'][$category->name]['balance'])?$payment['fees'][$category->name]['balance']:0;
							}
						?>
						<td><?=number_format($due,2);?></td>
						<td><?=number_format($paid,2);?></td>
						<td><?=number_format($balance,2);?></td>
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
