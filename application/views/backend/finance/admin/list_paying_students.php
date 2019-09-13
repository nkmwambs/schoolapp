<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//print_r($result);
?>

<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title"><?php echo get_phrase($transaction_type.'_list');?>: <?=$current_transaction_date;?></div>
      </div>

    <div class="panel-body">
    <div class="row">
      <div class="col-xs-12">
        <table class="table table-striped datatable">
          <thead>
            <tr>
              <th><?=get_phrase('payee');?></th>
              <th><?=get_phrase('batch_number');?></th>
              <th><?=get_phrase('description');?></th>
              <th><?=get_phrase('amount');?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($result as $transaction){?>
              <tr>
                <td><?=$transaction->payee;?></td>
                <td><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_transaction/<?=$transaction->batch_number?>');"><?=$transaction->batch_number;?></a></td>
                <td><?=$transaction->description;?></td>
                <td><?=$transaction->cost;?></td>
              <tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
