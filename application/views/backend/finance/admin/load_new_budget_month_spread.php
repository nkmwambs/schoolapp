
<table class="table">
	<thead>
		<tr>
			<th colspan="12"><?=get_phrase('monthly_spread');?></th>
		</tr>
		<tr>
			<?php
				foreach($months_in_term_short as $month_short){
					if($month_short == ""){continue;}									
			?>
			<th><input type="checkbox" class="chk_month" id="chk_<?=$month_short;?>" name=""/> <?=get_phrase($month_short);?></th>
											
			<?php
				}
			?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php
				foreach($months_in_term_short as $month_short){
					if($month_short == ""){continue;}									
			?>
				<td><input type="text" style="min-width: 80px;" class="form-control months spread" name="months[]" id="<?=$month_short;?>" value="0" required="required"/></td>
			<?php
				}
			?>
		</tr>
	</tbody>
</table>