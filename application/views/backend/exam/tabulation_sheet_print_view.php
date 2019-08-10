<?php 
	$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
	$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
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
		<?php echo get_phrase('tabulation_sheet');?><br>
		<?php echo get_phrase('class') . ' ' . $class_name;?><br>
		<?php echo $exam_name;?>

		
	</center>

	
	<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
			<thead>
				<tr>
				<th><?=get_phrase('class_position');?></th>	
				<td style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>
				<?php
					//$subjects = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
					foreach($subjects as $row):
				?>
					<td style="text-align: center;"><?php echo $row['name'];?></td>
				<?php endforeach;?>
				<td style="text-align: center;"><?php echo get_phrase('total');?></td>
				<td style="text-align: center;"><?php echo get_phrase('average_grade_point');?></td>
				<td style="text-align: center;"><?php echo get_phrase('grade_comment');?></td>
				</tr>
			</thead>
			<tbody>
			<?php	
			
			$subject_total = array();		
			
			foreach($subjects as $subject){
				$subject_total[$subject['name']] = 0;
			}	
			
			$subject_total['aggregate_total'] = 0;
			
			$subject_total['aggregate_grade_points'] = 0;
			
			$sizeofclass = 0;
			
			foreach($positions as $student=>$result){
				if($result['total_marks'] > 0){
					$sizeofclass++;
			?>
				<tr>
					<td><?=$result['position']?></td>
					<td><?=$student;?></td>
					
					<?php
						
						foreach($subjects as $subject){
							
							$mark = 0;
							foreach($result['subject']  as $row){
								if($row['subject_name'] == $subject['name']){
									$mark = $row['mark'];
									$subject_total[$subject['name']] +=$mark;
								}
							}
					?>
							<td><?=$mark?></td>
					<?php		
						}
						$subject_total['aggregate_total']  += $result['total_marks'];
						$subject_total['aggregate_grade_points']  += $result['grade_point'];
					?>
					
					<td><?=$result['total_marks'];?></td>
					<td><?=$result['grade_point'];?></td>
					<td><?=$result['grade_comment'];?></td>
				</tr>

			<?php
				}
			}
			//print_r($subject_total);
			?>
			<tfoot>
				<tr>
					<td colspan="2"><?=get_phrase('class_average');?></td>
					
					<?php
					foreach($subjects as $subject){
					?>
						<td><?=number_format(($subject_total[$subject['name']]/$sizeofclass),1);?></td>
					
					<?php
					}
					?>
					
					<td><?=number_format(($subject_total['aggregate_total']/$sizeofclass),1);?></td>
					<td colspan="2"><?=number_format(($subject_total['aggregate_grade_points']/$sizeofclass),1);?></td>
				</tr>
			</tfoot>	
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