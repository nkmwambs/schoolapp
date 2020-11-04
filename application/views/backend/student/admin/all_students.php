<style>
	tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

.enrol_suspended{
	color:red;
}	

.enrol_active{
	color:green
}
</style>

<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css"/>
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"/>

<a class='btn btn-default' href='<?=base_url();?>index.php?student/all_students/<?=$toggle_status;?>'><?=$toggle_status == 1?get_phrase('show_active'):get_phrase('show_suspended');?></a>
<hr/>

<?php echo form_open('' , array('id'=>'form-filter','class' => 'form-vertical form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

	<table class="table table-striped" id="table_export">
		<thead>
	    	<tr>
				<th><?php echo get_phrase('action');?></th>
				<th><?php echo get_phrase('admission_number');?></th>
				<th><?php echo get_phrase('username');?></th>
	            <th><?php echo get_phrase('name');?></th>
	            <th><?php echo get_phrase('caregiver');?></th>
	            <th><?php echo get_phrase('email');?></th>
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
					<td>
					<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <?=get_phrase('action');?> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-left" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?exam/student_marksheet/<?php echo $student['student_id'];?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li>

										<li class="divider"></li>

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $student['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <li class="divider"></li>


                                        <!-- STUDENT EDITING LINK -->
                                        <li class="<?=get_access_class("edit_student",$this->session->login_type,"accounts");?> ">
                                            <a  href="<?php echo base_url();?>index.php?student/student_edit/<?php echo $student['student_id'];?>" >
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>

                                       <li class="divider <?=get_access_class("edit_student",$this->session->login_type,"accounts");?>"></li>

                                         <!-- STUDENT SUSPEND LINK -->
										 <?php if($toggle_status == 0){?>
											<li class=" <?=get_access_class("suspend_student",$this->session->login_type,"accounts");?>">
												<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_transition_student/<?php echo $student['student_id'];?>');">
													<i class="entypo-trash"></i>
														<?php echo get_phrase('transition');?>
													</a>
											</li>
										 <?php }else{?>
											<li class=" <?=get_access_class("suspend_student",$this->session->login_type,"accounts");?>">
												<a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?student/unsuspended_student/<?php echo $student['student_id'];?>');">
													<i class="entypo-trash"></i>
														<?php echo get_phrase('unsuspend');?>
													</a>
											</li>
										 <?php }?>
                                         <li class="divider <?=get_access_class("suspend_student",$this->session->login_type,"accounts");?>"></li>

                                         <!-- Promote a Admin to A user -->
                                         <li class="<?=get_access_class('promote_admin_to_user',$this->session->login_type,'accounts')?>">
			                                    <a href="#" onclick="confirm_action('<?php echo base_url();?>index.php?settings/promote_to_user/student/<?php echo $student['student_id'];?>');">
			                                        <i class="fa fa-thumbs-up"></i>
												        <?php echo get_phrase('promote_to_user');?>
			                                    </a>
			                                </li>
                                        </ul>
								</div>
							
							<?php 
								//$enrol_color = "red";
								$enrol_status = 'enrol_suspended';

								if($student['lms_enrolled']){
									//$enrol_color = 'green';	
									$enrol_status = 'enrol_active';
								}
							?>

							<i class='fa fa-book lms_enrol <?=$enrol_status;?>' id='<?=$student['student_id'];?>' style='cursor:pointer;'><i>
					</td>
					<td><?=$student['username'];?></td>
					<td><?=$student['roll'];?></td>
					<td><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $student['student_id'];?>');"><?=ucwords($student['student_name']);?></a></td>
					<td><?php echo $student['parent_id']!=0?$this->crud_model->get_type_name_by_id('parent',$student['parent_id']):get_phrase('not_set');?></td>
					<td><?=ucwords($student['email']);?></td>
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
    	dom: 'lBfrtip',
        buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print','colvis'
        ],
        //orderCellsTop: true,
        //fixedHeader: true,

    } );
} );

$(".lms_enrol").on('click',function(){
	var student_id = $(this).attr('id');
	var url = '<?=base_url();?>index.php?student/enrol_to_lms';
	var data = {'student_id':student_id};

	if($(this).hasClass('enrol_suspended')){
		$(this).removeClass('enrol_suspended');
		$(this).addClass('enrol_active');
	}else{
		$(this).removeClass('enrol_active');
		$(this).addClass('enrol_suspended');
	}

	$.post(url,data,function(response){
		alert(response);
	});
	
})
</script>
<!-- 
<script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
