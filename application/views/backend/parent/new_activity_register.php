<?php

$check_attendance = $this->db->get_where("activity_attendance",array("activity_id"=>$record->activity_id))->num_rows();

?>

<div class="row" style="text-align: center;">
	<div class="col-sm-12">
		<span style="font-weight: bolder;font-size: 12pt;"><?=$record->name;?></span>
	</div>
	<div class="col-sm-12">
		<span style="font-weight: bold;font-size: 10pt;"><?=$record->description;?></span>
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<?php echo form_open(base_url() . 'index.php?parents/mark_parent_activity_attendance/' , array('id'=>'frm_activity_register', 'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th><?=get_phrase('parent_name');?></th>
						<th><?=get_phrase('students');?></th>
						<th><?=get_phrase('attendance');?></th>
					</tr>
				</thead>

				<tbody>
					<?php
						$this->db->join("parent","parent.parent_id=activity_attendance.parent_id");
						$parents = $this->db->get_where('activity_attendance',array("activity_id"=>$record->activity_id))->result_object();

							foreach($parents as $parent):
					?>
						<tr>
							<td><?=$parent->name;?></td>
							<td>
								<?php
									$students = $this->db->get_where("student",array("parent_id"=>$parent->parent_id))->result_object();
										foreach($students as $student){echo $student->name." (".$this->db->get_where('class',array('class_id'=>$student->class_id))->row()->name.")<br/>";}
								?>
							</td>
							<td>
								<?php

									$parent_attendance = $this->db->get_where("activity_attendance",array("parent_id"=>$parent->parent_id,"activity_id"=>$record->activity_id));
									if ($this->session->userdata('active_login') === '1'){
								?>
										<select class="form-control" name="attendance[<?=$parent->parent_id;?>]">
											<option value="1" <?php if($parent_attendance->row()->attendance === '1') echo "selected";?>><?=get_phrase('attended');?></option>
											<option value="0" <?php if($parent_attendance->row()->attendance === '0') echo "selected";?>><?=get_phrase('absent');?></option>

										</select>

								<?php

								}else{
									$attendance_array = array(get_phrase('absent'),get_phrase('attended'));
								?>

										<input type="text" readonly="readonly" class="form-control" value="<?php if(isset($parent_attendance->row()->attendance)) echo $attendance_array[$parent_attendance->row()->attendance]; else echo $attendance_array['0'];?>" />
								<?php
								}
								?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>

			</table>

		</form>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<a href="<?php echo base_url();?>index.php?parents/parent_activity_attendance_print/<?php echo $record->activity_id;?>"
						class="btn btn-primary print_activty_attendance" target="_blank">
						<?php echo get_phrase('print_activty_attendance');?>
			</a>
	</div>
</div>
