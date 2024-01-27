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

<p></p>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('year');?> <?=$year;?>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-xs-1">
		<a href="<?= base_url(); ?>index.php?finance/overpaid_invoices/<?= $year - 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>

  <div class="col-xs-10">
    <div class="row">
      <div class="col-xs-12">
            <div class="panel panel-default panel-shadow" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo get_phrase('overpaid_invoices');?></div>
                  </div>

                <div class="panel-body">
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
            </div>
        </div>
    </div>
  </div>

  <div class="col-xs-1">
    <a href="<?= base_url(); ?>index.php?finance/overpaid_invoices/<?= $year + 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
  </div>
</div>
