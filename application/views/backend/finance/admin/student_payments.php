<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

$this -> db -> where('status', 'unpaid');
$this -> db -> where('yr', $year);
$this -> db -> order_by('creation_timestamp', 'desc');
$unpaid_invoices = $this -> db -> get('invoice') -> result_array();

$this -> db -> where('status', 'paid');
$this -> db -> where('yr', $year);
$this -> db -> order_by('creation_timestamp', 'desc');
$paid_invoices = $this -> db -> get('invoice') -> result_array();

$this -> db -> where('status', 'excess');
$this -> db -> where('yr', $year);
$this -> db -> order_by('creation_timestamp', 'desc');
$overpaid_invoices = $this -> db -> get('invoice') -> result_array();

$this -> db -> where('status', 'active');
//$this->db->where('yr' , $year);
$this -> db -> order_by('creation_timestamp', 'desc');
$overpay_notes = $this -> db -> get('overpay') -> result_array();

$this -> db -> where('status', 'cleared');
//$this->db->where('yr' , $year);
$this -> db -> order_by('creation_timestamp', 'desc');
$cleared_overpay_notes = $this -> db -> get('overpay') -> result_array();

$this -> db -> where('status', 'cancelled');
$this -> db -> where('yr', $year);
$this -> db -> order_by('creation_timestamp', 'desc');
$cancelled_invoices = $this -> db -> get('invoice') -> result_array();
?>

<style>
.hidden-xs{
	font-size:8pt;
}

</style>

<div class="row">
	<div class="col-xs-12 text-center" style="align:center;padding:5px;margin-bottom: 25px;">
		<a href="<?= base_url(); ?>index.php?finance/student_collection_tally/<?= date('Y'); ?>" class="btn btn-info btn-icon"> <i class="fa fa-list"></i> <?= get_phrase('payment_tally_sheet'); ?></a>
		<?php $count_to_notify = $this -> db -> get_where('invoice', array('status' => 'unpaid')) -> num_rows(); ?>
		<a href="#" onclick="confirm_action('<?= base_url(); ?>index.php?finance/sms_fee_balances');" class="btn btn-info btn-icon"><i class="fa fa-mobile"></i><?= get_phrase('SMS_balances'); ?><span class="badge badge-primary"><?= $count_to_notify; ?></span></a>
		<a href="<?php echo base_url(); ?>index.php?finance/create_invoice" class="btn btn-info btn-icon"><i class="fa fa-money"></i><?= get_phrase('create_invoice'); ?></a>
		<a href="<?php echo base_url(); ?>index.php?finance/missing_invoices" class="btn btn-info  btn-icon"><i class="fa fa-times"></i><?= get_phrase('missing_invoices'); ?></a>
	</div>
</div>

