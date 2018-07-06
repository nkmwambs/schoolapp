<?php

$income = $this->db->get_where('payment',array('batch_number'=>$param2))->row();

//$income = $this->db->get_where('income',array('income_id'=>$income_id))->row();
?>

<div class="row">
	<center>
	    <a onClick="PrintElem('#receipt_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
	        <?=get_phrase('print_receipt');?>
	        <i class="entypo-print"></i>
	    </a>
	</center>
</div>

<hr/>

<div class="row"  id="receipt_print">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('view_batch');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open('' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payee');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control"  value="<?=$income->payee;?>" readonly="readonly"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control"  readonly="readonly" value="<?=$income->t_date;?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" readonly="readonly" value="<?=$income->description;?>"/>
						</div> 
					</div>

					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" readonly="readonly" value="<?=$this->db->get_where('accounts',array('accounts_id'=>$income->method))->row()->name;?>"/>
                        </div>
                    </div>
                    
					
					<table class="table table-bordered" id="tbl_details">
						
							<?php
								//$details = $this->db->get_where('income_details',array('income_id'=>$income->income_id))->result_object();
								if($income->payment_type == "1"){
									$details = $this->db->get_where('student_payment_details',array('payment_id'=>$income->payment_id))->result_object();
							
							?>
								<thead>
									<tr>
									<th><?=get_phrase('date');?></th>
									<th><?=get_phrase('details');?></th>
									<th><?=get_phrase('amount');?></th>
								</tr>
								</thead>
								<tbody>
								
							<?php
									foreach($details as $row){
							?>
									<tr>
										<td><?=$row->t_date;?></td>
										<td><?=$this->db->get_where("income_categories",array("income_category_id"=>$row->detail_id))->row()->name;?></td>
										<td><?=$row->amount;?></td>
									</tr>
							<?php			
									}
							?>
								</tbody>
								</tbody>
								<tfoot>
									<tr><td><?=get_phrase('total');?></td><td colspan="2"><input readonly="readonly" type="text" class="form-control"  value="<?=$income->amount;?>"/></td></tr>
								</tfoot>
						
							<?php			
								}else{
									$details = $this->db->get_where('other_payment_details',array('payment_id'=>$income->payment_id))->result_object();
							?>
								<thead>
									<tr>
									<th><?=get_phrase('quantity');?></th>
									<th><?=get_phrase('description');?></th>
									<th><?=get_phrase('unit_cost');?></th>
									<th><?=get_phrase('cost');?></th>
									<th><?=get_phrase('income_category');?></th>
								</tr>
								</thead>
								<tbody>
									
							<?php	
								
									foreach($details as $row){
							?>
									<tr>
										<td><?=$row->qty;?></td>
										<td><?=$row->description;?></td>
										<td><?=$row->unitcost;?></td>
										<td><?=$row->cost;?></td>
										<td><?=$this->db->get_where('income_categories',array('income_category_id'=>$row->income_category_id))->row()->name;?></td>
									</tr>	
								
							<?php	
									}
							?>
								</tbody>
								</tbody>
								<tfoot>
									<tr><td colspan="3"><?=get_phrase('total');?></td><td colspan="2"><input readonly="readonly" type="text" class="form-control"  value="<?=$income->amount;?>"/></td></tr>
								</tfoot>
							<?php		
								}
							?>
								
							
						
					</table>
                    
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'Receipt', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Receipt</title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo FCPATH;?>assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo FCPATH;?>assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>