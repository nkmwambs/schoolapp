<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

// echo json_encode($transitioned_invoices);
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
  <div class="col-xs-12">
    <div class="row">
      <div class="col-xs-12">
            <div class="panel panel-default panel-shadow" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo get_phrase('transitioned_invoices');?></div>
                  </div>

                <div class="panel-body">
                  <table  class="table table-striped datatable">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('admission_number'); ?></th>
                            <th><div><?php echo get_phrase('student'); ?></div></th>
                            <th><div><?php echo get_phrase('year'); ?></div></th>
                            <th><div><?php echo get_phrase('term'); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                            <th><div><?php echo get_phrase('balance'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                  </tr>
                </thead>
                          <tbody>
                            <?php
                                  $count = 1;

                                  foreach ($transitioned_invoices as $row):?>
                              <tr>
                                <td><?php echo $row['invoice_id']; ?></td>
                                <td><?php echo $row['roll'];?></td>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['yr']; ?></td>
                                <td><?php echo $row['term']; ?></td>
                                <td><?php echo $row['class_name'];?></td>
                                <td><?php echo number_format($row['amount_due'], 2); ?></td>
                

                            <td>
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                          <?= get_phrase('action'); ?> <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-default pull-right" role="menu">


                                          <?php if ($row['amount_due'] != 0):?>

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
</div>

<script>
    
</script>