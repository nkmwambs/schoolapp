<hr />
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(base_url() . 'index.php?exam/tabulation_sheet');?>
			<div class="col-md-4">
				<div class="form-group">
					<select name="class_id" class="form-control selectboxit">
                        <option value=""><?php echo get_phrase('select_a_class');?></option>
                        <?php
                        $classes = $this->db->get('class')->result_array();
                        foreach($classes as $row):
                        ?>
                            <option value="<?php echo $row['class_id'];?>"
                            	<?php if ($class_id == $row['class_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select name="exam_id" class="form-control selectboxit">
                        <option value=""><?php echo get_phrase('select_an_exam');?></option>
                        <?php
                        $exams = $this->db->get('exam')->result_array();
                        foreach($exams as $row):
                        ?>
                            <option value="<?php echo $row['exam_id'];?>"
                            	<?php if ($exam_id == $row['exam_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>
			<input type="hidden" name="operation" value="selection">
			<div class="col-md-4">
				<button type="submit" class="btn btn-info"><?php echo get_phrase('view_tabulation_sheet');?></button>
			</div>
		<?php echo form_close();?>
	</div>
</div>

<?php if ($class_id != '' && $exam_id != ''):?>
<br>
<?php
//print_r($positions);
?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-white tile-white-primary">
			<h3>
				<?php
					echo get_phrase('tabulation_sheet');
				?>
			</h3>
			<h4><?php echo get_phrase('class') . ' ' . $class_name;?></h4>
			<h4><?php echo $exam_name;?></h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>


<hr />

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered datatable">
			<thead>
				<tr>
				<th><?=get_phrase('class_position');?></th>
				<td style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>
				<?php
					//$subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
					foreach($subjects as $row):
				?>
					<td style="text-align: center;"><?php echo $row['name'];?></td>
				<?php endforeach;?>
				<td style="text-align: center;"><?php echo get_phrase('total');?></td>
				<td style="text-align: center;"><?php echo get_phrase('average_grade_point');?></td>
				<td><?=get_phrase('grade_comment');?></td>
				</tr>
			</thead>
			<tbody>
			<?php

			$subject_total = array();

			foreach($subjects as $subject){
				$subject_total[$subject['name']] = 0;
			}

			$subject_total['aggregate_total'] = 0;

			$subject_total['aggregate_grade_points'] = 0;

			$sizeofclass = 0;

			foreach($positions as $student=>$result){
				if($result['total_marks'] > 0){
					$sizeofclass++;
			?>
				<tr>
					<td><?=$result['position']?></td>
					<td><?=$student;?></td>

					<?php

						foreach($subjects as $subject){

							$mark = 0;
							foreach($result['subject']  as $row){
								if($row['subject_name'] == $subject['name']){
									$mark = $row['mark'];
									$subject_total[$subject['name']] +=$mark;
								}
							}
					?>
							<td><?=$mark?></td>
					<?php
						}
						$subject_total['aggregate_total']  += $result['total_marks'];
						$subject_total['aggregate_grade_points']  += $result['grade_point'];
					?>

					<td><?=$result['total_marks'];?></td>
					<td><?=$result['grade_point'];?></td>
					<td><?=$result['grade_comment'];?></td>
				</tr>

			<?php
				}
			}
			//print_r($subject_total);
			?>
			<tfoot>
				<tr>
					<td colspan="2"><?=get_phrase('class_average');?></td>

					<?php
					foreach($subjects as $subject){
					?>
						<td><?=number_format(($subject_total[$subject['name']]/$sizeofclass),1);?></td>

					<?php
					}
					?>

					<td><?=number_format(($subject_total['aggregate_total']/$sizeofclass),1);?></td>
					<td colspan="2"><?=number_format(($subject_total['aggregate_grade_points']/$sizeofclass),1);?></td>
				</tr>
			</tfoot>
			</tbody>
		</table>
		<center>
			<a href="<?php echo base_url();?>index.php?exam/tabulation_sheet_print_view/<?php echo $class_id;?>/<?php echo $exam_id;?>"
				class="btn btn-primary" target="_blank">
				<?php echo get_phrase('print_tabulation_sheet');?>
			</a>
		</center>
	</div>
</div>
<?php endif;?>
