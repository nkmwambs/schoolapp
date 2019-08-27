<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<style>
	/* style sheet for "A4" printing */
@media print and (width: 74mm) and (height: 105mm) {
     @page {
        margin: 3cm;
     }
}

span{
	font-weight:bold;
	margin-bottom:45px;
}

#invoice_print{
	font-size: 8pt;
}
</style>
<?php
$this->db->select(array('transaction.t_date as t_date','transaction.batch_number as batch_number','transaction.createdby as createdby',
'.transaction.invoice_id as invoice_id','transaction.description as description','transaction.payee as payee',
'transaction.cheque_no as cheque_no','transaction.amount as amount'));
$this->db->select(array('transaction_method.description as transaction_method'));
$this->db->join('transaction_type','transaction_type.transaction_type_id=transaction.transaction_type_id');
$this->db->join('transaction_method','transaction_method.transaction_method_id=transaction.transaction_method_id');
$this->db->join('transaction_detail','transaction_detail.transaction_id=transaction.transaction_id');
$transaction = $this->db->get_where('transaction',array('batch_number'=>$param2))->result_array();


$row = $transaction[0];

?>
<center>
    <a onClick="PrintElem('#invoice_print')" 
    class="btn btn-default btn-icon icon-left hidden-print pull-right">
        <?=get_phrase('print_receipt');?>
        <i class="entypo-print"></i>
    </a>
    
</center>

    <br><br>

    <div id="invoice_print">
       
       <div class="row">
	       	<div class="col-xs-12" align="center" style="font-weight: bold;"><u>Payment Receipt</u></div>
       </div>
       <br/>
       <div class="row">
	       	<div class="col-xs-6 pull-left"><span>Date of Receipt:</span> <?php echo date('d M,Y', strtotime($row['t_date']));?> </div>
	       	<div class="col-xs-6 pull-right"><span>Receipt Number:</span> <?=$row['batch_number'];?></div>
       </div>
       <br/>
       <?php
       		$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
			$words =  $f->format($row['amount']);
       ?>
       <div class="row">
       	<div class="col-xs-12">
       		<span>Amount receive from: </span> <u><?php echo ucwords($row['payee']);?></u> <br/><br/>
       		<span>Amount: </span> <u><?php echo ucwords($words); ?> (<?=number_format($row['amount'],2);?>)</u> <span> only</span><br/><br/>
       		<span>Being payment for </span> <u><?php echo $row['description']; ?></u> <span> paid on behalf of </span> <u><?php echo $this->crud_model->get_type_name_by_id('student',$this->db->get_where('invoice',
             array('invoice_id'=>$row['invoice_id']))->row()->student_id);?><u><br/><br/>
       	</div>
       </div>
       
       <br/>
       
       <div class="row">
       	<div class="col-xs-6">
       		<table border="1" style="border-collapse: collapse;">
       			<tr>
       				<td style="padding: 5px;font-weight: bold;text-align: center;" colspan="2">Account</td>
       			</tr>
       			<tr>
       				<td style="padding: 5px;">Total Amount Due</td>
       				<td style="padding: 5px;"><?php echo number_format($this->crud_model->fees_amount_due_by_invoice($row['invoice_id']),2); ?></td>
       			</tr>
       			<tr>
       				<td style="padding: 5px;">Amount Paid</td>
       				<td style="padding: 5px;"><?php echo number_format($this->crud_model->fees_paid_by_invoice($row['invoice_id']),2); ?></td>
       			</tr>
       			<tr>
       				<td style="padding: 5px;">Balance Due</td>
       				<td style="padding: 5px;"><?php echo number_format($this->crud_model->fees_balance_by_invoice($row['invoice_id']),2); ?></td>
       			</tr>
       		</table>
       	</div>
       	
       	<div class="col-xs-6">
       		<table border="1" style="border-collapse: collapse;">
       			<tr>
       				<td style="padding: 5px;font-weight: bold;text-align: center;" colspan="2">Payment Made By</td>
       			</tr>
       			<tr>
       				<td style="padding: 5px;">Cheques</td>
       				<td style="padding: 5px;"><?php if($row['transaction_method'] == 'Bank'){?><i class="fa fa-check"> (<?=$row['cheque_no'];?>) </i><?php }else{?> <i class="fa fa-times"></i> <?php }?></td>
       			</tr>
       			<tr>
       				<td style="padding: 5px;">Cash</td>
       				<td style="padding: 5px;"><?php if($row['transaction_method'] == 'Cash'){?><i class="fa fa-check"></i><?php }else{?> <i class="fa fa-times"></i> <?php }?></td>
       			</tr>
       			<tr>
       				<td style="padding: 5px;">Others</td>
       				<td style="padding: 5px;"><?php if($row['transaction_method'] !== 'Bank' || $row['transaction_method'] !== 'Cash'){?><i class="fa fa-check"></i><?php }else{?> <i class="fa fa-times"></i> <?php }?></td>
       			</tr>
       		</table>
       	</div>
       	
       </div>
       
       <br/>
       
       <div class="row">
       	<div class="col-xs-12">
       		<span>Amount received by: </span> <?=$this->crud_model->get_type_name_by_id('user',$row['createdby'],'firstname');?>
       	</div>
       </div>
       
       <br/>
       
       <div class="row visible-print">
       	<div class="col-xs-6">
       		-----------------------------------<br/>
       		<span>Receiver Authorized Signatures </span>
       	</div>
       	
       	<div class="col-xs-6">
       		-----------------------------------<br/>
       		<span>Verifier Authorized Signatures </span>
       	</div>
       	
       </div>
		
    </div>

<script>
	
</script>