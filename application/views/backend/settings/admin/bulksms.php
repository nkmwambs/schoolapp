<div class="row">
	<div class="col-xs-12">
		<?php echo form_open(base_url() . 'index.php?settings/send_bulksms', array('id'=>'frm_sms','class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
			<div class="form-group">
				<label class="control-label col-xs-4">Phone Number</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="phone" name="phone" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-xs-4">Phone Number</label>
				<div class="col-xs-8">
					<textarea class="form-control" id="message" name="message" rows="6"></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-xs-offset-6 col-xs-6">
					<div class="btn btn-primary" id="send">Send</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-xs-12" id="response">
					
				</div>
			</div>
			
			
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
               $("#response").html(resp);
               $("#overlay").css('display','none');
            },
            error:function(error){
            	alert(error);
            }
        });
	});
</script>