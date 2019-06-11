<?php
//print_r($attendance);
$date_rows = array_column($attendance, 'attendance');
$attendance_dates = array_keys($date_rows[0]);
$attendance_key = array('','P','A');
?>
<div class="row">
	<div class="col-xs-12" style="text-align: center;font-weight: bold;">
		<span><?=get_phrase('monthly_attendance_sheet')?>: <?=get_phrase('month')?>: <?=date('F Y',strtotime($year.'-'.$month.'-01'))?></span> 
	</div>
</div>
<hr />

<div class="row">

    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
    	<thead>
        	<tr>
            	<th><?php echo get_phrase('select_month');?></th>
            	<th><?php echo get_phrase('select_year');?></th>
            	<th><?php echo get_phrase('select_class');?></th>
            	<th><?php echo get_phrase('select_date');?></th>
           </tr>
       </thead>
		<tbody>
        	<form method="post" action="<?php echo base_url();?>index.php?attendance/attendance_sheet_selector" class="form">
            	<tr class="gradeA">
                    <td>
                    	<select name="month" class="form-control">
                        	<?php
							for($i=1;$i<=12;$i++):
								if($i==1)$m='january';
								else if($i==2)$m='february';
								else if($i==3)$m='march';
								else if($i==4)$m='april';
								else if($i==5)$m='may';
								else if($i==6)$m='june';
								else if($i==7)$m='july';
								else if($i==8)$m='august';
								else if($i==9)$m='september';
								else if($i==10)$m='october';
								else if($i==11)$m='november';
								else if($i==12)$m='december';
							?>
                            	<option value="<?php echo $i;?>"
                                	<?php if($month==$i)echo 'selected="selected"';?>>
										<?php echo $m;?>
                                        	</option>
                            <?php
							endfor;
							?>
                        </select>
                    </td>
                    <td>
                    	<select name="year" class="form-control">
                        	<?php for($i=2020;$i>=2010;$i--):?>
                            	<option value="<?php echo $i;?>"
                                	<?php if(isset($year) && $year==$i)echo 'selected="selected"';?>>
										<?php echo $i;?>
                                        	</option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <td>
                    	<select name="class_id" class="form-control">
                        	<option value="">Select a class</option>
                        	<?php
							$classes	=	$this->db->get('class')->result_array();
							foreach($classes as $row):?>
                        	<option value="<?php echo $row['class_id'];?>"
                            	<?php if(isset($class_id) && $class_id==$row['class_id'])echo 'selected="selected"';?>>
									<?php echo $row['name'];?>
                              			</option>
                            <?php endforeach;?>
                        </select>

                    </td>
                    <td align="center"><input type="submit" value="<?php echo get_phrase('show_attendance');?>" class="btn btn-info show_class_attendance"/></td>
                </tr>
            </form>
		</tbody>
	</table>
</div>

<hr/>
<?php if($month!='' && $year!='' && $class_id!=''):?>
	
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered datatable">
			<thead>
				<tr>
					<th rowspan="3"><?=get_phrase('student_name');?></th>
					<th rowspan="3"><?=get_phrase('roll');?></th>
					<th rowspan="3"><?=get_phrase('class');?></th>
					<th colspan="<?=count($attendance_dates)*2;?>"><?=get_phrase('attendance');?></th>
					<th rowspan="3"><?=get_phrase('morning_present');?></th>
					<th rowspan="3"><?=get_phrase('afternoon_present');?></th>
				</tr>
				</tr>	
					<?php
						foreach($attendance_dates as $date){
					?>
						<th colspan="2"><?=date('d',strtotime($date));?></th>
					<?php
						}
					?>
				</tr>
				<tr>
					<?php
						foreach($attendance_dates as $date){
					?>
						<th><?=get_phrase('M');?></th>
						<th><?=get_phrase('A');?></th>
					<?php
						}
					?>
				</tr>
				
			</thead>
			<tbody>
				<?php
					foreach($attendance as $student_attendance){
				?>
					<tr>
						<td><?=$student_attendance['student_information']['name'];?></td>
						<td><?=$student_attendance['student_information']['roll'];?></td>
						<td><?=$student_attendance['student_information']['class'];?></td>
						<?php
							foreach($attendance_dates as $date){
						?>	
							<td><?=$attendance_key[$student_attendance['attendance'][$date]['morning']];?></td>
							<td><?=$attendance_key[$student_attendance['attendance'][$date]['afternoon']];?></td>
						<?php
							}
							$morning = 0;
							$afternoon = 0;
							foreach($student_attendance[attendance] as $sum_attendance){
								if($sum_attendance['morning'] == 1){
									$morning+=$sum_attendance['morning'];
								}
								
								if($sum_attendance['afternoon'] == 1){
									$afternoon+=$sum_attendance['afternoon'];
								}
								
							}
						?>
						<td><?=$morning;?></td>
						<td><?=$afternoon;?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<?php endif;?>