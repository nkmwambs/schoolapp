<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$edit_data = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
	$this->db->select(array('route_name'));
	$this->db->join('student','student.transport_id=transport.transport_id');
	$transport_route = $this->db->get_where('transport',array('student.student_id'=>$row['student_id']));
?>
<center>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print Invoice
        <i class="entypo-print"></i>
    </a>
</center>

    <br><br>

    <div id="invoice_print">
        <table width="100%" border="0">
            <tr>
                <td align="right">
                    <h5><?php echo get_phrase('creation_date'); ?> : <?php echo date('d M,Y', $row['creation_timestamp']);?></h5>
                    <h5><?php echo get_phrase('year'); ?> : <?php echo $row['yr'];?></h5>
                    <h5><?php echo get_phrase('term'); ?> : <?php echo $this->db->get_where('terms',array('term_number'=>$row['term']))->row()->name;?></h5>
                    <h5><?php echo get_phrase('status'); ?> : <?php echo ucfirst($row['status']); ?></h5>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" border="0">    
            <tr>
                <td align="left"><h4><?php echo get_phrase('payment_to'); ?> </h4></td>
                <td align="right"><h4><?php echo get_phrase('bill_to'); ?> </h4></td>
            </tr>

            <tr>
                <td align="left" valign="top">
                    <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>            
                </td>
                <td align="right" valign="top">
                    <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?><br>
                    <?php 
                        $class_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->class_id;
                        echo get_phrase('class') . ' ' . $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                    ?><br>
                    <?php echo get_phrase('admission_number').' - ' .  $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->roll; ?><br>
                	<br />
                	<?php 
                		if($transport_route->num_rows()>0):
                			echo get_phrase('transport_route');?> - <?=$transport_route->row()->route_name;
                		endif;
                	?>
                </td>
               
	            
            </tr>
        </table>
        <hr>

        <table width="100%" border="0">    
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('total_amount'); ?> :</td>
                <td align="right"><?php echo number_format($row['amount_due'],2); ?></td>
            </tr>
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('paid_amount'); ?> :</td>
                <td align="right"><?php echo number_format($this->crud_model->fees_paid_by_invoice($row['invoice_id']),2); ?></td>
            </tr>
            <?php if ($this->crud_model->get_invoice_balance($row['invoice_id']) != 0):?>
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('balance'); ?> :</td>
                <td align="right"><?php echo number_format($this->crud_model->fees_balance_by_invoice($row['invoice_id']),2); ?></td>
            </tr>
            <?php endif;?>
            
        </table>
        
        <hr>
        
        <h4><?php echo get_phrase('invoice_breakdown'); ?></h4>

		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th><?php echo get_phrase('item');?></th>
					<th><?php echo get_phrase('amount_payable');?></th>
					<th><?php echo get_phrase('paid');?></th>
					<th><?php echo get_phrase('balance');?></th>
					
                </tr>
            </thead>
            <tbody>
            	<?php
					//$invoice_details = $this->db->get_where('invoice_details',array('invoice_id'=>$row['invoice_id']))->result_object();
					$this->db->select(array('fees_structure_details.detail_id','fees_structure_details.name',
	                'fees_structure_details.amount','invoice_details_id','invoice_details.amount_due'));
	                                	
					$this->db->join('fees_structure_details','fees_structure_details.detail_id=invoice_details.detail_id');									
	                $this->db->join('fees_structure','fees_structure.fees_id=fees_structure_details.fees_id');
	                $invoice_details = $this->db->get_where("invoice_details",array('invoice_details.invoice_id'=>$row['invoice_id']))->result_object();
					
										
					foreach($invoice_details as $inv):
				?>
					<tr>
						<td><?php echo $inv->name;?></td>
						<td><?php echo number_format($inv->amount_due,2);?></td>
						
						<td><?php echo number_format($this->crud_model->fees_paid_by_invoice_detail($inv->invoice_details_id));?></td>
						<td><?php echo number_format($this->crud_model->fees_balance_by_invoice_detail($inv->invoice_details_id));?></td>
						
					</tr>
									
					<?php
																			
						endforeach;
						
						$tot_due = array_sum(array_column($invoice_details, 'amount_due'));
						$tot_paid = $this->crud_model->fees_paid_by_invoice($row['invoice_id']);
						$tot_bal  = $this->crud_model->fees_balance_by_invoice($row['invoice_id']);
						
						if($this->crud_model->fees_balance_by_invoice($row['invoice_id']) < 0){
					?>
						<tr>
							<td><?=get_phrase('overpayment');?></td>
							<td><?=number_format(0,2);?></td>
							<td><?=number_format(abs($this->crud_model->fees_balance_by_invoice($row['invoice_id'])),2);?></td>
							<td><?=number_format($this->crud_model->fees_balance_by_invoice($row['invoice_id']),2);?></td>
						</tr>
					<?php
						}
					?>
						<tr>
							<td><?=get_phrase('total')?></td>
							<td><?php echo number_format($tot_due,2);?></td>
							<td><?php echo number_format($tot_paid,2);?></td>
							<td><?php echo number_format($tot_bal,2);?></td>
						</tr>
            </tbody>
          	
		</table>
		
        <hr>

        <!-- payment history -->
        <h4><?php echo get_phrase('payment_history'); ?></h4>
        <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th><?php echo get_phrase('date'); ?></th>
                    <th><?php echo get_phrase('amount'); ?></th>
                    <th><?php echo get_phrase('item'); ?></th>
                    <th><?php echo get_phrase('method'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $payment_history = $this->crud_model->get_invoice_transaction_history($row['invoice_id']);
				
				//if($payment_history->num_rows()>0){
	            	
	            //$payment = $payment_history->result_array(); 
					 
	            foreach ($payment_history as $line){
	            
	            ?>
	                    <tr>
	                        <td><?php echo $line->t_date; ?></td>
	                        <td><?php echo number_format($line->amount,2); ?></td>
	                        <td><?php echo $line->description;?></td>
	                        <td><?=$line->transaction_method;?></td>
	                        
	                    </tr>
                <?php 
					}
                //}

                ?>
            </tbody>
            <tbody>
        </table>
    </div>
<?php endforeach; ?>


<script type="text/javascript">

    // print invoice function
   

</script>