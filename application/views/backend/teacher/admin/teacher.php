<div class="row" >
	<div class="col-sm-12">
		<a href="<?php echo base_url();?>index.php?teacher/teacher_add/"
            	class="btn btn-primary pull-right <?=get_access_class('add_teacher','admin','accounts');?>">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('add_new_teacher');?>
                </a>
                <br><br>
               <table class="table table-striped datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><?php echo get_phrase("promoted_user");?></th>
                            <th><?php echo get_phrase("user_profile");?></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $teachers	=	$this->db->get('teacher' )->result_array();
                                foreach($teachers as $row):?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <?php
	                            	$promoted = get_phrase("no");
									$profile = get_phrase("none");
	                            	$user = $this->db->get_where("user",array("email"=>$row["email"]));
	                            	if($user->num_rows()>0){
	                            		$promoted = get_phrase("yes");

										if($user->row()->profile_id > 0){
											$profile = $this->db->get_where("profile",array("profile_id"=>$user->row()->profile_id))->row()->name;
										}

	                            	}

							?>
                            <td><?php echo $promoted;?></td>
                            <td><?=$profile;?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

										<!-- Promote a Teacher to A user -->
                                        <li class="<?=get_access_class("promote_teacher_to_user",$this->session->login_type,"accounts");?>">
                                        	<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/promote_to_user/teacher/<?php echo $row['teacher_id'];?>');">
                                            	<i class="fa fa-thumbs-up"></i>
													<?php echo get_phrase('promote_to_user');?>
                                               	</a>
                                        </li>
                                        <li class="divider <?=get_access_class("promote_teacher_to_user",$this->session->login_type,"accounts");?>"></li>

                                        <?php
                                        	if($user->num_rows()>0){
                                        ?>

                                        <!-- Reset Password -->
                                        <li class="<?=get_access_class("reset_teacher_password",$this->session->login_type,"accounts");?>">
                                        	<a href="#" onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_change_password/teacher/<?php echo $row['teacher_id'];?>');">
                                            	<i class="fa fa-reply"></i>
													<?php echo get_phrase('change_password');?>
                                               	</a>
                                        </li>
                                        <li class="divider <?=get_access_class("reset_teacher_password",$this->session->login_type,"accounts");?>"></li>

                                         <!-- Assign Profile -->
                                        <li class="<?=get_access_class("assign_profile",$this->session->login_type,"accounts");?>">
                                        	<a href="#" onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_assign_profile/teacher/<?php echo $row['teacher_id'];?>');">
                                            	<i class="fa fa-link"></i>
													<?php echo get_phrase('change_profile');?>
                                               	</a>
                                        </li>
                                        <li class="divider <?=get_access_class("assign_profile",$this->session->login_type,"accounts");?>"></li>

                                        <?php
                                        	}
                                        ?>

                                        <!-- teacher EDITING LINK -->
                                        <li class="<?=get_access_class("edit_teacher",$this->session->login_type,"accounts");?>">
                                        	<a href="<?php echo base_url();?>index.php?teacher/teacher_edit/<?php echo $row['teacher_id'];?>">
                                            	<i class="fa fa-pencil"></i>
													<?php echo get_phrase('edit');?>
                                               	</a>
                                        </li>
                                        <li class="divider <?=get_access_class("edit_teacher",$this->session->login_type,"accounts");?>"></li>

                                        <!-- teacher DELETION LINK -->
                                        <li class="<?=get_access_class("delete_teacher",$this->session->login_type,"accounts");?>">
                                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?teacher/teacher/delete/<?php echo $row['teacher_id'];?>');">
                                            	<i class="fa fa-trash-o"></i>
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
