<style>
  .connectedSortable{
    border: 1px solid #eee;
    width: 342px;
    min-height: 60px;
    list-style-type: none;
    margin-top: 10px;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
  .connectedSortable li  {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1.2em;
    width: auto;
  }
 </style>
  
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-plus-square"></i>
					<?php echo get_phrase('add_parents');?>
            	</div>
            </div>
			<div class="panel-body">
				
				<div class="row">
					<div class="col-sm-6">
						<div class="row">
							<div class="well-sm col-sm-12">
								<span style="font-weight: bold;text-decoration: underline'"><?=get_phrase("activity_details");?></span><br />
							<?php
								$activity_id = $this->uri->segment(3);
								$activity = $this->db->get_where('activity',array('activity_id'=>$activity_id))->row();
							?>
								<span style="font-weight: bold;"><?=get_phrase("activity_name");?></span>: <?=$activity->name;?><br />
								<span style="font-weight: bold;"><?=get_phrase("description");?></span>: <?=$activity->description;?><br />
								<span style="font-weight: bold;"><?=get_phrase("start_date");?></span>: <?=$activity->start_date;?><br />
								<span style="font-weight: bold;"><?=get_phrase("end_date");?></span>: <?=$activity->end_date;?><br />
							</div>
						</div>	
						
						<hr />
						<div class="row">
							<div class="col-sm-12">	
								<form id="search_form">
									<div class="form-group">
										
										<label for="" class="col-sm-4"><?=get_phrase('search_parents_by');?></label>
										<div class="col-sm-5">
											<select id="search_control" class="form-control select2" name="search">
												<option value="0"><?=get_phrase("All");?></option>
												<?php
													$classes = $this->crud_model->get_classes();
													
													foreach($classes as $row):
												?>
														<option value="<?=$row['class_id'];?>"><?=$row['name'];?></option>										
												<?php
													endforeach;
												?>
											</select>
										</div>
										
										<div class="col-sm-3">
											<div id="search_btn" class="btn btn-primary btn-icon"><i class="fa fa-arrow-circle-o-right"></i><?=get_phrase('go');?></div>
										</div>
									</div>
								</form>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12" id="search_result">
								
							</div>
						</div>
						
					</div>
					
					<div class="col-sm-6">
						<div class="col-sm-12" id="attendance_plan">
							<ul id="sortable_attendance_plan" class="connectedSortable">
								
							</ul>
							
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>			

<script>
	$("#search_btn").on("click",function(){
		var url = "<?=base_url();?>index.php?admin/parent_add_activity/search/"+$("#search_control").val();
		$.ajax({
			url:url,
			success:function(response){
				$("#search_result").html(response);
			}
		});
	});
	
$( function() {
	    $( "#sortable_search_result, #sortable_attendance_plan" ).sortable({
	      connectWith: ".connectedSortable",
	      opacity: 0.35,
	      cursor: "crosshair",
	      helper:"clone"
	    });

    });

</script>