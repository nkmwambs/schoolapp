<style>
	tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>

<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css"/>
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"/>


<?php echo form_open('' , array('id'=>'form-filter','class' => 'form-vertical form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

	<table class="table table-bordered" id="table_export">
		<thead>
	    	<tr>
	        	<th><?php echo get_phrase('admission_number');?></th>
	            <th><?php echo get_phrase('name');?></th>
	            <th><?php echo get_phrase('caregiver');?></th>
	            <th><?php echo get_phrase('address');?></th>
	            <th><?php echo get_phrase('class');?></th>
	            <th><?php echo get_phrase('gender');?></th>
	            <!-- <th><?php echo get_phrase('parent');?></th> -->
	       </tr>
		</thead>
		
		<tbody>
			<?php
				//print_r($students);
				foreach($students as $student){
			?>
				<tr>
					
					<td><?=$student['roll'];?></td>
					<td><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $student['student_id'];?>');"><?=ucwords($student['student_name']);?></a></td>
					<td><?php echo $student['parent_id']!=0?$this->crud_model->get_type_name_by_id('parent',$student['parent_id']):get_phrase('not_set');?></td>
					<td><?=ucwords($student['address']);?></td>
					<td><?=ucwords($student['class_name']);?></td>
					<td><?=$student['sex'] == 'female'?'F':'M';?></td>
					<!-- <td><?=ucwords($student->parent_name);?></td> -->
				</tr>
			<?php
				}
			?>
		</tbody>		
	</table>
</form>

<script>
	$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#table_export thead tr').clone(true).appendTo( '#table_export thead' );
    $('#table_export thead tr:eq(1) th').each( function (i) {
    	
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#table_export').DataTable( {
    	dom: 'Blfrtip',
        buttons: [
             //'copy', 'csv', 'excel', 'pdf', 'print','colvis'
        ],
        //orderCellsTop: true,
        //fixedHeader: true,
         
    } );
} );
</script>                    

<script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
