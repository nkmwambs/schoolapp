<?php
$class = $this->db->get_where('class' , array('class_id' => $class_id));

?>

<hr />
<div class='row'>
    <div class='col-xs-4'>
        <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/student_add/');"
            class="btn btn-primary <?=get_access_class("student_admission",$this->session->login_type,"accounts");?>" >
                <?php echo get_phrase('add_new_student');?>
        </a>
    </div>

    <div class='col-xs-4' style='text-align:center;'>
        <?=get_phrase('class_name');?>: <?=$class->row()->name;?>
    </div>

    <div class='col-xs-4'>
        <?php
        $new_numeric = $class->row()->name_numeric + 1;
        $new_class = $this->db->get_where("class",array("name_numeric"=>$new_numeric));

            if($new_class->num_rows() > 0 && $this->db->get_where('student',array('class_id'=>$class_id))->num_rows() > 0){
        ?>
        <a href="javascript:;" onclick="confirm_action('<?php echo base_url();?>index.php?student/student_promote/mass_promotion/<?php echo $class_id;?>');"
            class="btn btn-primary promote_student <?=get_access_class("promote_student",$this->session->login_type,"accounts");?>">
                <i class="entypo-forward"></i>
                <?php echo get_phrase('promote_students');?> : <?php echo $new_class->row()->name;?>
        <?php
            }
        ?>
        </a>
    </div>
</div>


<hr/>
<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                </a>
            </li>

            <li>
            	<a href="#suspended" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('transitioned_students');?></span>
                </a>
            </li>
        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <li>
                <a href="#<?php echo $row['section_id'];?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('section');?> <?php echo $row['name'];?> ( <?php echo $row['nick_name'];?> )</span>
                </a>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </ul>

        <div class="tab-content">
          <p></p>
            <div class="tab-pane active" id="home">

                <table class="table table-striped datatable table-responsive-xs" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll');?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('primary_caregiver');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('secondary_caregiver');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $students   =   $this->db->get_where('student' , array('class_id'=>$class_id,"active"=>1))->result_array();
                                foreach($students as $row):?>
                        <tr>
                            <td><?php echo $row['roll'];?></td>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                
                            <td><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');"><?=ucwords($row['name']);?></a></td>
                            <td><?php echo $row['parent_id']!=0?$this->crud_model->get_type_name_by_id('parent',$row['parent_id']):get_phrase('not_set');?></td>
                            <td>
                                <?php 
                                    $sec_parent_obj = $this->db->get_where('parent', array('primary_parent_id' => $row['parent_id']));
                                   //  echo $row['phone'];
                                   if($sec_parent_obj->num_rows() > 0){
                                        $care_names = array_column($sec_parent_obj->result_array(), 'name');
                                        echo implode(',', $care_names);
                                   }
                                ?>
                            </td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?exam/student_marksheet/<?php echo $row['student_id'];?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li>

										<li class="divider"></li>

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <li class="divider"></li>


                                        <!-- STUDENT EDITING LINK -->
                                        <li class="<?=get_access_class("edit_student",$this->session->login_type,"accounts");?> ">
                                            <a  href="<?php echo base_url();?>index.php?student/student_edit/<?php echo $row['student_id'];?>" >
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>

                                       <li class="divider <?=get_access_class("edit_student",$this->session->login_type,"accounts");?>"></li>

                                        <!-- STUDENT PROMOTE LINK -->
                                        <?php

                                        	if($this->school_model->highest_class_numeric() !== $class_id){
                                        ?>
                                        <li class="<?=get_access_class("promote_student",$this->session->login_type,"accounts");?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/student_promote/single_promotion/<?php echo $class_id;?>/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-fast-forward"></i>
                                                    <?php echo get_phrase('promote');?>
                                                </a>
                                        </li>

                                       <li class="divider <?=get_access_class("promote_student",$this->session->login_type,"accounts");?>"></li>

										 <?php
											}

                                        	if($this->school_model->lowest_class_numeric() !== $class_id){
                                        ?>
                                        <!-- STUDENT DEMOTE LINK -->
                                        <li class=" <?=get_access_class("demote_student",$this->session->login_type,"accounts");?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/student_promote/single_demotion/<?php echo $class_id;?>/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-fast-backward"></i>
                                                    <?php echo get_phrase('demote');?>
                                                </a>
                                        </li>


                                        <li class="divider <?=get_access_class("demote_student",$this->session->login_type,"accounts");?>"></li>
										<?php
											}
										?>
                                        <!-- STUDENT SUSPEND LINK -->
                                        <li class=" <?=get_access_class("suspend_student",$this->session->login_type,"accounts");?>">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_transition_student/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('transition');?>
                                                </a>
                                        </li>

                                        <li class="divider <?=get_access_class("suspend_student",$this->session->login_type,"accounts");?>"></li>

                                         <!-- Promote a Admin to A user -->
                                         <li class="<?=get_access_class('promote_admin_to_user',$this->session->login_type,'accounts')?>">
			                                    <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/promote_to_user/student/<?php echo $row['student_id'];?>');">
			                                        <i class="fa fa-thumbs-up"></i>
												        <?php echo get_phrase('promote_to_user');?>
			                                    </a>
			                                </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>


            <div class="tab-pane table-responsive-xs" id="suspended">
            	<table class="table table-striped datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll');?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('transition_type');?></div></th>
                            <th><?=get_phrase('transition_status');?></th>
                            <th><div><?php echo get_phrase('transition_date');?></div></th>
                            <th><div><?php echo get_phrase('reason');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        		$this->db->select(array('transition.name as transition_type','roll','student.student_id',
                        		'student.name','transition_date','reason','transition_detail.status'));

                        		$this->db->join('transition','transition.transition_id=transition_detail.transition_id');
                                $this->db->join('student','student.student_id=transition_detail.student_id');
                                $suspended_students   =   $this->db->get_where('transition_detail' , array('student.class_id'=>$class_id))->result_array();
                                foreach($suspended_students as $row):?>
                        <tr>
                            <td><?php echo $row['roll'];?></td>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo ucfirst($row['transition_type']);?></td>
                            <td><?=$row['status'] == 1?get_phrase('active'):get_phrase('inactive'); ?></td>
                            <td><?php echo $row['transition_date'];?></td>
                            <td><?php echo $row['reason'];?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <li class="divider"></li>

                                        <!-- STUDENT UNSUSPEND LINK -->
                                        <?php
                                        if($row['status'] == 1){
                                        ?>
                                        <li class="<?=get_access_class("reinstate_student",$this->session->login_type,"accounts");?> ">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/student/<?php echo $class_id;?>/reinstate/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-cw"></i>
                                                    <?php echo get_phrase('reinstate');?>
                                                </a>
                                        </li>

                                        <?php
										}
                                        ?>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>


        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll');?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('address');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $students   =   $this->db->get_where('student' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id']
                                ))->result_array();
                                foreach($students as $row):?>
                        <tr>
                            <td><?php echo $row['roll'];?></td>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['address'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <!-- STUDENT EDITING LINK -->
                                        <li class="<?=get_access_class("edit_student",$this->session->login_type,"accounts");?> ">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_edit/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("edit_student",$this->session->login_type,"accounts");?>"></li>

                                        <!-- STUDENT DELETION LINK -->
                                        <li class="<?=get_access_class("delete_student",$this->session->login_type,"accounts");?>">
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/student/<?php echo $class_id;?>/delete/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('delete');?>
                                                </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php endforeach;?>
        <?php endif;?>

        </div>


    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});

</script>
