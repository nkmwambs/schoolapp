<?php
$balances = $this->db->get('accounts')->result_object();
$start_date = $this->db->get_where("settings",array("type"=>"system_start_date"))->row()->description;
?>

<div class="row">
	<div class="panel panel-primary">
								
		<div class="panel-heading">
			<div class="panel-title"><?=get_phrase('account_opening_balances');?></div>						
		</div>
										
			<div class="panel-body">
		
			<?php echo form_open(base_url() . 'index.php?settings/opening_balances/edit/'.strtotime($this->db->get_where('settings',array('type'=>'system_start_date'))->row()->description), array('id'=>'frm_schedule','class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
			
				<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('bank');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="bank" value="<?php echo $balances[1]->opening_balance;?>"/>
                        </div>
                 </div>
                 
                 <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('cash');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="cash" value="<?php echo $balances[0]->opening_balance;?>"/>
                        </div>
                 </div>
                 
                  <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('start_date');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" readonly="readonly" name="system_start_date" value="<?=$start_date;?>" data-format="yyyy-mm-dd"/>
                        </div>
                 </div>
                 
                 <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add/_edit');?></button>
						</div>
					</div>
			
			</form>
				
			</div>
				
		</div>
</div>