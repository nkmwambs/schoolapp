<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//print_r($user_data);
?>
<div class="row">
	<div class="col-xs-12 <?= get_access_class('dashboard', 'admin'); ?>">

		<div class="row  <?= get_access_class('create_transaction', 'admin', 'accounting'); ?>">
			<div class="col-xs-10">
				<div class="col-xs-3 <?= get_access_class('create_transaction', 'admin', 'dashboard'); ?>">
					<!-- <a href="<?=base_url();?>index.php?finance/create_transaction" class="btn btn-success btn-icon float-left">
						<i class="fa fa-tasks"></i><?=get_phrase('create_a_transaction');?>
					</a> -->
					<div class="btn-group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							<?= get_phrase('create_a_transaction'); ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-default" role="menu">
							<li class="<?= get_access_class('take_student_payment', 'admin', 'dashboard'); ?>">
								<a href="<?= base_url(); ?>index.php?finance/create_transaction/active_invoices/fees_income"><?= get_phrase('student_fees_receipt'); ?></a>
							</li>
							<li class="divider <?= get_access_class('take_student_payment', 'admin', 'dashboard'); ?>"></li>
							
							<li class="<?= get_access_class('take_other_income', 'admin', 'dashboard'); ?>">
								<a href="<?= base_url(); ?>index.php?finance/create_transaction/income_add/other_income"><?= get_phrase('other_income_receipt'); ?></a>
							</li>
							<li class="divider <?= get_access_class('take_other_income', 'admin', 'dashboard'); ?>"></li>
							
							<li class="<?= get_access_class('make_expense', 'admin', 'dashboard'); ?>">
								<a href="<?= base_url(); ?>index.php?finance/create_transaction/expense_add/expense"><?= get_phrase('expense'); ?></a>
							</li>
							<li class="divider <?= get_access_class('make_expense', 'admin', 'dashboard'); ?>"></li>
							
							<li class="<?= get_access_class('tranfer_funds', 'admin', 'dashboard'); ?>">
								<a href="<?= base_url(); ?>index.php?finance/create_transaction/tranfer_funds/tranfer_funds"><?= get_phrase('funds_transfer'); ?></a>
							</li>
							<li class="divider <?= get_access_class('tranfer_funds', 'admin', 'dashboard'); ?>"></li>
							
							<li class="<?= get_access_class('raise_contra_entry', 'admin', 'dashboard'); ?>">
								<a href="<?= base_url(); ?>index.php?finance/create_transaction/contra_entry/contra"><?= get_phrase('contra_entry'); ?></a>
							</li>
						</ul>
					</div> 
				</div>
			</div>
			<div class="col-xs-2">
				<div class="label label-primary">SMS Gateway Balance: <?=$user_data->balance;?></div>
			</div>
		</div>
		
		<hr class="<?= get_access_class('create_transaction', 'admin', 'dashboard'); ?>"/>
		
		<div class="row">
			<div class="col-xs-12">
		            <div class="col-md-3 <?= get_access_class('student_count', 'admin', 'dashboard'); ?>">
		            
		                <div class="tile-stats tile-red <?= get_access_class('student_count', 'admin', 'dashboard'); ?>">
		                    <div class="icon"><i class="fa fa-group"></i></div>
		                    <?php $students = $this -> db -> get_where('student', array('active' => 1)) -> num_rows(); ?>
		                    <div class="num" data-start="0" data-end="<?= $students; ?>" 
		                    		data-postfix="" data-duration="1500" data-delay="0">0</div>
		                    
		                    <h3><?php echo get_phrase('students'); ?></h3>
		                   <p>Total active students</p>
		                </div>
		                
		            </div>
		            <div class="col-md-3  <?= get_access_class('teachers_count', 'admin', 'dashboard'); ?>">
		            
		                <div class="tile-stats tile-green <?= get_access_class('teachers_count', 'admin', 'dashboard'); ?>">
		                    <div class="icon"><i class="entypo-users"></i></div>
		                    <?php $teacher = $this -> db -> get_where('teacher', array('status' => 1)) -> num_rows(); ?>
		                    <div class="num" data-start="0" data-end="<?php echo $teacher; ?>" 
		                    		data-postfix="" data-duration="800" data-delay="0">0</div>
		                    
		                    <h3><?php echo get_phrase('teachers'); ?></h3>
		                   <p>Total Active teachers</p>
		                </div>
		                
		            </div>
		            <div class="col-md-3 <?= get_access_class('parents_count', 'admin', 'dashboard'); ?>">
		            
		                <div class="tile-stats tile-aqua <?= get_access_class('parents_count', 'admin', 'dashboard'); ?>">
		                    <div class="icon"><i class="entypo-user"></i></div>
		                    <?php // $this->db->where('student.active',1);
								// $this->db->join('student','student.parent_id=parent.parent_id');
								$parents = $this -> db -> get_where('parent', array('status' => 1)) -> num_rows();
		                    ?>
		                    <div class="num" data-start="0" data-end="<?php echo $parents; ?>" 
		                    		data-postfix="" data-duration="500" data-delay="0">0</div>
		                    
		                    <h3><?php echo get_phrase('parents'); ?></h3>
		                   <p>Total active parents</p>
		                </div>
		                
		            </div>
		            <div class="col-md-3 <?= get_access_class('today_students_attendance', 'admin', 'dashboard'); ?>">
		            
		                <div class="tile-stats tile-blue <?= get_access_class('today_students_attendance', 'admin', 'dashboard'); ?>">
		                    <div class="icon"><i class="entypo-chart-bar"></i></div>
		                    <?php $check = array('date' => date('Y-m-d'), 'afternoon' => '1');
								$query = $this -> db -> get_where('attendance', $check);
								$present_today = $query -> num_rows();
								?>
		                    <div class="num" data-start="0" data-end="<?php echo $present_today; ?>" 
		                    		data-postfix="" data-duration="500" data-delay="0">0</div>
		                    
		                    <h3><?php echo get_phrase('attendance'); ?></h3>
		                   <p>Total present student today</p>
		                </div>
		                
		            </div>
		    
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				
				<div class="col-sm-3 <?= get_access_class('unpaid_invoices_count', 'admin', 'dashboard'); ?>">
					
						<div class="tile-stats tile-primary <?= get_access_class('unpaid_invoices_count', 'admin', 'dashboard'); ?>">
							<div class="icon"><i class="entypo-suitcase"></i></div>
							<?php $unpaid_invoices = $this -> db -> get_where('invoice', array('status' => 'unpaid')) -> num_rows(); ?>
							<div class="num" data-start="0" data-end="<?= $unpaid_invoices; ?>"  data-duration="1500" data-delay="0">0</div>
							
							<h3>Invoices</h3>
							<p>Total Unpaid Invoices</p>
						</div>
						
					</div>
					
					<div class="col-sm-3 <?= get_access_class('total_fees_balance', 'admin', 'dashboard'); ?>">
					
						<div class="tile-stats tile-red <?= get_access_class('total_fees_balance', 'admin', 'dashboard'); ?>">
							<div class="icon"><i class="entypo-gauge"></i></div>
							
							<?php 
							//echo $this->crud_model->get_current_term();
								$balance = $this->crud_model->term_total_fees_balance(date('Y'),$this->crud_model->get_current_term());
							?>
							
							<div class="num"><?= number_format($balance); ?></div>
							
							<h3>Fees</h3>
							<p>Total Fee Balance in Kes.</p>
						</div>
						
					</div>
					
					<div class="col-sm-3">
					
						<div class="tile-stats tile-plum <?= get_access_class('total_fees_received', 'admin', 'dashboard'); ?>">
							<div class="icon"><i class="entypo-mail <?= get_access_class('total_fees_received', 'admin', 'dashboard'); ?>"></i></div>
							<?php $fees_paid = $this -> crud_model-> term_total_paid_fees(date('Y'),$this->crud_model->get_current_term()); ?>
							<div class="num"><?= number_format($fees_paid); ?></div>
							
							<h3>Fees</h3>
							<p>Total year amount received</p>
						</div>
						
					</div>
					
					<div class="col-sm-3 <?= get_access_class('total_invoices_cleared', 'admin', 'dashboard'); ?>">
					
						<div class="tile-stats tile-brown <?= get_access_class('total_invoices_cleared', 'admin', 'dashboard'); ?>">
							<div class="icon"><i class="entypo-suitcase"></i></div>
							<?php $cleared_invoices = $this -> db -> get_where('invoice', array('status' => 'paid', 'yr' => date("Y"))) -> num_rows(); ?>
							<div class="num"><?= number_format($cleared_invoices); ?></div>
							
							<h3>Invoices</h3>
							<p>Total Year cleared invoices</p>
						</div>
						
					</div>
					
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-xs-12">
				<div class="col-sm-3 <?= get_access_class('years_expense_to_date', 'admin', 'dashboard'); ?>">
					
						<div class="tile-stats tile-cyan <?= get_access_class('years_expense_to_date', 'admin', 'dashboard'); ?>">
							<div class="icon"><i class="entypo-paper-plane"></i></div>
							<?php $expense = $this -> db -> select_sum('amount') -> get_where('transaction', array('YEAR(t_date)' => date('Y'), 'transaction_type_id' => 2)) -> row() -> amount; ?>
							<div class="num"><?= number_format($expense); ?></div>
							
							<h3>Expenses</h3>
							<p>Total year expenses to date</p>
						</div>
						
					</div>
					
					<div class="col-sm-3 <?= get_access_class('budget_to_date', 'admin', 'dashboard'); ?>">
					
						<div class="tile-stats tile-purple <?= get_access_class('budget_to_date', 'admin', 'dashboard'); ?>">
							<div class="icon"><i class="entypo-gauge"></i></div>
							<?php $this -> db -> where_in('month', range(1, date('n')));
								$this -> db -> join('budget', 'budget.budget_id=budget_schedule.budget_id');
								$budget = $this -> db -> select_sum('amount') -> get_where('budget_schedule', array('fy' => date('Y'))) -> row() -> amount;
							?>
							<div class="num"><?= number_format($budget); ?></div>
							
							<h3>Budget</h3>
							<p>Total budget to date</p>
						</div>
						
					</div>
					
					<div class="col-sm-3  <?= get_access_class('percent_class_attendance', 'admin', 'dashboard'); ?>">
					
						<div class="tile-progress tile-primary  <?= get_access_class('percent_class_attendance', 'admin', 'dashboard'); ?>">
							
							<div class="tile-header">
								<h3>Attendance</h3>
								<span>% class attendance</span>
							</div>
							
							<div class="tile-progressbar">
								<?php $per_attendance = $present_today > 0 ? number_format(($present_today / $students) * 100, 1) : 0; ?>
								<span data-fill="<?= $per_attendance; ?>%"></span>
							</div>
							
							<div class="tile-footer">
								<h4>
									<span class="pct-counter">0</span>% class attendance
								</h4>
								
								<!-- <span>so far in our blog and our website</span> -->
							</div>
						</div>
					
					</div>
					
					<div class="col-sm-3 <?= get_access_class('percent_lesson_covered', 'admin', 'dashboard'); ?>">
					
						<div class="tile-progress tile-red <?= get_access_class('percent_lesson_covered', 'admin', 'dashboard'); ?>">
							
							<div class="tile-header">
								<h3>Lessons</h3>
								<span>% Lessons covered</span>
							</div>
							
							<div class="tile-progressbar">
								<?php $days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
								//print_r($days);
								$todays_lessons = $this -> db -> get_where('class_routine', array('day' => $days[date('w')])) -> num_rows();

								$this -> db -> join('class_routine', 'class_routine.class_routine_id=class_routine_attendance.class_routine_id');
								$attended_lessons = $this -> db -> get('class_routine_attendance', array('day' => $days[date('w')], 'attendance_date' => date('Y-m-d'))) -> num_rows();

								$per_lessons_attended = $todays_lessons > 0 ? number_format(($attended_lessons / $todays_lessons) * 100, 2) : 0;
								?>
								<span data-fill="<?= $per_lessons_attended; ?>"></span>
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
		    	<div class="row <?= get_access_class('event_schedule', 'admin', 'dashboard'); ?>">
		            <!-- CALENDAR-->
		            <div class="col-md-12 col-xs-12">    
		                <div class="panel panel-primary " data-collapsed="0">
		                    <div class="panel-heading">
		                        <div class="panel-title">
		                            <i class="fa fa-calendar"></i>
		                            <?php echo get_phrase('event_schedule'); ?>
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
							title: "<?php echo $row['notice_title']; ?>
								",
								start: new Date(
<?php echo date('Y', $row['create_timestamp']); ?>,<?php echo date('m', $row['create_timestamp']) - 1; ?>,<?php echo date('d', $row['create_timestamp']); ?>),
							end:	new Date(<?php echo date('Y', $row['create_timestamp']); ?>,<?php echo date('m', $row['create_timestamp']) - 1; ?>,<?php echo date('d', $row['create_timestamp']); ?>
								)
								},
						<?php endforeach ?>
							]
							});
							});
  </script>

  
