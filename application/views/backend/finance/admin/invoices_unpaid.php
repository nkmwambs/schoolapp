<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
?>

<style>
.hidden-xs{
	font-size:8pt;
}

.scroll_tabs{
	position: fixed;
}
</style>

<div class="row">
	<div class="col-xs-offset-4 col-xs-8 text-center" style="align:center;padding:5px;margin-bottom: 25px;">
		<div class="<?=get_access_class('mass_edit_invoices', 'admin', 'accounting'); ?> pull-left">
			<a href="<?= base_url(); ?>index.php?finance/mass_edit_invoices/<?= date('Y'); ?>" class="btn btn-default"> <i class="fa fa-list"></i> <?= get_phrase('mass_edit_invoices'); ?></a>
		</div>

		<div class="<?=get_access_class('send_fees_balance_by_sms', 'admin', 'accounting'); ?> pull-left">
			<?php $count_to_notify = $this -> db -> get_where('invoice', array('status' => 'unpaid')) -> num_rows(); ?>
			<a href="#" onclick="confirm_action('<?= base_url(); ?>index.php?finance/sms_fee_balances');" class="btn btn-default"> <i class="fa fa-mobile"></i> <?= get_phrase('SMS_balances'); ?> <span class="badge badge-warning"><?= $count_to_notify; ?></span></a>
		</div>

		<div class="<?=get_access_class('create_invoice', 'admin', 'accounting'); ?> pull-left">
			<a href="<?php echo base_url(); ?>index.php?finance/create_invoice" class="btn btn-default"> <i class="fa fa-money"></i> <?= get_phrase('create_invoice'); ?></a>
		</div>

		<div class="pull-left">
			<a href="<?php echo base_url(); ?>index.php?finance/missing_invoices" class="btn btn-default"> <i class="fa fa-times"></i> <?= get_phrase('missing_invoices'); ?></a>
		</div>

	</div>
</div>

<div class="row">
	<div class="col-xs-1">
		<a class="scroll_tabs" href="<?= base_url(); ?>index.php?finance/unpaid_invoices/<?= $year - 1; ?>"><i style="font-size: 60pt;" class="fa fa-minus-circle"></i></a>
	</div>

  <div class="col-xs-10">
    <div class="row">
      <div class="col-xs-12">
            <div class="panel panel-default panel-shadow" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo get_phrase('unpaid_invoices');?></div>
                  </div>

                <div class="panel-body">
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
                    <?php 
                        $fee_structure_amount = 0;
                        
                        $this->db->select_sum('amount');
                        $this->db->join('fees_structure_details','fees_structure_details.fees_id=fees_structure.fees_id');
                        $fee_structure_amount_obj = $this->db->get_where('fees_structure',
                        array('fees_structure.class_id' => $row['class_id'], 'fees_structure.yr' => $row['yr'], 'fees_structure.term' => $row['term']));
                        
                        if($fee_structure_amount_obj->num_rows() > 0 ){
                            $fee_structure_amount = $fee_structure_amount_obj->row()->amount;
                        }
                    ?>
                    <td><?php echo number_format($fee_structure_amount, 2); ?></td>
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
                                          $settings = $this->school_model->get_system_settings();

                                          if($settings['manage_invoice_require_approval'] == 'false'){
                                          ?>
                                                  <li class="<?= get_access_class('edit_invoice', 'admin', 'accounting'); ?>">
                                                      <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id']; ?>');">
                                                          <i class="entypo-pencil"></i>
                                                              <?php echo get_phrase('edit_invoice'); ?>
                                                          </a>
                                                  </li>
                                                  <li class="divider <?= get_access_class('edit_invoice', 'admin', 'accounting'); ?>"></li>

                                                  <li class="<?= get_access_class('delete_or_cancel_invoice', 'admin', 'accounting'); ?>">

                                                      <a href="#" onclick="confirm_action('<?php echo base_url(); ?>index.php?finance/invoice/cancel/<?php echo $row['invoice_id']; ?>');">
                                                            <i class="entypo-cancel"></i>
                                                                <?php echo get_phrase('cancel_invoice'); ?>
                                                        </a>


                                                   </li>
                                        <?php


                                          }else{

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
                                          <?php } } ?>

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
    </div>
  </div>

  <div class="col-xs-1">
    <a class="scroll_tabs" href="<?= base_url(); ?>index.php?finance/unpaid_invoices/<?= $year + 1; ?>"><i style="font-size: 60pt;" class="fa fa-plus-circle"></i></a>
  </div>
</div>
