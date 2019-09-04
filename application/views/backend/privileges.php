<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

?>

<style>
<?php
	$entitlements = $this->db->get("entitlement")->result_object();

	foreach($entitlements as $entitlement):

	echo ".".$entitlement->name."{display:none;}";

	endforeach;

	foreach($entitlements as $entitlement):
		if($this->crud_model->user_privilege($this->session->profile_id,$entitlement->name)){

			echo ".".$entitlement->name."{display:block;}";

				if($entitlement->derivative_id !== 0){
					$first_parent = $this->db->get_where("entitlement",array("entitlement_id"=>$entitlement->derivative_id));

					if($first_parent->num_rows()>0){
							echo ".".$first_parent->row()->name."{display:block;}";

							if($first_parent->row()->derivative_id !== 0){
								$second_parent = $this->db->get_where("entitlement",
								array("entitlement_id"=>$first_parent->row()->derivative_id));

									if($second_parent->num_rows()>0){
										echo ".".$second_parent->name."{display:block;}";

											if($second_parent->row()->derivative_id !== 0){
												$third_parent = $this->db->get_where("entitlement",
												array("entitlement_id"=>$second_parent->derivative_id));

														if($third_parent->num_rows()>0){
															echo ".".$third_parent->row()->name."{display:block;}";
															if($third_parent->row()->derivative_id !== 0){

																		$fourth_parent = $this->db->get_where("entitlement",
																		array("entitlement_id"=>$third_parent->derivative_id));

																			if($fourth_parent->num_rows()>0){
																				echo ".".$fourth_parent->row()->name."{display:block;}";
																			}
																	}
														}

											}
									}
							}
					}

				}

		}
	endforeach;
?>

</style>
