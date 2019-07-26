<table class="table table-striped datatable">
  <thead>
    <tr>
      <th><?=get_phrase('approval_record_type');?></th>
      <th><?=get_phrase('record_reference');?></th>
      <th><?=get_phrase('request_type');?></th>
      <th><?=get_phrase('status');?></th>
      <th><?=get_phrase('created_date');?></th>
      <th><?=get_phrase('last_modified_date');?></th>
      <th><?=get_phrase('action');?></th>
    </tr>
  </thead>

  <tbody>
    <?php
    foreach ($records as $approval) {
        $reference_field = 	$this->crud_model->get_type_name_by_id('record_type',$approval->record_type_id,'reference_field');
        $record_type = $this->crud_model->get_type_name_by_id('record_type',$approval->record_type_id);
        $reference_value = $this->db->get_where($record_type,array($record_type.'_id'=>$approval->record_type_primary_id))->row()->$reference_field;
    ?>
      <tr>
        <td><?=ucfirst($record_type);?></td>
        <td>
            <?=$reference_value;?>
            <!--Check if request has a comment and show bubble-->
            <?php
                $approval_request_message = $this->db->get_where('approval_request_messaging',
                array('approval_request_id'=>$approval->approval_request_id,'recipient_id'=>0));

                if($approval_request_message->num_rows()>0){
            ?>
                <i onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_request_comment_view/<?=$approval->approval_request_id;?>');" style="font-size:14pt;color:green;" title="<?=$approval_request_message->row()->message;?>" class="fa fa-comments-o"></i>
            <?php
          }else{
            ?>
                <i onclick="showAjaxModal('<?=base_url();?>index.php?modal/popup/modal_request_comment_view/<?=$approval->approval_request_id;?>');" style="font-size:14pt;color:red;" title="" class="fa fa-comments-o"></i>
            <?php
          }
             ?>

        </td>
        <td><?=ucfirst($this->crud_model->get_type_name_by_id('request_type',$approval->request_type_id));?></td>
        <td><?=ucfirst($status[$approval->status]);?></td>
        <td><?=$approval->created_date;?></td>
        <td><?=$approval->last_modified_date;?></td>
        <td>
          <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                      <!-- Approve request  -->
                      <?php if($approval->status !=="1"){ ?>
                        <li class="<?=get_access_class('approve_request','admin','approval')?>">
                          <a href="#" onclick="confirm_ajax_action('<?php echo base_url();?>index.php?approval/take_action/approve/<?php echo $approval->approval_request_id;?>','table_data');">
                              <i class="fa fa-thumbs-up"></i>
                              <?php echo get_phrase('approve');?>
                          </a>
                        </li>
                      <?php  }?>

                      <?php  if($approval->status !=="2"){?>

                        <li class="divider <?=get_access_class('decline_request','admin','approval')?>"></li>
                        <!-- Decline request  -->
                        <li class="<?=get_access_class('decline_request','admin','approval')?>">
                          <a href="#" onclick="confirm_ajax_action('<?php echo base_url();?>index.php?approval/take_action/decline/<?php echo $approval->approval_request_id;?>','table_data');">
                              <i class="fa fa-thumbs-down"></i>
                              <?php echo get_phrase('decline');?>
                          </a>
                        </li>
                      <?php  }?>
                        <!-- <li class="divider <?=get_access_class('approval_comment','admin','approval')?>"></li>

                        <li class="<?=get_access_class('approve_request','admin','approval')?>">
                          <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?approval/take_action/comment/<?php echo $approval->approval_request_id;?>');">
                              <i class="fa fa-comments-o"></i>
                              <?php echo get_phrase('comment');?>
                          </a>
                        </li> -->
                </ul>
              </div>

        </td>
      </tr>
    <?php }?>
  </tbody>
</table>
