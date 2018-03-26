<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-trophy"></i>
					<?php echo get_phrase('parents_activity');?>
            	</div>
            </div>
			<div class="panel-body">
				
				<div class="btn btn-primary btn-icon" onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_activity_add');"><i class="fa fa-plus-circle"></i><?=get_phrase('add_activity');?></div>
				<hr/>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?=get_phrase('activity_name');?></th>
							<th><?=get_phrase('description');?></th>
							<th><?=get_phrase('start_date');?></th>
							<th><?=get_phrase('end_date');?></th>
							<th><?=get_phrase('action');?></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>			