    <script type="text/javascript">
	function showAjaxModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal({backdrop: 'static',keyboard: false});

		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	</script>

    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $system_name;?></h4>
                </div>

                <div class="modal-body" style="height:500px; overflow:auto;">



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
	function confirm_modal(delete_url)
	{
		jQuery('#modal-4').modal('show', {backdrop: 'static'});
		document.getElementById('delete_link').setAttribute('href' , delete_url);
	}

  function confirm_ajax_action(action_url,replace_data_element_id){

    var cfrm = confirm('Are you sure you want to perform this action?');

    if(!cfrm){
      alert('Action aborted');
      return false;
    }

    $.ajax({
      url:action_url,
      beforeSend:function(){
        $("#overlay").css('display','block');
      },
      success:function(resp){
        $("#"+replace_data_element_id).html(resp);
        $("#overlay").css('display','none');
      },
      error:function(err,xh,msg){
        alert(msg);
        $("#overlay").css('display','none');
      }
    });

  }

	function confirm_action(url)
	{
		jQuery('#modal-5').modal('show', {backdrop: 'static'});
		document.getElementById('perform_link').setAttribute('href' , url);
	}
	</script>

    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>


                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link"><?php echo get_phrase('delete');?></a>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- (Confirm Modal)-->
    <div class="modal fade" id="modal-5">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">

                <div class="modal-header">
                    <button id="" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure you want to perform this action?</h4>
                </div>


                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="perform_link"><?php echo get_phrase('Ok');?></a>
                    <button id="" type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>

   <script>
   $(document).ready(function(){
   			if (location.hash) {
			        $("a[href='" + location.hash + "']").tab("show");
			    }
			    $(document.body).on("click", "a[data-toggle]", function(event) {
			        location.hash = this.getAttribute("href");
			    });

			$(window).on("popstate", function() {
			    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
			    $("a[href='" + anchor + "']").tab("show");

		});
	});


	function PrintElem(elem)
    {
    	var string = '<div class="row">';
    		string += '<div class="col-xs-12" style="text-align:center;">';
    		string += '<img src="<?=base_url();?>uploads/logo.png" width="40"/>';
    		string += '</div>';
    		string += '<div class="col-xs-12" style="text-align:center;font-size:8pt">';
    		string += '<?=$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;?>';
    		string += '</div>';
    		string += '<div class="col-xs-12" style="text-align:center;font-size:8pt">';
    		string += 'P.O. Box <?=$this->db->get_where('settings' , array('type'=>'address'))->row()->description;?>';
    		string += '</div>';
    		string += '<div class="col-xs-12" style="text-align:center;font-size:8pt">';
    		string += 'Mobile Number: <?=$this->db->get_where('settings' , array('type'=>'phone'))->row()->description;?>';
    		string += '</div>';
    		string += '<div class="col-xs-12" style="text-align:center;font-size:8pt">';
    		string += 'Email: <?=$this->db->get_where('settings' , array('type'=>'system_email'))->row()->description;?>';
    		string += '</div>';
    		string += '</div>';
    		string += '<hr />';

        $(elem).printThis({
		    debug: false,
		    importCSS: true,
		    importStyle: true,
		    printContainer: true,
		    loadCSS: ["<?=base_url();?>assets/css/bootstrap.css"],
		    pageTitle: "Print",
		    removeInline: false,
		    printDelay: 333,
		    header: string,
		    formValues: true
		});
    }


		function go_back(){
			window.history.back();
		}

		function go_forward() {
		  window.history.forward();
		}



</script>

<style>
	#overlay {
    position: fixed; /* Sit on top of the page content */
    display: none; /* Hidden by default */
    width: 100%; /* Full width (cover the whole page) */
    height: 100%; /* Full height (cover the whole page) */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
    z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
    cursor: pointer; /* Add a pointer on hover */
}

#overlay img{
	display: block;
	margin-top:25%;
	margin-left: auto;
    margin-right: auto;
}
</style>

<div id="overlay"><img src='<?php echo base_url()."uploads/preloader4.gif";?>'/></div>


<script>

jQuery(document).ready(function($)
{
  $('.datatable').DataTable({
      dom: 'lBfrtip',
      buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      'stateSave':true
  });


  if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });

  $(window).on("popstate", function() {
      var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
      $("a[href='" + anchor + "']").tab("show");

  });

});

</script>
