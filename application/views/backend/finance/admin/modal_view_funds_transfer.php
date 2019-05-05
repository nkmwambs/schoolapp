<?php

$record = $this->school_model->funds_transfer_by_batch_number($param2);//$this->db->get_where('payment',array('batch_number'=>$param2))->row();
//print_r($record);
?>

<div class="row">
	<center>
	    <a onClick="PrintElem('#receipt_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
	        <?=get_phrase('print_voucher');?>
	        <i class="entypo-print"></i>
	    </a>
	</center>
</div>

<hr/>

<div class="row"  id="receipt_print">
	<div class="col-xs-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('voucher');?> <?=get_phrase('serial')?>: <?=$record->batch_number;?>
            	</div>
            </div>
			<div class="panel-body">
				
				<?php echo form_open('', array(
									'class' => 'form-horizontal form-groups-bordered validate','target'=>'_top','id'=>'frm_payment'));?>
				
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
	                        
						<div class="col-sm-6">
							<input type="text" class="form-control" readonly="readonly" value="<?=$record->t_date;?>" id="t_date"/>
						</div>
					</div>
					
					<!-- <div class="form-group">
						<label for="" class="control-label col-sm-3"><?=get_phrase('batch_number');?></label>
						<div class="col-sm-6">
							<input type="number" class="form-control" readonly="readonly" id="batch_number" value="<?=$record->batch_number;?>"/>
						</div>
					</div> -->	
						
					<div class="form-group">
						<label for="" class="control-label col-sm-3"><?=get_phrase('account_from');?></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" readonly="readonly" value="<?=$record->account_from;?>"  id="account_from" />
						</div>
					</div>
				
					<div class="form-group">
						<label for="" class="control-label col-sm-3"><?=get_phrase('account_to');?></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" readonly="readonly" value="<?=$record->account_to;?>"  id="account_to" />
						</div>
					</div>
						
						
					<div class="form-group">
						<label for="" class="control-label col-sm-3"><?=get_phrase('amount');?></label>
						<div class="col-sm-6">
							<input type="number" class="form-control" readonly="readonly" value="<?=$record->amount;?>" id="amount"/>
						</div>
					</div>		
					
				</form>			
                
            </div>
        </div>
    </div>
</div>

