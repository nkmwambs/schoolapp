<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$expected_income_by_category = $this->crud_model->get_term_expected_income_grouped_by_income_category($year,$current_term);

$this->db->select(array('expense_category_id','expense_category.name as expense_category','income_categories.name as income_category'));
$this->db->join('income_categories','income_categories.income_category_id=expense_category.income_category_id');
//$this->db->where(array('income_categories.income_category_id'=>8));
$exp_categories = $this->db->get('expense_category')->result_array();

$grouped_expenses_accounts = group_array_by_key($exp_categories,'income_category');

//print_r($exp_categories);

?>

<style>
	.chk_month{
		display:none;
	}
</style>

<hr />
<div class="row">
	<div class="col-xs-12">
		<div style="text-align: center;"><h4><?=get_phrase('school_budget_for_year_');?><?=$year;?></h4></div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title"></div>
				<div class="panel-options">
					<ul class="nav nav-tabs" id="myTab">
						<li  class=""><a href="#new-budget-item" data-toggle="tab"><?=get_phrase('new_budget_item');?></a></li>
						<li class="active"><a href="#budget-summary" data-toggle="tab"><?=get_phrase('budget_summary');?></a></li>
						<li class=""><a href="#budget-schedules" data-toggle="tab"><?=get_phrase('budget_schedules');?></a></li>

					</ul>
				</div>
		</div>

		<div class="panel-body" style="overflow: auto;">

				<div class="tab-content create_budget_item">

				<div class="tab-pane" id="new-budget-item">
					<div class="row">
						<div class="col-sm-6">
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year-1;?>"><i class="fa fa-angle-left"></i><?=$year-1;?></a>
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year+1;?>"><i class="fa fa-angle-right"></i><?=$year+1;?></a>
						</div>
					</div>

					<hr />


					<?php echo form_open(base_url() . 'index.php?finance/budget/create/' , array('id'=>'frm_schedule','class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

							<div class="row">
								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('account_');?></label>
									<div class="col-sm-7">
										<select name="expense_category_id" id="expense_category_id" class="form-control"  required="required">
											<option selected disabled value=""><?=get_phrase('select');?></option>
											<?php
												//$exp_acc = $this->db->get('expense_category')->result();

												foreach($grouped_expenses_accounts as $income_acc => $exp_acc):
											?>
												<optgroup label="<?=$income_acc;?>">
												<?php
													foreach($exp_acc as $acc){
												?>
													<option value="<?=$acc['expense_category_id'];?>"><?=$acc['expense_category'];?></option>
												<?php
													}
												?>
												</optgroup>
											<?php
												endforeach;
											?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('description_');?></label>
									<div class="col-sm-7">
										<input type="text" name="description" id="description" class="form-control" required="required"/>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('financial_year');?></label>
									<div class="col-sm-7">

										<input type="text" id="fy" name="fy" value="<?=$year;?>" class="form-control" required="required" readonly='readonly'/>
									</div>
								</div>

								<div class="form-group">
								<label class="control-label col-sm-4"><?=get_phrase('term');?></label>
									<div class="col-sm-7">
										<select id="terms_id" name="terms_id" class="form-control">
													<option><?=get_phrase('select');?></option>
													<?php
														$terms = $this->db->get_where('terms')->result_object();

														foreach($terms as $term){
													?>
														<option value="<?=$term->terms_id;?>" <?php if($current_term == $term->terms_id) echo "selected";?> ><?=$term->name;?></option>
													<?php
														}
													?>
										</select>
									</div>

								</div>


								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('quantity_');?></label>
									<div class="col-sm-7">
										<input type="number" id="qty" name="qty" class="form-control header" required="required"/>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('unit_cost');?></label>
									<div class="col-sm-7">
										<input type="number" id="unitcost" name="unitcost" class="form-control header" required="required"/>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('how_often');?></label>
									<div class="col-sm-7">
										<input type="number" max="4" min="1" id="often" name="often" class="form-control header" required="required"/>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('total_');?></label>
									<div class="col-sm-7">
										<input type="text" id="total" name="total" class="form-control" required="required" readonly="readonly"/>
									</div>
								</div>

								<div id="new_budget_month_spread">
									<table class="table">
									<thead>
										<tr>
											<th colspan="12"><?=get_phrase('monthly_spread');?></th>
										</tr>
										<tr>
											<?php
												foreach($months_in_term_short as $month_short){
											?>
												<th><input type="checkbox" class="chk_month" id="chk_<?=$month_short;?>" name=""/> <?=get_phrase($month_short);?></th>

											<?php
											}
											?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php
												$months_in_term = $this->crud_model->months_in_a_term($current_term);
												$cnt = 0;
												foreach($months_in_term_short as $month_short){
											?>
												<td><input type="text" style="min-width: 80px;" class="form-control months spread" name="months[]" id="<?=$month_short;?>" value="0" required="required"/></td>
											<?php
												$cnt++;
											}
											?>
										</tr>
									</tbody>
								</table>
								</div>

								<div class="form-group">
									<div class="col-sm-12">
										<div id="error_msg" style="color:red;"></div>
									</div>
								</div>

							</div>
							<button type="submit" id="create" class="btn btn-primary btn-icon"><i class="fa fa-plus"></i><?=get_phrase('create');?></button>
							<div id="clear_spread" class="btn btn-danger btn-icon"><i class="fa fa-refresh"></i><?php echo get_phrase('clear_spread');?></div>
						</form>
				</div>


				<div class="tab-pane active" id="budget-summary">
					<div class="row">
						<div class="col-sm-6">
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year-1;?>"><i class="fa fa-angle-left"></i><?=$year-1;?></a>
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year+1;?>"><i class="fa fa-angle-right"></i><?=$year+1;?></a>
						</div>
						<div class="col-sm-6">
								<div class="col-sm-10">
								<?php echo form_open(base_url() . 'index.php?finance/scroll_budget/'.$year , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

										<select name="terms_id" class="form-control">
											<option><?=get_phrase('select_term');?></option>
											<?php
												$terms = $this->db->get_where('terms')->result_object();

												foreach($terms as $term){
											?>
												<option value="<?=$term->terms_id;?>" <?php if($current_term == $term->terms_id) echo "selected";?> ><?=$term->name;?></option>
											<?php
												}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<button type="submit" class="btn btn-primary"><?=get_phrase('go')?></button>
									</div>
								</form>
								</div>


						</div>

					<hr/>

					<caption><?=get_phrase('summary_by_income_categories');?></caption>

					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?=get_phrase('income_category');?></th>
								<th><?=get_phrase('expected_income');?></th>
								<th><?=get_phrase('total');?></th>

								<?php
								foreach($months_in_term_short as $short_month){
								?>
									<th><?php echo get_phrase($short_month);?></th>
								<?php
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
								$income_categories = $this->db->get('income_categories')->result_object();

								foreach($income_categories as $inc_cat){

								$inc_spread = $this->crud_model->budget_income_summary_by_expense_category($inc_cat->income_category_id,$year,$current_term);

							?>
								<tr>
									<td  align="left"><?=$inc_cat->name;?></td>
									<td align="right"><?=number_format(isset($expected_income_by_category[$inc_cat->name])?$expected_income_by_category[$inc_cat->name]:0,2);?></td>
									<td align="right"><?=number_format(array_sum($inc_spread),2);?></td>

									<?php
										foreach($inc_spread as $month):
									?>

										<td align="right"><?=number_format($month,2);?></td>

									<?php
										endforeach;
									?>

								</tr>
							<?php
								}
							?>
						</tbody>
						<tfoot align="right">
							<?php
								$budget_summary = $this->crud_model->budget_summary_by_expense_category($year,$current_term);
							?>
							<tr>
								<td align="left"><?=get_phrase('total');?></td>
								<td><?=number_format(array_sum($expected_income_by_category),2);?></td>
								<td><?=number_format(array_sum($budget_summary),2);?></td>

								<?php
									foreach($budget_summary as $total):
								?>
									<td><?=number_format($total,2);?></td>

								<?php
									endforeach;
								?>

							</tr>
						</tfoot>
					</table>

				</div>

				<div class="tab-pane" id="budget-schedules">
					<div class="row">
						<div class="col-sm-6">
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year-1;?>"><i class="fa fa-angle-left"></i><?=$year-1;?></a>
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year+1;?>"><i class="fa fa-angle-right"></i><?=$year+1;?></a>
						</div>
						<div class="col-sm-6">

								<div class="col-sm-10">
									<?php echo form_open(base_url() . 'index.php?finance/scroll_budget/'.$year , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

									<select name="terms_id" class="form-control">
										<option><?=get_phrase('select_term');?></option>
										<?php
											$terms = $this->db->get_where('terms')->result_object();

											foreach($terms as $term){
										?>
											<option value="<?=$term->terms_id;?>" <?php if($current_term == $term->terms_id) echo "selected";?> ><?=$term->name;?></option>
										<?php
											}
										?>
									</select>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-primary"><?=get_phrase('go')?></button>
								</div>
							</form>
						</div>
					</div>
					<hr />
				<?php
					//$income_categories = $this->db->get('income_categories')->result_object();

					foreach($grouped_expenses_accounts as $income_category_name=>$expense_categories){
				?>
					<table class="table table-bordered table-striped">
						<caption style="text-align: center;font-weight:bold;"><?=$income_category_name;?></caption>
						<thead>
							<tr>
								<th><?php echo get_phrase('action_');?></th>
								<th><?php echo get_phrase('description_');?></th>
								<th><?php echo get_phrase('qty');?></th>
								<th><?php echo get_phrase('unitcost');?></th>
								<th><?php echo get_phrase('often');?></th>
								<th><?php echo get_phrase('total');?></th>

								<?php
								foreach($months_in_term_short as $short_month){
								?>
									<th><?php echo get_phrase($short_month);?></th>
								<?php
								}
								?>

							</tr>

						</thead>
						<tbody>
				<?php
					$spread_amount = array();
					foreach($expense_categories as $exp){
						$exp = (object)$exp;
				?>



						<?php
							$spread_obj = $this->db->get_where('budget',array('expense_category_id'=>$exp->expense_category_id,'fy'=>$year,'terms_id'=>$current_term));
							//print_r($spread);
							//$total = 0;

							if($spread_obj->num_rows() > 0){
							foreach($spread_obj->result_object() as $rows){
						?>
							<tr>
								<td>
									<div class="btn-group">
				                    <button id="" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
				                        Action <span class="caret"></span>
				                    </button>
				                    <ul class="dropdown-menu dropdown-default pull-left" role="menu">
				                        <!-- Add Sub Account -->



				                        <li>
				                        	<a href="#" class="edit_budget" id="editBudget_<?php echo $rows->budget_id;?>">
				                            	<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit_');?>
				                               	</a>
				                        </li>

				                        <li class="divider"></li>

				                        <li>
				                        	<a href="#" id="" onclick="confirm_action('<?php echo base_url();?>index.php?finance/budget/delete_item/<?php echo $rows->budget_id;?>');">
				                        	<i class="entypo-cancel"></i>
													<?php echo get_phrase('delete_');?>
				                               	</a>
				                        </li>

				                     </ul>
				                     </div>
								</td>
								<td><?php echo $rows->description;?></td>
								<td><?php echo $rows->qty;?></td>
								<td><?php echo number_format($rows->unitcost,2);?></td>
								<td><?php echo $rows->often;?></td>
								<td><?php echo number_format($rows->total,2);?></td>
								<?php
									$month_spread = $this->db->get_where('budget_schedule',array('budget_id'=>$rows->budget_id))->result_object();
									$sum = 0;
									foreach($month_spread as $m_spread):
										$spread_amount[$rows->budget_id][] = $m_spread->amount;
										$spread_amount[$rows->budget_id]['total'] = $sum+=$m_spread->amount;
								?>
									<td><?php echo number_format($m_spread->amount,2);?></td>
								<?php
									endforeach;
								?>
							</tr>

						<?php
							//$total += $rows->total;
								}

							}

					}
						//print_r($spread_amount);
				?>
							<tr>
								<td colspan="5">Total</td>
								<td><?=number_format(array_sum(array_column($spread_amount,'total')),2);?></td>
								<td><?=number_format(array_sum(array_column($spread_amount,0)),2);?></td>
								<td><?=number_format(array_sum(array_column($spread_amount,1)),2);?></td>
								<td><?=number_format(array_sum(array_column($spread_amount,2)),2);?></td>
								<td><?=number_format(array_sum(array_column($spread_amount,3)),2);?></td>
							</tr>
						</tbody>
					</table>
				<?php
				}
				?>
				</div>

			</div>

		</div>

	</div>
</div>
</div>

<script>


	$(document).ready(function(){

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }



	$('.months').keyup(function(){
			// var spread_amount = $(this).val();
//
			if(!$.isNumeric($(this).val())){
				spread_amount = 0;
				$(this).val(0);
			}
//
			// var total = parseFloat($('#total').val())+parseFloat(spread_amount);
//
			// $('#total').val(total);

	});




		$('.header').keyup(function(e){

			var spread=0;
			var sum = 0;
			var sum_spread = 0;
			var sum_header = 0;

			if($(this).attr('id')==='qty'){
				sum = $(this).val()*$('#unitcost').val()*$('#often').val();

				$('#total').val(sum);

				spread = sum/12;

				$('.spread').each(function(){
					$(this).val(spread);
				})
			}

			if($(this).attr('id')==='unitcost'){
				sum = $(this).val()*$('#.qty').val()*$('#often').val();

				$('#total').val(sum);

				spread = sum/<?=count($months_in_term_short);?>;

				$('.spread').each(function(){
					$(this).val(spread);
				})
			}

			if($(this).attr('id')==='often'){
				sum = $(this).val()*$('#unitcost').val()*$('#qty').val();

				$('#total').val(sum);

				spread = sum/<?=count($months_in_term_short);?>;

				$('.spread').each(function(){
					$(this).val(spread);
				})
			}


		});



		$('#clear_spread').click(function(){

			//Show checkboxes for month selection
			$(".chk_month").css('display','block');
			//$(".chk_month").prop('checked',false);

			$('.spread').each(function(index){
				$(this).val('0');
			});
		});


$('.chk_month').click(function(){
	var total = $("#total").val();
	var chk_month_selected = $('.chk_month').filter(':checked').length;
	var monthly_spread = parseFloat(total)/parseFloat(chk_month_selected);

	$.each($('.chk_month'),function(i,el){
		var chk_id = $(this).attr('id').split('_');

		if($(this).is(':checked')){
			$("#"+chk_id[1]).val(monthly_spread);
		}else{
			$("#"+chk_id[1]).val(0);
		}
	});

	//alert(monthly_spread);
});

$('#frm_schedule').submit(function(ev){
			$('#error_msg').html();

			var cnt = 0;

			$('.spread').each(function(index){

				if($(this).val().length===0){
					cnt++;
				}

			});

			if(cnt>0){
				$('#error_msg').html('<?php echo get_phrase('error:_spread_missing');?>');
				ev.preventDefault();
			}else{
				$('#error_msg').html();
			}

			var spread = 0;
			$('.spread').each(function(index){
				spread += +$(this).val();
			});

			var total = $('#total').val();

			//alert(Math.ceil(total));
			//alert(Math.ceil(spread));

			if(Math.ceil(spread)!==Math.ceil(total)){
				$('#error_msg').html('<?php echo get_phrase('error:_spread_incorrect');?>');
				ev.preventDefault();
			}else{
				$('#error_msg').html();
			}


		});



	});

	$(".edit_budget").on('click',function(ev){

		var id = $(this).attr('id');

		var id_array = id.split("_");

		var budget_id = id_array[1];

		var url = "<?=base_url();?>index.php?finance/edit_budget/"+budget_id;

		$.ajax({
			url:url,
			beforeSend:function(){
				$("overlay").css('display','block');
			},
			success:function(resp){

				var obj = JSON.parse(resp);

				$("#expense_category_id").val(obj[0].expense_category_id);
				$("#description").val(obj[0].description);
				$("#qty").val(obj[0].qty);
				$("#fy").val(obj[0].fy);
				$("#unitcost").val(obj[0].unitcost);
				$("#total").val(obj[0].total);
				$("#often").val(obj[0].often);

				var cnt = 0;
				$.each($(".spread"),function(i,el){
					$(this).val(obj[cnt].amount);
					cnt++;
				})

				$("#create").prop('id','edit');
				$("#edit").html('<i class="fa fa-pencil"></i><?=get_phrase('edit');?>');

				$("#frm_schedule").prop('action','<?=base_url();?>index.php?finance/budget/edit_item/'+obj[0].budget_id);

				//alert($("#frm_schedule").attr('action'));

				$("overlay").css('display','none');
			},
			error:function(){

			}
		});

	});

	$("#terms_id").on('change',function(){
		var term_id = $(this).val();
		var url = "<?=base_url();?>index.php?finance/change_new_item_budget_month_spread/"+term_id;
		$.ajax({
			url:url,
			beforeSend:function(){
				$("#overlay").css('display','block');
			},
			success:function(resp){
				$("#new_budget_month_spread").html(resp);
				$("#overlay").css('display','none');
			},
			error:function(){
				alert('Error occurred!');
				$("#overlay").css('display','none');
			}
		});

	})

	$("#create").on('click',function(ev){

		var sum_spread = 0;
		var total = $("#total").val();

		$('.months').each(function(i,el){
			sum_spread += parseInt($(el).val());
		});

		if(parseInt(total) !== sum_spread){
			alert('Spread error occurred');
			$("#total").css('border','1px solid red');
			$(".months").css('border','1px solid red');
			ev.preventDefault();
		}else{
			$("#total").css('border','1px solid gray');
			$(".months").css('border','1px solid gray');
		}


	});
</script>
