<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//print_r($fund_balances);
?>
<p></p>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('vote_balance_report');?>: <?=date('F Y',strtotime($t_date));?>
	</div>
</div>
<p></p>
<div class="row">
	<div class="col-sm-1">

		<a href="<?=base_url();?>index.php?finance/fund_balance_report/<?=strtotime('-1 month',strtotime($t_date));?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-xs-10">

		<table class="table table-striped datatable">
			<thead>
				<tr>
					<th>Category</th>
					<th style="text-align: right;"><?=get_phrase('opening_balance');?></th>
					<th style="text-align: right;"><?=get_phrase('month_income');?></th>
					<th style="text-align: right;"><?=get_phrase('month_expense');?></th>
					<th style="text-align: right;"><?=get_phrase('month_balaance')?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$cnt = 0;
					//print_r($fund_balances);
					foreach($fund_balances['categories'] as $category_id=>$category_name){

						$opening  = $fund_balances['opening_balances'][$category_id];
						$income = $fund_balances['month_income'][$category_id];
						$expense = $fund_balances['month_expense'][$category_id];
						$closing = $opening + ($income - $expense);
				?>
					<tr>
						<td><?=$category_name;?></td>
						<td style="text-align: right;"><?=number_format($opening,2);?></td>
						<td style="text-align: right;"><?=number_format($income,2);?></td>
						<td style="text-align: right;"><?=number_format($expense,2);?></td>
						<td style="text-align: right;"><?=number_format($closing,2);?></td>
					</tr>
				<?php
					$cnt++;
					}

					$sum_opening = array_sum($fund_balances['opening_balances']);
					$sum_income = array_sum($fund_balances['month_income']);
					$sum_expense = array_sum($fund_balances['month_expense']);
					$sum_closing = $sum_opening + ($sum_income - $sum_expense);
				?>
				<tfoot>
					<tr>
						<th>Total</th>
						<th style="text-align: right;"><?=number_format($sum_opening,2);?></th>
						<th style="text-align: right;"><?=number_format($sum_income,2);?></th>
						<th style="text-align: right;"><?=number_format($sum_expense,2);?></th>
						<th style="text-align: right;"><?=number_format($sum_closing,2);?></th>
					</tr>
				</tfoot>
			</tbody>
		</table>
	</div>
	<div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/fund_balance_report/<?=strtotime('+1 month',strtotime($t_date));?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
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
