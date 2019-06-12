<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="col-sm-12">
	<div class="well" style="text-align: center;"><?=get_phrase("year");?>:<?=date("Y",$timestamp);?></div>
</div>

<div class="col-sm-1">
	<a id="prev_year" title="<?=date('Y',strtotime("-1 Year",$timestamp))?>" href="#cleared"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
</div>
						
						<div class="col-sm-10">
								<table  class="table table-bordered datatable paid_invoices">
			                	<thead>
			                		<tr>
			                			<th>#</th>
			                    		<th><div><?php echo get_phrase('student');?></div></th>
			                    		<th><div><?php echo get_phrase('year');?></div></th>
			                            <th><div><?php echo get_phrase('fee_structure_total');?></div></th>
			                            <th><div><?php echo get_phrase('payable_amount');?></div></th>
			                            <th><div><?php echo get_phrase('balance');?></div></th>
			                    		<th><div><?php echo get_phrase('date');?></div></th>
										<th><div><?php echo get_phrase('action');?></div></th>
									</tr>
								</thead>
			                    <tbody>
			                    	<?php
			                    		$count = 1;
			                    		//$this->db->where('status' , 'paid');
			                    		//$this->db->order_by('creation_timestamp' , 'desc');
			                    		//$invoices = $this->db->get('invoice')->result_array();
			                    		foreach($paid_invoices as $row3):
			                    	?>
			                        <tr>
			                        	<td><?php echo $count++;?></td>
										<td><?php echo $this->crud_model->get_type_name_by_id('student',$row3['student_id']);?></td>
										<td><?php echo $row3['yr'];?></td>
										<td><?php echo $row3['amount'];?></td>
			                            <td><?php echo $row3['amount_due'];?></td>
			                            <?php
			                            	$bal = $row3['amount_due'] - $row3['amount_paid']; 
			                            ?>
			                            <td><?php echo $bal;?></td>
										<td><?php echo date('d M,Y', $row3['creation_timestamp']);?></td>
										<td>
											<div class="btn-group">
			                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			                                    Action <span class="caret"></span>
			                                </button>
			                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
			
			
			                                    <li>
			                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row3['invoice_id'];?>');">
			                                            <i class="entypo-bookmarks"></i>
			                                                <?php echo get_phrase('view_history');?>
			                                        </a>
			                                    </li>
			
			                                </ul>
			                            </div>
										</td>
			                        </tr>
			                        <?php endforeach;?>
			                    </tbody>
			                </table>		
						</div>
						
						
<div class="col-sm-1">
	<a id="next_year" title="<?=date('Y',strtotime("+1 Year",$timestamp))?>" href="#cleared"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
</div>

<script>
		var datatable = $(".paid_invoices").dataTable({
			"sPaginationType": "bootstrap",
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
		$("#prev_year, #next_year").click(function(){

			var url = "<?=base_url();?>index.php?finance/paid_invoice_scroll/<?=strtotime('-1 year',$timestamp);?>";
			if($(this).attr('id')=='next_year'){
				url = "<?=base_url();?>index.php?finance/paid_invoice_scroll/<?=strtotime('+1 year',$timestamp);?>";
			}
			
			$.ajax({
				url:url,
				beforeSend:function(){
					
				},
				success:function(resp){
					$("#paid_invoices_placeholder").html(resp);
				},
				error:function(){
					
				}	
			});
			
		});
</script>