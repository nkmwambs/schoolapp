<?php
$class = $this->db->get_where('class',array('class_id'=>$scheme->class_id))->row()->name; 
$subject = $this->db->get_where('subject',array('class_id'=>$scheme->subject_id))->row()->name;
$term = $this->db->get_where('terms',array('terms_id'=>$scheme->term_id))->row()->name;
//print_r($scheme_details);
?>

<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><?=get_phrase('school');?></th>
					<th><?=get_phrase('class');?></th>
					<th><?=get_phrase('subject');?></th>
					<th><?=get_phrase('term');?></th>
					<th><?=get_phrase('year');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?=$system_title;?></td>
					<td><?=$class;?></td>
					<td><?=$subject;?></td>
					<td><?=$term;?></td>
					<td><?=$scheme->year;?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<hr />

<div class="row">
	<div class="col-xs-12">
		<a href="<?=base_url();?>index.php?subject/scheme_detail/<?=$scheme->scheme_header_id;?>" class="btn btn-info"><?=get_phrase('add_scheme_detail');?></a>
		<hr />
		<table class="table table-bordered datatable">
			<thead>
				<tr>
					<th><?=get_phrase('week');?></th>
					<th><?=get_phrase('lesson');?></th>
					<th><?=get_phrase('strand');?></th>
					<th><?=get_phrase('sub_strand');?></th>
					<th><?=get_phrase('specific_learning_outcomes');?></th>
					<th><?=get_phrase('key_inquiry_question');?></th>
					<th><?=get_phrase('learning_experiences');?></th>
					<th><?=get_phrase('learning_resources');?></th>
					<th><?=get_phrase('assessment');?></th>
					<th><?=get_phrase('action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($scheme_details as $row){
						
				?>	
					<tr>
						<td><?=$row->week;?></td>
						<td><?=$row->lesson;?></td>
						<td><?=$row->strand;?></td>
						<td><?=$row->sub_strand;?></td>
						<td><?=$row->learning_outcomes;?></td>
						<td><?=$row->inquiry_question;?></td>
						<td><?=$row->learning_experiences;?></td>
						<td><?=$row->learning_resources;?></td>
						<td><?=$row->assessment;?></td>
						<td>
							
							<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?subject/lesson_plan/<?php echo $row->scheme_id;?>">
                                                <i class="fa fa-plus"></i>
                                                    <?php echo get_phrase('lesson_plan');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?subject/edit_scheme_detail/<?php echo $row->scheme_id;?>">
                                                <i class="fa fa-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        
                                        <li>
                                            <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?subject/scheme_detail/delete/<?php echo $row->scheme_id;?>');">
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