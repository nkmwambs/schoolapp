<?php

$this->db->join('transaction_detail','transaction_detail.transaction_id=transaction.transaction_id');
$transaction = $this->db->get_where('transaction',array('batch_number'=>$param2))->result_array();


$row = $transaction[0];

?>
<center>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        <?=get_phrase('print_transaction');?>
        <i class="entypo-print"></i>
    </a>
</center>

    <br><br>

    <div id="invoice_print">
        <table width="100%" border="0">
            <tr>
                <td align="right">
                    <h5><?php echo get_phrase('creation_date'); ?> : <?php echo date('d M,Y', strtotime($row['t_date']));?></h5>
                    <h5><?php echo get_phrase('batch_number'); ?> : <?php echo $row['batch_number'];?></h5>
                    <h5><?php echo get_phrase('transaction_type'); ?> : <?php echo $this->db->get_where('transaction_type',array('transaction_type_id'=>$row['transaction_type_id']))->row()->description;?></h5>
                    <h5><?php echo get_phrase('transaction_method'); ?> : <?php echo $this->db->get_where('transaction_method',array('transaction_method_id'=>$row['transaction_method_id']))->row()->description;?></h5>
                	<h5><?php echo get_phrase('cheque_number'); ?> : <?php echo $row['cheque_no'];?></h5>
                </td>
            </tr>
        </table>
        <hr>
        
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
								if($details['expense_catgory_id'] >  0){
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
