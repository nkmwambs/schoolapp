<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />

<div class="row">
	<div class="col-xs-12">
		<?php echo form_open(base_url() . 'index.php?messages/send_bulksms', array('id'=>'frm_sms','class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
			<div class="form-group">
				<label class="control-label col-xs-4"></label>
				<div class="col-xs-6">
					 <select class="form-control" id="multiselect" name="reciever[]" multiple="multiple" required>

			                <?php
							// $this->db->join('student','student.parent_id=parent.parent_id','LEFT');
							$this->db->where(array('status' => 1));
			                $parents = $this->db->order_by('parent.name')->get_where('parent', array('care_type' => 'primary'))->result_array();
			                foreach ($parents as $row):
								$students_result = $this->db->select(array('name'))->get_where('student',
								array('parent_id'=>$row['parent_id'], 'active' => 1))->result_array();
								
								if(empty(array_column($students_result, 'name'))) continue;

								$students = implode(",",array_column($students_result, 'name'));
			                ?>
			
			                    <option value="<?php echo $row['phone']; ?>"><?php echo $row['name']; ?> - <?=ucwords($row['care_type']).' '.get_phrase('caregiver');;?> -  <?php if(!empty($students_result)) {?> [<?=$students;?>]<?php }?></option>
			
			                <?php endforeach; ?>

			           
			           
			        </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-xs-4"></label>
				<div class="col-xs-6">
					<div class="col-xs-12">
						<div id="counter">160</div>
					</div>	
					<div class="col-xs-12">	
						<textarea required='required' class="form-control" id="message" name="message" rows="6" placeholder='Type message here'></textarea>
					</div>
					<div class="col-xs-12" id="response"></div>
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

<div class="row">
	<div class="col-xs-12">
		<?php 
			//print_r($outbox);
		?>
	</div>
</div>

<script>
	$(document).ready(function() {
	    $('#multiselect').multiselect({
	      	enableFiltering: true,
	      	numberDisplayed: 5,
	      	includeSelectAllOption: true,
	      	selectAllText: 'Select All SMS Receivers',
	      	enableCaseInsensitiveFiltering: true,
	      	filterPlaceholder: 'Search SMS Receiver',
	      	buttonWidth: '580px',
	      	nonSelectedText:"Select SMS Receivers"
	    	
	    });
	  });
  
	
	// $('textarea').keypress(function(){

	//     if($(this).val().length > 155){
	//         return false;
	//     }
	//     $("#counter").html("Remaining characters : " +(155 - $(this).val().length));
	// });

	$('textarea').bind('blur keyup keypress', function(e){
       	    if($(this).val().length > 155){
	        return false;
	    }
	    $("#counter").html("Remaining characters : " +(155 - $(this).val().length));
    });
	
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