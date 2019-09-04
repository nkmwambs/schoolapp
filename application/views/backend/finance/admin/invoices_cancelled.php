<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
?>

<style>
.hidden-xs{
	font-size:8pt;
}

</style>

<div class="row">
	<div class="col-xs-1">
		<a href="<?= base_url(); ?>index.php?finance/cancelled_invoices/<?= $year - 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>

  <div class="col-xs-10">
    <div class="row">
      <div class="col-xs-12">
            <div class="panel panel-default panel-shadow" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo get_phrase('cancelled_invoices');?></div>
                  </div>

                <div class="panel-body">
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
    </div>
  </div>

  <div class="col-xs-1">
    <a href="<?= base_url(); ?>index.php?finance/cancelled_invoices/<?= $year + 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
  </div>
</div>
