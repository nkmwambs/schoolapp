<hr/>
<div class="row">
	<div class="col-xs-12">
		<?php //print_r($results);?>
		<?php
			foreach($results as $table=>$data){
		?>
			<div class="row">
				<div class="col-xs-12"  style="text-align: center;">
					<span><?=ucfirst($table);?> <?=get_phrase('search_results');?></span>
				</div>
			</div>
			<?php
			foreach($data as $row){
				array_shift($row);
				$name = array_shift($row);
			?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan=""><?=$name;?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php
								foreach($row as $key=>$value){
																	
									if($table == 'parent' && $key == 'relationship_id'){
										$value = $this->db->get_where('relationship',array('relationship_id'=>$value))->row()->name;	
										$key = get_phrase('relationship');
									}
									
									if($table == 'student' && strpos($key, "_id")){
										$split_key = explode('_',$key);
										$value = $this->db->get_where($split_key[0],array($key=>$value))->row()->name;	
										$key = get_phrase($split_key[0]);
									}
									
									if($key == 'active'){
										$value = $value==1?get_phrase('yes'):get_phrase('no');	
									}
							?>
								<span style="font-weight: bold;"><?=get_phrase($key);?></span>:
								<span><?=$value==""?'Null':ucfirst($value);?></span>,
							<?php
								}
							?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php
			}
			}
		?>
	</div>
</div>