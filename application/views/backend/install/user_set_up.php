<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

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
            <?php echo form_open(base_url() . 'index.php?install/set_up_admin_user/create' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data' , 'id'=>'my_form'));?>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('first_name');?></label>
                  <div class="col-xs-9">
                      <input type="text" class="form-control" name="first_name" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('last_name');?></label>
                  <div class="col-xs-9">
                      <input type="text" class="form-control" name="last_name" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('gender');?></label>
                  <div class="col-xs-9">
                      <select class="form-control" name="sex">
                        <option value=""><?=get_phrase('select');?></option>
                        <option value="male"><?=get_phrase('male');?></option>
                        <option value="female"><?=get_phrase('female');?></option>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('email');?></label>
                  <div class="col-xs-9">
                      <input type="email" class="form-control" name="email" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('phone');?></label>
                  <div class="col-xs-9">
                      <input type="text" class="form-control" name="phone" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('password');?></label>
                  <div class="col-xs-9">
                      <input type="password" class="form-control" name="password" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('confirm_password');?></label>
                  <div class="col-xs-9">
                      <input type="password" class="form-control" name="password" />
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-xs-12">
                      <button type="submit" class="btn btn-success"><?=get_phrase('create_account');?></button>
                  </div>
              </div>

            </form>
            <script type='text/javascript'>
            	
            	$("#my_form")[0].reset();
            </script>
          </div>
      </div>
  </div>
</div>
