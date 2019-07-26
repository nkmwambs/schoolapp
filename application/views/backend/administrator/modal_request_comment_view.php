<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$comments = $this->db->get_where('approval_request_messaging',array('approval_request_id'=>$param2))->result_object();
$request = $this->db->get_where('approval_request',array('approval_request_id'=>$param2))->row();

?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('view_comments');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url().'index.php?admin/proccess_request_approval/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

                  <div class="form-group">
                    <div class="col-xs-2"><?=get_phrase('sender');?></div>
                    <div class="col-xs-8"><?=get_phrase('message');?></div>
                    <div class="col-xs-2"><?=get_phrase('date');?></div>
                  </div>
                    <?php
                      foreach ($comments as $comment) {
                    ?>
                    <div class="form-group">
                      <div class="col-xs-2">
                          <div><?=$this->crud_model->get_type_name_by_id('user',$comment->sender_id,'firstname');?></div>
                      </div>
                        <div class="col-xs-8">
                            <div><?=$comment->message;?></div>
                        </div>
                        <div class="col-xs-2">
                            <div><?=$comment->created_date;?></div>
                        </div>
                      </div>
                    <?php

                      }
                     ?>


                  <div class="form-group">
                    <div class="col-xs-12">
                        <textarea required="required" name="request_message" class="form-control" rows="5" placeholder="Enter request reason here"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="submit" name="approval_action" value="post_comment" class="btn btn-default"><?=get_phrase('post_comment');?></button>
											<?php if($request->status !== '1'){ ?>
											<button type="submit" name="approval_action" value="approve" class="btn btn-success"><?=get_phrase('approve');?></button>
											<?php  }?>
											<?php  if($request->status !== '2'){?>
											<button type="submit" name="approval_action" value="decline" class="btn btn-danger"><?=get_phrase('decline');?></button>
										<?php  }?>
										</div>
                  </div>

                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
