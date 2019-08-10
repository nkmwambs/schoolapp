<style>
	tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css"/>
<?php echo form_open('' , array('id'=>'form-filter','class' => 'form-vertical form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

	<table class="table table-bordered" id="table_export">
		<thead>
	    	<tr>
	        	<th><?php echo get_phrase('admission_number');?></th>
	            <th><?php echo get_phrase('name');?></th>
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
					<td><?=ucwords($student['address']);?></td>
					<td><?=ucwords($student['class_name']);?></td>
					<td><?=$student['sex'] == 'female'?'F':'M';?></td>
					<!-- <td><?=ucwords($student->parent_name);?></td> -->
				</tr>
			<?php
				}
			?>
		</tbody>
		
		 <!-- <tfoot>
            <tr>
            	<th></th>
                <th>Admission Number</th>
                <th>Student Name</th>
                <th>Address</th>
                <th>Class</th>
                <th>Gender</th>
            </tr>
        </tfoot> -->
		
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
        orderCellsTop: true,
        fixedHeader: true,
         
    } );
} );
</script>                    
<script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>