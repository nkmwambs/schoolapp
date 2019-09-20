<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<div class="row">
  <div class="col-xs-offset-2 col-xs-8 col-xs-offset-2">
    <div class="panel panel-success" data-collapsed="0">
        <div class="panel-heading">
              <div class="panel-title">
                    <i class="fa fa-users"></i>
                        <?php echo $page_title;?>
                </div>
          </div>
          <div class="panel-body">
            <?php echo form_open(base_url() . 'index.php?install/set_up_admin_user/create' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

            <div class="form-group">
                <label for="" class="label-control col-xs-3"><?=get_phrase('school_name');?></label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name="" />
                </div>
            </div>

            <div class="form-group">
                <label for="" class="label-control col-xs-3"><?=get_phrase('school_address');?></label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name="" />
                </div>
            </div>

            <div class="form-group">
                <label for="" class="label-control col-xs-3"><?=get_phrase('school_phone');?></label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name="" />
                </div>
            </div>

            <div class="form-group">
                <label for="" class="label-control col-xs-3"><?=get_phrase('school_email');?></label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name="" />
                </div>
            </div>


            <div class="form-group">
                <div class="col-xs-12">
                    <a href="<?=base_url().'index.php?install/set_up_admin_user'?>" class="btn btn-success pull-left"><?=get_phrase('back');?></a>
                    <button type="submit" class="btn btn-success pull-right"><?=get_phrase('save_settings');?></button>
                </div>
            </div>

          </form>
          </div>
      </div>
  </div>
</div>