<div class="row">
	<div class="col-xs-1">
		<a href="<?= base_url(); ?>index.php?finance/scroll_student_payments/<?= $year - 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-md-10">

			<ul class="nav nav-tabs bordered">
				<li class="active">
					<a href="#unpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('unpaid_invoices'); ?></span>
						<span class="badge badge-danger"><?php echo count($unpaid_invoices); ?></span>
					</a>
				</li>

				<li class="">
					<a href="#cleared" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cleared_invoices'); ?></span>
						<span class="badge badge-success"><?php echo count($paid_invoices); ?></span>
					</a>
				</li>

				<li class="">
					<a href="#overpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('overpaid_invoices'); ?></span>
						<span class="badge badge-default"><?php echo count($overpaid_invoices); ?></span>
					</a>
				</li>

				<li class="">
					<a href="#overpay_notes" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('overpay_notes'); ?></span>
						<span class="badge badge-default"><?php echo count($overpay_notes); ?></span>
					</a>
				</li>

				<li class="">
					<a href="#cleared_overpay_notes" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cleared_overpay_notes'); ?></span>
						<span class="badge badge-default"><?php echo count($cleared_overpay_notes); ?></span>
					</a>
				</li>

				<!-- <li>
					<a href="#paid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('payment_history');?></span>
					</a>
				</li> -->

				<li>
					<a href="#cancelled" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('cancelled_invoices'); ?></span>
						<span class="badge badge-info"><?php echo count($cancelled_invoices); ?></span>
					</a>
				</li>

			</ul>

			<div class="tab-content">
				<p></p>
				<div class="tab-pane active" id="unpaid">



						<table  class="table table-striped datatable example">
                	<thead>
                		<tr>
                			<th>#</th>
												<th><?php echo get_phrase('admission_number'); ?></th>
                    		<th><div><?php echo get_phrase('student'); ?></div></th>
                    		<th><div><?php echo get_phrase('year'); ?></div></th>
                    		<th><div><?php echo get_phrase('term'); ?></div></th>
                    		<th><div><?php echo get_phrase('class'); ?></div></th>
                            <th><div><?php echo get_phrase('fee_structure_total'); ?></div></th>
                            <th><div><?php echo get_phrase('payable_amount'); ?></div></th>
                            <th><div><?php echo get_phrase('actual_paid'); ?></div></th>
                            <th><div><?php echo get_phrase('balance'); ?></div></th>
                    		<!-- <th><div><?php echo get_phrase('date'); ?></div></th> -->
												<th><div><?php echo get_phrase('approval_request_type'); ?></div></th>
												<th><div><?php echo get_phrase('approval_status'); ?></div></th>
                    		<th><div><?php echo get_phrase('options'); ?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                            $count = 1;

                            foreach ($unpaid_invoices as $row):
                                                    /**
                                                    * Check if this invoice has any approval request:
                                                    *	If yes get the request_type and status
                                                    *
                                                    **/
                                                    $approval_info = $this->school_model->get_approval_record_status('invoice', $row['invoice_id']);
                                                    //print_r($approval_info);
                                            ?>
                        <tr>
                        	<td><?php echo $row['invoice_id']; ?></td>
													<td><?php echo $this -> crud_model -> get_type_name_by_id('student', $row['student_id'],'roll'); ?></td>
							<td><?php echo $this -> crud_model -> get_type_name_by_id('student', $row['student_id']); ?></td>
							<td><?php echo $row['yr']; ?></td>
							<td><?php echo $row['term']; ?></td>
							<td><?php echo $this -> crud_model -> get_type_name_by_id('class', $row['class_id']); ?></td>
							<td><?php echo number_format($row['amount'], 2); ?></td>
              <td><?php echo number_format($row['amount_due'], 2); ?></td>

              <?php $paid = $this -> crud_model -> fees_paid_by_invoice($row['invoice_id']); ?>
              <td><?php echo number_format($paid, 2); ?></td>

							<?php $bal = $this -> crud_model -> fees_balance_by_invoice($row['invoice_id']); ?>

              <td><?php echo number_format($bal, 2); ?></td>
							<!-- <td><?php echo date('d M,Y', $row['creation_timestamp']); ?></td> -->
							<td><?= ucfirst($approval_info['request_type']); ?></td>

							<td><?= isset($states[$approval_info['request_status']]) ? ucfirst($states[$approval_info['request_status']]) : ''; ?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <?= get_phrase('action'); ?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">


                                    <?php if ($bal != 0):?>

                                    <li class="<?= get_access_class('take_student_payment', 'admin', 'accounting'); ?>">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_take_payment/<?php echo $row['invoice_id']; ?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('take_payment'); ?>
                                        </a>
                                    </li>
                                    <li class="divider <?= get_access_class('take_student_payment', 'admin', 'accounting'); ?>"></li>
                                    <?php endif; ?>

                                    <!-- VIEWING INVOICE LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_invoice/<?php echo $row['invoice_id']; ?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo get_phrase('view_invoice'); ?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

																		<?php
                                                                        //Show these links when a request has been raiased and approved
                                                                        if ($approval_info['request_status'] == 1) {
                                                                            if ($approval_info['request_type'] == 'update') { ?>
                                    <!-- EDIT INVOICE LINK -->
                                    <li class="<?= get_access_class('edit_invoice', 'admin', 'accounting'); ?>">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id']; ?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit_invoice'); ?>
                                            </a>
                                                    </li>
                                    <li class="divider <?= get_access_class('edit_invoice', 'admin', 'accounting'); ?>"></li>

																		<?php } ?>

                                    <!-- DELETION LINK -->
																		<?php if ($approval_info['request_type'] == 'cancel') { ?>
                                    <li class="<?= get_access_class('delete_or_cancel_invoice', 'admin', 'accounting'); ?>">

                                    		<a href="#" onclick="confirm_action('<?php echo base_url(); ?>index.php?finance/invoice/cancel/<?php echo $row['invoice_id']; ?>');">
	                                            <i class="entypo-cancel"></i>
	                                                <?php echo get_phrase('cancel_invoice'); ?>
	                                        </a>


                                     </li>
																		<?php }
																		}
                                                                         ?>

																		 <?php
                                                                        //Show these links when a request has not been raised or has been implemented by the requestor
                                                                        if ($approval_info['request_status'] == "" || $approval_info['request_status'] == 4 || $approval_info['request_status'] == 2 ) {
                                                                            ?>
                                     <!-- Send edit invoice request link  -->
                                     <li class="<?=get_access_class('request_edit_invoice', 'admin', 'accounting'); ?>">
                                         <!-- <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id']; ?>');"> -->
																				 	<a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_request_comment_add/request_edit/<?php echo $row['invoice_id']; ?>');">
                                             <i class="entypo-pencil"></i>
                                                 <?php echo get_phrase('request_edit_invoice'); ?>
                                             </a>
                                    </li>

																		<li class="divider <?=get_access_class('request_edit_invoice', 'admin', 'accounting'); ?>"></li>


                                     <!-- Send cancel request link -->

                                     <li class="<?=get_access_class('request_delete_or_cancel_invoice', 'admin', 'accounting'); ?>">
                                     		<!-- <a href="#" onclick="confirm_action('<?php echo base_url(); ?>index.php?finance/invoice/request_cancel/<?php echo $row['invoice_id']; ?>');"> -->
																					<a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_request_comment_add/request_cancel/<?php echo $row['invoice_id']; ?>');">
 	                                            <i class="entypo-cancel"></i>
 	                                                <?php echo get_phrase('request_cancel_invoice'); ?>
 	                                        </a>

                                      </li>
 																		<?php } ?>

                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

				</div>

				<div class="tab-pane" id="cleared">
					<div class="row" id="paid_invoices_placeholder">

						<!-- <div class="col-sm-1">
							<a id="prev_year" title="<?=date('Y', strtotime("-1 Year"))?>" href="#cleared"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
						</div> -->

						<div class="col-sm-12">
								<table  class="table table-bordered datatable example">
			                	<thead>
			                		<tr>
			                			<th>#</th>
			                    		<th><div><?php echo get_phrase('student'); ?></div></th>
															<th><div><?php echo get_phrase('class'); ?></div></th>

			                    		<th><div><?php echo get_phrase('year'); ?></div></th>
			                    		<th><div><?php echo get_phrase('term'); ?></div></th>
			                    		<th><div><?php echo get_phrase('class'); ?></div></th>
			                            <th><div><?php echo get_phrase('fee_structure_total'); ?></div></th>
			                            <th><div><?php echo get_phrase('payable_amount'); ?></div></th>
			                            <th><div><?php echo get_phrase('actual_paid'); ?></div></th>
			                            <th><div><?php echo get_phrase('balance'); ?></div></th>
			                    		<th><div><?php echo get_phrase('date'); ?></div></th>
										<th><div><?php echo get_phrase('action'); ?></div></th>
									</tr>
								</thead>
			                    <tbody>
			                    	<?php
                                        $count = 1;
                                        foreach ($paid_invoices as $row3):
                                    ?>
			                        <tr>
			                        	<td><?php echo $row3['invoice_id']; ?></td>
										<td><?php echo $this -> crud_model -> get_type_name_by_id('student', $row3['student_id']); ?></td>
											<td><?php echo $this -> crud_model -> get_type_name_by_id('class', $row3['class_id']); ?></td>
										<td><?php echo $row3['yr']; ?></td>
										<td><?php echo $row3['term']; ?></td>
										<td><?php echo $this -> crud_model -> get_type_name_by_id('class', $row3['class_id']); ?></td>
										<td><?php echo number_format($row3['amount'], 2); ?></td>
			                            <td><?php echo number_format($row3['amount_due'], 2); ?></td>

			                             <?php $paid = $this -> db -> select_sum('amount') -> get_where('transaction', array('invoice_id' => $row3['invoice_id'])) -> row() -> amount; ?>

				                            <td><?php echo number_format($paid, 2); ?></td>
				                           <?php $balance = $row3['amount_due'] - $paid; ?>

				                        <td><?php echo number_format($balance, 2); ?></td>

										<td><?php echo date('d M,Y', $row3['creation_timestamp']); ?></td>
										<td>
											<div class="btn-group">
			                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			                                    Action <span class="caret"></span>
			                                </button>
			                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">


			                                    <li>
			                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_invoice/<?php echo $row3['invoice_id']; ?>');">
			                                            <i class="entypo-bookmarks"></i>
			                                                <?php echo get_phrase('view_history'); ?>
			                                        </a>
			                                    </li>

			                                </ul>
			                            </div>
										</td>
			                        </tr>
			                        <?php endforeach; ?>
			                    </tbody>
			                </table>
						</div>

					</div>

				</div>

				<div class="tab-pane" id="overpaid">
						<table  class="table table-bordered datatable example">
                	<thead>
                		<tr>
                			<th>#</th>
                    		<th><div><?php echo get_phrase('student'); ?></div></th>
												<th><div><?php echo get_phrase('class'); ?></div></th>

                    		<th><div><?php echo get_phrase('year'); ?></div></th>
                    		<th><div><?php echo get_phrase('term'); ?></div></th>
                            <th><div><?php echo get_phrase('fee_structure_total'); ?></div></th>
                            <th><div><?php echo get_phrase('payable_amount'); ?></div></th>
                            <th><div><?php echo get_phrase('actual_amount'); ?></div></th>
                            <th><div><?php echo get_phrase('balance'); ?></div></th>
                    		<th><div><?php echo get_phrase('date'); ?></div></th>
							<th><div><?php echo get_phrase('action'); ?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                            $count = 1;
                            //$this->db->where('status' , 'paid');
                            //$this->db->order_by('creation_timestamp' , 'desc');
                            //$invoices = $this->db->get('invoice')->result_array();
                            foreach ($overpaid_invoices as $row3):
                        ?>
                        <tr>
                        <td><?php echo $row3['invoice_id']; ?></td>
							<td><?php echo $this -> crud_model -> get_type_name_by_id('student', $row3['student_id']); ?></td>
							<td><?php echo $this -> crud_model -> get_type_name_by_id('class', $row3['class_id']); ?></td>
							<td><?php echo $row3['yr']; ?></td>
							<td><?php echo $row3['term']; ?></td>
							<td><?php echo number_format($row3['amount'], 2); ?></td>
                            <td><?php echo number_format($row3['amount_due'], 2); ?></td>
                            <?php $paid = $this -> db -> select_sum('amount') -> get_where('transaction', array('invoice_id' => $row3['invoice_id'])) -> row() -> amount; ?>

				             <td><?php echo number_format($paid, 2); ?></td>
				             <?php $balance = $row3['amount_due'] - $paid; ?>

				            <td><?php echo number_format($balance, 2); ?></td>
							<td><?php echo date('d M,Y', $row3['creation_timestamp']); ?></td>
							<td>
								<div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">


                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_invoice/<?php echo $row3['invoice_id']; ?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('view_history'); ?>
                                        </a>
                                    </li>

                                </ul>
                            </div>
							</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

				</div>



				<div class="tab-pane" id="overpay_notes">

					<div class="row">

						<div class="col-sm-12 <?= get_access_class('add_overpay_note', 'admin', 'accounting'); ?>">
							<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_overpay_add/');"
							class="btn btn-primary pull-right">
							<i class="entypo-plus-circled"></i>
							<?php echo get_phrase('add_note'); ?>
							</a>

						</div>
					</div>

					<hr/>

					<div class="row">
						<div class="col-sm-12">
								<table class="table table-bordered datatable example">
							    <thead>
							        <tr>
							            <th><div>#</div></th>
							            <th><div><?php echo get_phrase('student'); ?></div></th>
							            <th><div><?php echo get_phrase('amount'); ?></div></th>
							            <th><div><?php echo get_phrase('balance'); ?></div></th>
							            <th><div><?php echo get_phrase('description'); ?></div></th>
							            <th><div><?php echo get_phrase('status'); ?></div></th>
							            <th><div><?php echo get_phrase('date'); ?></div></th>

							        </tr>
							    </thead>
							    <tbody>
							    	<?php
                                        $notes_object = $this->db->get_where("overpay", array("status"=>"active"));

                                        if ($notes_object->num_rows() > 0) {
                                            $cnt = 1;
                                            foreach ($notes_object->result_object() as $row) {
                                                ?>
							    			<tr>
							    				<td><?=$cnt; ?></td>
							    				<td><?= $this -> crud_model -> get_type_name_by_id("student", $row -> student_id); ?></td>
							    				<td><?= $row -> amount; ?></td>
							    				<td><?= $this->crud_model->overpay_balance($row -> overpay_id); ?></td>
							    				<td><?= $row -> description; ?></td>
							    				<td><?= $row -> status; ?></td>
							    				<td><?= $row -> creation_timestamp; ?></td>
							    			</tr>
							    	<?php $cnt++;
									}
									}
                                    ?>

								</tbody>
							</table>
							</div>
						</div>

				</div>

				<div class="tab-pane" id="cleared_overpay_notes">

					<div class="row">
						<div class="col-sm-12">
								<table class="table table-bordered datatable example">
							    <thead>
							        <tr>
							            <th><div>#</div></th>
							            <th><div><?php echo get_phrase('student'); ?></div></th>
							            <th><div><?php echo get_phrase('amount'); ?></div></th>
							            <th><div><?php echo get_phrase('balance'); ?></div></th>
							            <th><div><?php echo get_phrase('description'); ?></div></th>
							            <th><div><?php echo get_phrase('status'); ?></div></th>
							            <th><div><?php echo get_phrase('date'); ?></div></th>

							        </tr>
							    </thead>
							    <tbody>
							    	<?php
                                        $notes_object = $this->db->get_where("overpay", array("status"=>"cleared"));

                                        if ($notes_object->num_rows() > 0) {
                                            $cnt = 1;
                                            foreach ($notes_object->result_object() as $row) {
                                                ?>
							    			<tr>
							    				<td><?=$cnt; ?></td>
							    				<td><?= $this -> crud_model -> get_type_name_by_id("student", $row -> student_id); ?></td>
							    				<td><?= $row -> amount; ?></td>
							    				<td><?= $this->crud_model->overpay_balance($row -> overpay_id); ?></td>
							    				<td><?= $row -> description; ?></td>
							    				<td><?= $row -> status; ?></td>
							    				<td><?= $row -> creation_timestamp; ?></td>
							    			</tr>
							    	<?php $cnt++;
									}
									}
                                    ?>

								</tbody>
							</table>
							</div>
						</div>

				</div>


				<div class="tab-pane" id="cancelled">
						<table class="table table-bordered datatable example">
					    <thead>
					        <tr>
										<th>#</th>
											<th><div><?php echo get_phrase('student'); ?></div></th>
											<th><div><?php echo get_phrase('year'); ?></div></th>
											<th><div><?php echo get_phrase('term'); ?></div></th>
											<th><div><?php echo get_phrase('class'); ?></div></th>
													<th><div><?php echo get_phrase('fee_structure_total'); ?></div></th>
													<th><div><?php echo get_phrase('payable_amount'); ?></div></th>
													<th><div><?php echo get_phrase('actual_paid'); ?></div></th>
													<th><div><?php echo get_phrase('balance'); ?></div></th>
											<th><div><?php echo get_phrase('date'); ?></div></th>
											<th><div><?php echo get_phrase('approval_request_type'); ?></div></th>
											<th><div><?php echo get_phrase('approval_status'); ?></div></th>
											<th><div><?php echo get_phrase('options'); ?></div></th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php
                            $count = 1;

                            foreach ($cancelled_invoices as $row):


                                        /**
                                        * Check if this invoice has any approval request:
                                        *	If yes get the request_type and status
                                        * 0-new,1-approved,2-declined,3-reinstated, 4-implemented
                                        **/
                                        $approval_info = $this->school_model->get_approval_record_status('invoice', $row['invoice_id']);
                                        //print_r($approval_info);
                                ?>
									<tr>
										<td><?php echo $row['invoice_id']; ?></td>
				<td><?php echo $this -> crud_model -> get_type_name_by_id('student', $row['student_id']); ?></td>
				<td><?php echo $row['yr']; ?></td>
				<td><?php echo $row['term']; ?></td>
				<td><?php echo $this -> crud_model -> get_type_name_by_id('class', $row['class_id']); ?></td>
				<td><?php echo number_format($row['amount'], 2); ?></td>
											<td><?php echo number_format($row['amount_due'], 2); ?></td>

											<?php $paid = $this -> crud_model -> fees_paid_by_invoice($row['invoice_id']); ?>

											<td><?php echo number_format($paid, 2); ?></td>
										 <?php $bal = $this -> crud_model -> fees_balance_by_invoice($row['invoice_id']); ?>

											<td><?php echo number_format($bal, 2); ?></td>
				<td><?php echo date('d M,Y', $row['creation_timestamp']); ?></td>
				<td><?= ucfirst($approval_info['request_type']); ?></td>

				<td><?= isset($states[$approval_info['request_status']]) ? ucfirst($states[$approval_info['request_status']]) : ''; ?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">


                                    <!-- VIEWING INVOICE LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_invoice/<?php echo $row['invoice_id']; ?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo get_phrase('view_invoice'); ?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- Re-Claim LINK -->
                                    <?php
                                    if ($row['carry_forward'] == 0) {
                                    	if ($approval_info['request_type'] == 'reinstate') {
                                        ?>
                                    <li class="reclaim_cancelled_invoice">
                                        <a href="#" onclick="confirm_action('<?php echo base_url(); ?>index.php?finance/invoice/reclaim/<?php echo $row['invoice_id']; ?>');">
                                            <i class="entypo-reply"></i>
                                                <?php echo get_phrase('reclaim_invoice'); ?>
                                            </a>
                                     </li>
                                     <?php
										} else{
										?>

										<li class="reclaim_cancelled_invoice">
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_request_comment_add/request_reinstate/<?php echo $row['invoice_id']; ?>');">
                                            <i class="entypo-reply"></i>
                                                <?php echo get_phrase('request_reclaim_invoice'); ?>
                                            </a>
										</li>
									<?php
										}

										}
									?>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach; ?>
					    </tbody>
					  </table>
				</div>

			</div>


	</div>
	<div class="col-xs-1">
		<a href="<?= base_url(); ?>index.php?finance/scroll_student_payments/<?= $year + 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
