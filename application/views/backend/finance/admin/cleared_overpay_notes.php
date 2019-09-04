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
		<a href="<?= base_url(); ?>index.php?finance/cleared_overpay_notes/<?= $year - 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>

  <div class="col-xs-10">
    <div class="row">
      <div class="col-xs-12">
            <div class="panel panel-default panel-shadow" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo get_phrase('cleared_overpay_notes');?></div>
                  </div>

                <div class="panel-body">
                  <table class="table table-bordered datatable example">
  							    <thead>
  							        <tr>
  							            <th><div>#</div></th>
  							            <th><div><?php echo get_phrase('student'); ?></div></th>
  														<th><div><?php echo get_phrase('class'); ?></div></th>
  							            <th><div><?php echo get_phrase('amount'); ?></div></th>
  							            <th><div><?php echo get_phrase('balance'); ?></div></th>
  							            <th><div><?php echo get_phrase('description'); ?></div></th>
  							            <th><div><?php echo get_phrase('status'); ?></div></th>
  							            <th><div><?php echo get_phrase('date'); ?></div></th>

  							        </tr>
  							    </thead>
  							    <tbody>
  							    	<?php
  																				$this->db->join('student','overpay.student_id=student.student_id');
  																			  $notes_object = $this->db->get_where("overpay", array("status"=>"cleared"));

                                          if ($notes_object->num_rows() > 0) {
                                              $cnt = 1;
                                              foreach ($notes_object->result_object() as $row) {
                                                  ?>
  							    			<tr>
  							    				<td><?=$cnt; ?></td>
  							    				<td><?= $this -> crud_model -> get_type_name_by_id("student", $row -> student_id); ?></td>
  																										<td><?php echo $this -> crud_model -> get_type_name_by_id('class', $row -> class_id); ?></td>
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
    </div>
  </div>

  <div class="col-xs-1">
    <a href="<?= base_url(); ?>index.php?finance/cleared_overpay_notes/<?= $year + 1; ?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
  </div>
</div>
