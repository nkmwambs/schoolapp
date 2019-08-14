<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//print_r($transfers);
?>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('year');?> <?=$year;?>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/funds_transfers_report/<?=$year - 1;?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-sm-10">
		<table class="table table-striped datatable">
			<thead>
				<tr>
					<th><?=get_phrase('transfer_date')?></th>
					<th><?=get_phrase('batch_number')?></th>
					<th>Transfer From</th>
					<th><?=get_phrase('transfer_to')?></th>
					<th><?=get_phrase('amount')?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($transfers as $row){
				?>
					<tr>
						<td><?=$row['t_date'];?></td>
						<td><?=$row['batch_number'];?></td>
						<td><?=$row['account_from'];?></td>
						<td><?=$row['account_to'];?></td>
						<td><?=number_format($row['amount'],2);?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/funds_transfers_report/<?=$year + 1;?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
</div>

<script>
	jQuery(document).ready(function($)
	{

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>
