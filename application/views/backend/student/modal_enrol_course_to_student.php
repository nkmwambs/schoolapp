<?php 

$this->db->where(array('student_id'=>$param2));
$this->db->join('course','course.course_id=course_enrolment.course_id');
$course_enrolment = $this->db->get('course_enrolment');

$list_of_courses = $this->db->get('course');

?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('enrolled_courses');?>
            	</div>
            </div>
			<div class="panel-body">
                <?php echo form_open('' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                   <?php if($list_of_courses->num_rows() > 0){?>
                        <div class='form=group'>
                            <label class='col-xs-2'>Course Name</label>
                            <div class='col-xs-8'>
                                <select id='select_course' class="form-control">
                                    <option value=''>Select a course</option>
                                    <?php foreach($list_of_courses->result_object() as $course){?>
                                        <option value="<?=$course->course_id;?>"><?=$course->course_shortname;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <div id='enrol_course' class="btn btn-default">Enrol</div>
                            </div>
                        </div>
                   <?php }?>
                </form>
                
                <hr/>



                
                <table class='table table-striped datatable' id='enrol_table'>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Enrolment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($course_enrolment->result_object() as $enrolment){ ?>
                            <tr>
                                <td><?=$enrolment->course_id;?></td>
                                <td><?=$enrolment->course_fullname;?></td>
                                <td><?=$enrolment->course_enrolment_date;?></td>
                                <td><div class='btn btn-default unenrol'>Unenrol</div></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
     
</div>       


    </div>
</div>

<script>
    $("#enrol_course").on('click',function(){
        //alert('Hello');
        var enrol_table = $("#enrol_table").find('tbody');
        var select_course = $("#select_course").find("option:selected").html();
        var select_course_id = $("#select_course").val();
        var url = "<?=base_url();?>index.php?student/enrol_to_course";
        var data = {'course_id':select_course_id,'student_id':<?=$param2;?>};
        
        if(select_course_id == ''){
            alert('Choose a course to enrol');
            return false;
        }

        $.post(url,data,function(response){
            //alert(response);
            if(response){
                enrol_table.append('<tr><td>'+select_course_id+'</td><td>'+select_course+'</td><td><?=date('Y-m-d');?></td><td><div class="btn btn-default unenrol">Unenrol</div></td></tr>');    
            }else{
                alert('A student cannot be enrolled more than once to a course');
            }
            
        });
        
    });

    $(document).on('click','.unenrol',function(){
        var course_id = $(this).closest('tr').find('td').eq(0).html();
        var student_id = <?=$param2;?>;
        var tr = $(this).closest('tr');

        var cnf = confirm('Are you sure you want to unenrol the student from this course?');

        if(!cnf){
            alert('Unenrol action aborted');
            return false;
        }

        var data = {"course_id":course_id,"student_id":student_id};
        var url = "<?=base_url();?>index.php?student/unenrol_from_course";

        $.ajax({
            async: false,
            data:data,
            type:"POST",
            url:url,
            success:function(response){
                if(response){
                    tr.remove();
                }else{
                    alert('Failed to unenrol student');
                }
            },
            error:function(){
                alert('Error occurred');
            } 
        });
        async: false 
        
    })
</script>