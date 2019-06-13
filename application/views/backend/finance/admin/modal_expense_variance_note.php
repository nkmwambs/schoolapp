<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
		<div class="col-md-12">
        	<div class="panel panel-default panel-shadow" data-collapsed="0">
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo get_phrase('expense_variance_note');?>: <?=$this->db->get_where('income_categories',array('income_category_id'=>$param2))->row()->name;?></div>
              	</div>
	            
	            <div class="panel-body">
	            	<?php echo form_open(base_url() . 'index.php?finance/add_expense_variance_note/'.$param2.'/'.$param3 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
					
					<div class="form-group">
						<div class="col-xs-12">
							<?php
								$note = "";
								$note_obj = $this->db->get_where('expense_variance_note',array('month'=>$param3,'income_category_id'=>$param2));
								if($note_obj->num_rows() > 0){
									$note = $note_obj->row()->note;
								}
							?>
							<textarea class="form-control" rows="10" name="note" placeholder='Enter comment here'><?=$note;?></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-xs-12">
							<button class="btn btn-primary"><?=get_phrase('post_note');?></button>
						</div>
					</div>
					
					</form>
	            </div>
        </div>
     </div>
</div>
	            
