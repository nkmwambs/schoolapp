<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$param4 = $param4 !== ""?$param4:'invoice';

?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase($param2);?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url().'index.php?finance/'.$param4.'/'.$param2.'/'.$param3 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

                  <div class="form-group">
                    <div class="col-xs-12">
                        <textarea required="required" name="request_message" class="form-control" rows="10" placeholder="Enter request reason here"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="submit" class="btn btn-default"><?=get_phrase('send_request');?></button>
                    </div>
                  </div>

                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
