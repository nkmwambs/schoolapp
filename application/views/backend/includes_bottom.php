<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>




	<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">

   	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<!-- <script src="assets/js/bootstrap.js"></script> -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/toastr.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/fileinput.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/datatables/TableTools.min.js"></script>
	<script src="assets/js/dataTables.bootstrap.js"></script>
	<script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
	<script src="assets/js/datatables/lodash.min.js"></script>
	<script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>

   <script src="assets/js/jquery.multi-select.js"></script>

	<script src="assets/js/neon-calendar.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>

	<script src="assets/js/printElement.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
	
	
		
	<script src="<?php echo base_url();?>assets/js/printThis.js"></script>
	
	<!--Accounting JS-->
	<script src="<?php echo base_url();?>assets/js/accounting.min.js"></script>
	
	<!--Cookie Plugin -->
	<script src="<?php echo base_url();?>assets/js/jquery.cookie.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->
	
<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>

<script type="text/javascript">
	toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>

<?php endif;?>

<span style="display: hidden;" id="buffer"></span>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		
		
		var datatable = $("#table_export").dataTable();

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});

		$('.modal-dialog').draggable();

		$('.modal-content').resizable({
		    //alsoResize: ".modal-dialog",
		    minHeight: 300,
		    minWidth: 300
		});
		
		$.cookie('buffer','');
		$.cookie('buffer_name','');
		
		$(".unique").on('click,mousedown',function(){
			
			var attr_name1 = $(this).attr('name');	
			
			if($.cookie('buffer_name') != attr_name1){
				$.cookie('buffer_name',attr_name1);
				$.cookie('buffer',$(this).val());
			}		
			
		});
		
		$(".unique").on('mousedown',function(){
			
			var attr_name1 = $(this).attr('name');	
			
			if($.cookie('buffer_name') != attr_name1){
				$.cookie('buffer_name',attr_name1);
				$.cookie('buffer',$(this).val());
			}			
			
		});
		
		$(".unique").on('change',function(){
			var table_name = $(this).attr('data-tablename');
			var field = $(this).attr('name');
			var value = $(this).val();
			var url = "<?=base_url();?>index.php?general/check_duplicate_record/";
			var data = {'table':table_name,'field':field,'value':value};
			var elem = $(this);
			
			//check if element property required
			if($(this).attr('required') != 'required' || $(this).attr('data-validate') != 'required' ){
				$(this).prop('required','required');
			}
			
			$.ajax({
				url:url,
				data:data,
				type:"POST",
				success:function(resp){
					
					elem.parent().find('.duplicate-errror').remove();
					
					if(resp != "0" && $.cookie("buffer") != value){
						elem.css('border','1px solid red');
						elem.parent().append('<div class="duplicate-errror"><span style="color:red;">Duplicate value found for <span>'+value+'</span></span></div>');
						elem.val($.cookie('buffer'));
						
					}else{
						elem.css('border','1px solid grey');
					}
				}
			});
			
		});
	

	});


</script>
