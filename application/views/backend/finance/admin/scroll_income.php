<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="col-sm-12">
	<div class="well" style="text-align: center;"><?=get_phrase("year");?>:<?=date("Y",$timestamp);?></div>
</div>

<div class="col-sm-1">
		<a id="prev_year" title="<?=date('Y',strtotime("-1 Year",$timestamp))?>" href="#"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>

	<div class="col-sm-10">
		<table class="table table-bordered datatable" id="payments">
	    <thead>
	        <tr>
	            <th><div><?php echo get_phrase('date');?></div></th>
	            <th><div><?php echo get_phrase('batch_number');?></div></th>
	            <th><div><?php echo get_phrase('title');?></div></th>
	            <th><div><?php echo get_phrase('method');?></div></th>
	            <th><div><?php echo get_phrase('amount');?></div></th>
	            <th><div><?php echo get_phrase('options');?></div></th>
	        </tr>
	    </thead>
	    <tbody>
			<?php
				foreach($payments as $row):
			?>
	       		<tr>
	       			<td><?=$row->t_date;?></td>
	       			<td><?=$row->batch_number;?></td>
	       			<td><?=$row->description;?></td>
	       			<td><?=$this->db->get_where('accounts',array('accounts_id'=>$row->method))->row()->name;?></td>
	       			<td><?=$row->amount;?></td>
	       			<td>
	       				<div class="btn-group">
							 <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
							        Action <span class="caret"></span>
							 </button>
							       <ul class="dropdown-menu dropdown-default pull-right" role="menu">
							                        
							            <!-- View Bath Link -->
							            <li>
							               	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_income/<?=$row->batch_number;?>');">
							                   	<i class="fa fa-eye-slash"></i>
													<?php echo get_phrase('view');?>
							               	</a>
							             </li>
							             <li class="divider"></li>
							                        
							             <!--Reverse Batch Link -->
							             <li class="reverse_none_student_income">
							                 <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/income/reverse/<?=$row->payment_id?>');">
							                     <i class="fa fa-refresh"></i>
													<?php echo get_phrase('reverse');?>
							                  </a>
							             </li>
							        </ul>
							</div>
	       			</td>
	       		</tr>
	       
	       <?php
			endforeach;
			?>
	    </tbody>
	</table>		
	</div>
	
	<div class="col-sm-1">
		<a id="next_year" title="<?=date('Y',strtotime("+1 Year",$timestamp))?>" href="#"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
	
<script>
		var datatable = $("#payments").dataTable({
			"sPaginationType": "bootstrap",
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
			$("#prev_year, #next_year").click(function(){

			var url = "<?=base_url();?>index.php?finance/income_scroll/<?=strtotime('-1 year',$timestamp);?>";
			if($(this).attr('id')=='next_year'){
				url = "<?=base_url();?>index.php?finance/income_scroll/<?=strtotime('+1 year',$timestamp);?>";
			}
			
			$.ajax({
				url:url,
				beforeSend:function(){
					
				},
				success:function(resp){
					$("#income_placeholder").html(resp);
				},
				error:function(){
					
				}	
			});
			
		});
</script>