</div>

<script type="text/javascript">
		jQuery(document).ready(function($)
	{


		// var datatable = $(".example").dataTable({
			// "sPaginationType": "bootstrap",
//
		// });

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});


		   if (location.hash) {
			        $("a[href='" + location.hash + "']").tab("show");
			    }
			    $(document.body).on("click", "a[data-toggle]", function(event) {
			        location.hash = this.getAttribute("href");
			    });

			$(window).on("popstate", function() {
			    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
			    $("a[href='" + anchor + "']").tab("show");

			});

	});

$("#prev_year, #next_year").click(function(){

	var url = "<?= base_url(); ?>index.php?finance/paid_invoice_scroll/<?= strtotime('-1 year'); ?>
	";
	if($(this).attr('id')=='next_year'){
	url = "
<?= base_url(); ?>index.php?finance/paid_invoice_scroll/<?= strtotime('+1 year'); ?>
		";
		}

		$.ajax({
		url:url,
		beforeSend:function(){

		},
		success:function(resp){
		$("#paid_invoices_placeholder").html(resp);
		},
		error:function(){

		}
		});

		});

		jQuery(document).ready(function($)
		{

		var datatable = $(".datatable").dataTable({
		"sPaginationType": "bootstrap",
		"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
		"oTableTools": {
		"aButtons": [

		{
		"sExtends": "xls",
		"mColumns": [0, 1, 2, 3, 4, 5]
		},
		{
		"sExtends": "pdf",
		"mColumns": [0,1, 2, 3, 4, 5]
		},
		{
		"sExtends": "print",
		"fnSetText"	   : "Press 'esc' to return",
		"fnClick": function (nButton, oConfig) {
		datatable.fnSetColumnVis(1, false);
		datatable.fnSetColumnVis(5, false);

		this.fnPrint( true, oConfig );

		window.print();

		$(window).keyup(function(e) {
		if (e.which == 27) {
		datatable.fnSetColumnVis(1, true);
		datatable.fnSetColumnVis(5, true);
		}
		});
		},

		},
		]
		},

		});

		$(".dataTables_wrapper select").select2({
		minimumResultsForSearch: -1
		});
		});

</script>
