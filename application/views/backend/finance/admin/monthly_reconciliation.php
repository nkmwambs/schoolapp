<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$reconcile_obj = $this->db->get("reconcile");


?>
<div class="row">
	<div class="col-sm-12">
		<table class="table datatable">
			<thead>
				<tr>
					<td>Month</td>
					<td>Amount</td>
					<td>Suspense Balance</td>
					<td>Time Stamp</td>
					<td>Action</td>
				</tr>
			</thead>

			<tbody>
				<?php
					if($reconcile_obj->num_rows() > 0){
						foreach($reconcile_obj->result_object() as $row){
				?>
						<tr>
							<td><?=$row->month;?></td>
							<td><?=number_format($row->statement_amount,2);?></td>
							<td><?=number_format($row->suspense_balance,2);?></td>
							<td><?=$row->timestamp;?></td>
							<td>
								 <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

																			<li class="<?= get_access_class('view_financial_report', 'admin', 'accounting'); ?>">
																					<a href="<?php echo base_url();?>index.php?finance/monthly_reconciliation/view/<?php echo $row->reconcile_id;?>">
																							<i class="fa fa-eye"></i>
																									<?php echo get_phrase('view');?>
																							</a>
																			</li>

																			<li class="divider <?= get_access_class('view_financial_report', 'admin', 'accounting'); ?>"></li>
                                        <!-- EDIT -->
                                        <li class="<?= get_access_class('edit_reconciliation', 'admin', 'accounting'); ?>">
                                            <a href="<?php echo base_url();?>index.php?finance/monthly_reconciliation/edit/<?php echo $row->reconcile_id;?>">
                                                <i class="fa fa-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>

																				<li class="divider <?= get_access_class('edit_reconciliation', 'admin', 'accounting'); ?>"></li>

																				<li class="<?= get_access_class('approve_financial_report', 'admin', 'accounting'); ?>">
                                            <a href="<?php echo base_url();?>index.php?finance/monthly_reconciliation/approve/<?php echo $row->reconcile_id;?>">
                                                <i class="fa fa-thumbs-up"></i>
                                                    <?php echo get_phrase('approve');?>
                                                </a>
                                        </li>

                                      </ul>
                                   </div>
							</td>
						</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){

	});
</script>
