<div class="row">
	<div class="col-xs-12">
				<div class="panel panel-primary" data-collapsed="0">
		        	<div class="panel-heading">
		            	<div class="panel-title" >
		            		<i class="fa fa-exchange"></i>
							<?php echo get_phrase('funds_transfer');?>
		            	</div>
		            </div>
					<div class="panel-body">
						<?php echo form_open(base_url() . 'index.php?finance/funds_transfer/', array(
									'class' => 'form-horizontal form-groups-bordered validate','target'=>'_top','id'=>'frm_payment'));?>
						
						
						<div class="form-group">
							<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
	                        
							<div class="col-sm-6">
								<input type="text" class="form-control datepicker" data-start-date="<?php echo $this->crud_model->next_cashbook_date()->start_date;?>" data-end-date="<?php echo $this->crud_model->next_cashbook_date()->end_date;?>" data-format="yyyy-mm-dd" readonly="readonly" name="t_date" id="t_date"/>
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="control-label col-sm-3"><?=get_phrase('from');?></label>
							<div class="col-sm-6">
								<select class="form-control select2" name="account_from" id="account_from">
									<option value=""><?=get_phrase('select');?></option>
									<?php
									$income_categories = $this->school_model->income_categories();
									foreach($income_categories as $row){
									?>
										<option value="<?=$row->income_category_id;?>"><?=$row->name;?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
				
						<div class="form-group">
							<label for="" class="control-label col-sm-3"><?=get_phrase('to');?></label>
							<div class="col-sm-6">
								<select class="form-control select2" name="account_to" id="account_to">
									<option value=""><?=get_phrase('select');?></option>
									<?php
									$income_categories = $this->school_model->income_categories();
									foreach($income_categories as $row){
									?>
										<option value="<?=$row->income_category_id;?>"><?=$row->name;?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
						
						<div class="form-group">
							<label for="" class="control-label col-sm-3"><?=get_phrase('amount');?></label>
							<div class="col-sm-6">
								<input type="number" class="form-control" name="amount" id="amount"/>
							</div>
						</div>
						
						 <div class="form-group">
								<div class="col-sm-offset-3 col-sm-6">
									<button type="submit" class="btn btn-info"><?php echo get_phrase('transact');?></button>
								</div>
						</div>
		
		
						</form>	
				</div>
			</div>	
		</div>			
</div>