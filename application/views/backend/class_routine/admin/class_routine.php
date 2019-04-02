
<hr />
<div class="row">
	<div class="col-sm-12">
			<div class="form-group">
				<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('routine_date');?></label>

					<div class="col-sm-6">
						<input type="text" class="form-control datepicker" id="routine_date" readonly="readonly" value="<?=date("Y-m-d");?>" data-format="yyyy-mm-dd" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>

					<div class="col-sm-2">
						<button id="search_routine" class="btn btn-info"><?=get_phrase('search_routine');?></button>
					</div>
			</div>
	</div>
</div>

<!-- <div class="row">
	<div class="col-sm-12">
		<div id="progress"></div>
	</div>
</div> -->

<div class="row" id="routine_schedule">
	<div class="col-md-12">
    <?php
		//print_r($routine_attendance)."<br/>";
		//echo date("w",strtotime($attendance_date));
		//echo $attendance_date;
	?>

    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
					<?php echo get_phrase('class_routine_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_class_routine');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>


		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane active" id="list">
				<div class="panel-group joined" id="accordion-test-2">
					<div class="well">
						<?php

							if(count($routine_attendance)>0){ echo count($routine_attendance). " ".get_phrase('session(s)_attended_today');
							}else{ echo get_phrase("no_session_attended_today"); }
						?>
					</div>
                	<?php
						$toggle = true;
						$classes = $this->db->get('class')->result_array();
						foreach($classes as $row):
					?>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                		<h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapse<?php echo $row['class_id'];?>">
                                    	<?php
                                    		$this->db->join('class_routine',"class_routine.class_routine_id=class_routine_attendance.class_routine_id");
                                    	 	$class_routine_attendance_by_class = $this->db->get_where("class_routine_attendance",
                                    	 		array("class_id"=>$row['class_id'],"attendance_date"=>date('Y-m-d')))->num_rows();
                                    	?>
                                        <i class="entypo-rss"></i> Class <?php echo $row['name'];?> <span class="badge badge-primary"><?=$class_routine_attendance_by_class;?></span>
                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse<?php echo $row['class_id'];?>" class="panel-collapse collapse <?php if($toggle){echo 'in';$toggle=false;}?>">
                                    <div class="panel-body">
                                        <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                                            <tbody>
                                                <?php
                                                for($d=1;$d<=7;$d++):

                                                if($d==1)$day='sunday';
                                                else if($d==2)$day='monday';
                                                else if($d==3)$day='tuesday';
                                                else if($d==4)$day='wednesday';
                                                else if($d==5)$day='thursday';
                                                else if($d==6)$day='friday';
                                                else if($d==7)$day='saturday';
                                                ?>
                                                <tr class="gradeA">
                                                    <td width="100"><?php echo strtoupper($day);?> <?php if($d == date("w",strtotime($attendance_date))+1){?><i style="color: red;" class="fa fa-arrow-right"></i><?php }?></td>
                                                    <td>
                                                    	<?php
														$this->db->order_by("time_start", "asc");
														$this->db->where('day' , $day);
														$this->db->where('class_id' , $row['class_id']);
														$routines	=	$this->db->get('class_routine')->result_array();
														foreach($routines as $row2):
														?>
														<div class="btn-group">
															<?php
																$teacher_id = $this->crud_model->get_type_name_by_id('subject',$row2['subject_id'],'teacher_id');

																$color = "btn-primary";
																foreach($routine_attendance as $attendance){
																	if($row2['class_routine_id'] === $attendance->class_routine_id){
																		$color = "btn-success";
																	}
																}

															?>

															<button class="btn <?=$color;?> dropdown-toggle" data-toggle="dropdown" title="<?php echo $this->crud_model->get_type_name_by_id('teacher',$teacher_id);?>">

																<?php

																	echo $this->crud_model->get_subject_name_by_id($row2['subject_id']);

                                                                    if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0)
                                                                        echo '('.$row2['time_start'].'-'.$row2['time_end'].')';
                                                                    if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                                                                        echo '('.$row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'].')';

                                                                ?>
                                                            	<span class="caret"></span>
                                                            </button>
															<ul class="dropdown-menu">
																<li class="edit_class_routine">
                                                                	<a href="#collapse<?php echo $row['class_id'];?>" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_class_routine/<?php echo $row2['class_routine_id'];?>');">
                                                                    <i class="entypo-pencil"></i>
                                                                        <?php echo get_phrase('edit');?>
                                                                    			</a>
		                                                         </li>

		                                                         <?php if($d == date("w",strtotime($attendance_date))+1){?>
			                                                         <li class="mark_routine_attended">
	                                                                	<a href="#collapse<?php echo $row['class_id'];?>" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_class_routine_attendance/<?php echo $row2['class_routine_id'];?>/<?php echo $attendance_date;?>');">
		                                                                    <i class="entypo-check"></i>
		                                                                        <?php echo get_phrase('mark_attended');?>
	                                                                    </a>
			                                                         </li>
		                                                         <?php }?>

		                                                         <li class="delete_class_routine">
		                                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?class_routine/class_routine/delete/<?php echo $row2['class_routine_id'];?>');">
		                                                                <i class="entypo-trash"></i>
		                                                                    <?php echo get_phrase('delete');?>
		                                                                </a>
		                                                    		</li>
															</ul>
														</div>
														<?php endforeach;?>

                                                    </td>
                                                </tr>
                                                <?php endfor;?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
						<?php
					endforeach;
					?>
  				</div>
			</div>
            <!----TABLE LISTING ENDS--->


			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content add_class_routine">
                	<?php echo form_open(base_url() . 'index.php?class_routine/class_routine/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-5">
                                    <select name="class_id" class="form-control" style="width:100%;"
                                        onchange="return get_class_subject(this.value)">
                                        <option value=""><?php echo get_phrase('select_class');?></option>
                                    	<?php
										$classes = $this->db->get('class')->result_array();
										foreach($classes as $row):
										?>
                                    		<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
                                <div class="col-sm-5">
                                    <select name="subject_id" class="form-control" style="width:100%;" id="subject_selection_holder">
                                        <option value=""><?php echo get_phrase('select_class_first');?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('day');?></label>
                                <div class="col-sm-5">
                                    <select name="day" class="form-control" style="width:100%;">
                                        <option value="sunday">sunday</option>
                                        <option value="monday">monday</option>
                                        <option value="tuesday">tuesday</option>
                                        <option value="wednesday">wednesday</option>
                                        <option value="thursday">thursday</option>
                                        <option value="friday">friday</option>
                                        <option value="saturday">saturday</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('starting_time');?></label>
                                <div class="col-sm-9">
                                    <div class="col-md-3">
                                        <select name="time_start" class="form-control">
                                            <option value=""><?php echo get_phrase('hour');?></option>
    										<?php for($i = 0; $i <= 12 ; $i++):?>
                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="time_start_min" class="form-control">
                                            <option value=""><?php echo get_phrase('minutes');?></option>
                                            <?php for($i = 0; $i <= 11 ; $i++):?>
                                                <option value="<?php echo $i * 5;?>"><?php echo $i * 5;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="starting_ampm" class="form-control">
                                        	<option value="1">am</option>
                                        	<option value="2">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('ending_time');?></label>
                                <div class="col-sm-9">
                                    <div class="col-md-3">
                                        <select name="time_end" class="form-control">
                                            <option value=""><?php echo get_phrase('hour');?></option>
    										<?php for($i = 0; $i <= 12 ; $i++):?>
                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="time_end_min" class="form-control">
                                            <option value=""><?php echo get_phrase('minutes');?></option>
                                            <?php for($i = 0; $i <= 11 ; $i++):?>
                                                <option value="<?php echo $i * 5;?>"><?php echo $i * 5;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="ending_ampm" class="form-control">
                                        	<option value="1">am</option>
                                        	<option value="2">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_class_routine');?></button>
                              </div>
							</div>
                    </form>
                </div>
			</div>
			<!----CREATION FORM ENDS-->

		</div>
	</div>
</div>

<script type="text/javascript">


    $("#search_routine").on("click",function(e){

    	var routine_date = $("#routine_date").val();
    	var url = "<?=base_url();?>index.php?class_routine/search_class_routine/"+routine_date;

    	$.ajax({
    		url:url,
    		beforeSend:function(){
    			$("#routine_schedule").removeClass("hidden");

    			$('#routine_schedule').html('<div style="text-align:center;"><img style="width:60px;height:60px;" src="<?php echo base_url();?>uploads/preloader4.gif" /></div>');
    		},
    		success:function(response){

    			$('#routine_schedule').html(response);
    		},
    		error:function(){

    		}
    	});
    });


     function get_class_subject(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?class_routine/get_class_subject/' + class_id ,
            success: function(response)
            {
                jQuery('#subject_selection_holder').html(response);
            }
        });
    }

	function mark_attendance(class_routine_id=""){

		showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_class_routine_attendance/'+class_routine_id+"/<?=$attendance_date;?>");
	}

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
</script>
