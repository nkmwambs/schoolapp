<?php
$class = $this->db->get_where('class' , array('class_id' => $class_id));
?>

<hr />
<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/student_add/');"
    class="btn btn-primary pull-right <?=get_access_class("student_admission",$this->session->login_type,"student");?>" >
        <?php echo get_phrase('add_new_student');?>
</a>

<?php 
	$new_numeric = $class->row()->name_numeric + 1; 
    $new_class = $this->db->get_where("class",array("name_numeric"=>$new_numeric));
	
	if($new_class->num_rows() > 0 && $this->db->get_where('student',array('class_id'=>$class_id))->num_rows() > 0){
?>
<a href="javascript:;" onclick="confirm_action('<?php echo base_url();?>index.php?student/student_promote/mass_promotion/<?php echo $class_id;?>');"
    class="btn btn-primary pull-left promote_student">
        <i class="entypo-forward"></i>
        <?php echo get_phrase('promote_students');?> : <?php echo $new_class->row()->name;?>
<?php 
	}
?>        
</a>

<br>

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
                    <span class="hidden-xs"><?php echo get_phrase('suspended_students');?></span>
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
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
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
                                $students   =   $this->db->get_where('student' , array('class_id'=>$class_id,"active"=>1))->result_array();
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

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?exam/student_marksheet/<?php echo $row['student_id'];?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li>


                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <!-- STUDENT EDITING LINK -->
                                        <li class="<?=get_access_class("edit_student",$this->session->login_type,"student");?> ">
                                            <a  href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_edit/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        
                                       <li class="divider <?=get_access_class("edit_student",$this->session->login_type,"student");?>"></li>

                                        <!-- STUDENT PROMOTE LINK -->
                                        <li class="<?=get_access_class("promote_student",$this->session->login_type,"student");?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/student_promote/single_promotion/<?php echo $class_id;?>/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-fast-forward"></i>
                                                    <?php echo get_phrase('promote');?>
                                                </a>
                                        </li>
                                        
                                       <li class="divider <?=get_access_class("promote_student",$this->session->login_type,"student");?>"></li>

                                        <!-- STUDENT DEMOTE LINK -->
                                        <li class=" <?=get_access_class("demote_student",$this->session->login_type,"student");?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/student_promote/single_demotion/<?php echo $class_id;?>/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-fast-backward"></i>
                                                    <?php echo get_phrase('demote');?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("demote_student",$this->session->login_type,"student");?>"></li>

                                        <!-- STUDENT SUSPEND LINK -->
                                        <li class=" <?=get_access_class("suspend_student",$this->session->login_type,"student");?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/student/<?php echo $class_id;?>/delete/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('suspend');?>
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


            <div class="tab-pane" id="suspended">
            	<table class="table table-bordered datatable" id="table_export">
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
                                $suspended_students   =   $this->db->get_where('student' , array('class_id'=>$class_id,"active"=>0))->result_array();
                                foreach($suspended_students as $row):?>
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

                                        <li class="divider"></li>

                                        <!-- STUDENT UNSUSPEND LINK -->
                                        <li class="<?=get_access_class("unsuspend_student",$this->session->login_type,"student");?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?admin/student/<?php echo $class_id;?>/unsuspend/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-cw"></i>
                                                    <?php echo get_phrase('unsuspend_');?>
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


        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
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
                                        <li class="<?=get_access_class("edit_student",$this->session->login_type,"student");?>">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_edit/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("edit_student",$this->session->login_type,"student");?>"></li>

                                        <!-- STUDENT DELETION LINK -->
                                        <li class="<?=get_access_class("delete_student",$this->session->login_type,"student");?>">
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


		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [

					{
						"sExtends": "xls",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(1, false);
							datatable.fnSetColumnVis(5, false);

							this.fnPrint( true, oConfig );

							window.print();

							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(1, true);
									  datatable.fnSetColumnVis(5, true);
								  }
							});
						},

					},
				]
			},

		});

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});

</script>
