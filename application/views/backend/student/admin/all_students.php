<?php echo form_open('' , array('id'=>'form-filter','class' => 'form-vertical form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

	<table class="table table-bordered" id="table_export">
		<thead>
	    	<tr>
	        	<th><?php echo get_phrase('roll');?></th>
	            <th><?php echo get_phrase('name');?></th>
	            <th><?php echo get_phrase('address');?></th>
	            <th><?php echo get_phrase('email');?></th>
	            <th><?php echo get_phrase('options');?></th>
	       </tr>
		</thead>
		
	</table>
</form>

<script>
	$(document).ready(function(){
		   
		   
		var datatable = $('#table_export,table.display').DataTable({
		       dom: '<Bf><"col-sm-12"rt><ip>',
		       //sDom:'r',
		       pagingType: "full_numbers",
		       buttons: [
		           'csv', 'excel', 'print'
		       ],
		       stateSave: true,
		       oLanguage: {
			        sProcessing: "<img src='<?php echo base_url();?>uploads/preloader4.gif'>"
			    },
			   processing: true, //Feature control the processing indicator.
		       serverSide: true, //Feature control DataTables' server-side processing mode.
		       order: [], //Initial no order.
		
		       // Load data for the table's content from an Ajax source
		       "ajax": {
		           "url": "<?php echo base_url();?>index.php?student/ajax_list",
		           "type": "POST",
		           "data": function(data){
		           		var x = $("#form-filter").serializeArray();

					    $.each(x, function(i, field){
					            data[field.name] = field.value;
					     });
		           }
		       },
		
		       
		   });



	});
</script>                    
