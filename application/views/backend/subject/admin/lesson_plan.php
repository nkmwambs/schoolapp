<hr/>
<?php
//print_r($class_routine);
?>

<style>
	.on_signal{
		border: 2px green solid;
	}
	
	.off_signal{
		border: 1px gray solid;
	}
</style>

<div class="row">
	<div class="col-xs-12">
		<a href="<?=base_url();?>index.php?subject/edit_lesson_plan/<?=$scheme_id;?>" class="btn btn-info"><?=get_phrase('edit_lesson_plan');?></a>
	</div>
</div>

<p></p>
<div class="row">
	<div class="col-xs-12">
				
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><?=get_phrase('school');?></th>
					<th><?=get_phrase('subject');?></th>
					<th><?=get_phrase('class');?></th>
					<th><?=get_phrase('planned_date');?></th>
					<th><?=get_phrase('attendance_date');?></th>
					<th><?=get_phrase('time');?></th>
					<th><?=get_phrase('class_roll');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?=$system_title;?></td>
					<td><?=$lesson_plan->subject;?></td>
					<td><?=$lesson_plan->class_name;?></td>
					<td><?=$lesson_plan->planned_date;?></td>
					<td><input type="text" id="attendance_date" readonly="readonly" class="form-control" 
						value="<?php if($lesson_plan->attendance_date !== '0000-00-00') echo $lesson_plan->attendance_date;?>"/></td>
					<td>
						<select class="form-control" id="class_routine_id" onchange="get_the_date_of_the_day(this);">
							<option value=""><?=get_phrase('select');?></option>
							<?php
								foreach($class_routine as $row){
							?>
								<option value="<?=$row->class_routine_id;?>" <?php if($row->class_routine_id == $lesson_plan->class_routine_id ) echo "selected";?>><?=$row->time_start;?>:<?=$row->time_start_min;?> - <?=$row->time_end;?>:<?=$row->time_end_min;?> (<?=$row->day;?>)</option>
							<?php
								}
							?>
						</select>
					</td>
					<td><?=$lesson_plan->roll;?></td>
				</tr>
				
				<tr><td style="border-left: 1px white solid;border-right: 1px white solid;" colspan="7"></td></tr>
				
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('strand')?></td>
					<td colspan="6"><?=$lesson_plan->strand;?></td>
				</tr>
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('sub_strand')?></td>
					<td colspan="6"><?=$lesson_plan->sub_strand;?></td>
				</tr>
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('specific_learning_outcomes')?></td>
					<td colspan="6"><?=$lesson_plan->learning_outcomes;?></td>
				</tr>
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('learning_resources')?></td>
					<td colspan="6"><?=$lesson_plan->learning_resources;?></td>
				</tr>
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('core_competencies,values,PCIs')?></td>
					<td colspan="6"><?=$lesson_plan->core_competencies;?></td>
				</tr>
				
				<tr>
					<td style="border-left: 1px white solid;border-right: 1px white solid;text-align: center;font-weight: bold;" colspan="7">
						<?=get_phrase('organization_of_learning');?>
					</td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('introduction')?></td>
					<td colspan="6"><?=$lesson_plan->introduction;?></td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('lesson_development')?></td>
					<td colspan="6"><?=$lesson_plan->lesson_development;?></td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('conclusion')?></td>
					<td colspan="6"><?=$lesson_plan->conclusion;?></td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('summary')?></td>
					<td colspan="6"><?=$lesson_plan->summary;?></td>
				</tr>
				
				<tr>
					<td style="border-left: 1px white solid;border-right: 1px white solid;text-align: center;font-weight: bold;" colspan="7">
						<?=get_phrase('reflection_on_the_lesson');?>
					</td>
				</tr>
				
				<tr>
					<td colspan="7"><textarea id="reflection" onkeyup="post_lesson_plan_reflection();" class="form-control off_signal" rows="10"><?=$lesson_plan->reflection;?></textarea></td>
				</tr>
				
				<tr>
					<td style="border-left: 1px white solid;border-right: 1px white solid;text-align: center;font-weight: bold;" colspan="7">
						<?=get_phrase('signing_off');?>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('signed_off_by')?></td>
					<td colspan="6"><?=$lesson_plan->signed_off_by;?></td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;"><?=get_phrase('signed_off_date')?></td>
					<td colspan="6"><?=$lesson_plan->signed_off_date;?></td>
				</tr>
				
				
			</tbody>
		</table>
	</div>
</div>

<script>
	
	function get_the_date_of_the_day(elem){
		var class_routine_id = $(elem).val();
		var url = "<?=base_url();?>index.php?subject/get_date_of_class_routine/"+class_routine_id;
		
		if($("#reflection").val() == "") {
			alert('Please fill in the reflection on the lesson before marking the attendance date!');
			$('#class_routine_id').val("");
			return false;
		}
		
		$.ajax({
			url:url,
			success:function(resp){
				$("#attendance_date").val(resp);
				
				post_attendance_date_and_routine_id($("#attendance_date").val(),class_routine_id);
				
			},
			error:function(){
				alert('Error occurred!');
			}
		})
		
	}
	
	function post_attendance_date_and_routine_id(attendance_date,class_routine_id){
		var lesson_plan_id = "<?=$lesson_plan->lesson_plan_id;?>";
		var url = "<?=base_url();?>index.php?subject/post_attendance_date_and_routine_id";
		
		var data = {'attendance_date':attendance_date,'class_routine_id':class_routine_id,'lesson_plan_id':lesson_plan_id}
		//alert(attendance_date);
		$.ajax({
			url:url,
			data:data,
			type:"POST",
			success:function(){
				
			},
			error:function(){
				alert('Error occurred!');
			}
		});
	}
	
	function post_lesson_plan_reflection(){
		var lesson_plan_id = "<?=$lesson_plan->lesson_plan_id;?>";
		var url = "<?=base_url();?>index.php?subject/post_lesson_plan_reflection";
		
		var data = {'lesson_plan_id':lesson_plan_id,'reflection':$("#reflection").val()}
		
		$.ajax({
			url:url,
			data:data,
			type:"POST",
			success:function(){
				$("#reflection").toggleClass('on_signal off_signal');
			},
			error:function(){
				alert('Error occurred!');
			}
		})
	
	}
	
</script>
	