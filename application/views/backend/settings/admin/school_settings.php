<?php
//echo $approved_reports_exists;
$display_style = '';
$readonly = "";
if($approved_reports_exists == true){
$readonly_style = '';
	$display_style = "style='display:none;'";
	$readonly = "disabled='disabled'";
}

?>

<div class="row">

			<div class="col-md-10">

				<div class="tabs-vertical-env">

					<ul class="nav tabs-vertical"><!-- available classes "right-aligned" -->
						<li class="active"><a href="#v-terms" data-toggle="tab"><?=get_phrase('school_terms');?></a></li>
						<li><a href="#v-cash" data-toggle="tab"><?=get_phrase('start_cash_balance');?></a></li>
						<li><a href="#v-income" data-toggle="tab"><?php echo get_phrase('income_categories');?></a></li>
						<li><a href="#v-expense" data-toggle="tab"><?php echo get_phrase('expense_categories');?></a></li>
						<li><a href="#v-care" data-toggle="tab"><?php echo get_phrase('care_relationship');?></a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="v-terms">
							<p>
								<div class="btn btn-primary btn-icon pull-right" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_new_term');"><i class="entypo-plus-squared"></i><?php echo get_phrase('add');?></div>

								<table class="table table-striped">
									<thead>
										<tr>
											<th><?php echo get_phrase('action');?></th>
											<th><?php echo get_phrase('term_number');?></th>
											<th><?php echo get_phrase('terms');?></th>
											<th><?php echo get_phrase('start_month');?></th>
											<th><?php echo get_phrase('end_month');?></th>

										</tr>
									</thead>
									<tbody>
										<?php
											foreach($terms as $rows):
										?>
										<tr>
											<td>
													<div class="btn-group">
				                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
				                                        Action <span class="caret"></span>
				                                    </button>
				                                    <ul class="dropdown-menu dropdown-default pull-left" role="menu">
				                                        <!-- Edit -->
				                                        <li>
				                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_term/<?php echo $rows->terms_id;?>');">
				                                                <i class="entypo-pencil"></i>
				                                                    <?php echo get_phrase('edit');?>
				                                                </a>
				                                        </li>

				                                        <li class="divider"></li>

				                                        <!-- DELETE -->
				                                        <li>
				                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/school_settings/delete_term/<?php echo $rows->terms_id;?>');">
				                                                <i class="entypo-trash"></i>
				                                                    <?php echo get_phrase('delete');?>
				                                                </a>
				                                        </li>
				                                    </ul>
				                                </div>
											</td>
											<td><?php echo $rows->term_number;?></td>
											<td><?php echo $rows->name;?></td>
											<td><?php echo $rows->start_month;?></td>
											<td><?php echo $rows->end_month;?></td>

										</tr>
										<?php
											endforeach;
										?>
									</tbody>
								</table>
							</p>
						</div>
						<div class="tab-pane" id="v-cash">
							<p>
								<div <?=$display_style;?> class="btn btn-primary btn-icon pull-right" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_edit_account/');"><i class="fa fa-plus-square"></i><?=get_phrase('add/_Edit');?></div>

								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?=get_phrase('date');?></th>
											<th><?=get_phrase('account');?></th>
											<th><?=get_phrase('amount');?></th>

										</tr>
									</thead>
									<?php
										$balances = $this->db->get('accounts')->result_object();
									?>
									<tbody>
										<tr>
											<td><?php echo $this->db->get_where('settings',array('type'=>'system_start_date'))->row()->description;?></td>
											<td><?=get_phrase('bank');?></td>
											<td><?php echo number_format($balances[1]->opening_balance,2);?></td>
										</tr>
										<tr>
											<td><?php echo $this->db->get_where('settings',array('type'=>'system_start_date'))->row()->description;?></td>
											<td><?=get_phrase('cash');?></td>
											<td><?php echo number_format($balances[0]->opening_balance,2);?></td>
										</tr>
									</tbody>
								</table>
							</p>
						</div>
						<div class="tab-pane" id="v-income">
							<p>
								<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/income_category_add/');"
								class="btn btn-primary pull-right">
								<i class="entypo-plus-circled"></i>
								<?php echo get_phrase('add_new_income_category');?>
								</a>
								<br><br>
								<table class="table table-bordered datatable" id="table_export_1">
								    <thead>
								        <tr>
								            <th><div>#</div></th>
								            <th><div><?php echo get_phrase('name');?></div></th>
														<th><div><?php echo get_phrase('account_status');?></div></th>
								            <th><div><?php echo get_phrase('opening_balance');?></div></th>
								            <th><?=get_phrase('fees_carry_forward_category');?></th>
								            <th><div><?php echo get_phrase('options');?></div></th>
								        </tr>
								    </thead>
								    <tbody>
								        <?php
								        	$count = 1;
								        	$incomes = $this->db->get('income_categories')->result_array();
											//print_r($incomes);
								        	foreach ($incomes as $row):
								        ?>
								        <tr>
								            <td><?php echo $count++;?></td>
								            <td><?php echo $row['name'];?></td>
														<td><?=$row['status'] == 1?get_phrase('active'):get_phrase('suspended');?></td>
								            <td><input <?=$readonly;?> type="text" id="openingbalance_<?=$row['income_category_id']?>" class="form-control opening_balance" value="<?php echo $row['opening_balance'];?>" /></td>
								            <td><input <?=$readonly;?> type="radio" id="default_<?=$row['income_category_id']?>" name="defaut_category" class="default_category" value="1" <?=$row['default_category']== '1'?'checked':'';?> /></td>
								            <td>

								                <div class="btn-group">
								                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
								                        Action <span class="caret"></span>
								                    </button>
								                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

								                        <!--  EDITING LINK -->
								                        <li>
								                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/income_category_edit/<?php echo $row['income_category_id'];?>');">
								                            	<i class="entypo-pencil"></i>
																	<?php echo get_phrase('edit');?>
								                               	</a>
								                        				</li>
								                        <li class="divider"></li>

																				<li>

																				<?php if($row['status'] == 1){?>

								                        	<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/change_category_status/income/<?=$row['status'];?>/<?php echo $row['income_category_id'];?>');">
								                            	<i class="entypo-thumbs-down"></i>
																									<?php echo get_phrase('deactive');?>
								                         	</a>

																				<?php }else{?>

																					<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/change_category_status/income/<?=$row['status'];?>/<?php echo $row['income_category_id'];?>');">
																							<i class="entypo-thumbs-up"></i>
																									<?php echo get_phrase('activate');?>
																					</a>

																				<?php }?>

								                        </li>

																				<li class="divider"></li>
								                        <!--  DELETION LINK -->
								                        <li <?=$display_style;?>>
								                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?settings/income_category/delete/<?php echo $row['income_category_id'];?>');">
								                            	<i class="entypo-trash"></i>
																									<?php echo get_phrase('delete');?>
								                               	</a>
								                        	</li>
								                    </ul>
								                </div>

								            </td>
								        </tr>
								        <?php endforeach;?>
								    </tbody>
								</table>
							</p>
						</div>
						<div class="tab-pane" id="v-expense">
							<p>
								<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/expense_category_add/');"
								class="btn btn-primary pull-right">
								<i class="entypo-plus-circled"></i>
								<?php echo get_phrase('add_new_expense_category');?>
								</a>
								<br><br>
								<table class="table table-bordered datatable" id="table_export_2">
								    <thead>
								        <tr>
								            <th><div>#</div></th>
								            <th><div><?php echo get_phrase('name');?></div></th>
														<th><div><?php echo get_phrase('status');?></div></th>
								            <th><div><?php echo get_phrase('income_category');?></div></th>
								            <th><div><?php echo get_phrase('options');?></div></th>
								        </tr>
								    </thead>
								    <tbody>
								        <?php
								        	$count = 1;
								        	$expenses = $this->db->get('expense_category')->result_array();
								        	foreach ($expenses as $row):
								        ?>
								        <tr>
								            <td><?php echo $count++;?></td>
								            <td><?php echo $row['name'];?></td>
														<td><?=$row['status'] == 1?get_phrase('active'):get_phrase('suspended');?></td>
								            <td><?php echo $this->crud_model->get_income_category_name($row['income_category_id']);?></td>
								            <td>

								                <div class="btn-group">
								                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
								                        Action <span class="caret"></span>
								                    </button>
								                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

								                        <!-- teacher EDITING LINK -->
								                        <li>
								                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/expense_category_edit/<?php echo $row['expense_category_id'];?>');">
								                            	<i class="entypo-pencil"></i>
																	<?php echo get_phrase('edit');?>
								                               	</a>
								                        				</li>
								                        <li class="divider"></li>

																				<li>

																				<?php if($row['status'] == 1){?>

								                        	<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/change_category_status/expense/<?=$row['status'];?>/<?php echo $row['expense_category_id'];?>');">
								                            	<i class="entypo-thumbs-down"></i>
																									<?php echo get_phrase('deactive');?>
								                         	</a>

																				<?php }else{?>

																					<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/change_category_status/expense/<?=$row['status'];?>/<?php echo $row['expense_category_id'];?>');">
																							<i class="entypo-thumbs-up"></i>
																									<?php echo get_phrase('activate');?>
																					</a>

																				<?php }?>

								                        </li>

																				<li class="divider"></li>

								                        <!-- teacher DELETION LINK -->
								                        <li <?=$display_style?>>
								                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?settings/expense_category/delete/<?php echo $row['expense_category_id'];?>');">
								                            	<i class="entypo-trash"></i>
																	<?php echo get_phrase('delete');?>
								                               	</a>
								                        				</li>
								                    </ul>
								                </div>

								            </td>
								        </tr>
								        <?php endforeach;?>
								    </tbody>
								</table>
							</p>
						</div>
						<div class="tab-pane" id="v-care">
							<p>
								<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_relationship_add/');"
						class="btn btn-primary pull-right">
						<i class="entypo-plus-circled"></i>
						<?php echo get_phrase('add_relationship');?>
					</a>
						<br><br>

					<table class="table table-bordered datatable" id="table_export_3">
						<thead>
							<tr>
								<th><?=get_phrase('serial');?></th>
								<th><?=get_phrase('name');?></th>
								<th><?=get_phrase('action');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$cnt = 1;
								$relationship = $this->db->get('relationship')->result_object();
								foreach($relationship as $row):
							?>
								<tr>
									<td><?=$cnt;?></td>
									<td><?=$row->name;?></td>
									<td>
										<div class="btn-group">
						                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
						                        Action <span class="caret"></span>
						                    </button>
						                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

						                        <!-- RELATIONSHIP EDITING LINK -->
						                        <li>
						                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_relationship_edit/<?php echo $row->relationship_id;?>');">
						                            	<i class="entypo-pencil"></i>
															<?php echo get_phrase('edit');?>
						                               	</a>
						                        				</li>
						                        <li class="divider"></li>

						                        <!-- RELATIONSHIP DELETION LINK -->
						                        <li>
						                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?settings/school_settings/delete_relationship/<?php echo $row->relationship_id;?>');">
						                            	<i class="entypo-trash"></i>
															<?php echo get_phrase('delete');?>
						                               	</a>
						                        </li>
						                    </ul>
						                </div>
									</td>
								</tr>
							<?php $cnt++; endforeach; ?>
						</tbody>
					</table>
							</p>
						</div>
					</div>

				</div>

			</div>
	</div>




<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{





	});

	$(".opening_balance").on('change',function(){
		var income_category_id = $(this).attr('id').split("_")[1];

		var url = "<?=base_url();?>index.php?settings/update_income_category_opening_balance/"+income_category_id;

		var data = {'opening_balance':$(this).val()};

		$.ajax({
			url:url,
			type:"POST",
			data:data
		});
	});

	$(".default_category").on('click',function(){
		var income_category_id = $(this).attr('id').split("_")[1];

		var url = "<?=base_url();?>index.php?settings/update_default_category/"+income_category_id;

		var data = {'default_category':$(this).val()};

		$.ajax({
			url:url,
			type:"POST",
			data:data
		});
	});

</script>
