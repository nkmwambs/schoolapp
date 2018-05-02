<?php
$activity = $this->db->get_where("activity",array("activity_id"=>$param2))->row();
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-plus-square"></i>
					<?php echo get_phrase('parents_activity');?>
            	</div>
            </div>
			<div class="panel-body">
				
				 <?php echo form_open(base_url() . 'index.php?admin/parent_activity/edit/' , array("id"=>"activity_form",'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('activity_name');?></label>
                        
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" value="<?=$activity->name;?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('description');?></label>
                        
						<div class="col-sm-8">
							<textarea name="description" class="form-control"  data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"><?=$activity->description;?></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('start_date');?></label>
                        
						<div class="col-sm-8">
							<input type="text" class="form-control datepicker" value="<?=$activity->start_date;?>" name="start_date" readonly="readonly" data-format="yyyy-mm-dd" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('end_date');?></label>
                        
						<div class="col-sm-8">
							<input type="text" class="form-control datepicker" value="<?=$activity->end_date;?>" name="end_date" readonly="readonly" data-format="yyyy-mm-dd" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-12">
							<div class="btn btn-primary btn-icon" id="submit"><i class="fa fa-plus-square-o"></i><?=get_phrase('edit');?></div>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>			

<script>
	$("#submit").on("click",function(ev){
		var errCnt = 0;
		
		$.each($(".form-control"),function(i,el){
			
			if($(el).val() === ""){
				errCnt++;
				$(el).css("border","1px red solid");
			}
		});
		
		if(errCnt>0){
			alert("You have " + errCnt + " empty fields!");
			ev.preventDefault();
			return false;
		} 
		
		//var data = $("#activity_form").serializeArray();
		//var url = "<?=base_url();?>index.php?admin/parent_activity/create";
		//$.ajax({
			//url:url,
			//data:data,
			//type:"POST",
			//success:function(){
				//alert("Record Created Successful");
			//}
		//});
		$("#activity_form").submit();
	});
</script>
		