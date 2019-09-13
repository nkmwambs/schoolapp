<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row" style="margin-bottom:25px;">
  <div class="col-xs-12">
    <?php echo form_open(base_url() . 'index.php?finance/daily_reports/'.$month ,
      array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

      <div class="form-group">
        <label class="control-label col-xs-2"><?=get_phrase('choose_summary_type');?></label>
        <div class="col-xs-3">
          <select class="form-control" name="transaction_type">
              <option value=""><?=get_phrase('select');?></option>
              <option value="income" <?php if($transaction_type == 'income') echo "selected";?> ><?=get_phrase('income');?></option>
              <option value="expense" <?php if($transaction_type == 'expense') echo "selected";?> ><?=get_phrase('expense');?></option>
          </select>
        </div>

        <div class="col-xs-2">
            <input type="submit" class="btn btn-default" value="<?=get_phrase('go');?>" />
        </div>

      </div>

    </form>
  </div>
</div>

<div class="row">

  <div class="col-xs-12 text-center" style="font-weight:bold;margin:25px;">
      Daily Collection and Expense Report for <?=date('F Y',$month);?>
  </div>

  <div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/daily_reports/<?=strtotime('-1 month',$month);?>"><i style="font-size: 60pt;" class="fa fa-minus-circle"></i></a>
	</div>
  <div class="col-xs-10">

    <table class="table table-bordered datatable">
        <thead>
          <tr>
              <th rowspan="2"><?=get_phrase('date');?></th>
              <th rowspan="2"><?=get_phrase('total');?></th>
              <th colspan="<?=count($income_categories);?>"><?=get_phrase('account');?></th>

          </tr>
          <tr>
            <?php
              foreach($income_categories as $category){
            ?>
              <th nowrap="nowrap"><?=$category->name;?></th>
            <?php
              }
             ?>

          </tr>
        </head>
        <tbody>
            <?php
              $grand_total = 0;
              foreach($transactions as $date=>$transaction){
            ?>
              <tr>
                <td nowrap="nowrap">
                  <?=$date;?>
                  <a target="_blank" href="<?=base_url();?>index.php?finance/list_paying_students/<?=strtotime($date);?>/<?=$transaction_type;?>"><i class="fa fa-print"></i></a>
                </td>

                <?php $grand_total+=array_sum($transaction);?>

                <td style="text-align:right;"><?=number_format(array_sum($transaction),2);?></td>
                <?php foreach($income_categories as $category){ ?>
                    <td  style="text-align:right;"><?=number_format(isset($transaction[$category->name])?$transaction[$category->name]:0,2);?></td>
                <?php }?>
              </tr>
            <?php
              }
            ?>
        </tbody>
        <tfoot>
          <tr>
            <th><?=get_phrase('total');?></th>
            <th><?=number_format($grand_total,2);?></th>
            <?php foreach($income_categories as $category){ ?>
                <th style="text-align:right;"><?=number_format(array_sum(array_column($transactions,$category->name)),2);?></th>
            <?php }?>
          </tr>
        </tfoot>
    </table>
  </div>
  <div class="col-sm-1">
		<a href="<?=base_url();?>index.php?finance/daily_reports/<?=strtotime('+1 month',$month);?>"><i style="font-size: 60pt;" class="fa fa-plus-circle"></i></a>
	</div>
</div>
