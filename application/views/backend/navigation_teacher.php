<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="uploads/logo.png"  style="max-height:140px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> <?=get_access_class("dashboard",$this->session->login_type)?>">
            <a href="<?php echo base_url(); ?>index.php?dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- STUDENT -->
        <li class="<?php
        if ($page_name == 'student_add' ||
                $page_name == 'student_bulk_add' ||
                $page_name == 'student_information' ||
                $page_name == 'student_marksheet')
            echo 'opened active has-sub';
        ?> <?=get_access_class("student",$this->session->login_type)?>">
            <a href="#">
                <i class="fa fa-group"></i>
                <span><?php echo get_phrase('student'); ?></span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> <?=get_access_class("student_admission",$this->session->login_type,"student")?>">
                    <a href="<?php echo base_url(); ?>index.php?student/student_add">
                        <span><i class="fa fa-male"></i> <?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT BULK ADMISSION -->
                <li class="<?php if ($page_name == 'student_bulk_add') echo 'active'; ?> <?=get_access_class("student_admission",$this->session->login_type,"student")?>">
                    <a href="<?php echo base_url(); ?>index.php?student/student_bulk_add">
                        <span><i class="fa fa-cloud-upload"></i> <?php echo get_phrase('admit_bulk_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_marksheet') echo 'opened active'; ?> <?=get_access_class("all_student_information",$this->session->login_type,"student")?>">
                    <a href="#">
                        <span><i class="fa fa-list"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                    <ul>
                        <?php
						
						/** Restrict teachers to only see their classes **/
						
						$classes = $this->db->order_by("name_numeric","asc")->get_where('class',array("teacher_id"=>$this->session->type_login_user_id))->result_array();						
                        
                        foreach ($classes as $row):
                        										
						    ?>
                            <li class="<?php if ($page_name == 'student_information' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?> ">
                                <a href="<?php echo base_url(); ?>index.php?student/student_information/<?php echo $row['class_id']; ?>">
                                    <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

            </ul>
        </li>

        <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> <?=get_access_class("teacher",$this->session->login_type)?>">
            <a href="<?php echo base_url(); ?>index.php?teacher/teacher">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
        </li>

        <!-- PARENTS -->

        <li class="<?php
        if ($page_name == 'parent' ||
                $page_name == 'parent_activity')
            echo 'opened active has-sub';
        ?> <?=get_access_class("parent",$this->session->login_type)?>">
            <a href="#">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('parent'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'parent') echo 'active'; ?> <?=get_access_class("view_parents",$this->session->login_type,"parent")?>">
                    <a href="<?php echo base_url(); ?>index.php?parents/parent">
                        <span><i class="fa fa-user-md"></i> <?php echo get_phrase('view_parent'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'parent_activity') echo 'active'; ?> <?=get_access_class("parents_activity",$this->session->login_type,"parent")?>">
                    <a href="<?php echo base_url(); ?>index.php?parents/parent_activity">
                        <span><i class="fa fa-trophy"></i> <?php echo get_phrase('parent_activity'); ?></span>
                    </a>
                </li>
            </ul>
        </li>




        <!-- CLASS -->
        <li class="<?php
        if ($page_name == 'class' ||
                $page_name == 'section')
            echo 'opened active';
        ?> classes">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span><?php echo get_phrase('class'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'class') echo 'active'; ?> manage_classes">
                    <a href="<?php echo base_url(); ?>index.php?classes/classes">
                        <span><i class="fa fa-star-o"></i> <?php echo get_phrase('manage_classes'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'section') echo 'active'; ?> manage_sections">
                    <a href="<?php echo base_url(); ?>index.php?classes/section">
                        <span><i class="fa fa-ticket"></i> <?php echo get_phrase('manage_sections'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SUBJECT -->
        <li class="<?php if ($page_name == 'subject') echo 'opened active'; ?> subject">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('subject'); ?></span>
            </a>
            <ul>
                <?php
                $classes = $this->db->get('class')->result_array();
                foreach ($classes as $row):
                    ?>
                    <li class="<?php if ($page_name == 'subject' && $class_id == $row['class_id']) echo 'active'; ?> subjects_class_numeric_<?php echo $row['name_numeric']; ?>">
                        <a href="<?php echo base_url(); ?>index.php?subject/subject/<?php echo $row['class_id']; ?>">
                            <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

        <!-- CLASS ROUTINE -->
        <li class="<?php if ($page_name == 'class_routine') echo 'active'; ?> class_routine">
            <a href="<?php echo base_url(); ?>index.php?class_routine/class_routine">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('class_routine'); ?></span>
            </a>
        </li>

        <!-- DAILY ATTENDANCE -->
        <li class="<?php if ($page_name == 'manage_attendance') echo 'active'; ?> manage_attendance">
            <a href="<?php echo base_url(); ?>index.php?attendance/manage_attendance/<?php echo date("d/m/Y"); ?>">
                <i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('daily_attendance'); ?></span>
            </a>

        </li>

        <!-- EXAMS -->
        <li class="<?php
        if ($page_name == 'exam' ||
                $page_name == 'grade' ||
                $page_name == 'marks' ||
                    $page_name == 'exam_marks_sms' ||
                        $page_name == 'tabulation_sheet')
                            echo 'opened active';
        ?> exams">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam') echo 'active'; ?> exam_list">
                    <a href="<?php echo base_url(); ?>index.php?exam/exam">
                        <span><i class="fa fa-bell"></i> <?php echo get_phrase('exam_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'grade') echo 'active'; ?> exam_grades">
                    <a href="<?php echo base_url(); ?>index.php?exam/grade">
                        <span><i class="fa fa-archive"></i> <?php echo get_phrase('exam_grades'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'marks') echo 'active'; ?> manage_marks">
                    <a href="<?php echo base_url(); ?>index.php?exam/marks">
                        <span><i class="fa fa-bullseye"></i> <?php echo get_phrase('manage_marks'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'exam_marks_sms') echo 'active'; ?> send_marks_by_sms">
                    <a href="<?php echo base_url(); ?>index.php?exam/exam_marks_sms">
                        <span><i class="fa fa-mobile"></i> <?php echo get_phrase('send_marks_by_sms'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'tabulation_sheet') echo 'active'; ?> tabulation_sheet">
                    <a href="<?php echo base_url(); ?>index.php?exam/tabulation_sheet">
                        <span><i class="fa fa-rss"></i> <?php echo get_phrase('tabulation_sheet'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- PAYMENT -->
        <!-- <li class="<?php //if ($page_name == 'invoice') echo 'active'; ?> ">
            <a href="<?php //echo base_url(); ?>index.php?admin/invoice">
                <i class="entypo-credit-card"></i>
                <span><?php //echo get_phrase('payment'); ?></span>
            </a>
        </li> -->

        <!-- ACCOUNTING -->
        <li class="<?php
        if (	$page_name == 'income' ||
                $page_name == 'expense' ||
                $page_name == 'create_invoice' ||
                $page_name == 'income'||
                $page_name == 'student_payments'||
				$page_name == 'budget'||
				$page_name == 'cash_book'||
				$page_name == 'financial_report'||
				$page_name == 'fees_structure' ||
				$page_name == 'monthly_reconciliation'
				)
                echo 'opened active';
        ?> accounting">
            <a href="#">
                <i class="entypo-suitcase"></i>
                <span><?php echo get_phrase('accounting'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'fees_structure') echo 'active'; ?> fees_structure">
                    <a href="<?php echo base_url(); ?>index.php?finance/fees_structure">
                        <span><i class="fa fa-tasks"></i> <?php echo get_phrase('fees_structure'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'create_invoice') echo 'active'; ?> create_invoice">
                    <a href="<?php echo base_url(); ?>index.php?finance/create_invoice">
                        <span><i class="fa fa-bookmark"></i> <?php echo get_phrase('create_invoice'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'student_payments') echo 'active'; ?> students_income">
                    <a href="<?php echo base_url(); ?>index.php?finance/student_payments">
                        <span><i class="fa fa-money"></i> <?php echo get_phrase('students_income'); ?></span>
                    </a>
                </li>
				
				<li class="<?php if ($page_name == 'income') echo 'active'; ?> other_income">
                    <a href="<?php echo base_url(); ?>index.php?finance/income">
                        <span><i class="fa fa-credit-card"></i> <?php echo get_phrase('other_income'); ?></span>
                    </a>
                </li>
					
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?> school_expenses">
                    <a href="<?php echo base_url(); ?>index.php?finance/expense">
                        <span><i class="fa fa-credit-card"></i> <?php echo get_phrase('school_expenses'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'cash_book') echo 'active'; ?> cash_book">
                    <a href="<?php echo base_url(); ?>index.php?finance/cash_book">
                        <span><i class="fa fa-book"></i> <?php echo get_phrase('cash_book'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'budget') echo 'active'; ?> budget">
                    <a href="<?php echo base_url(); ?>index.php?finance/budget">
                        <span><i class="fa fa-code"></i> <?php echo get_phrase('budget'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'monthly_reconciliation') echo 'active'; ?> monthly_reconciliation">
                    <a href="<?php echo base_url(); ?>index.php?finance/monthly_reconciliation">
                        <span><i class="fa fa-bell"></i> <?php echo get_phrase('monthly_reconciliation'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'financial_report') echo 'active'; ?> financial_report">
                    <a href="<?php echo base_url(); ?>index.php?finance/financial_report">
                        <span><i class="fa fa-filter"></i> <?php echo get_phrase('financial_report'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- LIBRARY -->
        <li class="<?php if ($page_name == 'book') echo 'active'; ?> library">
            <a href="<?php echo base_url(); ?>index.php?Books/book">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('library'); ?></span>
            </a>
        </li>

        <!-- TRANSPORT -->
        <li class="<?php if ($page_name == 'transport') echo 'active'; ?> transport">
            <a href="<?php echo base_url(); ?>index.php?transport/transport">
                <i class="entypo-location"></i>
                <span><?php echo get_phrase('transport'); ?></span>
            </a>
        </li>

        <!-- DORMITORY -->
        <li class="<?php if ($page_name == 'dormitory') echo 'active'; ?> dormitory">
            <a href="<?php echo base_url(); ?>index.php?dormitory/dormitory">
                <i class="entypo-home"></i>
                <span><?php echo get_phrase('dormitory'); ?></span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> noticeboard">
            <a href="<?php echo base_url(); ?>index.php?events/noticeboard">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>

        <!-- MESSAGE -->
        <li class="<?php if ($page_name == 'message') echo 'active'; ?> messages">
            <a href="<?php echo base_url(); ?>index.php?Messages/message">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' ||
                $page_name == 'manage_language' ||
                    $page_name == 'sms_settings'||
					$page_name == 'school_settings' ||
					$page_name == 'user_profiles')
                        echo 'opened active';
        ?> settings">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> general_settings">
                    <a href="<?php echo base_url(); ?>index.php?settings/system_settings">
                        <span><i class="fa fa-cog"></i> <?php echo get_phrase('general_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> sms_settings">
                    <a href="<?php echo base_url(); ?>index.php?settings/sms_settings">
                        <span><i class="fa fa-mobile"></i> <?php echo get_phrase('sms_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> language_settings">
                    <a href="<?php echo base_url(); ?>index.php?settings/manage_language">
                        <span><i class="fa fa-info"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>
                 <li class="<?php if ($page_name == 'school_settings') echo 'active'; ?> school_settings">
                    <a href="<?php echo base_url(); ?>index.php?settings/school_settings">
                        <span><i class="fa fa-gears"></i> <?php echo get_phrase('school_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'user_profiles') echo 'active'; ?> user_profiles">
                    <a href="<?php echo base_url(); ?>index.php?settings/user_profiles">
                        <span><i class="fa fa-flag"></i> <?php echo get_phrase('user_profiles'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

         <!-- Admin -->
        <li class="<?php if ($page_name == 'administrator') echo 'active'; ?> administrator">
            <a href="<?php echo base_url(); ?>index.php?admin/administrator">
                <i class="entypo-user-add"></i>
                <span><?php echo get_phrase('administrators'); ?></span>
            </a>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> manage_accounts">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>
