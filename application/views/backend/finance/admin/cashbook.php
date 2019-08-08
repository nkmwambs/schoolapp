<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$t_date = strtotime(date('Y-m-d'));

if(isset($current)){
	$t_date = strtotime($current);
}

?>

<hr>
<div class="row">
	<div class="col-sm-3 <?=get_access_class('create_transaction','admin','accounting');?>">
			<div class="btn-group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							<?=get_phrase('create_a_transaction');?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-default" role="menu">
							<li class="<?=get_access_class('take_student_payment','admin','accounting');?>">
								<a href="<?=base_url();?>index.php?finance/create_transaction/active_invoices/fees_income"><?=get_phrase('student_fees_receipt');?></a>
							</li>
							<li class="divider <?=get_access_class('take_student_payment','admin','accounting');?>"></li>
							
							<li class="<?=get_access_class('take_other_income','admin','accounting');?>">
								<a href="<?=base_url();?>index.php?finance/create_transaction/income_add/other_income"><?=get_phrase('other_income_receipt');?></a>
							</li>
							<li class="divider <?=get_access_class('take_other_income','admin','accounting');?>"></li>
							
							<li class="<?=get_access_class('make_expense','admin','accounting');?>">
								<a href="<?=base_url();?>index.php?finance/create_transaction/expense_add/expense"><?=get_phrase('expense');?></a>
							</li>
							<li class="divider <?=get_access_class('make_expense','admin','accounting');?>"></li>
							
							<li class="<?=get_access_class('tranfer_funds','admin','accounting');?>">
								<a href="<?=base_url();?>index.php?finance/create_transaction/tranfer_funds/tranfer_funds"><?=get_phrase('funds_transfer');?></a>
							</li>
							<li class="divider <?=get_access_class('tranfer_funds','admin','accounting');?>"></li>
							
							<li class="<?=get_access_class('raise_contra_entry','admin','accounting');?>">
								<a href="<?=base_url();?>index.php?finance/create_transaction/contra_entry/contra"><?=get_phrase('contra_entry');?></a>
							</li>
						</ul>
					</div> 
	</div>
	
	<div class="col-sm-3 create_bank_reconciliation_statement">
		<div class=" <?=get_access_class('bank_reconcialition','admin','accounting');?>">
			<a href="<?=base_url();?>index.php?finance/reconcile/<?=$t_date;?>" id="reconcile" class="btn btn-success btn-icon float-left"><i class="fa fa-book"></i><?=get_phrase('bank_reconciliation');?></a>
		</div>
	</div>	
</div>


<hr>

<div class="row">
	<div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/cashbook/scroll/<?=strtotime('-1 month',$t_date);?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-sm-10">
		<div class="" style="font-weight: bolder;text-align: center;">Cash Book for the Month of <?=date('F-Y',strtotime($current));?></div>
		<table class="table table-hover table-bordered table-responsive datatable">
			<thead>
				<tr>
					<th colspan="5">&nbsp;</th>
					<th colspan="3"><?=get_phrase('bank');?> <br/> <?=get_phrase('balance_brought_forward');?>: <?=number_format($bank_balance,2);?></th>
					<th colspan="3"><?=get_phrase('cash');?> <br/> <?=get_phrase('balance_brought_forward');?>: <?=number_format($cash_balance,2);?></th>
				</tr>
				
				<tr>
					<th><?=get_phrase('date');?></th>
					<th><?=get_phrase('reference');?></th>
					<th><?=get_phrase('payee');?></th>
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
				
				<?php
					
					$sum_bank_income = 0;
					$sum_bank_expense = 0;
					
					$sum_cash_income = 0;
					$sum_cash_expense = 0;
					
					foreach($transactions as $rows):
						
					$btn_color = "btn-default";
					$btn_title = "";	
					
					if($rows->is_cancelled == 1) {
						$btn_color = "btn-danger";	
						//$btn_title = "'title'='".get_phrase('reversing_batch_number').":'".$rows->reversing_batch_number."";
						$btn_title = get_phrase('reversing_batch_number').': '.$rows->reversing_batch_number;
					}
					
					$approval_status =  $this->crud_model->check_transaction_reverse_approval($rows->transaction_id);
					
					if($approval_status == 0){
						$btn_color = "btn-info";	
						$btn_title = get_phrase('pending_reversal_request');
					}elseif($approval_status == 1){
						$btn_color = "btn-success";	
						$btn_title = get_phrase('reversal_request_approved');
					}
					
				?>
					
					<tr>
						<td><?=$rows->t_date;?></td>
						<td><i class="fa fa-undo" style="font-size: 12pt;cursor: pointer;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_request_comment_add/request_cancel/<?php echo $rows->transaction_id; ?>/transaction');" ></i> 
							<div class="btn <?=$btn_color;?>" title="<?=$btn_title;?>" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_transaction/<?=$rows->batch_number?>');"><?=$rows->batch_number?></div></td>
						<td><?=$rows->payee;?></td>
						<td><?=$rows->description;?></td>
						<td><?=ucwords($rows->transaction_type);?></td>
						
						<!--Bank Income-->
						<?php
							$bank_income = 0;
							if(($rows->transaction_type_id==='1' && $rows->transaction_method_id==='2')||$rows->transaction_type_id==='3') $bank_income = $rows->amount;		
							$sum_bank_income +=	$bank_income;		
						?>
						
						<td><?=number_format($bank_income,2);?></td>
						
						<!--Bank Expense-->
						<?php
							$bank_expense = 0;
							if(($rows->transaction_type_id==='2' && $rows->transaction_method_id==='2')||$rows->transaction_type_id==='4') $bank_expense = $rows->amount;
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
							if(($rows->transaction_type_id==='1' && $rows->transaction_method_id==='1')||$rows->transaction_type_id==='4') $cash_income = $rows->amount;	
							$sum_cash_income +=	$cash_income;		
						?>
						
						<td><?=number_format($cash_income,2);?></td>
						
						<!--Cash Expense-->
						<?php
							$cash_expense = 0;
							if(($rows->transaction_type_id==='2' && $rows->transaction_method_id==='1')||$rows->transaction_type_id==='3') $cash_expense = $rows->amount;
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
					<td colspan="5"><?=get_phrase('total');?></td>
					
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
		<a href="<?=base_url();?>index.php?finance/cashbook/scroll/<?=strtotime('+1 month',$t_date);?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
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
			aaSorting: [[1, 'asc']],
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [
					
					{
						"sExtends": "xls",
						
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							//datatable.fnSetColumnVis(1, false);
							//datatable.fnSetColumnVis(5, false);
							
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