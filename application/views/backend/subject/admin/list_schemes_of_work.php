<hr />
<div class="row">
	<div class="col-xs-12">
		<div class="btn btn-info" 
			onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_schemes_of_work/<?=$class_id;?>/<?php echo $subject_id;?>');">
			<?=get_phrase('add_schemes_of_work')?>
		</div>
	</div>
</div>
<p></p>

<div class="row">
	<div class="col-xs-12">
		<?php
		//print_r($schemes->result_object());
		if($schemes->num_rows() == 0){
		?>
			<div class="well">No schemes of work available</div>
		<?php
		}else{
		?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><?=get_phrase('school');?></th>
					<th><?=get_phrase('class');?></th>
					<th><?=get_phrase('subject');?></th>
					<th><?=get_phrase('term');?></th>
					<th><?=get_phrase('year');?></th>
					<th><?=get_phrase('action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($schemes->result_object() as $scheme){
						$class = $this->db->get_where('class',array('class_id'=>$scheme->class_id))->row()->name; 
						$subject = $this->db->get_where('subject',array('class_id'=>$scheme->subject_id))->row()->name;
						$term = $this->db->get_where('terms',array('terms_id'=>$scheme->term_id))->row()->name;
				?>
					<tr>
						<td><?=$system_title;?></td>
						<td><?=$class;?></td>
						<td><?=$subject;?></td>
						<td><?=$term;?></td>
						<td><?=$scheme->year;?></td>
						<td>
							 <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        
                                        <li>
                                            <a href="<?=base_url();?>index.php?subject/scheme_detail/<?=$scheme->scheme_header_id;?>">
                                                <i class="fa fa-list"></i>
                                                    <?php echo get_phrase('add_details');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        
                                        
                                        <li>
                                            <a href="<?=base_url();?>index.php?subject/schemes_of_work/<?=$scheme->class_id;?>/<?=$scheme->subject_id;?>/<?=$scheme->term_id;?>/<?=$scheme->year;?>">
                                                <i class="fa fa-glass"></i>
                                                    <?php echo get_phrase('view_full_scheme');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        
                                        <li>
                                            <a href="<?=base_url();?>index.php?subject/scheme_detail/<?=$scheme->scheme_header_id;?>">
                                                <i class="fa fa-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        
                                        <li>
                                            <a href="<?=base_url();?>index.php?subject/scheme_detail/<?=$scheme->scheme_header_id;?>">
                                                <i class="fa fa-trash-o"></i>
                                                    <?php echo get_phrase('delete');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        
                                        
                                     </ul>
                               </div>  	
						</td>
					</tr>
				<?php
					}
				?>
				
			</tbody>
		</table>
		<?php	
		}
		?>
	</div>
</div>		