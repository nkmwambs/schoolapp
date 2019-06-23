<?php
//print_r($missing_invoices);

?>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('missing_invoices');?>
            	</div>
            </div>
			<div class="panel-body">
				
			  <table class="table table-bordered datatable table-responsive-xs" id="table_export">
	                    <thead>
	                        <tr>
	                            <th width="80"><div><?php echo get_phrase('roll');?></div></th>
	                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
	                            <th><div><?php echo get_phrase('name');?></div></th>
	                            <th class="span3"><div><?php echo get_phrase('class');?></div></th>
	
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php
	                           foreach($missing_invoices as $row):?>
	                        <tr>
	                            <td><?php echo $row['roll'];?></td>
	                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
	                            <td><?php echo $row['name'];?></td>
	                            <td><?php echo $row['class'];?></td>                            
	                        </tr>
	                        <?php endforeach;?>
	                    </tbody>
	                </table>
	           </div>
	        </div>         
	</div>
</div>