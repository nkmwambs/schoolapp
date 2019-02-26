<div class="row">
	<div class="col-sm-12">
		
		<div class="btn btn-primary" onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_profile_add');">Add Profile</div>
		
		<hr/>
		
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Profile Name</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$profiles = $this->db->get('profile');
					if($profiles->num_rows() > 0){
						foreach($profiles->result_object() as $rows){
				?>
					<tr>
						<td><?=$rows->name;?></td>
						<td><?=$rows->description;?></td>
						<td>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
									Action <span class="caret"></span>
								</button>
								
								<ul class="dropdown-menu dropdown-default pull-right" role="menu">
									<li class="set_up_entitlement">
										<a href="<?php echo base_url();?>index.php?settings/entitlement/<?=$rows->profile_id;?>">
											<i class="fa fa-link"></i>
											Entitlement
										</a>
									</li>
									
									<li class="divider set_up_entitlement"></li>
									
									<li class="edit_profile">
										<a href="<?php echo base_url();?>index.php?settings/entitlement/<?=$rows->profile_id;?>">
											<i class="fa fa-pencil"></i>
											Edit
										</a>
									</li>
									
									<li class="divider edit_profile"></li>
									
									<li class="delete_profile">
										<a href="<?php echo base_url();?>index.php?settings/entitlement/<?=$rows->profile_id;?>">
											<i class="fa fa-eraser"></i>
											Delete
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		var datatable=  $(".table").DataTable();
	});
</script>