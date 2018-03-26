<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-umbrella"></i>
					<?php echo get_phrase('beneficiaries');?>
            	</div>
            </div>
			<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo get_phrase('beneficiary_name');?></th>
							<th><?php echo get_phrase('roll');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$beneficiaries  = $this->db->get_where('student',array('parent_id'=>$param2))->result_object();
							
							foreach($beneficiaries as $row):
						?>
								<tr>
									<td><?=$row->name;?></td>
									<td><?=$row->roll;?></td>
								</tr>
						<?php
							endforeach;
						?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>				
	