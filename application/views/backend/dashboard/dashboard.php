<!-- <p></p>

<div class="row">
	<div class="col-xs-12 <?=get_access_class('show_updates',$this->session->login_type,'dasboard');?>">

		<?php
			$current_version = $this->db->get_where('settings',array('type'=>'version'))
					->row()->description;
			$new_version = $this->config->item('version');
			
			$update_notice = "System is up to date";
			$color = 'btn-success';
				
			if($current_version < $new_version){
				$update_notice = "Updates Available!";
				$color = 'btn-info';
			
			}
		?>
			<div class="btn btn-block <?=$color;?>" style="text-align: center;"><?=$update_notice;?></div>
	</div>
</div> -->

<p></p>

<div class="row">
	<div class="col-xs-12">
			
		<div class="col-xs-3">
			<div class="tile-title tile-primary">
					
				<div class="icon">
					<a href="<?=base_url();?>index.php?finance/student_payments">
						<i class="glyphicon glyphicon-leaf"></i>
					</a>	
				</div>
						
				<div class="title">
					<h3>Take Student Payment</h3>
					<p>shortcut to record student fees payment.</p>
				</div>
			</div>
		</div>
		
		
		<div class="col-xs-3">
			<div class="tile-title tile-info">
					
				<div class="icon">
					<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_income_add/');" >
						<i class="glyphicon glyphicon-gift"></i>
					</a>	
				</div>
						
				<div class="title">
					<h3>Take Other income</h3>
					<p>shortcut to record other income.</p>
				</div>
			</div>
		</div>
				
		<div class="col-xs-3">
			<div class="tile-title tile-red">
					
				<div class="icon">
					<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_expense_add/');" >
						<i class="glyphicon glyphicon-link"></i>
					</a>	
				</div>
						
				<div class="title">
					<h3>Record expenses</h3>
					<p>shortcut to record expenses.</p>
				</div>
			</div>
		</div>		
	</div>
</div>


<p></p>

