<?php 
if(empty($data)){
    ?>
        <div class="well">No results found</div>
    <?php
}
?>

<div class="panel-group" id="accordion">
    <?php 
    foreach($data as $student):
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                    Search result for <?=$student['student_name'];?>
                </a>
            </h4>
            </div>

            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">

        <?php
        foreach($student as $label => $value):
            if (strpos($label, '_id') !== false) continue;
            if($label == 'active') $value = $value == 1 ? get_phrase('yes') : get_phrase('no'); 
    ?>
                    <tr>
                        <td><?=get_phrase($label);?></td>
                        <td><?=ucwords($value);?></td>
                    </tr>
               
    <?php 
        endforeach;
        ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php
    endforeach;
    ?>
</div>