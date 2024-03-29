<?php
    $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
?>
<div class="row">

    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
    	<thead>
        	<tr>
            	<th><?php echo get_phrase('select_date');?></th>
            	<th><?php echo get_phrase('select_month');?></th>
            	<th><?php echo get_phrase('select_year');?></th>
            	<th><?php echo get_phrase('select_class');?></th>
            	<th><?php echo get_phrase('select_date');?></th>
           </tr>
       </thead>
		<tbody>
        	<form method="post" action="<?php echo base_url();?>index.php?attendance/attendance_selector" class="form">
            	<tr class="gradeA">
                    <td>
                    	<select name="date" class="form-control">
                        	<?php for($i=1;$i<=31;$i++):?>
                            	<option value="<?php echo $i;?>"
                                	<?php if(isset($date) && $date==$i)echo 'selected="selected"';?>>
										<?php echo $i;?>
                                        	</option>
                            <?php endfor;?>
                        </select>
                    </td>
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
                        	<?php for($i=2030;$i>=2020;$i--):?>
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
                    <td align="center"><input type="submit" value="<?php echo get_phrase('manage_attendance');?>" class="btn btn-info show_class_attendance"/></td>
                </tr>
            </form>
		</tbody>
	</table>
</div>

<hr />



<?php if($date!='' && $month!='' && $year!='' && $class_id!=''):?>

<center>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">

            <div class="tile-stats tile-white-gray">
                <div class="icon"><i class="entypo-suitcase"></i></div>
                <?php
                    $full_date	=	$year.'-'.$month.'-'.$date;
                    $timestamp  = strtotime($full_date);
                    $day        = strtolower(date('l', $timestamp));
                 ?>
                <h2><?php echo ucwords($day);?></h2>

                <h3>Attendance of class <?php echo ($class_id);?></h3>
                <p><?php echo $date.'-'.$month.'-'.$year;?></p>
            </div>
            <a href="#" id="update_attendance_button" onclick="return update_attendance()"
                class="btn btn-info update_class_attendance">
                    Update Attendance
            </a>
        </div>

    </div>
</center>
<hr />

