<hr />
<?php
//print_r($transfers);
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered datatable">
			<thead>
				<tr>
					<th>Transfer Date</th>
					<th>Batch Number</th>
					<th>Transfer From</th>
					<th>Transfer To</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($transfers as $row){
				?>
					<tr>
						<td><?=$row->t_date;?></td>
						<td><?=$row->batch_number;?></td>
						<td><?=$row->account_from;?></td>
						<td><?=$row->account_to;?></td>
						<td><?=number_format($row->amount,2);?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
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
						"sExtends": "xls",
						"mColumns": [0, 1, 2, 3, 4, 5]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1, 2, 3, 4, 5]
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