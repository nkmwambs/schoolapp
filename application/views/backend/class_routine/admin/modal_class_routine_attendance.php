<?php 
$routine_attendance = $this->db->get_where("class_routine_attendance",array("class_routine_id"=>$param2,"attendance_date"=>$param3));

$notes = "";

if($routine_attendance->num_rows()>0){
	$notes = $routine_attendance->row()->notes;
}
//echo $param2;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-plus-square"></i>
					<?php echo get_phrase('class_routine_attendance');?>
            	</div>
            </div>
			<div class="panel-body">
				
				 <?php echo form_open(base_url() . 'index.php?Class_Routine/create_routine_attendance/'.$param2 , array("id"=>"frm_mark_routine",'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('attendance_date');?></label>
                        
						<div class="col-sm-8">
							<input type="text" value="<?=$param3;?>" class="form-control wanted datepicker" name="attendance_date" readonly="readonly" data-format="yyyy-mm-dd" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('notes');?></label>
                        
						<div class="col-sm-8">
							<textarea name="notes" class="form-control wanted" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"><?=$notes;?></textarea>
						</div>
					</div>
					
									
					<div class="form-group">
						<div class="col-sm-12">
							<div class="btn btn-primary btn-icon" id="submit"><i class="fa fa-plus-square-o"></i><?=get_phrase('mark');?></div>
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
		
		$.each($(".wanted"),function(i,el){
			
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
		
			var url = $("#frm_mark_routine").attr("action");
			var data  = $("#frm_mark_routine").serializeArray();
			
			$.ajax({
				url:url,
				data:data,
				type:"POST",
				beforeSend:function(){
					$('#routine_schedule').html('<div style="text-align:center;"><img style="width:60px;height:60px;" src="<?php echo base_url();?>uploads/preloader4.gif" /></div>');
				},
				success:function(response){
					$('#routine_schedule').html(response);
				},
				error:function(data, textStatus, jqXHR){
					alert("Error Occurred ".textStatus);
				}
			});
			

	});
</script>
		