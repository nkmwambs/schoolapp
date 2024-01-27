<?php
$student_info    =    $this->crud_model->get_student_info($param2);
foreach ($student_info as $row) : ?>

    <div class="profile-env">

        <header class="row">

            <div class="col-sm-3">

                <a href="#" class="profile-picture">
                    <img src="<?php echo $this->crud_model->get_image_url('student', $row['student_id']); ?>" class="img-responsive img-circle" />
                </a>

            </div>

            <div class="col-sm-9">

                <ul class="profile-info-sections">
                    <li style="padding:0px; margin:0px;">
                        <div class="profile-name">
                            <h3><?php echo $row['name']; ?></h3>
                        </div>
                    </li>
                </ul>

            </div>


        </header>

        <section class="profile-info-tabs">

            <div class="row">

                <div class="col-xs-12">
                    <br>
                    <table class="table table-bordered">

                        <?php if ($row['class_id'] != '') : ?>
                            <tr>
                                <td>Class</td>
                                <td><b><?php echo $this->crud_model->get_class_name($row['class_id']); ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['section_id'] != '' && $row['section_id'] != 0) : ?>
                            <tr>
                                <td>Section</td>
                                <td><b><?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['roll'] != '') : ?>
                            <tr>
                                <td>Roll</td>
                                <td><b><?php echo $row['roll']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['upi_number'] != '') : ?>
                            <tr>
                                <td>UPI Number</td>
                                <td><b><?php echo $row['upi_number']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['birthday'] != '') : ?>
                            <tr>
                                <td>Birthday</td>
                                <td><b><?php echo $row['birthday']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['sex'] != '') : ?>
                            <tr>
                                <td>Gender</td>
                                <td><b><?php echo $row['sex']; ?></b></td>
                            </tr>
                        <?php endif; ?>


                        <?php if ($row['phone'] != '') : ?>
                            <tr>
                                <td>Phone</td>
                                <td><b><?php echo $row['phone']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['email'] != '') : ?>
                            <tr>
                                <td>Email</td>
                                <td><b><?php echo $row['email']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['address'] != '') : ?>
                            <tr>
                                <td>Address</td>
                                <td><b><?php echo $row['address']; ?></b>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($this->db->get_where("parent", array("parent_id" => $row['parent_id']))->num_rows() > 0) : ?>
                            <tr>
                                <td>Parent</td>
                                <td><b><?php echo $this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->name; ?></b></td>
                            </tr>
                            <tr>
                                <td>Parent Phone</td>
                                <td><b><?php echo $this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->phone; ?></b></td>
                            </tr>
                            <tr>
                                <td>Transport Route</td>
                                <td><b>
                                        <?php
                                        if ($row['transport_id'] !== '0') {
                                            echo $this->db->get_where('transport', array('transport_id' => $row['transport_id']))->row()->route_name;
                                        } else {
                                            echo "Not Set";
                                        }

                                        ?>
                                    </b>
                                </td>
                            </tr>
                        <?php endif; ?>

                    </table>
                </div>
                <div class='col-xs-12'>
                    <h4><?php echo get_phrase('payment_history'); ?></h4>
                    <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase('date'); ?></th>
                                <th><?php echo get_phrase('batch_number'); ?></th>
                                <th><?php echo get_phrase('amount'); ?></th>
                                <th><?php echo get_phrase('item'); ?></th>
                                <th><?php echo get_phrase('method'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $payment_history = $this->crud_model->get_student_transaction_history($row['student_id']);

                            //if($payment_history->num_rows()>0){

                            //$payment = $payment_history->result_array();

                            // echo json_encode($payment_history);

                            foreach ($payment_history as $line) {

                            ?>
                                <tr>
                                    <td><?php echo $line->t_date; ?></td>
                                    <td><a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_transaction/<?= $line->batch_number ?>');"><?php echo $line->batch_number; ?></a></td>
                                    <td><?php echo number_format($line->amount, 2); ?></td>
                                    <td><?php echo $line->description; ?></td>
                                    <td><?= $line->transaction_method; ?></td>

                                </tr>
                            <?php
                            }
                            //}

                            ?>
                        </tbody>
                        <tbody>
                    </table>
                </div>
            </div>
        </section>



    </div>


<?php endforeach; ?>