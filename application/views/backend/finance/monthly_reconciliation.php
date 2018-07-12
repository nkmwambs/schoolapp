<?php

$reconcile_obj = $this->db->get("reconcile");


?>
<div class="row">
	<div class="col-sm-12">
		<table class="table datatable">
			<thead>
				<tr>
					<td>Month</td>
					<td>Amount</td>
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
							<td><?=$row->statement_amount;?></td>
							<td><?=$row->timestamp;?></td>
							<td>
								 <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- EDIT -->
                                        <li class="edit_reconciliation">
                                            <a href="<?php echo base_url();?>index.php?finance/monthly_reconciliation/edit/<?php echo $row->reconcile_id;?>">
                                                <i class="fa fa-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
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
		var datatable = $(".datatable").DataTable();
	});
</script>