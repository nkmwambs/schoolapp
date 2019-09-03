<div class="panel panel-default" data-collapsed="0">

      <div class="panel-heading">
          <div class="panel-title">
              <?php echo get_phrase('finance_settings');?>
          </div>
      </div>


      <div class="panel-body form-horizontal form-groups-bordered">
        <?php echo form_open(base_url().'index.php?finance/settings' , array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data'));?>

          <div class="row">
              <div class="col-xs-6">

                <div class="form-group">
                    <label class="col-xs-5 control-label"><?php echo get_phrase('manage_invoice_require_approval');?></label>
                    <div class="col-xs-7">
                        <input type="checkbox" <?php if($settings['manage_invoice_require_approval'] == 'true') echo 'checked';?> class="settings" name="manage_invoice_require_approval" id="manage_invoice_require_approval" data-toggle="toggle">
                    </div>
                </div>

              </div>
              <div class="col-xs-6">

              </div>
          </div>
      </div>
      <?php echo form_close(); ?>
  </div>

  <script>
    $(".settings").change(function(){
      var url = "<?=base_url();?>index.php?finance/settings/"+$(this).attr('id')+'/'+$(this).prop('checked');

      $.get(url);
    });
  </script>
