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
								$beneficiaries  = $this->db->get_where('caregiver',array('parent_id'=>$param2))->result_object();
								
								foreach($beneficiaries as $row):
									$this->db->select(array('student_id','student.name as name','roll','class.name as class'));
									$this->db->join('class','class.class_id=student.class_id');
									$student = $this->db->get_where('student',array('student_id'=>$row->student_id,'active'=>1))->row();

						?>
								<tr>
									<td><?=$student->name;?></td>
									<td><?=$student->roll;?></td>
									<td><?=$student->class;?></td>
								</tr>				
						
						<?php
								endforeach;			
							}

						?>
							
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>				
	