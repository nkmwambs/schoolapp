<style>
	/* style sheet for "A4" printing */
@media print and (width: 74mm) and (height: 105mm) {
     @page {
        margin: 3cm;
     }
}

</style>
<?php
//$this->db->select(array(''));
$this->db->join('transaction_type','transaction_type.transaction_type_id=transaction.transaction_type_id');
$this->db->join('transaction_detail','transaction_detail.transaction_id=transaction.transaction_id');
$transaction = $this->db->get_where('transaction',array('batch_number'=>$param2))->result_array();

//print_r($transaction);

$row = $transaction[0];

?>
<center>
    <a onClick="PrintElem('#invoice_print')" 
    class="btn btn-default btn-icon icon-left hidden-print pull-right">
        <?=get_phrase('print_transaction');?>
        <i class="entypo-print"></i>
    </a>
    
    <?php
    if($row['is_cancelled'] == 0 && $row['can_be_cancelled'] == 1){
    ?>
    <div class="<?=get_access_class('reverse_transaction','admin','accounting');?>">
	    <a onclick="confirm_action('<?=base_url();?>index.php?finance/reverse_transaction/<?=$row['transaction_id'];?>');" 
	    	class="btn btn-danger btn-icon icon-left hidden-print pull-left">
	    	<?=get_phrase('reverse_transaction');?>
	        <i class="entypo-ccw"></i>
	    </a>
    </div>
    <?php
	}
    ?>
</center>

    <br><br>

    <div id="invoice_print">
        <table width="100%" border="0">
            <tr>
                <td align="right">
                    <h5><?php echo get_phrase('creation_date'); ?> : <?php echo date('d M,Y', strtotime($row['t_date']));?></h5>
                    <h5><?php echo get_phrase('batch_number'); ?> : <?php echo $row['batch_number'];?></h5>
                    <h5><?php echo get_phrase('cheque_number'); ?> : <?php echo $row['cheque_no'];?></h5>
                    
                </td>
            </tr>
        </table>
        <hr />
        <table width="100%" border="0">    
            <tr>
                <td align="left"><h4><?php echo get_phrase('payment_from'); ?> </h4></td>
                <td align="right"><h4><?php echo get_phrase('transaction_type'); ?> </h4></td>
            </tr>

            <tr>
                <td align="left" valign="top">
                	<?php echo get_phrase('payee'); ?> : <?php echo $row['payee'];?><br />
                    <?php
                    	if($row['invoice_id'] > 0){
                    ?>
                    	
                    	<?php echo get_phrase('invoice_number'); ?> : <?php echo $row['invoice_id'];?><br/>
                    	<?php echo get_phrase('invoice_term'); ?> : <?php echo $this->crud_model->get_type_name_by_id('terms',$this->db->get_where('invoice'
                    	,array('invoice_id'=>$row['invoice_id']))->row()->term);?><br/>
                    	<?php echo get_phrase('invoice_year'); ?> : <?php echo $this->db->get_where('invoice'
                    	,array('invoice_id'=>$row['invoice_id']))->row()->yr;?><br/>
                    	<?php echo get_phrase('class'); ?> : <?php echo $this->crud_model->get_type_name_by_id('class',$this->db->get_where('invoice'
                    	,array('invoice_id'=>$row['invoice_id']))->row()->class_id);?><br/>
                    	<?php echo get_phrase('student'); ?> : <?php echo $this->crud_model->get_type_name_by_id('student',$this->db->get_where('invoice',
                    	array('invoice_id'=>$row['invoice_id']))->row()->student_id);?><br/>
                    	
                    <?php		
                    	}
                    ?>         
                </td>
                <td align="right" valign="top">
                    <?php echo get_phrase('transaction_type'); ?> : <?php echo $this->db->get_where('transaction_type',array('transaction_type_id'=>$row['transaction_type_id']))->row()->description;?><br/>
                    <?php echo get_phrase('transaction_method'); ?> : <?php echo $this->db->get_where('transaction_method',array('transaction_method_id'=>$row['transaction_method_id']))->row()->description;?><br/>
                </td>
               
	            
            </tr>
        </table>
        <hr />
        
        <table width="100%" border="0">    
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('total_amount'); ?> :</td>
                <td align="right"><?php echo number_format($row['amount'],2); ?></td>
            </tr>
                        
        </table>
        <hr />
        <table width="100%" border="0">
        	<tr>
                <td width="5%"><?php echo get_phrase('description'); ?> : <?php echo $row['description']; ?></td>
              
            </tr>
        </table>
        
        <hr>
        
        <h4><?php echo get_phrase('transaction_breakdown'); ?></h4>

		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th><?php echo get_phrase('item');?></th>
                    <th><?php echo get_phrase('quantity');?></th>
					<th><?php echo get_phrase('unit_cost');?></th>
					<th><?php echo get_phrase('total_cost');?></th>
					<th><?php echo get_phrase('account');?></th>
					
                </tr>
            </thead>
            <tbody>
            	<?php
															
					foreach($transaction as $details):
				?>
					<tr>
						<td><?=$details['detail_description'];?></td>
						<td><?=$details['qty'];?></td>
						<td><?=number_format($details['unitcost'],2);?></td>
						<td><?=number_format($details['cost'],2);?></td>
						<td>
							<?php 
								if($details['expense_category_id'] >  0){
									echo $this->crud_model->get_type_name_by_id('expense_category',$details['expense_category_id']);
								}else{
									echo $this->db->select('name')->get_where('income_categories',
									array('income_category_id'=> $details['income_category_id']))->row()->name;
								}
								
							?>
						</td>
					</tr>
									
					<?php
																			
						endforeach;
						
						
					?>
						
            </tbody>
          	
		</table>
		
    </div>

<script>
	
</script>