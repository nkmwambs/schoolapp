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
				<a href="<?=base_url();?>index.php?parents/parent_activity" class="btn btn-primary"><?=get_phrase("back");?></a>
				<hr/>

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

				</div>

			</div>
		</div>
	</div>
</div>

<script>
	$("#search_btn").on("click",function(){
		var url = "<?=base_url();?>index.php?parents/parent_add_activity/search/"+$("#search_control").val()+"/<?=$activity_id;?>";
		$.ajax({
			url:url,
      beforeSend:function(){
          	$('#search_result').html('<div style="text-align:center;"><img style="width:60px;height:60px;" src="<?php echo base_url();?>uploads/preloader4.gif" /></div>');
      },
			success:function(response){
				$("#search_result").html(response);
			}
		});
	});


</script>
