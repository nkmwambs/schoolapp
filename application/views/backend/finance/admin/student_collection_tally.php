<?php
//print_r($payments);
//echo get_term_number(date('w'));
$income_categories = $this->db->get('income_categories')->result_object();
//print_r($income_categories);
?>
<hr/>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered datatable">
			<thead>
				<tr>
					<th rowspan="2">Student Name</th>
					<th rowspan="2">Class</th>
					<th rowspan="2">Roll Number</th>
					<?php
						foreach($income_categories as $category){
					?>
						<th colspan="3"><?=$category->name;?></th>
						
					<?php
						}
					?>
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
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($payments as $student=>$payment){
				?>
					<tr>
						<td><?=$payment['student']['name'];?></td>
						<td><?=$payment['student']['class'];?></td>
						<td><?=$payment['student']['roll'];?></td>
						<?php
							foreach($income_categories as $category){
						?>
							<td><?=number_format($payment['fees'][$category->name]['due'],2);?></td>
							<td><?=number_format($payment['fees'][$category->name]['paid'],2);?></td>
							<td><?=number_format($payment['fees'][$category->name]['balance'],2);?></td>
						<?php
							}
						?>
					</tr>
				<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">Total</th>
					<?php
						foreach($income_categories as $category){
					?>
						<th><?=number_format(array_sum(array_column(array_column($payments['fees'],$category->name),'due')),2);?></th>
						<th><?=number_format(array_sum(array_column(array_column($payments['fees'],$category->name),'paid')),2);?></th>
						<th><?=number_format(array_sum(array_column(array_column($payments['fees'],$category->name),'balance')),2);?></th>
					<?php
						}
					?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>
	
</script>