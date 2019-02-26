<?php
//print_r($this->crud_model->budget_income_summary_by_expense_category(1))
//$year = '2017';
?>

<div class="row">
	<div class="col-sm-12">
	<div class="panel panel-primary" id="">
						
		<div class="panel-heading">
			<div class="panel-title"><?=get_phrase('school_budget_for_year_');?><?=$year;?></div>						
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
						<div class="col-sm-12">
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
												$exp_acc = $this->db->get('expense_category')->result();
												
												foreach($exp_acc as $acc):
											?>
												<option value="<?=$acc->expense_category_id;?>"><?=$acc->name;?></option>
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
										<!--<select name="fy" id="fy" class="form-control"  required="required">
											<option disabled selected value=""><?=get_phrase('select');?></option>
											<?php 
												$fy = range(date('Y')-5, date('Y')+5);
													
												foreach($fy as $yr):
											?>
												<option value="<?=$yr;?>" <?php if($yr === $year) echo 'selected';?>><?=$yr;?></option>
											<?php 
												endforeach;
											?>
										</select>-->
										<input type="text" id="fy" name="fy" value="<?=$year;?>" class="form-control" required="required" readonly='readonly'/>
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('quantity_');?></label>
									<div class="col-sm-7">
										<input type="text" id="qty" name="qty" class="form-control header" required="required"/>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('unit_cost');?></label>
									<div class="col-sm-7">
										<input type="text" id="unitcost" name="unitcost" class="form-control header" required="required"/>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('how_often');?></label>
									<div class="col-sm-7">
										<input type="text" id="often" name="often" class="form-control header" required="required"/>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-4"><?=get_phrase('total_');?></label>
									<div class="col-sm-7">
										<input type="text" id="total" name="total" class="form-control" required="required" readonly="readonly"/>
									</div>
								</div>								
								
								<table class="table">
									<thead>
										<tr>
											<th colspan="12"><?=get_phrase('monthly_spread');?></th>
										</tr>
										<tr>
											<th><?=get_phrase('January');?></th>
											<th><?=get_phrase('February');?></th>
											<th><?=get_phrase('March');?></th>
											<th><?=get_phrase('April');?></th>
											<th><?=get_phrase('May');?></th>
											<th><?=get_phrase('June');?></th>
											<th><?=get_phrase('July');?></th>
											<th><?=get_phrase('August');?></th>
											<th><?=get_phrase('September');?></th>
											<th><?=get_phrase('October');?></th>
											<th><?=get_phrase('November');?></th>
											<th><?=get_phrase('December');?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Jan" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Feb" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Mar" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Apr" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="May" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Jun" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Jul" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Aug" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Sep" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Oct" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Nov" value="0" required="required"/></td>
											<td><input type="text" style="min-width: 80px;" class="form-control spread" class="months spread" name="months[]" id="Dec" value="0" required="required"/></td>
										</tr>
									</tbody>
								</table>
								
								<div class="form-group">
									<div class="col-sm-12">
										<div id="error_msg" style="color:red;"></div>
									</div>
								</div>
								
							</div>
							<button type="submit" class="btn btn-primary btn-icon"><i class="fa fa-plus"></i><?=get_phrase('create');?></button>
							<div id="clear_spread" class="btn btn-danger btn-icon"><i class="fa fa-refresh"></i><?php echo get_phrase('clear_spread');?></div>
						</form>
				</div>
						
				<div class="tab-pane active" id="budget-summary">
					<div class="row">
						<div class="col-sm-12">
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year-1;?>"><i class="fa fa-angle-left"></i><?=$year-1;?></a>
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year+1;?>"><i class="fa fa-angle-right"></i><?=$year+1;?></a>
						</div>
					</div>
					<hr />
					<caption><?=get_phrase('summary_by_expense_categories');?></caption>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?=get_phrase('expense_category');?></th>
								<th><?=get_phrase('total');?></th>
								
								<th><?php echo get_phrase('Jan');?></th>
								<th><?php echo get_phrase('Feb');?></th>
								<th><?php echo get_phrase('Mar');?></th>
								<th><?php echo get_phrase('Apr');?></th>
								<th><?php echo get_phrase('May');?></th>
								<th><?php echo get_phrase('Jun');?></th>
								<th><?php echo get_phrase('Jul');?></th>
								<th><?php echo get_phrase('Aug');?></th>
								<th><?php echo get_phrase('Sep');?></th>
								<th><?php echo get_phrase('Oct');?></th>
								<th><?php echo get_phrase('Nov');?></th>
								<th><?php echo get_phrase('Dec');?></th>
							</tr>
						</thead>	
						<tbody align="right">
							<?php
								$expense_category = $this->db->get('expense_category')->result_object();
								
								foreach($expense_category as $exp_cat):
								
								$exp_spread = $this->crud_model->budget_expense_summary_by_expense_category($exp_cat->expense_category_id,$year);
								
							?>
								<tr>
									<td  align="left"><?=$exp_cat->name;?></td>
									<td><?=number_format(array_sum($exp_spread),2);?></td>
									
									<?php
										foreach($exp_spread as $month):
									?>
										
										<td><?=number_format($month,2);?></td>
									
									<?php
										endforeach;
									?>
									
								</tr>
							<?php
								endforeach;
							?>
						</tbody>
						<tfoot align="right">
							<?php
								$budget_summary = $this->crud_model->budget_summary_by_expense_category($year);
							?>
							<tr>
								<td align="left"><?=get_phrase('total');?></td>
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
					
					<hr/>
					
					<caption><?=get_phrase('summary_by_income_categories');?></caption>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?=get_phrase('income_category');?></th>
								<th><?=get_phrase('total');?></th>
								
								<th><?php echo get_phrase('Jan');?></th>
								<th><?php echo get_phrase('Feb');?></th>
								<th><?php echo get_phrase('Mar');?></th>
								<th><?php echo get_phrase('Apr');?></th>
								<th><?php echo get_phrase('May');?></th>
								<th><?php echo get_phrase('Jun');?></th>
								<th><?php echo get_phrase('Jul');?></th>
								<th><?php echo get_phrase('Aug');?></th>
								<th><?php echo get_phrase('Sep');?></th>
								<th><?php echo get_phrase('Oct');?></th>
								<th><?php echo get_phrase('Nov');?></th>
								<th><?php echo get_phrase('Dec');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$income_categories = $this->db->get('income_categories')->result_object();
								
							foreach($income_categories as $inc_cat):
								
								$inc_spread = $this->crud_model->budget_income_summary_by_expense_category($inc_cat->income_category_id,$year);
								
							?>
								<tr>
									<td  align="left"><?=$inc_cat->name;?></td>
									<td><?=number_format(array_sum($inc_spread),2);?></td>
									
									<?php
										foreach($inc_spread as $month):
									?>
										
										<td><?=number_format($month,2);?></td>
									
									<?php
										endforeach;
									?>
									
								</tr>
							<?php
								endforeach;
							?>
						</tbody>
						<tfoot align="right">
							<?php
								$budget_summary = $this->crud_model->budget_summary_by_expense_category($year);
							?>
							<tr>
								<td align="left"><?=get_phrase('total');?></td>
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
						<div class="col-sm-12">
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year-1;?>"><i class="fa fa-angle-left"></i><?=$year-1;?></a>
							<a class="btn btn-info btn-icon scroll" href="<?=base_url();?>index.php?finance/budget/scroll/<?=$year+1;?>"><i class="fa fa-angle-right"></i><?=$year+1;?></a>
						</div>
					</div>
					<hr />
				<?php
					$expense_category = $this->db->get('expense_category')->result_object();
					
					foreach($expense_category as $exp):
				?>
					<table class="table table-bordered table-striped">
						<caption><?php echo $exp->name;?></caption>
						<thead>
							<tr>
								<th><?php echo get_phrase('action_');?></th>
								<th><?php echo get_phrase('description_');?></th>
								<th><?php echo get_phrase('qty');?></th>
								<th><?php echo get_phrase('unitcost');?></th>
								<th><?php echo get_phrase('often');?></th>
								<th><?php echo get_phrase('total');?></th>
								
								<th><?php echo get_phrase('Jan');?></th>
								<th><?php echo get_phrase('Feb');?></th>
								<th><?php echo get_phrase('Mar');?></th>
								<th><?php echo get_phrase('Apr');?></th>
								<th><?php echo get_phrase('May');?></th>
								<th><?php echo get_phrase('Jun');?></th>
								<th><?php echo get_phrase('Jul');?></th>
								<th><?php echo get_phrase('Aug');?></th>
								<th><?php echo get_phrase('Sep');?></th>
								<th><?php echo get_phrase('Oct');?></th>
								<th><?php echo get_phrase('Nov');?></th>
								<th><?php echo get_phrase('Dec');?></th>
							</tr>
							
						</thead>
						<tbody>
						<?php
							$spread = $this->db->get_where('budget',array('expense_category_id'=>$exp->expense_category_id,'fy'=>$year))->result_object();
							//print_r($spread);
							$total = 0;
							
							foreach($spread as $rows):
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
				                        	<a href="#" id="" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_budget/<?php echo $rows->budget_id;?>');">
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
									
									foreach($month_spread as $m_spread):
								?>
									<td><?php echo number_format($m_spread->amount,2);?></td>
								<?php
									endforeach;
								?>
							</tr>
						
						<?php
							$total += $rows->total;
							endforeach;
						?>	
						<tr>
							<td colspan="5"><?php echo get_phrase('total_');?></td>
							<td><?php echo number_format($total,2);?></td>
							
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</tbody>
					</table>
				<?php
					endforeach;
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

			var total = parseFloat($('#total').val())+parseFloat($(this).val());
			
			$('#total').val(total);

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
				
				spread = sum/12;
				
				$('.spread').each(function(){
					$(this).val(spread);
				})
			}
			
			if($(this).attr('id')==='often'){
				sum = $(this).val()*$('#unitcost').val()*$('#qty').val();
				
				$('#total').val(sum);
				
				spread = sum/12;
				
				$('.spread').each(function(){
					$(this).val(spread);
				})
			}
				

		});
		
		
		
		$('#clear_spread').click(function(){
			$('.spread').each(function(index){
				$(this).val('0');
			});
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
	
</script>