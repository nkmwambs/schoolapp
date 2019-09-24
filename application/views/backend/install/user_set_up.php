<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $asterick="<span style ='color:red;'><b>*</b></span>"; ?>
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
                  <label for="" class="label-control col-xs-3"><?=get_phrase('first_name').$asterick;?></label>
                  <div class="col-xs-9">
                      <input type="text" class="form-control required" name="first_name" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('last_name').$asterick;?></label>
                  <div class="col-xs-9">
                      <input type="text" class="form-control required" name="last_name" />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('gender').$asterick;?></label>
                  <div class="col-xs-9">
                      <select class="form-control required" name="sex" >
                        <option value=""><?=get_phrase('select');?></option>
                        <option value="male"><?=get_phrase('male');?></option>
                        <option value="female"><?=get_phrase('female');?></option>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('email').$asterick;?></label>
                  <div class="col-xs-9">
                      <input type="email" class="form-control required" name="email"  />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('phone').$asterick;?></label>
                  <div class="col-xs-9">
                      <input type="text" class="form-control required" name="phone" required />
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('password').$asterick;?></label>
                  <div class="col-xs-9">
                      <input id='password' type="password" class="form-control required" name="password" required/>
                  </div>
              </div>

              <div class="form-group">
                  <label for="" class="label-control col-xs-3"><?=get_phrase('confirm_password').$asterick;?></label>
                  <div class="col-xs-9">
                      <input id='confirm_password' type="password" class="form-control required" name="confirm_password"  required/>
                  </div>
              </div>
              
                
                  <div class='col-xs-3' ></div>
                  <div class="col-xs-9" id='message'></div>
            

              <div class="form-group">
                  <div class="col-xs-12">
                      <button  id='create_account' type="submit" class="btn btn-success"><?=get_phrase('create_account');?></button>
                  </div>
              </div>

            </form>
            
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
//Reset the form values to avoid resubmitting and creating a new dbase and dump tables when a user refreshes.

$("#my_form")[0].reset();

//Check required fields
 $('#create_account').click(function(e){ //submit button name
 	
   // e.preventDefault();
    
    $('.required').each(function() {   //a constant class for evert input item
	    if($(this).val() == '') 
	    {
	    	$(this).css({'border-color': '#FF0000', "border-weight":"1px", "border-style":"solid"});
	    	$(this).attr("placeholder", "Required");
	    }
	    else{
	    	$(this).removeAttr('style');
	    }
    });
  });


//Compare the password and confirm password values

	//function check_password() {
		$('#my_form').on('submit',function(e){
			//$('#password, #confirm_password').on('change', function() {

			var password = $('#password').val();
			var confirm_pass = $('#confirm_password').val();

			if ((password != confirm_pass) && password != '' && confirm_pass != '') {
				//$('#message').html('Matching').css('color', 'green');
				$('#message').removeAttr("hidden");
				$('#message').html('Password and password confirm not Matching').css('color', 'red');

				e.preventDefault();
			} else if (password == confirm_pass) {
				$('#message').attr("hidden", true);
				return true;
			}
		//});
		});
		
	//}

  // $('#my_form').validate({
       // rules : {
          // password : {
              // minlength : 5
            // },
            // confirm_password : {
                // minlength : 5,
                // equalTo : '[name="password"]'
            // }
       // }});
</script>
