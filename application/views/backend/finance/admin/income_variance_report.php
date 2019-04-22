<hr />
<?php
//print_r($variances);
?>
<p></p>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('income_variance');?>: <?=date('F Y',strtotime($t_date));?>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-sm-1">
		
		<a href="<?=base_url();?>index.php?finance/income_variance_report/<?=strtotime('-1 month',strtotime($t_date));?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-xs-10">
		<table class="table table-striped datatable">
			<thead>
				<tr>
					<th>Income Category</th>
					<th style="text-align: right;">Project Income</th>
					<th style="text-align: right;">Income to date</th>
					<th style="text-align: right;">Income Variance</th>
					<th style="text-align: right;">% Variance</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					foreach($variances['categories'] as $category_id=>$category_name){
						
						$project_income = $variances['projected_income'][$category_id];
						$income_to_date = $variances['income_to_date'][$category_id];
						$variance = $project_income - $income_to_date;
						$percent_variance = $project_income!=0?$variance/$project_income:0;
						
				?>
					<tr>
						<td><?=$category_name;?></td>
						<td style="text-align: right;"><?=number_format($project_income,2);?></td>
						<td style="text-align: right;"><?=number_format($income_to_date,2);?></td>
						<td style="text-align: right;"><?=number_format($variance,2);?></td>
						<td style="text-align: right;"><?=number_format($percent_variance,2);?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/income_variance_report/<?=strtotime('+1 month',strtotime($t_date));?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
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
						"mColumns": [0,1, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0, 1, 2, 3, 4]
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