<hr />
<?php
//print_r($variances);
?>

<p></p>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('expense_variance');?>: <?=date('F Y',strtotime($t_date));?>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/variance_report/<?=strtotime('-1 month',strtotime($t_date));?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-xs-10">
		<table class="table table-striped datatable">
			<thead>
				<tr>
					<th>Income Category</th>
					<th style="text-align: right;">Month Expense</th>
					<th style="text-align: right;">Expense To Date</th>
					<th style="text-align: right;">Budget To Date</th>
					<th style="text-align: right;">Variance</th>
					<th style="text-align: right;">% Variance</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				foreach($variances['categories'] as $category_id=>$category_name){
					
					$expense 			= $variances['month_expense'][$category_id];
					$expense_to_date 	= $variances['expense_to_date'][$category_id];
					$budget_to_date 	= $variances['budget_to_date'][$category_id];
					$variance 			= $budget_to_date -  $expense_to_date;
					$percent_variance 	= $budget_to_date <> 0?$variance/$budget_to_date:0;
					if($budget_to_date == 0 && $expense_to_date > 0){
						$percent_variance = -1;
					}
					
				?>
					<tr>
						<td><?=$category_name;?></td>
						<td style="text-align: right;"><?=number_format($expense,2);?>
						<td style="text-align: right;"><?=number_format($expense_to_date,2);?></td>
						<td style="text-align: right;"><?=number_format($budget_to_date,2);?></td>
						<td style="text-align: right;"><?=number_format($variance,2);?></td>
						<td style="text-align: right;"><?=number_format($percent_variance*100,2);?></td>
					</tr>
				<?php
				}
				?>				
			</tbody>
		</table>
	</div>
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/variance_report/<?=strtotime('+1 month',strtotime($t_date));?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
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
						"sExtends": "xls",
						"mColumns": [0, 1, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1, 2, 3, 4]
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