
            <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_parent_add/');" 
                class="btn btn-primary pull-right <?=get_access_class("add_parent",$this->session->login_type,"parent")?>">
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('add_new_parent');?>
                </a> 
                <br><br>
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('profession');?></div></th>
                            <th><div><?php echo get_phrase('beneficiaries');?></div></th>
                            <th><div><?php echo get_phrase('relationship');?></div></th>
                            <th><div><?php echo get_phrase('care_type');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1; 
                            $parents   =   $this->db->get('parent' )->result_array();
                            foreach($parents as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['profession'];?></td>
                            <td>
                            	
                            	<?php 
                            			if($row['care_type'] === "primary"){
                            				echo $this->db->get_where('student',array('parent_id'=>$row['parent_id']))->num_rows();
                            			}else{
                            				echo $this->db->get_where('caregiver',array('parent_id'=>$row['parent_id']))->num_rows();
                            			}
                            			
                            	?>
                            	
                            </td>
                            
                            <td><?php if($this->db->get_where('relationship',array('relationship_id'=>$row['relationship_id']))->num_rows()>0) echo $this->db->get_where('relationship',array('relationship_id'=>$row['relationship_id']))->row()->name; else echo get_phrase("none");?></td>
                            <td><?php echo ucfirst($row['care_type']);?></td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- teacher EDITING LINK -->
                                        <li class="<?=get_access_class("edit_parent",$this->session->login_type,"parent")?>">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_parent_edit/<?php echo $row['parent_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("edit_parent",$this->session->login_type,"parent")?>"></li>
                                        
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_beneficiaries/<?php echo $row['parent_id'];?>/<?php echo $row['care_type'];?>');">
                                                <i class="fa fa-umbrella"></i>
                                                    <?php echo get_phrase('beneficiaries');?>
                                                </a>
                                        </li>
                                        <li class="divider"></li>
                                        
                                        <?php if($row['care_type'] === "secondary"){?>
                                        
                                        <li class="<?=get_access_class("assign_beneficiary",$this->session->login_type,"parent")?>">
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_assign_beneficiaries/<?php echo $row['parent_id'];?>/<?php echo $row['care_type'];?>');">
                                                <i class="fa fa-link"></i>
                                                    <?php echo get_phrase('assign_beneficiary');?>
                                                </a>
                                        </li>
                                        <li class="divider <?=get_access_class("assign_beneficiary",$this->session->login_type,"parent")?>"></li>
                                        
                                        <?php }?>
                                        
                                        <!-- teacher DELETION LINK -->
                                        <li class="<?=get_access_class("delete_parent",$this->session->login_type,"parent")?>">
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/parent/delete/<?php echo $row['parent_id'];?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('delete');?>
                                                </a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        

        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    
                    {
                        "sExtends": "xls",
                        "mColumns": [1,2,3,4,5]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2,3,4,5]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"    : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(5, false);
                            
                            this.fnPrint( true, oConfig );
                            
                            window.print();
                            
                            $(window).keyup(function(e) {
                                  if (e.which == 27) {
                                      datatable.fnSetColumnVis(5, true);
                                  }
                            });
                        },
                        
                    },
                ]
            },
            
        });
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
        
</script>

