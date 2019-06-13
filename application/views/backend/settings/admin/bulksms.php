<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />

<div class="row">
	<div class="col-xs-12">
		<?php echo form_open(base_url() . 'index.php?settings/send_bulksms', array('id'=>'frm_sms','class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
			<div class="form-group">
				<label class="control-label col-xs-4"></label>
				<div class="col-xs-6">
					 <select class="form-control" id="multiselect" name="reciever[]" multiple="multiple" required>

			            <!-- <option value=""><?php echo get_phrase('select_a_user'); ?></option>
			            -->
			            <!-- <optgroup label="<?php echo get_phrase('parent'); ?>"> -->
			                <?php
			                $parents = $this->db->get('parent')->result_array();
			                foreach ($parents as $row):
			                    ?>
			
			                    <option value="<?php echo $row['phone']; ?>">
			                        - <?php echo $row['name']; ?></option>
			
			                <?php endforeach; ?>
			            <!-- </optgroup> -->
			           
			            <!-- <optgroup label="<?php echo get_phrase('teacher'); ?>">
			                <?php
			                $teachers = $this->db->get('teacher')->result_array();
			                foreach ($teachers as $row):
			                    ?>
			
			                    <option value="<?php echo $row['phone']; ?>">
			                        - <?php echo $row['name']; ?></option>
			
			                <?php endforeach; ?>
			            </optgroup>
			            
			            <optgroup label="<?php echo get_phrase('student'); ?>">
			                <?php
			                $students = $this->db->get('student')->result_array();
			                foreach ($students as $row):
			                    ?>
			
			                    <option value="<?php echo $row['phone']; ?>">
			                        - <?php echo $row['name']; ?></option>
			
			                <?php endforeach; ?>
			            </optgroup> -->
			           
			           
			        </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-xs-4"></label>
				<div class="col-xs-6">
					<textarea class="form-control" id="message" name="message" rows="6" placeholder='Type message here'></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-xs-offset-6 col-xs-6">
					<div class="btn btn-primary" id="send">Send</div>
				</div>
			</div>
			
			<!-- <div class="form-group">
				<div class="col-xs-12" id="response">
					
				</div>
			</div> -->
			
			
		</form>
	</div>
</div>

<script>
	$('#send').on('click',function(){
		
		var frm = $('#frm_sms');
		
		if($('#phone').val() == ""){
			alert('Please enter a phone number');
			return false;
		}
		
		 $.ajax({
            type: "POST",
            data:frm.serializeArray(),
            url: frm.attr('action'),
            beforeSend:function(){
            	$("#overlay").css('display','block');
            },
            success: function(resp){
               //$("#response").html(resp);
               $("#overlay").css('display','none');
            },
            error:function(error,msg){
            	alert(msg);
            	$("#overlay").css('display','none');
            }
        });
	});
	
	
$(document).ready(function() {
  $('#multiselect').multiselect({
    buttonWidth : '160px',
    includeSelectAllOption : true,
		nonSelectedText: 'Select an Option'
  });
});

function getSelectedValues() {
  var selectedVal = $("#multiselect").val();
	for(var i=0; i<selectedVal.length; i++){
		function innerFunc(i) {
			setTimeout(function() {
				location.href = selectedVal[i];
			}, i*2000);
		}
		innerFunc(i);
	}
}


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>