<div class="row">
	<div class="col-xs-12">
            <div class="col-md-3">
            
                <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-group"></i></div>
                    <?php
                    	$students = $this->db->get_where('student',array('active'=>1))->num_rows();
                    ?>
                    <div class="num" data-start="0" data-end="<?=$students;?>" 
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('students');?></h3>
                   <p>Total active students</p>
                </div>
                
            </div>
            <div class="col-md-3">
            
                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <?php
                    	$teacher = $this->db->get_where('teacher',array('status'=>1))->num_rows();
                    ?>
                    <div class="num" data-start="0" data-end="<?php echo $teacher;?>" 
                    		data-postfix="" data-duration="800" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('teachers');?></h3>
                   <p>Total Active teachers</p>
                </div>
                
            </div>
            <div class="col-md-3">
            
                <div class="tile-stats tile-aqua">
                    <div class="icon"><i class="entypo-user"></i></div>
                    <?php
                    	$this->db->where('student.active',1);
                    	$this->db->join('student','student.parent_id=parent.parent_id');
                    	$parents = $this->db->get('parent')->num_rows();
                    ?>
                    <div class="num" data-start="0" data-end="<?php echo $parents;?>" 
                    		data-postfix="" data-duration="500" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('parents');?></h3>
                   <p>Total active parents</p>
                </div>
                
            </div>
            <div class="col-md-3">
            
                <div class="tile-stats tile-blue">
                    <div class="icon"><i class="entypo-chart-bar"></i></div>
                    <?php 
							$check	=	array(	'date' => date('Y-m-d') , 'status' => '1' );
							$query = $this->db->get_where('attendance' , $check);
							$present_today		=	$query->num_rows();
						?>
                    <div class="num" data-start="0" data-end="<?php echo $present_today;?>" 
                    		data-postfix="" data-duration="500" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('attendance');?></h3>
                   <p>Total present student today</p>
                </div>
                
            </div>
    
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		
		<div class="col-sm-3">
			
				<div class="tile-stats tile-primary">
					<div class="icon"><i class="entypo-suitcase"></i></div>
					<?php
						$unpaid_invoices = $this->db->get_where('invoice',array('status'=>'unpaid'))->num_rows();
					?>
					<div class="num" data-start="0" data-end="<?=$unpaid_invoices;?>"  data-duration="1500" data-delay="0">0</div>
					
					<h3>Invoices</h3>
					<p>Total Unpaid Invoices</p>
				</div>
				
			</div>
			
			<div class="col-sm-3">
			
				<div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-gauge"></i></div>
					
					<?php
						$balance = $this->db->select_sum('balance')->get_where('invoice',array('status'=>'unpaid'))->row()->balance;
					?>
					
					<div class="num"><?=number_format($balance);?></div>
					
					<h3>Fees</h3>
					<p>Total Fee Balance in Kes.</p>
				</div>
				
			</div>
			
			<div class="col-sm-3">
			
				<div class="tile-stats tile-plum">
					<div class="icon"><i class="entypo-mail"></i></div>
					<?php
						$fees_paid = $this->db->select_sum('amount_paid')->get_where('invoice',
						array('yr'=>date('Y')))->row()->amount_paid;
					?>
					<div class="num"><?=number_format($fees_paid);?></div>
					
					<h3>Fees</h3>
					<p>Total year amount received</p>
				</div>
				
			</div>
			
			<div class="col-sm-3">
			
				<div class="tile-stats tile-brown">
					<div class="icon"><i class="entypo-suitcase"></i></div>
					<?php
						$cleared_invoices = $this->db->get_where('invoice',array('status'=>'paid','yr'=>date("Y")))->num_rows();
					?>
					<div class="num"><?=number_format($cleared_invoices);?></div>
					
					<h3>Invoices</h3>
					<p>Total Year cleared invoices</p>
				</div>
				
			</div>
			
	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		<div class="col-sm-3">
			
				<div class="tile-stats tile-cyan">
					<div class="icon"><i class="entypo-paper-plane"></i></div>
					<?php
						$expense = $this->db->select_sum('amount')->get_where('expense',
						array('YEAR(t_date)'=>date('Y')))->row()->amount;
					?>
					<div class="num"><?=number_format($expense);?></div>
					
					<h3>Expenses</h3>
					<p>Total year expenses to date</p>
				</div>
				
			</div>
			
			<div class="col-sm-3">
			
				<div class="tile-stats tile-purple">
					<div class="icon"><i class="entypo-gauge"></i></div>
					<?php
					
						$this->db->where_in('month',range(1, date('n')));
						$this->db->join('budget','budget.budget_id=budget_schedule.budget_id');
						$budget = $this->db->select_sum('amount')->get_where('budget_schedule',
						array('fy'=>date('Y')))->row()->amount;
					?>
					<div class="num"><?=number_format($budget);?></div>
					
					<h3>Budget</h3>
					<p>Total budget to date</p>
				</div>
				
			</div>
			
			<div class="col-sm-3">
			
				<div class="tile-progress tile-primary">
					
					<div class="tile-header">
						<h3>Attendance</h3>
						<span>% class attendance</span>
					</div>
					
					<div class="tile-progressbar">
						<?php
							$per_attendance = $present_today>0?number_format(($present_today/$students)*100,1):0;
						?>
						<span data-fill="<?=$per_attendance;?>%"></span>
					</div>
					
					<div class="tile-footer">
						<h4>
							<span class="pct-counter">0</span>% class attendance
						</h4>
						
						<!-- <span>so far in our blog and our website</span> -->
					</div>
				</div>
			
			</div>
			
			<div class="col-sm-3">
			
				<div class="tile-progress tile-red">
					
					<div class="tile-header">
						<h3>Lessons</h3>
						<span>% Lessons covered</span>
					</div>
					
					<div class="tile-progressbar">
						<?php
							$days = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
							//print_r($days);
							$todays_lessons = $this->db->get_where('class_routine',
							array('day'=>$days[date('w')]))->num_rows();
							
							$this->db->join('class_routine','class_routine.class_routine_id=class_routine_attendance.class_routine_id');
							$attended_lessons = $this->db->get('class_routine_attendance',
							array('day'=>$days[date('w')],'attendance_date'=>date('Y-m-d')))->num_rows();
							
							$per_lessons_attended = $todays_lessons>0?number_format(($attended_lessons/$todays_lessons)*100,2):0;
						?>
						<span data-fill="<?=$per_lessons_attended;?>"></span>
					</div>
					
					<div class="tile-footer">
						<h4>
							<span class="pct-counter">0</span>% Lessons covered
						</h4>
						
						<!-- <span>so far in our blog and our website</span> -->
					</div>
				</div>
			
			</div>
	</div>
</div>

<p></p>

<div class="row">
	<div class="col-xs-12">
    	<div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">    
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('event_schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	
	
</div>



    <script>
  $(document).ready(function() {
	  
	  var calendar = $('#notice_calendar');
				
				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
					
					//defaultView: 'basicWeek',
					
					editable: false,
					firstDay: 1,
					height: 530,
					droppable: false,
					
					events: [
						<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
						},
						<?php 
						endforeach
						?>
						
					]
				});
	});
  </script>

  
