<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
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
							<th><?php echo get_phrase('class');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($param3 === "primary"){
								$this->db->select(array('student_id','student.name as name','roll','class.name as class'));
								$this->db->join('class','class.class_id=student.class_id');
								$beneficiaries  = $this->db->get_where('student',array('parent_id'=>$param2,'active'=>1))->result_object();
								foreach($beneficiaries as $row):
						?>
								<tr>
									<td><?=$row->name;?></td>
									<td><?=$row->roll;?></td>
									<td><?=$row->class;?></td>
								</tr>
						<?php	
								endforeach;	
							}else{
								$beneficiaries = 0;
								$primary_parent_id = $this->db->get_where('parent',array('parent_id' => $param2))->row()->primary_parent_id;
    
                                if($primary_parent_id){
									$this->db->select(array('student_id','student.name as name','roll','class.name as class'));
									$this->db->join('class','class.class_id=student.class_id');
                                    $beneficiaries = $this -> db -> get_where('student', array('parent_id' => $primary_parent_id, 'active' => 1));
								
								if($beneficiaries->num_rows() > 0){
								foreach($beneficiaries->result_object() as $student):

						?>
								<tr>
									<td><?=$student->name;?></td>
									<td><?=$student->roll;?></td>
									<td><?=$student->class;?></td>
								</tr>				
						
						<?php
								endforeach;		
							}	
							}
						}

						?>
							
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>				
	