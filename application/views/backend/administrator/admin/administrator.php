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
			            	class="btn btn-primary pull-right add_teacher">
			                <i class="entypo-plus-circled"></i>
			            	<?php echo get_phrase('add_an_admin');?>
			                </a>
                    	
                    	<table class="table table-striped datatable">
                    		<thead>
                    			<tr>
                    				<th><?=get_phrase('name');?></th>
                    				<th><?=get_phrase('email');?></th>
                    				<th><?=get_phrase('birthdate');?></th>
                    				<th><?=get_phrase('gender');?></th>
                    				<th><?=get_phrase('phone');?></th>
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
                    					<td><?=$row->birthday;?></td>
                    					<td><?=ucfirst($row->sex);?></td>
                    					<td><?=$row->phone;?></td>
                    					<td><?=ucfirst($row->level);?></td>
                    					<td>
                    						<div class="btn-group">
			                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
			                                        Action <span class="caret"></span>
			                                    </button>
			                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
													
													<!-- Promote a Teacher to A user -->
			                                        <li class="promote_admin_to_user">
			                                        	<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/promote_to_user/admin/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-thumbs-up"></i>
																<?php echo get_phrase('promote_to_user');?>
			                                               	</a>
			                                        </li>
			                                        <li class="divider promote_teacher_to_user"></li>
			                                        
			                                        <li class="edit_admin">
			                                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_admin_edit/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-pencil"></i>
																<?php echo get_phrase('edit');?>
			                                               	</a>
			                                        </li>
			                                        <li class="divider edit_teacher"></li>
			                                        
			                                        <!-- teacher DELETION LINK -->
			                                        <li class="delete_teacher">
			                                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/admin/delete/<?php echo $row->admin_id;?>');">
			                                            	<i class="fa fa-trash"></i>
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
                    
