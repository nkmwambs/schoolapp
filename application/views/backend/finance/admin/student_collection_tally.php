<?php
//print_r($payments);
//echo get_term_number(date('w'));
$income_categories = $this->db->get('income_categories')->result_object();
//print_r($income_categories);
?>
<hr/>
<div class="row">
	<div class="col-xs-12">
		<?php echo form_open(base_url() . 'index.php?finance/student_collection_tally/'.$year.'/'.$term.'/filter', array(
					'class' => 'form-horizontal form-groups-bordered validate','target'=>'_top','id'=>'frm_payment'));?>
			
			<div class="form-group">
				<label class="control-label col-xs-2">Filter Balance</label>
				<div class="col-xs-4">
					<select class="form-control" name="operator">
						<option value="="><?=get_phrase('select');?></option>
						<option value="=">Equal</option>
						<option value=">">Greater Than</option>
						<option value="<">Less Than</option>
						<option value=">=">Greater Than or Equal To</option>
						<option value="<=">Less Than or Equal To</option>
					</select>
				</div>
				<div class="col-xs-4">
					<input type="number" class="form-control" name="filter_amount" placeholder="Amount to filter" />
				</div>
				<div class="col-xs-2">
					<button type="submit" class="btn btn-default">Go</button>
				</div>
			</div>
			
		</form>
	</div>
</div>
<p></p>
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
							<td><?=number_format($payment['fees'][$category->name]['due'],2);?></td>
							<td><?=number_format($payment['fees'][$category->name]['paid'],2);?></td>
							<td><?=number_format($payment['fees'][$category->name]['balance'],2);?></td>
						<?php
								$due += $payment['fees'][$category->name]['due'];
								$paid += $payment['fees'][$category->name]['paid'];
								$balance += $payment['fees'][$category->name]['balance'];
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
						<th><?=number_format(array_sum(array_column(array_column($payments['fees'],$category->name),'due')),2);?></th>
						<th><?=number_format(array_sum(array_column(array_column($payments['fees'],$category->name),'paid')),2);?></th>
						<th><?=number_format(array_sum(array_column(array_column($payments['fees'],$category->name),'balance')),2);?></th>
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
jQuery(document).ready(function($)
	{


		var datatable = $(".datatable").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [

					{
						"sExtends": "xls"
					},
					{
						"sExtends": "pdf"
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(1, false);
							datatable.fnSetColumnVis(5, false);

							this.fnPrint( true, oConfig );

							window.print();

							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(1, true);
									  datatable.fnSetColumnVis(5, true);
								  }
							});
						},

					},
				]
			},

		});

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>