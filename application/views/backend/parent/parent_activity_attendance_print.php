<?php
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
?>

<div id="print">

	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
		td {
			padding: 5px;
		}
	</style>

	<center>
		<img src="uploads/logo.png" style="max-height : 60px;"><br>
		<h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<h3><?php echo get_phrase('activity_register');?></h3><br>
		<u><?php echo $activity->name;?></u><br>
		<?php echo get_phrase('start_date') . ' ' . $activity->start_date;?><br>
		<?php echo get_phrase('end_date') . ' ' . $activity->end_date;?><br>
	</center>

	<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
       <thead>
        <tr>
            <td style="text-align: center;"><?=get_phrase("parent");?></td>
            <td style="text-align: center;"><?=get_phrase("students");?></td>
            <td style="text-align: center;"><?=get_phrase("attendance");?></td>
        </tr>
    </thead>
    <tbody>
      <?php
        $this->db->join("parent","parent.parent_id=activity_attendance.parent_id");
        $parents = $this->db->get_where('activity_attendance',array("activity_id"=>$activity->activity_id))->result_object();

          foreach($parents as $parent):
      ?>
        <tr>
          <td><?=$parent->name;?></td>
          <td>
            <?php
              $students = $this->db->get_where("student",array("parent_id"=>$parent->parent_id))->result_object();
                foreach($students as $student){echo $student->name." (".$this->db->get_where('class',array('class_id'=>$student->class_id))->row()->name.")<br/>";}
            ?>
          </td>
          <td>
            <?php
              $parent_attendance = $this->db->get_where("activity_attendance",array("parent_id"=>$parent->parent_id,"activity_id"=>$activity->activity_id));
              $attendance_array = array(get_phrase('absent'),get_phrase('attended'));
              if(isset($parent_attendance->row()->attendance)) echo $attendance_array[$parent_attendance->row()->attendance]; else echo $attendance_array['0'];
            ?>

          </td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>

</div>

<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		var elem = $('#print');
		PrintElem(elem);
		Popup(data);

	});

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
