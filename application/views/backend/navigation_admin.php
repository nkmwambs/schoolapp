	<header class="navbar navbar-fixed-top"><!-- set fixed position by adding class "navbar-fixed-top" -->
		
		<div class="navbar-inner">
		
			<!-- logo -->
			<div class="navbar-brand">
				 <a href="<?php echo base_url(); ?>">
	                <img src="uploads/logo.png"  style="max-height:20px;"/>
	            </a>
			</div>
			
			
			<!-- main menu -->
						
			<ul class="navbar-nav">
				<!-- DASHBOARD -->
		        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> <?=get_access_class('dashboard','admin');?>">
		            <a href="<?php echo base_url(); ?>index.php?dashboard">
		                <i class="entypo-gauge"></i>
		                <span><?php echo get_phrase('dashboard'); ?> </span>
		            </a>
		        </li>
		        
				
				<li class="opened active has-sub">
					<a href="#">
						<i class="entypo-layout"></i>
						<span class="title"><?=get_phrase('accounts');?></span>
					</a>
					<ul class="visible">
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?admin/administrator">
								<span class="title"><?=get_phrase('administrators');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?teacher/teacher">
								<span class="title"><?=get_phrase('teachers');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?parents/parent">
								<span class="title"><?=get_phrase('parents');?></span>
							</a>
						</li>
						
						<li class="has-sub active">
							<a href="#">
								<span class="title"><?=get_phrase('students');?></span>
							</a>
							<ul>
								<li>
									<a href="<?php echo base_url(); ?>index.php?student/student_add">
										<span class="title"><?=get_phrase('admit_student');?></span>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php?student/student_bulk_add">
										<span class="title"><?=get_phrase('admit_bulk_students');?></span>
									</a>
								</li>
								<li class="has-sub">
									<a href="#">
										<span class="title"><?=get_phrase('student_information');?></span>
									</a>
									<ul>
										
					                    	<li class="<?php if ($page_name == 'all_students') echo 'active'; ?> <?=get_access_class('all_students','admin','student');?>">
							                    <a href="<?php echo base_url(); ?>index.php?student/all_students">
							                        <span><i class="fa fa-users"></i> <?php echo get_phrase('all_students'); ?></span>
							                    </a>
							                </li>
					                        <?php
					                        $classes = $this->db->order_by("name_numeric","asc")->get('class')->result_array();
											
											/** Restrict teachers to only see their classes **/
											
					                        foreach ($classes as $row):
					                        										
											    ?>
					                            <li class="<?php if ($page_name == 'student_information' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?> <?=get_access_class('class_numeric_'.$row['name_numeric'].'_students','admin','student');?>">
					                                <a href="<?php echo base_url(); ?>index.php?student/student_information/<?php echo $row['class_id']; ?>">
					                                	<?php
					                                		 $students_count   =   $this->db->get_where('student' , array('class_id'=>$row['class_id'],"active"=>1))->num_rows();
					                                	?>
					                                    <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span> <span class="badge badge-info"><?=$students_count;?></span>
					                                </a>
					                            </li>
					                        <?php endforeach; ?>
					                    
									</ul>
								</li>
								
							</ul>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?account/manage_profile">
								<span class="title"><?=get_phrase('manage_own_account');?></span>
							</a>
						</li>	
						
					</ul>
				</li>
				
				<li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> <?=get_access_class('dashboard','admin');?>">
		            <a href="<?php echo base_url(); ?>index.php?parents/parent_activity">
		                <i class="fa fa-trophy"></i>
		                <span><?php echo get_phrase('parent_activity'); ?> </span>
		            </a>
		        </li>
				
				<li class="has-sub">
					<a href="#">
						<i class="entypo-newspaper"></i>
						<span class="title">Classes</span>
					</a>
					<ul>
						<li class="has-sub">
							<a href="#">
								<span class="title"><?=get_phrase('classes');?></span>
							</a>
							<ul>
								<li>
									<a href="<?php echo base_url(); ?>index.php?classes/classes">
										<span class="title"><?=get_phrase('manage_classes');?></span>
									</a>
								</li>
								
								<li>
									<a href="<?php echo base_url(); ?>index.php?classes/section">
										<span class="title"><?=get_phrase('manage_sections');?></span>
									</a>
								</li>
								
								<li>
									<a href="<?php echo base_url(); ?>index.php?Class_Routine/class_routine">
										<span class="title"><?=get_phrase('class_routine');?></span>
									</a>
								</li>
							</ul>
						</li>
						<li class="has-sub">
							<a href="#">
								<span class="title"><?=get_phrase('subjects');?></span>
							</a>
							<ul>
				                <?php
				                $classes = $this->db->order_by("name_numeric","asc")->get('class')->result_array();
				                foreach ($classes as $row):
				                    ?>
				                    <li class="<?php if ($page_name == 'subject' && $class_id == $row['class_id']) echo 'active'; ?> <?=get_access_class('class_numeric_'.$row['name_numeric'].'_subjects','admin','subject');?>">
				                        <a href="<?php echo base_url(); ?>index.php?subject/subject/<?php echo $row['class_id']; ?>">
				                            <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
				                        </a>
				                    </li>
				                <?php endforeach; ?>
				            </ul>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?attendance/manage_attendance/<?php echo date("d/m/Y"); ?>">
								<span class="title"><?=get_phrase('class_attendance');?></span>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="has-sub">
					<a href="#">
						<i class="entypo-star"></i>
						<span class="title"><?=get_phrase('examination');?></span>
					</a>
					<ul>
						<li>
							<a href="<?php echo base_url(); ?>index.php?exam/exam">
								<span class="title"><?=get_phrase('examination_list');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?exam/grade">
								<span class="title"><?=get_phrase('examination_grades');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?exam/marks">
								<span class="title"><?=get_phrase('marks');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?exam/exam_marks_sms">
								<span class="title"><?=get_phrase('send_marks_by_sms');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?exam/tabulation_sheet">
								<span class="title"><?=get_phrase('tabulation_sheet');?></span>
							</a>
						</li>
						
					</ul>
				</li>
				<li class="has-sub">
					<a href="extra-icons.html">
						<i class="entypo-heart"></i>
						<span class="title"><?=get_phrase('finance');?></span>
						<!-- <span class="badge badge-secondary">9</span> -->
					</a>
					<ul>
						<li>
							<a href="<?php echo base_url(); ?>index.php?finance/fees_structure">
								<span class="title"><?=get_phrase('fee_structure');?></span>
								<!-- <span class="badge badge-success">3</span> -->
							</a>
						</li>	
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?finance/student_payments">
								<span class="title"><?=get_phrase('invoices');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?finance/cashbook">
								<span class="title"><?=get_phrase('cashbook');?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php?finance/budget">
								<span class="title"><?=get_phrase('budget');?></span>
							</a>
						</li>
							
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?finance/monthly_reconciliation">
								<span class="title"><?=get_phrase('monthly_reconciliation');?></span>
							</a>
						</li>
						<li class="has-sub">
							<a href="#">
								<span class="title"><?=get_phrase('financial_reports');?></span>
							</a>
							<ul>
								<li>
									<a href="<?php echo base_url(); ?>index.php?finance/fund_balance_report">
										<span class="title"><?=get_phrase('fund_balance');?></span>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php?finance/expense_variance_report">
										<span class="title"><?=get_phrase('expense_variance');?></span>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php?finance/income_variance_report">
										<span class="title"><?=get_phrase('income_variance');?></span>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php?finance/funds_transfers_report">
										<span class="title"><?=get_phrase('funds_transfers');?></span>
									</a>
								</li>
							</ul>
						</li>
														
					</ul>
				</li>
						
				<li class="has-sub">
					<a href="#">
						<i class="entypo-bag"></i>
							<span class="title"><?=get_phrase('inventory');?></span>
					</a>
					<ul>
						<li>
							 <a href="<?php echo base_url(); ?>index.php?Books/book">
								<span class="title"><?=get_phrase('library');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?transport/transport">
								<span class="title"><?=get_phrase('transport');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?dormitory/dormitory">
								<span class="title"><?=get_phrase('dormitory');?></span>
							</a>
						</li>
						
					</ul>
				</li>
				
				<li class="has-sub">
					<a href="#">
						<i class="entypo-mail"></i>
							<span class="title"><?=get_phrase('messaging');?></span>
					</a>
					<ul>
						<li>
							<a href="<?php echo base_url(); ?>index.php?events/noticeboard">
								<span class="title"><?=get_phrase('noticeboard');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?Messages/message">
								<span class="title"><?=get_phrase('messages');?></span>
							</a>
						</li>
						
						
					</ul>
				</li>
				
				
				<li class="has-sub">
					<a href="#">
						<i class="fa fa-gear"></i>
							<span class="title"><?=get_phrase('settings');?></span>
					</a>
					<ul>
						<li>
							<a href="<?php echo base_url(); ?>index.php?settings/system_settings">
								<span class="title"><?=get_phrase('general_settings');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?settings/sms_settings">
								<span class="title"><?=get_phrase('sms_settings');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?settings/manage_language">
								<span class="title"><?=get_phrase('language_settings');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?settings/school_settings">
								<span class="title"><?=get_phrase('school_settings');?></span>
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url(); ?>index.php?settings/user_profiles">
								<span class="title"><?=get_phrase('user_profiles');?></span>
							</a>
						</li>
						
					</ul>
				</li>
				
			</ul>
						
			
			<!-- notifications and other links -->
			<ul class="nav navbar-right pull-right">
	
				<li class="sep"></li>
				
				<li>
					<a href="<?php echo base_url();?>index.php?login/logout">
						<?=get_phrase('log_out');?> <i class="entypo-logout right"></i>
					</a>
				</li>
				
				
				<!-- mobile only -->
				<li class="visible-xs">	
				
					<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
					<div class="horizontal-mobile-menu visible-xs">
						<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
							<i class="entypo-menu"></i>
						</a>
					</div>
					
				</li>
				
			</ul>
	
		</div>
		
	</header>