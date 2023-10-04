<hr />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="fa fa-child"></i>
					<?php echo get_phrase('parents'); ?>
            	</div>
            </div>
			<div class="panel-body">

                <div class = 'row'>
                    <div class = 'col-xs-6'>
                        <a href="<?=base_url();?>index.php?parents/parent/by_status/<?=$status;?>" id = "records_status" class = 'btn <?=$status == 1 ? 'btn-danger': 'btn-success';?>'><?=get_phrase($status == 1 ? 'show_inactive_records' : 'show_active_records');?></a>
                    </div>

                    <div class = 'col-xs-6'>
                        <a href="<?php echo base_url(); ?>index.php?parents/parent_add/"
                            class="btn btn-primary pull-right <?=get_access_class("add_parent",$this->session->login_type,"accounts")?>">
                            <i class="entypo-plus-circled"></i>
                            <?php echo get_phrase('add_new_parent'); ?>
                        </a>
                    </div>
                </div>

                <br><br>
               <table class="table table-striped datatable" id="table_export">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase('email'); ?></div></th>
                            <th><div><?php echo get_phrase('phone'); ?></div></th>
                            <th><div><?php echo get_phrase('profession'); ?></div></th>
                            <th><div><?php echo get_phrase('beneficiaries'); ?></div></th>
                            <th><div><?php echo get_phrase('relationship'); ?></div></th>
                            <th><div><?php echo get_phrase('care_type'); ?></div></th>
                            <th><div><?php echo get_phrase('linked_primary_caregiver'); ?></div></th>
                            <th><div><?php echo get_phrase('status'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach($parents as $row):?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['profession']; ?></td>
                            <td>

                            	<?php
								if ($row['care_type'] === "primary") {
									echo $this -> db -> get_where('student', array('parent_id' => $row['parent_id'], 'active' => 1)) -> num_rows();
								} else {
                                        $primary_parent_id = $this->db->get_where('parent',array('parent_id' => $row['parent_id']))->row()->primary_parent_id;
                                        // echo $primary_parent_id;
                                        if($primary_parent_id){
                                            echo $this -> db -> get_where('student', array('parent_id' => $primary_parent_id, 'active' => 1)) -> num_rows();
                                        }else{
                                            echo 0;
                                        }

								}
                            	?>

                            </td>

                            <td><?php
							if ($this -> db -> get_where('relationship', array('relationship_id' => $row['relationship_id'])) -> num_rows() > 0)
								echo $this -> db -> get_where('relationship', array('relationship_id' => $row['relationship_id'])) -> row() -> name;
							else
								echo get_phrase("none");
							?></td>
                            <td><?php echo ucfirst($row['care_type']); ?></td>
                            <td>
                                <?php 
                                    // echo ucfirst($row['care_type']); 
                                    $primary_parent_id = $this->db->get_where('parent',array('parent_id' => $row['parent_id']))->row()->primary_parent_id;

                                    if($primary_parent_id){
                                        echo $this->db->get_where('parent',array('parent_id' => $primary_parent_id))->row()->name;
                                    }
                                ?>
                            </td>
                            <td><?= $row['status'] == 1 ? get_phrase('active') : get_phrase('inactive') ;?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- teacher EDITING LINK -->
                                        <li class="<?=get_access_class("edit_parent",$this->session->login_type,"accounts")?>">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_parent_edit/<?php echo $row['parent_id']; ?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit'); ?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("edit_parent",$this->session->login_type,"accounts")?>"></li>

                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_beneficiaries/<?php echo $row['parent_id']; ?>/<?php echo $row['care_type']; ?>');">
                                                <i class="fa fa-umbrella"></i>
                                                    <?php echo get_phrase('beneficiaries'); ?>
                                                </a>
                                        </li>
                                        <li class="divider"></li>

                                        <?php if($row['care_type'] != "primary"){?>

                                        <li class="<?=get_access_class("assign_primary_caregiver",$this->session->login_type,"accounts")?>">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_assign_primary_caregiver/<?php echo $row['parent_id']; ?>');">
                                                <i class="fa fa-link"></i>
                                                    <?php echo get_phrase('assign_primary_caregiver'); ?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("assign_primary_caregiver", $this -> session -> login_type, "accounts") ?>"></li>

                                        <?php } ?>

                                        <li class="<?=get_access_class($row['status'] == 1 ? "deactivate_parent" : "activate_parent", $this -> session -> login_type, "accounts") ?>">
                                            <a href="#" onclick="confirm_action('<?php echo base_url(); ?>index.php?parents/parent/change_status/<?php echo $row['parent_id']; ?>/<?=$row['status'];?>');">
                                                <i class="entypo-<?= $row['status'] == 1 ? 'mute' : 'sound';?>"></i>
                                                    <?php echo get_phrase($row['status'] == 1 ? 'deactivate' : 'activate'); ?>
                                                </a>
                                        </li>

                                        <li class="divider <?=get_access_class($row['status'] == 1 ? "deactivate_parent" : "activate_parent", $this -> session -> login_type, "accounts") ?>"></li>

                                        <!-- teacher DELETION LINK -->
                                        <li class="<?=get_access_class("delete_parent", $this -> session -> login_type, "accounts") ?>">
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?parents/parent/delete/<?php echo $row['parent_id']; ?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('delete'); ?>
                                                </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
</div>
</div>
</div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($)
    {

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

// $("#records_status").on('click', function () {
//     const has_danger = $(this).hasClass('btn-danger')
    
//     if(has_danger){
//         $(this).removeClass('btn-danger')
//         $(this).addClass('btn-success')
//     }else{
//         $(this).removeClass('btn-success')
//         $(this).addClass('btn-danger')
//     }
// })
</script>
