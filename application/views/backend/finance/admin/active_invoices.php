<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


	$this->db->where('status' , 'unpaid');
	$this->db->where('yr' , $year);
    $this->db->order_by('creation_timestamp' , 'desc');
    $unpaid_invoices = $this->db->get('invoice')->result_array();
?>
<div class="row">
    <div class="col-xs-1">
        <a class="scroll_tabs" href="<?= base_url(); ?>index.php?finance/create_transaction/active_invoices/fees_income/<?= $year - 1; ?>"><i style="font-size: 60pt;" class="fa fa-minus-circle"></i></a>
    </div>
	<div class="col-xs-10">
		<table  class="table table-bordered datatable example">
                	<thead>
                		<tr>
                			<th>#</th>
                    		<th><div><?php echo get_phrase('student');?></div></th>
                    		<th><div><?php echo get_phrase('year');?></div></th>
                    		<th><div><?php echo get_phrase('term');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('fee_structure_total');?></div></th>
                            <th><div><?php echo get_phrase('payable_amount');?></div></th>
                            <th><div><?php echo get_phrase('actual_paid');?></div></th>
                            <th><div><?php echo get_phrase('balance');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                    		$count = 1;

                    		foreach($unpaid_invoices as $row):
                    	?>
                        <tr>
                        	<td><?php echo $count++;?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $row['yr'];?></td>
							<td><?php echo $row['term'];?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
							<td><?php echo number_format($row['amount'],2);?></td>
                            <td><?php echo number_format($row['amount_due'],2);?></td>

                            <?php $paid = $this->db->select_sum('amount')->get_where('transaction',
                            array('invoice_id'=>$row['invoice_id']))->row()->amount;?>

                            <td><?php echo $paid;?></td>

                            <?php
                            	$bal = $row['amount_due'] - $paid;
                            ?>

                            <td><?php echo number_format($bal,2);?></td>
							<td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <?php if ($bal != 0):?>

                                    <li class="take_student_payment">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_take_payment/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('take_payment');?>
                                        </a>
                                    </li>
                                    <li class="divider take_student_payment"></li>
                                    <?php endif;?>

                                    <!-- VIEWING INVOICE LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo get_phrase('view_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- EDIT INVOICE LINK -->
                                    <li class="edit_invoice">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider edit_invoice"></li>

                                    <!-- DELETION LINK -->
                                    <li class="delete_or_cancel_invoice">

                                    		<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/invoice/cancel/<?php echo $row['invoice_id'];?>');">
	                                            <i class="entypo-cancel"></i>
	                                                <?php echo get_phrase('cancel_invoice');?>
	                                        </a>


                                     </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
	</div>
    <div class="col-xs-1">
        <a class="scroll_tabs" href="<?= base_url(); ?>index.php?finance/create_transaction/active_invoices/fees_income/<?= $year + 1; ?>"><i style="font-size: 60pt;" class="fa fa-plus-circle"></i></a>
    </div>
</div>

<script>
	jQuery(document).ready(function($)
	{
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>
