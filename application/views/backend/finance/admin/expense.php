<div class="row">
	<div class="col-sm-12">
		<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_expense_add/');" 
			class="btn btn-primary pull-right add_expense">
			<i class="entypo-plus-circled"></i>
			<?php echo get_phrase('add_new_expense');?>
		</a> 		
	</div>
</div>

<br />

<div class="row" id="expense_placeholder">
	<div class="col-sm-1">
		<a id="prev_year" title="<?=date('Y',strtotime("-1 Year"))?>" href="#"><i style="font-size: 145pt;" class="fa fa-angle-left"></i></a>
	</div>
	
	<div class="col-sm-10">
		<table class="table table-bordered datatable" id="table_export">
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
					foreach($expenses as $row):
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
								               	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_expense/<?=$row->batch_number;?>');">
								                   	<i class="fa fa-eye-slash"></i>
														<?php echo get_phrase('view');?>
								               	</a>
								             </li>
								             <li class="divider"></li>
								                        
								             <!--Reverse Batch Link -->
								             <li class="reverse_expense">
								                 <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?finance/expense/reverse/<?=$row->expense_id?>');">
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
		<a id="next_year" title="<?=date('Y',strtotime("+1 Year"))?>" href="#"><i style="font-size: 145pt;" class="fa fa-angle-right"></i></a>
	</div>
</div>







<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [
					
					{
						"sExtends": "xls",
						"mColumns": [1,2,3,4,5]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1,2,3,4,5]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(0, false);
							datatable.fnSetColumnVis(6, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(0, true);
									  datatable.fnSetColumnVis(6, true);
								  }
							});
						},
						
					},
				]
			},
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
	
	
	$("#prev_year, #next_year").click(function(){

			var url = "<?=base_url();?>index.php?finance/expense_scroll/<?=strtotime('-1 year');?>";
			if($(this).attr('id')=='next_year'){
				url = "<?=base_url();?>index.php?finance/expense_scroll/<?=strtotime('+1 year');?>";
			}
			
			$.ajax({
				url:url,
				beforeSend:function(){
					
				},
				success:function(resp){
					$("#expense_placeholder").html(resp);
				},
				error:function(){
					
				}	
			});
			
		});
		
</script>

