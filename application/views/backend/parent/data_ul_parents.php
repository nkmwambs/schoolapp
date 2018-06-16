<hr/>
	<?php
	$marked_expected = $this->db->get_where("activity_attendance",array("activity_id"=>$activity_id));

	?>
<!-- <select class="multi-select form-control" name="parent_id[]" multiple="multiple" id="multiSelect_id" style="overflow-y: auto;" > -->
<form id="parents_list">
<ul style="list-style-type: none;">
	<?php

		foreach($list_parents as $row):
			/**Get students for the parent**/
			$checked  = "";
			$students = $this->db->get_where("student",array("parent_id"=>$row->parent_id));
			$to_show_list = array();
			$student_list = "";
			if($students->num_rows() > 0){

				foreach($students->result_object() as $student){
					$to_show_list[] = $student->name."[".$this->db->get_where("class",array("class_id"=>$student->class_id))->row()->name."]";
				}
				$student_list = implode(", ",$to_show_list);

				if($marked_expected->num_rows() > 0){
					foreach ($marked_expected->result_object() as $expected) {
						if($expected->parent_id == $row->parent_id){
							$checked = "checked='checked'";
						}
					}
				}

		?>
			<li><input type="checkbox" name="parent_ids_<?=$row->parent_id;?>" value="<?=$row->parent_id;?>" <?=$checked;?> /><?=$row->name.' - '.$student_list;?></li>
		<?php
			}

		endforeach;
	?>
</ul>
</form>
<hr/>

<div class="btn btn-success" id="mark_expected"><?=get_phrase("mark");?></div>
<script>

$(document).ready(function() {
		$("#multiSelect_id").attr("size",$("#multiSelect_id option").length);

		$("#mark_expected").click(function(){
				var url = "<?=base_url();?>index.php?parents/parent_expected_attendance/<?=$activity_id;?>";
				var data = {"parent_ids":$("#parents_list").serializeArray()};

				$.ajax({
					url:url,
					type:"POST",
					data:data,
					success:function(resp){
							alert(resp);
					},
					error:function(){
						alert("Error Occurred!");
					}
				});
		});
})
</script>
