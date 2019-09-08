<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$structure_details = $this->db->order_by('pay_order')->get_where('fees_structure_details', array('fees_id' => $param2))->result_array();

//check if the first element has pay_order zero
// Reset the pay order numbers if this is TRUE

if($structure_details[0]['pay_order'] == 0){
  $order = 1;
  foreach ($structure_details as $detail) {
    $this->db->update('fees_structure_details',
    array('pay_order'=>$order),array('detail_id'=>$detail['detail_id']));
    $order++;
  }

  $structure_details = $this->db->order_by('pay_order')->get_where('fees_structure_details', array('fees_id' => $param2))->result_array();

}

?>
<center>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Fees Structure
        <i class="entypo-print"></i>
    </a>
</center>

    <br><br>

    <div id="invoice_print">
<table class="table table-bordered datatable" id="table_export">
<?php
	$structure = $this->db->get_where("fees_structure",array("fees_id"=>$param2))->row()->name;
?>
<caption><?php echo ucwords(str_replace("_", " ", $structure));?></caption>
    <thead>
        <tr>
          <th><div><?=get_phrase('pay_order');?></div></th>
        	<th><div><?php echo get_phrase('action');?></div></th>
            <th><div><?php echo get_phrase('name');?></div></th>
            <th><div><?php echo get_phrase('amount');?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php
        	//$fees = $this->db->get_where('fees_structure_details',array("fees_id"=>$param2))->result_array();
        	$sum =0;
        	foreach ($structure_details as $row):
        ?>
        <tr>
          <td>
            <i data-detailid = "<?=$row["detail_id"];?>" data-order = "<?=$row["pay_order"];?>" style="cursor:pointer;" class="fa fa-angle-double-up move_up move"></i> &nbsp;&nbsp;
            <i data-detailid = "<?=$row["detail_id"];?>" data-order = "<?=$row["pay_order"];?>" style="cursor:pointer;" class="fa fa-angle-double-down move_down move"></i>
          </td>
        	<td>
        		<div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-left" role="menu">

                        <!-- Fee Structure Edit Link -->
                        <li>
                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_structure_details_edit/<?php echo $row['detail_id'];?>');">
                            	<i class="entypo-pencil"></i>
									<?php echo get_phrase('edit');?>
                               	</a>
                        				</li>

                        <li class="divider"></li>

                        <!-- DELETION LINK -->
                        <li>
                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?finance/fees_structure_details/delete/<?php echo $row['detail_id'];?>');">
                            	<i class="entypo-trash"></i>
									<?php echo get_phrase('delete');?>
                               	</a>
                        				</li>
                    </ul>
                </div>
        	</td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo number_format($row['amount'],2);?></td>

        </tr>
        <?php

        	$sum+=$row['amount'];
        	endforeach;
        ?>
        <tr><td colspan="3"><?=get_phrase('total');?></td><td><?=number_format($sum,2);?></td></tr>
    </tbody>
</table>

    </div>
<?php //endforeach; ?>


<script type="text/javascript">
$(".move").click(function(){
    var selected_row = $(this).closest('tr');
    var selected_row_index =  selected_row.index();
    var self_order = $(this).attr('data-order');
    var next_row_order = selected_row.next().find('.move').attr('data-order') == undefined?-1:selected_row.next().find('.move').attr('data-order');
    var prev_row_order = selected_row.prev().find('.move').attr('data-order') == undefined?0:selected_row.prev().find('.move').attr('data-order');
    var self_detail_id = $(this).attr('data-detailid');
    var next_row_detailid = selected_row.next().find('.move').attr('data-detailid') == undefined?-1:selected_row.next().find('.move').attr('data-detailid');
    var prev_row_detailid = selected_row.prev().find('.move').attr('data-detailid') == undefined?-1:selected_row.prev().find('.move').attr('data-detailid');

    if($(this).hasClass('move_up')){
      if(prev_row_order !== 0){
        change_pay_order(selected_row,'before',self_order,self_detail_id,prev_row_order,prev_row_detailid);
      }else{
        alert('You can\'t mode the first row up');
      }
    }else{
      if(next_row_order !== -1){
        change_pay_order(selected_row,'after',self_order,self_detail_id,next_row_order,next_row_detailid);
      }else{
        alert('You can\'t mode the last row down');
      }
    }
});

function change_pay_order(selected_row,insertAction,self_order,self_detail,relative_order,relative_detailid){
  var url = "<?=base_url();?>index.php?finance/change_pay_order";

  var data = {'insertAction':insertAction,'self':{self_order,self_detail},'relative':{relative_order,relative_detailid}};

  $.ajax({
    url:url,
    data:data,
    type:"POST",
    beforeSend:function(){

    },
    success:function(resp){
      //alert(resp);
      if(insertAction == 'after'){
        selected_row.insertAfter(selected_row.next());
      }else{
        selected_row.insertBefore(selected_row.prev());
      }
    },
    error:function(){

    }
  });

}

</script>