<div class="row" id="attendance_list">
    <div class="col-sm-offset-3 col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td><?php echo get_phrase('roll');?></td>
                    <td><?php echo get_phrase('name');?></td>
                    <td><?php echo get_phrase('morning');?></td>
                    <td><?php echo get_phrase('afternoon');?></td>
                </tr>
            </thead>
            <tbody>

                <?php
                    $students   =   $this->db->get_where('student' , array('class_id'=>$class_id))->result_array();
                        foreach($students as $row):?>
                        <tr class="gradeA">
                            <td><?php echo $row['roll'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <?php
                                //inserting blank data for students attendance if unavailable
                                $verify_data    =   array(  'student_id' => $row['student_id'],
                                                            'date' => $full_date);
                                $query = $this->db->get_where('attendance' , $verify_data);
                                if($query->num_rows() < 1)
                                $this->db->insert('attendance' , $verify_data);

                               
                            ?>
                        
                        
                        <!--Morning Attendance-->
                        <?php
                        		//Morning - showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                                $morning_status     = $attendance->morning;
                        ?>
                        
                         <?php if ($morning_status == 1):?>
                            <td align="center">
                              <span class="badge badge-success"><?php echo get_phrase('present');?></span>
                            </td>
                        <?php endif;?>
                        <?php if ($morning_status == 2):?>
                            <td align="center">
                              <span class="badge badge-danger"><span style="color:orange;"><?php echo get_phrase('absent');?></span></span>
                            </td>
                        <?php endif;?>
                        <?php if ($morning_status == 0):?>
                            <td></td>
                        <?php endif;?>
                        
                        
                        <!--Afternoon Attendance-->
                        <?php
                        		//Afternoon - showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                                $afternoon_status     = $attendance->afternoon;
                        ?>
                        
                         <?php if ($afternoon_status == 1):?>
                            <td align="center">
                              <span class="badge badge-success"><?php echo get_phrase('present');?></span>
                            </td>
                        <?php endif;?>
                        <?php if ($afternoon_status == 2):?>
                            <td align="center">
                              <span class="badge badge-danger"><span style="color:orange;"><?php echo get_phrase('absent');?></span></span>
                            </td>
                        <?php endif;?>
                        <?php if ($afternoon_status == 0):?>
                            <td></td>
                        <?php endif;?>
                        
                        </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>




<div class="row" id="update_attendance">

<!-- STUDENT's attendance submission form here -->
<form method="post"
    action="<?php echo base_url();?>index.php?attendance/manage_attendance/<?php echo $date.'/'.$month.'/'.$year.'/'.$class_id;?>">
    <div class="col-sm-offset-3 col-md-6">
        <table  class="table table-bordered">
    		<thead>
    			<tr class="gradeA">
                	<th><?php echo get_phrase('roll');?></th>
                	<th><?php echo get_phrase('name');?></th>
                	<th><?php echo get_phrase('morning');?></th>
                	<th><?php echo get_phrase('afternoon');?></th>
    			</tr>
            </thead>
            <tbody>

            	<?php
    			//STUDENTS ATTENDANCE
    			$students	=	$this->db->get_where('student' , array('class_id'=>$class_id))->result_array();

    			foreach($students as $row)
    			{
    				?>
    				<tr class="gradeA">
    					<td><?php echo $row['roll'];?></td>
    					<td><?php echo $row['name'];?></td>
    				
    						<?php
    						//inserting blank data for students attendance if unavailable
    						$verify_data	=	array(	'student_id' => $row['student_id'],
    													'date' => $full_date);
    						$query = $this->db->get_where('attendance' , $verify_data);
    						if($query->num_rows() < 1)
    						$this->db->insert('attendance' , $verify_data);

    						?>

                        <td>
                        	<?php

    						//Morning - showing the attendance status editing option
    						$attendance = $this->db->get_where('attendance' , $verify_data)->row();
    						$morning_status		= $attendance->morning;
                        	?>


                                <select name="morning_status_<?php echo $row['student_id'];?>" class="form-control" style="width:100px; float:left;">
                                    <option value="0" <?php if($morning_status == 0)echo 'selected="selected"';?>></option>
                                    <option value="1" <?php if($morning_status == 1)echo 'selected="selected"';?>>Present</option>
                                    <option value="2" <?php if($morning_status == 2)echo 'selected="selected"';?>>Absent</option>
                                </select>
                        </td>
                        <td>
                        	<?php
    						
    						//Afternoon - showing the attendance status editing option
    						$attendance = $this->db->get_where('attendance' , $verify_data)->row();
    						$afternoon_status		= $attendance->afternoon;
                        	?>


                                <select name="afternoon_status_<?php echo $row['student_id'];?>" class="form-control" style="width:100px; float:left;">
                                    <option value="0" <?php if($afternoon_status == 0)echo 'selected="selected"';?>></option>
                                    <option value="1" <?php if($afternoon_status == 1)echo 'selected="selected"';?>>Present</option>
                                    <option value="2" <?php if($afternoon_status == 2)echo 'selected="selected"';?>>Absent</option>
                                </select>
                        </td>
    				</tr>
    				<?php
    			}
    			?>
            </tbody>
        </table>
        <input type="hidden" name="date" value="<?php echo $full_date;?>" />
        <center>
            <input type="submit" class="btn btn-info" value="save changes">
        </center>
    </div>
</form>

</div>

<br>

<?php
        if ($active_sms_service == ''):
    ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
           <div class="alert alert-danger">
                SMS <?php echo get_phrase('service_is_not_selected');?>
           </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <?php endif;?>
    <?php
        if ($active_sms_service == 'disabled'):
    ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="alert alert-warning">
                SMS <?php echo get_phrase('service_is_disabled');?>
           </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <?php endif;?>
    <?php
        if ($active_sms_service == 'clickatell'):
    ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="alert alert-info">
                SMS <?php echo get_phrase('will_be_sent_by_clickatell');?>
           </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <?php endif;?>
    <?php
        if ($active_sms_service == 'twilio'):
    ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="alert alert-info">
                SMS <?php echo get_phrase('will_be_sent_by_twilio');?>
           </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <?php endif;?>

<?php endif;?>

<script type="text/javascript">

    $("#update_attendance").hide();

    function update_attendance() {

        $("#attendance_list").hide();
        $("#update_attendance_button").hide();
        $("#update_attendance").show();

    }
</script>
