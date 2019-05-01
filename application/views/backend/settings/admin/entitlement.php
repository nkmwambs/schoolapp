<?php

$access = $this->db->get("access")->result_object();

$login_type_id = $this->db->get_where("profile",array("profile_id"=>$profile_id))->row()->login_type_id;
$parent_entitlement = $this->db->get_where("entitlement",array("derivative_id"=>0,"login_type_id"=>$login_type_id))->result_object();

//print_r($parent_entitlement);

?>

<div class="row">
	<div class="col-sm-12">
		
		<a class="btn btn-primary" href="<?=base_url();?>index.php?settings/user_profiles">Back</a>
		
		<hr/>
		
		<div class="well">Entitlement for Profile: <?php echo $this->db->get_where("profile",array("profile_id"=>$profile_id))->row()->name;?></div>
		
		<ul style="list-style: none;">
			<?php
				foreach($parent_entitlement as $parent){
					//print_r($parent);
					$checked = "";
					foreach($access as $row){
						
						if(($row->entitlement_id == $parent->entitlement_id) && ($row->profile_id == $profile_id)){
							$checked = "checked='checked'";
						}
					}
					
					$children = $this->db->get_where("entitlement",array("derivative_id"=>$parent->entitlement_id));
					
					$checkbox = "";
					
					//if($children->num_rows() == 0){
						$checkbox = '<input type="checkbox" '.$checked.' id="parent-'.$profile_id.'-'.$parent->entitlement_id.'-'.$parent->name.'" />';	
					//}
				?>
					<li id="parent_<?=$parent->name;?>"><?=$children->num_rows() == 0?$checkbox:"";?><?=ucwords(str_replace("_", " ", $parent->name));?>
						
					<?php
							// id_obj = $(this).attr("id").split("-");
							// level = id_obj[0];
							// profile_id = id_obj[1];
							// entitlement_id = id_obj[2];
							// entitlement_name = id_obj[3];	
						if($children->num_rows() > 0){
							echo "<span class='fa fa-plus collapsible' id='span_".$parent->name."'></span>";
							echo "<ul style='list-style: none;' class='sub-entitlement child_".$parent->name."'>";
							echo "<li>".$checkbox.' '.get_phrase('view').' '.$parent->name."</li>";
							foreach($children->result_object() as $child){
								
								$checked_child = "";
								foreach($access as $row2){
									
									if(($row2->entitlement_id == $child->entitlement_id) && ($row2->profile_id == $profile_id)){
										$checked_child = "checked='checked'";
									}
								}
								
					?>
								<li><input type="checkbox" <?=$checked_child;?> id="child-<?=$profile_id."-".$child->entitlement_id."-".$child->name."-".$parent->name;?>" /><?=ucwords(str_replace("_", " ", $child->name));?></li>
					<?php
							}
							echo "</ul>";
						}
					?>
				</li>
				<li><hr/></li>
			<?php
				}
			?>
		</ul>
		
	</div>
</div>

<script>
$(".collapsible").click(function(){
	
	var id_parent = $(this).attr('id').split("_");
	var parent_name = id_parent[1];
	var child_class = "child_"+parent_name;
	
	//$(".sub-entitlement").css("display","none");
	//$("."+child_class).css("display","block");
});	

$("input:checkbox").click(function(){
	var id_obj = $(this).attr("id").split("-");
	var level = id_obj[0];
	var profile_id = id_obj[1];
	var entitlement_id = id_obj[2];
	var entitlement_name = id_obj[3];
	var action = $(this).is(":checked");
	var url = "<?=base_url();?>index.php?settings/update_entitlement/"+entitlement_id+"/"+profile_id+"/"+action;
	
	//alert(level);
	
	if(action){
		$("."+entitlement_name).css("display","block");
		if(level = 'child'){
			var parent_name = id_obj[4];
			$("."+parent_name).css("display","block")				
		}
		
	}else{
		$("."+entitlement_name).css("display","none");
	}
	
	$.ajax({
		url:url,
		success:function(resp){
			//alert(resp);
		},
		error:function(){
			
		}
	});
	
	
});
</script>