<?php
$edit_data = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
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
                    <?php echo 'Admission Number - ' .  $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->roll; ?><br>
                </td>
            </tr>
        </table>
        <hr>

        <table width="100%" border="0">    
            <tr>
                <td align="right" width="80%"><?php echo get_phrase('total_amount'); ?> :</td>
                <td align="right"><?php echo $row['amount_due']; ?></td>
            </tr>
            <tr>
                <td align="right" width="80%"><h4><?php echo get_phrase('paid_amount'); ?> :</h4></td>
                <td align="right"><h4><?php echo $row['amount_paid']; ?></h4></td>
            </tr>
            <?php if ($row['balance'] != 0):?>
            <tr>
                <td align="right" width="80%"><h4><?php echo get_phrase('due'); ?> :</h4></td>
                <td align="right"><h4><?php echo $row['balance']; ?></h4></td>
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
					$invoice_details = $this->db->get_where('invoice_details',array('invoice_id'=>$row['invoice_id']))->result_object();
										
					$tot_due = 0;
					$tot_paid = 0;
					$tot_bal = 0;
										
					foreach($invoice_details as $inv):
				?>
					<tr>
						<td><?php echo $this->db->get_where('fees_structure_details',array('detail_id'=>$inv->detail_id))->row()->name;?></td>
						<td><?php echo $inv->amount_due;?></td>
							<?php
								$paid = 0;
												
								if($this->db->get_where('payment',array('invoice_id'=>$inv->invoice_id))->num_rows()>0){
									$payment_id  =  $this->db->get_where('payment',array('invoice_id'=>$inv->invoice_id))->row()->payment_id; //,'detail_id'=>$inv->detail_id
									$paid = $this->db->select_sum('amount')->get_where('student_payment_details',array('payment_id'=>$payment_id,'detail_id'=>$inv->detail_id))->row()->amount;
								} 
												
								$detail_bal = $inv->amount_due-$paid;
					?>
						<td><?php echo $paid;?></td>
						<td><?php echo $detail_bal;?></td>
						
					</tr>
									
					<?php
										
						$tot_due += $inv->amount_due;
						$tot_paid += $paid;
						$tot_bal += $detail_bal;
										
						endforeach;
					?>
						<tr><td>Totals</td><td><?php echo number_format($tot_due,2);?></td><td><?php echo number_format($tot_paid,2);?></td><td><?php echo number_format($tot_bal,2);?></td></tr>
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
                $payment  = $this->db->get_where("payment",array("invoice_id"=>$row['invoice_id']));
				if($payment->num_rows()>0){
					$payment_id = $payment->row()->payment_id;
	                $payment_history = $this->db->get_where('student_payment_details', array('payment_id' => $payment_id))->result_array();
	                foreach ($payment_history as $row2):
	                    ?>
	                    <tr>
	                        <td><?php echo $row2['t_date']; ?></td>
	                        <td><?php echo $row2['amount']; ?></td>
	                        <td><?php echo $this->db->get_where('fees_structure_details',array('detail_id'=>$row2['detail_id']))->row()->name;?></td>
	                        <td>
	                            <?php 
	                                if ($payment->row()->method == 1)
	                                    echo get_phrase('cash');
	                                if ($payment->row()->method == 2)
	                                    echo get_phrase('check');
	                                if ($payment->row()->method == 3)
	                                    echo get_phrase('card');
	                                if ($payment->row()->method == 'paypal')
	                                    echo 'paypal';
	                            ?>
	                        </td>
	                        
	                    </tr>
                <?php 
                		endforeach; 
                	}
                ?>
            </tbody>
            <tbody>
        </table>
    </div>
<?php endforeach; ?>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>