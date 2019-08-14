<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<p></p>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;font-size: 18pt;">
		<?=get_phrase('year');?> <?=$year;?>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/scroll_fees_structure/<?=$year - 1;?>"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	<div class="col-xs-10">
		<a href="<?php echo base_url();?>index.php?finance/fees_structure_add/"
			class="btn btn-primary pull-right add_fees_structure">
			<i class="entypo-plus-circled"></i>
			<?php echo get_phrase('add_new_fees_structure');?>
			</a>
			<br><br>
			<table class="table table-striped datatable" id="table_export">
			    <thead>
			        <tr>
			            <th><div><?php echo get_phrase('name');?></div></th>
			            <th><div><?php echo get_phrase('class');?></div></th>
			            <th><div><?php echo get_phrase('year');?></div></th>
			            <th><div><?php echo get_phrase('invoice_count');?></div></th>
			            <th><div><?php echo get_phrase('term');?></div></th>
			            <th><div><?php echo get_phrase('amount_payable');?></div></th>
			            <th><div><?php echo get_phrase('options');?></div></th>
			        </tr>
			    </thead>
			    <tbody>
			        <?php
			        	$count = 1;
			        	//$fees = $this->db->get('fees_structure')->result_array();
			        	foreach ($fees as $row):

						$term = $this->db->get_where('terms',array('term_number'=>$row['term']))->row();
			        ?>
			        <tr>
			            <td><?php echo ucwords(str_replace("_", " ", $row['name']));?></td>
			            <td><?php echo $this->crud_model->get_class_name($row['class_id']);?></td>
			            <td><?php echo $row['yr'];?></td>
			            <?php $count = $this->db->get_where('invoice',array('class_id'=>$row['class_id'],'term'=>$term->terms_id,'yr'=>$row['yr']))->num_rows();?>
			            <td><?=$count;?></td>
			            <td><?php echo $term->name;?></td>
			            <td><?=number_format($this->db->select_sum('amount')->get_where('fees_structure_details',array('fees_id'=>$row['fees_id']))->row()->amount,2);?></td>
			            <td>

			                <div class="btn-group">
			                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			                        Action <span class="caret"></span>
			                    </button>
			                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

			                        <!-- Fee Structure Edit Link -->
			                        <li class="edit_fee_structure">
			                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_fees_structure_edit/<?php echo $row['fees_id'];?>');">
			                            	<i class="entypo-pencil"></i>
												<?php echo get_phrase('edit');?>
			                               	</a>
			                        				</li>
			                        <li class="divider edit_fee_structure"></li>

			                        <!-- Add Fees Structure Details -->
			                         <!-- <li class="add_fee_structure_item">
			                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_fees_structure_details_add/<?php echo $row['fees_id'];?>');">
			                            	<i class="entypo-book-open"></i>
												<?php echo get_phrase('add_item');?>
			                               	</a>
			                        </li> -->
			                        <!-- <li class="divider add_fee_structure_item"></li> -->

									<li class="add_fee_structure_item">
			                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_fees_structure_multi_details_add/<?php echo $row['fees_id'];?>');">
			                            	<i class="entypo-book-open"></i>
												<?php echo get_phrase('add_items');?>
			                               	</a>
			                        </li>
			                        <li class="divider add_fee_structure_item"></li>

			                        <!-- VIEW FEES STRUCTURE DETAILS -->

			                          <li>
			                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_fees_structure/<?php echo $row['fees_id'];?>');">
			                            	<i class="entypo-eye"></i>
												<?php echo get_phrase('view_fees_structure');?>
			                               	</a>
			                        				</li>
			                        <li class="divider"></li>

			                        <!-- Clone Structure Details -->
			                        <li class="add_fees_structure">
			                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_structure_clone/<?php echo $row['fees_id'];?>');">
			                            	<i class="entypo-cc"></i>
												<?php echo get_phrase('clone_fees_structure');?>
			                               	</a>
			                        </li>

			                        <li class="divider add_fees_structure"></li>
			                        <?php if($count == 0) {?>
			                        <!-- DELETION LINK -->
			                        <li class="delete_fee_structure">
			                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?finance/fees_structure/delete/<?php echo $row['fees_id'];?>');">
			                            	<i class="entypo-trash"></i>
												<?php echo get_phrase('delete');?>
			                               	</a>
			                        </li>
			                        <?php
									}
			                        ?>
			                    </ul>
			                </div>

			            </td>
			        </tr>
			        <?php endforeach;?>
			    </tbody>
			</table>
	</div>

	<div class="col-xs-1">
		<a href="<?=base_url();?>index.php?finance/scroll_fees_structure/<?=$year + 1;?>"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
</div>




<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{

	});

</script>
