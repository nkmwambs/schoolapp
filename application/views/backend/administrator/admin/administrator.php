<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-users"></i>
                            <?php echo get_phrase($page_title);?>
                        </div>
                    </div>
                    <div class="panel-body">
                    	
                    	<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_admin_add/');"
			            	class="btn btn-primary pull-right <?=get_access_class('add_administrator','admin','administrator')?>">
			                <i class="entypo-plus-circled"></i>
			            	<?php echo get_phrase('add_new_admin');?>
			                </a>
                    	
                    	<table class="table table-striped datatable">
                    		<thead>
                    			<tr>
                    				<th><?=get_phrase('name');?></th>
                    				<th><?=get_phrase('email');?></th>
                    				<th><?=get_phrase('phone');?></th>
                    				<th><?php echo get_phrase("promoted_user");?></th>
                    				<th><?php echo get_phrase("user_profile");?></th>
                    				<th><?=get_phrase('level');?></th>
                    				<th><?=get_phrase('action');?></th>
                    			</tr>
                    		</thead>
                    		
                    		<tbody>
                    			<?php
                    				foreach($records as $row){
                    			?>
                    				<tr>
                    					<td><?=$row->name;?></td>
                    					<td><?=$row->email;?></td>
                    					<td><?=$row->phone;?></td>
                    					<?php
				                            	$promoted = get_phrase("no");
												$profile = get_phrase("none");
				                            	$user = $this->db->get_where("user",array("email"=>$row->email));
				                            	if($user->num_rows()>0){
				                            		$promoted = get_phrase("yes");
													
													if($user->row()->profile_id > 0){
														$profile = $this->db->get_where("profile",array("profile_id"=>$user->row()->profile_id))->row()->name;	
													}
													
				                            	}
									
										?>
                    					
                    					<td><?=$promoted;?></td>
                    					<td><?=$profile;?></td>
                    					
                    					<td><?=ucfirst($row->level);?></td>
                    					<td>
                    						<div class="btn-group">
			                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			                                        Action <span class="caret"></span>
			                                    </button>
			                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
													
													<!-- Promote a Admin to A user -->
			                                        <li class="<?=get_access_class('promote_admin_to_user','admin','administrator')?>">
			                                        	<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/promote_to_user/admin/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-thumbs-up"></i>
																<?php echo get_phrase('promote_to_user');?>
			                                               	</a>
			                                        </li>
			                                        <li class="divider <?=get_access_class('promote_admin_to_user','admin','administrator')?>"></li>
			                                        
			                                        <li class="<?=get_access_class('edit_admin','admin','administrator')?>">
			                                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_admin_edit/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-pencil"></i>
																<?php echo get_phrase('edit');?>
			                                               	</a>
			                                        </li>
			                                        <li class="divider <?=get_access_class('edit_admin','admin','administrator')?>"></li>
			                                        
			                                         <!-- Assign Profile -->
			                                        <li class="<?=get_access_class("assign_profile",$this->session->login_type,"administrator");?>">
			                                        	<a href="#" onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_assign_profile/admin/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-link"></i>
																<?php echo get_phrase('change_profile');?>
			                                               	</a>
			                                        </li>
			                                        <li class="divider <?=get_access_class("assign_profile",$this->session->login_type,"administrator");?>"></li>
			                                        
			                                        
			                                        <!-- Admin DELETION LINK -->
			                                        <li class="<?=get_access_class('delete_admin','admin','administrator')?>">
			                                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/admin/delete/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-trash-o"></i>
																<?php echo get_phrase('delete');?>
			                                             </a>
			                                        </li>
			                                        
			                                     </ul>
			                                  </div>      
                    					</td>
                    				</tr>
                    			<?php
									}
                    			?>
                    		</tbody>
                    	</table>
                    </div>
              </div>
         </div>
     </div>
                    
