<?php
$t_date = strtotime(date('Y-m-d'));

if(isset($current)){
	$t_date = strtotime($current);
}

?>

<hr>
<div class="row">
	<div class="col-sm-3 add_contra_entry">
			<!-- <button id="contra" class="btn btn-success btn-icon" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_contras');"><i class="fa fa-tasks"></i><?=get_phrase('contra_entries');?></button> -->
			<a href="<?=base_url();?>index.php?finance/create_transaction" class="btn btn-success btn-icon float-left">
				<i class="fa fa-tasks"></i><?=get_phrase('create_a_transaction');?>
			</a> 
	</div>
	
	<div class="col-sm-3 create_bank_reconciliation_statement">
			<a href="<?=base_url();?>index.php?finance/reconcile/<?=$t_date;?>" id="reconcile" class="btn btn-success btn-icon float-left"><i class="fa fa-book"></i><?=get_phrase('bank_reconciliation');?></a>
	</div>	
	
	<div class="col-sm-6">
		<div class="btn btn-group">
			<a href="<?php echo base_url(); ?>index.php?finance/income"" class="btn btn-info"><?=get_phrase('income_list');?></a>
			<a href="<?php echo base_url(); ?>index.php?finance/expense" class="btn btn-info"><?=get_phrase('expense_list');?></a>
		</div>
	</div>
</div>


<hr>

<div class="row">
	<div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/scroll_cashbook/<?=strtotime('-1 month',$t_date);?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-sm-10">
		<div class="well well-sm" style="font-weight: bolder;text-align: center;">Cash Book for the Month of <?=date('F-Y',strtotime($current));?></div>
		<table class="table table-hover table-bordered datatable">
			<thead>
				<tr>
					<th colspan="4">&nbsp;</th>
					<th colspan="3"><?=get_phrase('bank');?> <br/> <?=get_phrase('balance_brought_forward');?>: <?=number_format($bank_balance,2);?></th>
					<th colspan="3"><?=get_phrase('cash');?> <br/> <?=get_phrase('balance_brought_forward');?>: <?=number_format($cash_balance,2);?></th>
				</tr>
				
				<tr>
					<th><?=get_phrase('date');?></th>
					<th><?=get_phrase('reference');?></th>
					<th><?=get_phrase('description');?></th>
					<th><?=get_phrase('transaction_type');?></th>
					<!--Bank-->
					<th><?=get_phrase('income');?></th>
					<th><?=get_phrase('expense');?></th>
					<th><?=get_phrase('balance');?></th>
					<!--Bank-->
					<th><?=get_phrase('income');?></th>
					<th><?=get_phrase('expense');?></th>
					<th><?=get_phrase('balance');?></th>
				</tr>
				
				
			</thead>
			<tbody>
				<!-- <tr>
					<td colspan="4"><?=get_phrase('balance_brought_forward');?></td>
					
					<td colspan="2">&nbsp;</td>
					<td><?=number_format($bank_balance,2);?></td>
					
					<td colspan="2">&nbsp;</td>
					<td><?=number_format($cash_balance,2);?></td>
				</tr> -->
				<?php
					
					$sum_bank_income = 0;
					$sum_bank_expense = 0;
					
					$sum_cash_income = 0;
					$sum_cash_expense = 0;
					
					foreach($transactions as $rows):
						
					$type = array('1'=>'Income','2'=>'Expense','3'=>'Bank Deposit from Cash','4'=>'Bank Withdraw to Cash');
				?>
					
					<tr>
						<td><?=$rows->t_date;?></td>
						<td><div class="btn btn-success"
							
							<?php if($rows->transaction_type==='2' && ($rows->account==='1' || $rows->account==='2')){ ?>
								onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_expense/<?=$rows->batch_number?>');"
							<?php } ?>
							
							<?php if($rows->transaction_type==='1' && ($rows->account==='1' || $rows->account==='2')){ ?>
								onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_income/<?=$rows->batch_number?>');"
							<?php } ?>
							
							<?php if(($rows->transaction_type==='3' ||$rows->transaction_type==='4')){ ?>
								onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_contra/<?=$rows->batch_number?>');"
							<?php } ?>
							
							
							><?=$rows->batch_number?></div></td>
						<td><?=substr($rows->description,0,25);?></td>
						<td><?=$type[$rows->transaction_type];?></td>
						
						<!--Bank Income-->
						<?php
							$bank_income = 0;
							if(($rows->transaction_type==='1' && $rows->account==='2')||$rows->transaction_type==='3') $bank_income = $rows->amount;		
							$sum_bank_income +=	$bank_income;		
						?>
						
						<td><?=number_format($bank_income,2);?></td>
						
						<!--Bank Expense-->
						<?php
							$bank_expense = 0;
							if(($rows->transaction_type==='2' && $rows->account==='2')||$rows->transaction_type==='4') $bank_expense = $rows->amount;
							$sum_bank_expense +=	$bank_expense;					
						?>
						
						<td><?=number_format($bank_expense,2);?></td>
						
						<!--Bank Balance-->
						<?php
							$bank_balance += $bank_income-$bank_expense;
						?>
						<td><?=number_format($bank_balance,2);?></td>
						
						
						
						
						
						<!--Cash Income-->
						<?php
							$cash_income = 0;
							if(($rows->transaction_type==='1' && $rows->account==='1')||$rows->transaction_type==='4') $cash_income = $rows->amount;	
							$sum_cash_income +=	$cash_income;		
						?>
						
						<td><?=number_format($cash_income,2);?></td>
						
						<!--Cash Expense-->
						<?php
							$cash_expense = 0;
							if(($rows->transaction_type==='2' && $rows->account==='1')||$rows->transaction_type==='3') $cash_expense = $rows->amount;
							$sum_cash_expense +=	$cash_expense;				
						?>
						
						<td><?=number_format($cash_expense,2);?></td>
						
						<!--Cash Balance-->
						<?php
							$cash_balance += $cash_income-$cash_expense;
						?>
						<td><?=number_format($cash_balance,2);?></td>
						
					</tr>
					
				<?php
					endforeach;
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4"><?=get_phrase('total');?></td>
					
					<td><?=number_format($sum_bank_income,2);?></td>
					<td><?=number_format($sum_bank_expense,2);?></td>
					<td><?=number_format($bank_balance,2);?></td>
					
					<td><?=number_format($sum_cash_income,2);?></td>
					<td><?=number_format($sum_cash_expense,2);?></td>
					<td><?=number_format($cash_balance,2);?></td>
				</tr>
			</tfoot>
		</table>
		
	</div>
	<div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/scroll_cashbook/<?=strtotime('+1 month',$t_date);?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
</div>


<script>
	$('#contra').click(function(e){
		e.preventDefault();
	});
	
	
	jQuery(document).ready(function($)
	{
		var datatable = $(".datatable").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [
					
					{
						"sExtends": "xls",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0, 2, 3, 4]
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