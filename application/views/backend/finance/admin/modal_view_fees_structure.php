<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$structure_details = $this->db->get_where('fees_structure_details', array('fees_id' => $param2))->result_array();
//foreach ($edit_data as $row):
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
        <tr><td colspan="2"><?=get_phrase('total');?></td><td><?=number_format($sum,2);?></td></tr>
    </tbody>
</table>

    </div>
<?php //endforeach; ?>


<script type="text/javascript">


</script>