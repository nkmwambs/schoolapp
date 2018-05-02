<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-trophy"></i>
					<?php echo get_phrase('parents_activity');?>
            	</div>
            </div>
			<div class="panel-body">
				
				
				<hr/>
				<table class="table table-striped" id="table_export">
					<thead>
						<tr>
							<th><?=get_phrase('activity_name');?></th>
							<th><?=get_phrase('description');?></th>
							<th><?=get_phrase('start_date');?></th>
							<th><?=get_phrase('end_date');?></th>
							<th><?=get_phrase('action');?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($activities as $activity):?>
							<tr>
								<td><?=$activity->name;?></td>
								<td><?=$activity->description;?></td>
								<td><?=$activity->start_date;?></td>
								<td><?=$activity->end_date;?></td>
								<td>
									
									<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <?=get_phrase('action');?> <span class="caret"></span>
                                    </button>
	                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
	
	                                        <!-- STUDENT MARKSHEET LINK  -->
	                                        <li>
	                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_activity_edit/<?php echo $activity->activity_id;?>');">
	                                                <i class="fa fa-edit"></i>
	                                                    <?php echo get_phrase('edit');?>
	                                                </a>
	                                        </li>
	                                        
	                                        <li class="divider"></li>
	                                        
	                                        <li>
	                                            <a href="#" onclick="show_attendance(this);" id="<?php echo $activity->activity_id;?>">
	                                                <i class="fa fa-check"></i>
	                                                    <?php echo get_phrase('show_attendance');?>
	                                                </a>
	                                        </li>
	                                        
	                                      </ul>
                                      </div>  
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
				<hr />
				
				<div class="row">
					<div class="col-sm-12" id="activity_register" style="display: none;">
						
						<div class="row">
							<div class="col-sm-12">
								<div class="btn btn-info pull-right" id="mark_attendance"><?=get_phrase("mark_attendance");?></div>
							</div>
							
							<div class="col-sm-12">
								<div style="text-align: center;color:green;font-weight:bold;" id="register_message"></div>
							</div>
						</div>
						
						<hr />
						
						<div class="row">
							<div class="col-sm-12">
								<div id="load_register"><!--Register is here-->	</div>
								
							</div>
						</div>		
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>	

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
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(1, false);
							datatable.fnSetColumnVis(5, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(1, true);
									  datatable.fnSetColumnVis(5, true);
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
	
	function show_attendance(elem){
		
		var url = "<?=base_url();?>index.php?admin/load_activity_register/"+$(elem).attr("id");
		
		$.ajax({
			url:url,
			beforeSend:function(){
				$("#activity_register").css("display","block");
				$('#load_register').html('<div style="text-align:center;"><img style="width:60px;height:60px;" src="<?php echo base_url();?>uploads/preloader4.gif" /></div>');
			},
			success:function(response){
				
				$("#load_register").html(response);
				$('#register_message').html('');
				$("#frm_activity_register").prop('action',$("#frm_activity_register").attr('action')+$(elem).attr('id'))
			},
			error:function(){
				alert("Error Occurred");
			}
		});
		
		
	}		
	
	$("#mark_attendance").click(function(){
		var url = $("#frm_activity_register").attr('action');
		var data = $("#frm_activity_register").serializeArray();
		//alert(url);
		$.ajax({
			url:url,
			data:data,
			type:"POST",
			beforeSend:function(){
				$('#register_message').html('<div style="text-align:center;"><img style="width:60px;height:60px;" src="<?php echo base_url();?>uploads/preloader4.gif" /></div>');
			},
			success:function(response){
				$('#register_message').html(response);
			},
			error:function(){
				alert("Error Occurred");
			}
		});
	});
</script>		